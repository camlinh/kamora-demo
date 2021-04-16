<div class="row">
  <div class="col-8">
    {!!Form::text('title', 'Title')->placeholder('Title')!!}
    {!!Form::textarea('description', 'Description')->placeholder('Description')!!}
    {!!Form::text('language', 'Language')->placeholder('Language')!!}
    <div class="btn-groups">
      <a class="btn btn-danger btn-sm" href="{{route('admin.books')}}">Cancel</a>
      <button class="btn btn-success btn-sm btn-submit">
        <span>Submit</span>
      </button>
    </div>
  </div>

  <div class="col-4">
    @if($book)
      <div class="form-group">
        <label>Reader</label>
        <div>
          @if($book->user)
            <a target="_blank" href="{{route('admin.users.edit', $book->user->id)}}" class="reader">
              {{$book->user->name}}
            </a>
            <a class="btn btn-info btn-xs link-remote" href="{{route('admin.books.order.return', $book->id)}}" data-method="PUT">Returned</a>
          @else
            -
          @endif
        </div>
      </div>
    @endif
    {!!Form::select('author_id', 'Author', $authors->prepend('Choose author', ''))->placeholder('Author')!!}
    {!!Form::file('thumbnail', 'Thumbnail')->attrs(['class' => 'input-file'])!!}
  </div>
</div>