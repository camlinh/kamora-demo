<?php

namespace App\Models\Relations;

use App\Models\Book;

trait UserRelations
{
    public function books(){
      return $this->belongsToMany(Book::class, 'user_booking')
                  ->withPivot('borrow_date', 'due_date', 'return_date', 'status');
    }
}
