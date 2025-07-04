<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'documentNumber',
        'typeDocument',
        'dateElaboration',
        'totalInventory',
        'retentionTime',
        'originDependency',
        'physicalLocation',

    ];
}
