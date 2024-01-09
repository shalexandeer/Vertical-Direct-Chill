<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billet extends Model
{
    use HasFactory;

    protected $table = 'billet';
    protected $primaryKey = 'id';

    protected $fillable = [
        'date', // add this line
        'total_billet',
        'diameter',
        'status',
        'total_defected',
    ];

    protected $casts = [
        'date' => 'datetime', // add this line
        'total_billet' => 'integer',
        'diameter' => 'integer',
        'status' => 'string',
        'total_defected' => 'integer',
    ];
}
