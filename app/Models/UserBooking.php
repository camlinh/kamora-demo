<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class UserBooking extends Model
{
    protected $table = 'user_booking';

    public static function generateTransation(){
      $code =  Str::uuid()->toString();
      while(static::where('transaction_code', $code)->exists()){
        $code =  Str::uuid()->toString();
      }
      return $code;
    }
}
