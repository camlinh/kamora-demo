<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\UploadTrait;
use App\Models\Book;
use App\Models\Author;
use App\Models\User;
use App\Models\UserBooking;
use App\Traits\ResponseTrait;
use DB;
use App\Helpers\Constants;
use App\Helpers\Common;
use App\Http\Requests\CreateBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Requests\CreateUserBookRequest;
use Carbon\Carbon;

class BookController extends BaseController
{
    use UploadTrait, ResponseTrait;

    public function index(Request $request){
      $query = Book::orderBy('updated_at', 'DESC');
      $term = $request->get('term');

      if($term){
        $term = preg_replace('/\s+/', '%', $term);
        $query = $query->where('title', 'LIKE', "%$term%");
      }

      $books = $query->paginate(10)->withQueryString();
      $request->flash();
      return view('admin.book.index', compact('books'));
    }
    
    public function create(){
      $authors = Author::select('name', 'id')->get()->pluck('name', 'id');
      return view('admin.book.create', compact('authors'));
    }

    public function store(CreateBookRequest $request){
      try {
        DB::beginTransaction();
        $data = $request->getData();
        $data['status'] = Constants::BOOK_FREE;

        if($request->hasFile('thumbnail')){
          $data['thumbnail'] = $this->uploadImage($request->file('thumbnail'), 'books');
        }

        $book = Book::create($data);
        DB::commit();
        return $this->success([
            'message' => 'Create book success.',
            'redirect_url' => route('admin.books'),
        ]);
      } catch (\Exception $e) {
          DB::rollBack();
          return $this->error($e->getMessage());
      }//end try
    }

    public function edit($id){
      $book = Book::findOrFail($id);
      $authors = Author::select('name', 'id')->get()->pluck('name', 'id');
      return view('admin.book.edit', compact('book', 'authors'));
    }

    public function update(UpdateBookRequest $request, $id){
      try {
        DB::beginTransaction();

        $book = Book::findOrFail($id);
        $data = $request->getData();

        if($request->hasFile('thumbnail')){
          $data['thumbnail'] = $this->uploadImage($request->file('thumbnail'), 'books');
        }
      
        $book->update($data);

        DB::commit();
        return $this->success([
            'message' => 'Update book success.',
            'redirect_url' => route('admin.books'),
        ]);
      } catch (\Exception $e) {
          DB::rollBack();
          return $this->error($e->getMessage());
      }//end try
    }

    public function order(){
      $users = User::where('status', true)->get()->pluck('name', 'id');
      $books = Book::where('user_id', null)->get()->pluck('title', 'id');
      return view('admin.book.order', compact('users', 'books'));
    }

    public function userBorrow(CreateUserBookRequest $request){
      try {
        DB::beginTransaction();

        $userId = $request->get('user_id');
        $bookIds = $request->get('book_id');
        $dueDate = $request->get('due_date');

        foreach ($bookIds as $bookId) {
          $book = Book::find($bookId);
          $code = UserBooking::generateTransation();
          $book->update([
            'status' => Constants::BOOK_LENDING,
            'user_id' => $userId,
            'transaction_code' => $code
          ]);

          $book->readers()->attach($userId, [
            'status' => Constants::USER_BOOKING,
            'due_date' => Common::parseDate($dueDate, 'd/m/Y'),
            'borrow_date' => Carbon::now(),
            'transaction_code' => $code
          ]);
        }

        DB::commit();

        return $this->success([
            'message' => 'Give book for user success.',
            'redirect_url' => route('admin.books'),
        ]);
      } catch (\Exception $e) {
          DB::rollBack();
          return $this->error($e->getMessage());
      }//end try
    }

    public function userReturn($id){
      try {
        DB::beginTransaction();

        $book = Book::findOrFail($id);
        $user = $book->user;

        if($user){
          $item = $book->readers()
                ->wherePivot('transaction_code', '=', $book->transaction_code)
                ->updateExistingPivot($user, [
                  'return_date' => Carbon::now(),
                  'status' => Constants::USER_RETURNED
                ]);

          $book->update([
            'status' => Constants::BOOK_FREE,
            'user_id' => null,
            'transaction_code' => null
          ]);
        }

        DB::commit();
        return $this->success('Return book success.');
      } catch (\Exception $e) {
          DB::rollBack();
          return $this->error($e->getMessage());
      }//end try
    }
}
