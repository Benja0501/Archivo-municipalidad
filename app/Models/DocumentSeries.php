<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DocumentSeries extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'parent_id',
        'active',
    ];

    public function parent()
    {
        return $this->belongsTo(DocumentSeries::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(DocumentSeries::class, 'parent_id');
    }
}
