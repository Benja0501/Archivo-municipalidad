<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\Tomo;
use App\Models\DocumentSeries;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $tomoId = $request->input('tomo_id');

        $tomos  = Tomo::with('area')
            ->orderBy('year')
            ->orderBy('description')
            ->get();

        $documents = Document::with(['tomo.area', 'series', 'files']) // añadimos files
            ->withCount('files')                                      // cantidad de archivos
            ->when($tomoId, fn($q) => $q->where('tomo_id', $tomoId))
            ->when($search, function ($q) use ($search) {
                $q->where('number', 'like', "%{$search}%")
                    ->orWhere('summary', 'like', "%{$search}%");
            })
            ->orderBy('tomo_id')
            ->orderBy('folio_number')
            ->paginate(25)
            ->withQueryString();

        return view('admin.documents.index', compact('documents', 'tomos', 'tomoId', 'search'));
    }


    public function create()
    {
        $tomos  = Tomo::with('area', 'series')->orderBy('year')->orderBy('description')->get();
        $series = DocumentSeries::orderBy('code')->get();

        return view('admin.documents.create', compact('tomos', 'series'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tomo_id'            => ['required', 'exists:tomos,id'],
            'document_series_id' => ['nullable', 'exists:document_series,id'],
            'number'             => ['required', 'string', 'max:255'],
            'date'               => ['nullable', 'date'],
            'summary'            => ['nullable', 'string'],
            'pages'              => ['nullable', 'integer', 'min:1'],

            // NUEVO: múltiples archivos opcionales
            'files'              => ['nullable', 'array'],
            'files.*'            => ['file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ]);

        $tomo = Tomo::findOrFail($data['tomo_id']);

        // correlativo dentro del tomo (folio de archivo)
        $nextFolio = ($tomo->documents()->max('folio_number') ?? 0) + 1;
        $data['folio_number'] = $nextFolio;

        // No guardamos pdf_path en el documento (lo dejamos null para nuevos)
        unset($data['files']);

        $document = Document::create($data);

        // Guardar archivos si vienen (0, 1 o muchos)
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $uploadedFile) {
                $path = $uploadedFile->store('documents', 'public');

                $document->files()->create([
                    'path'          => $path,
                    'original_name' => $uploadedFile->getClientOriginalName(),
                    'mime_type'     => $uploadedFile->getClientMimeType(),
                    'size'          => $uploadedFile->getSize(),
                ]);
            }
        }

        $this->updateTomoStats($tomo);

        return redirect()
            ->route('admin.documents.index')
            ->with('status', 'Documento registrado correctamente.');
    }


    public function edit(Document $document)
    {
        $document->load('files');
        $tomos  = Tomo::with('area', 'series')->orderBy('year')->orderBy('description')->get();
        $series = DocumentSeries::orderBy('code')->get();

        return view('admin.documents.edit', compact('document', 'tomos', 'series'));
    }

    public function update(Request $request, Document $document)
    {
        $data = $request->validate([
            'tomo_id'            => ['required', 'exists:tomos,id'],
            'document_series_id' => ['nullable', 'exists:document_series,id'],
            'number'             => ['required', 'string', 'max:255'],
            'date'               => ['nullable', 'date'],
            'summary'            => ['nullable', 'string'],
            'pages'              => ['nullable', 'integer', 'min:1'],

            // NUEVO: múltiples archivos opcionales en la edición
            'files'              => ['nullable', 'array'],
            'files.*'            => ['file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
        ]);

        $tomoAntes = $document->tomo;

        unset($data['files']); // no es columna del documento

        $document->fill($data);
        $document->save();

        // Si cambió de tomo, recalculamos ambos
        if ($tomoAntes->id !== $document->tomo_id) {
            $this->updateTomoStats($tomoAntes);
            $this->updateTomoStats($document->tomo);
        } else {
            $this->updateTomoStats($document->tomo);
        }

        // NUEVO: agregar más archivos al documento
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $uploadedFile) {
                $path = $uploadedFile->store('documents', 'public');

                $document->files()->create([
                    'path'          => $path,
                    'original_name' => $uploadedFile->getClientOriginalName(),
                    'mime_type'     => $uploadedFile->getClientMimeType(),
                    'size'          => $uploadedFile->getSize(),
                ]);
            }
        }

        // NOTA: pdf_path se mantiene solo como compatibilidad si ya existía

        return redirect()
            ->route('admin.documents.index')
            ->with('status', 'Documento actualizado correctamente.');
    }


    public function destroy(Document $document)
    {
        $tomo = $document->tomo;

        // Borrar todos los archivos múltiples
        foreach ($document->files as $file) {
            Storage::disk('public')->delete($file->path);
            $file->delete();
        }

        // Borrar archivo único legacy
        if ($document->pdf_path) {
            Storage::disk('public')->delete($document->pdf_path);
        }

        $document->delete();

        $this->updateTomoStats($tomo);

        return redirect()
            ->route('admin.documents.index')
            ->with('status', 'Documento eliminado correctamente.');
    }



    protected function updateTomoStats(Tomo $tomo): void
    {
        $documents = $tomo->documents()->orderBy('folio_number')->get();

        $tomo->folios = $documents->count(); // IMPORTANTE: folios = cantidad de DOCUMENTOS

        if ($documents->isEmpty()) {
            $tomo->from_ref = null;
            $tomo->to_ref   = null;
        } else {
            $first = $documents->first();
            $last  = $documents->last();

            $tomo->from_ref = $this->formatDocumentRef($first);
            $tomo->to_ref   = $this->formatDocumentRef($last);
        }

        $tomo->save();
    }

    protected function formatDocumentRef(Document $doc): string
    {
        if ($doc->date) {
            return $doc->number . ' (' . $doc->date->format('d-m-Y') . ')';
        }

        return $doc->number;
    }
}
