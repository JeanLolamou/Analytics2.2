<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historiquepaiement extends Model
{
    protected $fillable=['user_id','initiateDate','orderId','amount','payToken','status','txnid','pack_id','type_paiement'];


      public $timestamps = false;
}
