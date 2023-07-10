<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Demandeuser extends Model
{
    protected $fillable=['id_user','objet','message'];
    public $timestamps = false;
}
