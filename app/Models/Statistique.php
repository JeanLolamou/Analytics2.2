<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Statistique extends Model
{
    protected $fillable=['libelle','description','id_type','source','datePublication','periode','id_pack','supprimer'];
    public $timestamps = false;
}
