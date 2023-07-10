<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apropo extends Model
{
    protected $fillable=['titre','description','afficher'];
    public $timestamps = false;
}
