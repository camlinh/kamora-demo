@php
  use App\Helpers\Constants;
  use App\Helpers\Common;
@endphp

<div class="row">
    <div @if ($user) class="col-6" @else class="col-12" @endif>
        {!! Form::text('name', 'Name')->placeholder('Name') !!}
        {!! Form::text('email', 'Email')->placeholder('Email') !!}
        {!! Form::textarea('address', 'Address')->placeholder('Address') !!}

        <div class="row">
            <div class="col-6">
                {!! Form::select('gender', 'Gender', Constants::GENDER) !!}
            </div>
            <div class="col-6">
                {!! Form::file('thumbnail', 'Thumbnail')->attrs(['class' => 'input-file']) !!}
            </div>
        </div>
        <div class="btn-groups">
            <a class="btn btn-danger btn-sm" href="{{route('admin.users')}}">Cancel</a>
            <button class="btn btn-success btn-sm btn-submit">
                <span>Submit</span>
            </button>
        </div>
    </div>

    @if ($user)
        <div class="col-6 form-group">
            <label>Books</label>
            <div class="tab-regular">
                <ul class="nav nav-tabs nav-fill" id="myTab7" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active show" id="home-tab-justify" data-toggle="tab" href="#user-booking"
                            role="tab" aria-controls="home" aria-selected="true">Booking</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab-justify" data-toggle="tab" href="#user-returned" role="tab"
                            aria-controls="profile" aria-selected="false">Returned</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent7">
                    <div class="tab-pane fade active show" id="user-booking" role="tabpanel"
                        aria-labelledby="home-tab-justify">
                        <div class="list-book">
                            @forelse ($booking as $book)
                                <div class="book-item">
                                    <img src="{{ $book->thumbnail }}" alt="{{ $book->title }}" class="book-image" />
                                    <div class="book-body">
                                        <h5>
                                            <a href="{{ route('admin.books.edit', $book->id) }}" target="_blank">
                                                {{ $book->title }}
                                            </a>
                                        </h5>
                                        <p>Borrow Date: <b>{{ Common::formatDate($book->pivot->borrow_date, 'd/m/Y') }}</b></p>
                                        <p>Due Date: <b>{{ Common::formatDate($book->pivot->due_date, 'd/m/Y') }}</b></p>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center">You not have any books.</div>
    @endforelse
</div>
</div>
<div class="tab-pane fade" id="user-returned" role="tabpanel" aria-labelledby="profile-tab-justify">
    <div class="list-book">
        @forelse ($returned as $book)
            <div class="book-item">
                <img src="{{ $book->thumbnail }}" alt="{{ $book->title }}" class="book-image" />
                <div class="book-body">
                    <h5>
                        <a href="{{ route('admin.books.edit', $book->id) }}" target="_blank">
                            {{ $book->title }}
                        </a>
                    </h5>
                    <p>Borrow Date: <b>{{ Common::formatDate($book->pivot->borrow_date, 'd/m/Y') }}</b></p>
                    <p>Due Date: <b>{{ Common::formatDate($book->pivot->due_date, 'd/m/Y') }}</b></p>
                    <p>Return Date: <b>{{ Common::formatDate($book->pivot->return_date, 'd/m/Y') }}</b></p>
                </div>
            </div>
        @empty
            <div class="text-center">You not have any books.</div>
        @endforelse
    </div>
</div>
</div>
</div>
</div>
@endif
</div>
