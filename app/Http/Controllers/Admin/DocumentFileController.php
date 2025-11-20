<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\DocumentFile;
use Illuminate\Support\Facades\Storage;


class DocumentFileController extends Controller
{
    // Elimina UN archivo concreto de un documento
    public function destroy(Document $document, DocumentFile $file)
    {
        // Seguridad: que el archivo pertenezca al documento
        if ($file->document_id !== $document->id) {
            abort(404);
        }

        // Borrar archivo físico
        Storage::disk('public')->delete($file->path);

        // Borrar registro
        $file->delete();

        return back()->with('status', 'Archivo eliminado correctamente.');
    }

    // (Opcional) Elimina TODOS los archivos de un documento
    public function destroyAll(Document $document)
    {
        // Nuevos múltiples
        foreach ($document->files as $file) {
            Storage::disk('public')->delete($file->path);
            $file->delete();
        }

        // Soporte para el esquema antiguo de un solo pdf_path
        if ($document->pdf_path) {
            Storage::disk('public')->delete($document->pdf_path);
            $document->pdf_path = null;
            $document->save();
        }

        return back()->with('status', 'Todos los archivos de este documento han sido eliminados.');
    }
}
