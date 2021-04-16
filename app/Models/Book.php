<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Relations\BookRelations;

class Book extends Model
{
    use HasFactory, BookRelations;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'author_id',
      'user_id',
      'title',
      'description',
      'language',
      'status',
      'thumbnail',
      'transaction_code'
    ];
}
