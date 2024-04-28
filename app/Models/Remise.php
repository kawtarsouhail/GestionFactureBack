<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Remise extends Model
{
   
    protected $primaryKey = 'NumRemise';

    protected $fillable = ['NumRemise', 'MontantEnc'];
}
