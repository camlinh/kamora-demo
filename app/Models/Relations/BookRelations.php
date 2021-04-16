<?php

namespace App\Models\Relations;

use App\Models\User;
use App\Models\Author;
use App\Models\UserBooking;

trait BookRelations
{
    public function user(){
      return $this->belongsTo(User::class, 'user_id');
    }

    public function author(){
      return $this->belongsTo(Author::class, 'author_id');
    }

    public function readers(){
      return $this->belongsToMany(User::class, 'user_booking')
                  ->withPivot('borrow_date', 'due_date', 'return_date', 'status');
    }

    public function transaction(){
      return $this->belongsTo(UserBooking::class, 'transaction_code', 'transaction_code');
    }
}
