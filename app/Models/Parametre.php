<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parametre extends Model
{
    protected $fillable=['email','tel1','tel2','app_name','apropos','adresse','lien','facebook','twitter','linkedin','youtube'];
}
