<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cheque extends Model
{
    protected $primaryKey = 'NumCheque';
    protected $fillable = [
        'NumCheque',
        'NumRemise'
    ];

}