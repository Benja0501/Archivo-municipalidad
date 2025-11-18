<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tomo extends Model
{
    use HasFactory;

    protected $fillable = [
        'area_id',
        'document_series_id',
        'item',
        'description',
        'year',
        'tome_number',
        'folios',
        'from_ref',
        'to_ref',
        'shelf_number',
        'shelf_row',
        'active',
    ];

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function series()
    {
        return $this->belongsTo(DocumentSeries::class, 'document_series_id');
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}
