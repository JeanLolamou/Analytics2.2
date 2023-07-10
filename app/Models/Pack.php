<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pack extends Model
{
    protected $fillable=['nom','description','prix','duree','image','supprimer'];
    public $timestamps = false;
}
