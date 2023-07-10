<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Types_statistique extends Model
{
     protected $fillable=['libelle','description','image','supprimer'];
    public $timestamps = false;
}
