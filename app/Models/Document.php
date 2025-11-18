<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'tomo_id',
        'document_series_id',
        'number',
        'date',
        'summary',
        'pages',
        'pdf_path',
        'folio_number',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function tomo()
    {
        return $this->belongsTo(Tomo::class);
    }

    public function series()
    {
        return $this->belongsTo(DocumentSeries::class, 'document_series_id');
    }

    public function area()
    {
        // El área viene del tomo
        return $this->tomo?->area();
    }
}
