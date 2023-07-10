<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PieceJointe extends Model
{
    protected $fillable=['nom','id_stat','fichier','supprimer'];
    public $timestamps = false;
}
