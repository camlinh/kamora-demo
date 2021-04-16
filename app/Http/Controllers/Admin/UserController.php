<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Traits\ResponseTrait;
use DB;
use Illuminate\Http\Request;
use Str;
use App\Helpers\Constants;

class UserController extends BaseController
{
    use ResponseTrait;

    public function index(Request $request)
    {
        $query = User::withCount('books')->latest();
        $term = $request->get('term');

        if ($term) {
            $term = preg_replace('/\s+/', '%', $term);
            $query = $query->where(function ($q) use ($term) {
                $q->where('name', 'LIKE', "%$term%");
                $q->orWhere('card_number', 'LIKE', "%$term%");
            });
        }

        $users = $query->paginate(10)->withQueryString();
        return view('admin.user.index', compact('users'));
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function store(CreateUserRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->getData();
            $data['status'] = true;
            $data['password'] = bcrypt('123123');
            $data['card_number'] = strtoupper(Str::random(12));
            $user = User::create($data);

            DB::commit();
            return $this->success([
                'message' => 'Create user success.',
                'redirect_url' => route('admin.users'),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage());
        } //end try
    }

    public function edit($id)
    {
        $user = User::with('books', 'books.author')->findOrFail($id);
        $booking = $user->books()->wherePivot('status', Constants::USER_BOOKING)->get();
        $returned = $user->books()->wherePivot('status', Constants::USER_RETURNED)->get();
        return view('admin.user.edit', compact('user', 'booking', 'returned'));
    }

    public function update(UpdateUserRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            $user = User::findOrFail($id);
            $data = $request->getData();
            $user->update($data);

            DB::commit();
            return $this->success([
                'message' => 'Update user success.',
                'redirect_url' => route('admin.users'),
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage());
        } //end try
    }
}
