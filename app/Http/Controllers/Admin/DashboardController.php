<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\User;
use App\Helpers\Constants;
use Carbon\Carbon;
use App\Mail\DeadlineNotification;
use Illuminate\Support\Facades\Mail;
use App\Traits\ResponseTrait;

class DashboardController extends BaseController
{
    use ResponseTrait;

    public function index(){
      $query = Book::where('status', Constants::BOOK_LENDING)
      ->whereHas('readers', function($q){
        $q->whereDate('user_booking.due_date', '<', Carbon::now());
      });

      $countBook = Book::count();
      $countUser = User::count();
      $countBorrowing = Book::where('status', Constants::BOOK_LENDING)->count();
      $countOverdue = $query->count();
      $overdues = $query->paginate(10);
      return view('admin.dashboard.index', compact('overdues', 'countBook', 'countUser', 'countOverdue', 'countBorrowing'));
    }

    public function sendNotification(){
      try {
        $users = User::whereHas('books', function($q){
          $q->has('transaction');
          $q->whereDate('user_booking.due_date', '<', Carbon::now());
        })->with(['books' => function($q){
          $q->has('transaction');
          $q->whereDate('user_booking.due_date', '<', Carbon::now());
        }])->get();

        foreach ($users as $user) {
          $books = $user->books;
          Mail::to($user)->queue(new DeadlineNotification($user, $books));
        }

        return $this->success('Send notification success!');
      } catch (\Exception $e) {
        return $this->error($e->getMessage());
      }
    }
}
