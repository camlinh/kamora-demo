@php
    use App\Helpers\Constants;
@endphp

@extends('admin.layout')

@section('admin_content')
    <div class="container-fluid dashboard-content ">
        <!-- ============================================================== -->
        <!-- pageheader  -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h2 class="pageheader-title">Books</h2>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}" class="breadcrumb-link">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Books</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        @include('admin.includes.messages');
        <!-- ============================================================== -->
        <!-- end pageheader  -->
        <!-- ============================================================== -->
        <div class="row">
            <!-- ============================================================== -->
            <!-- basic table -->
            <!-- ============================================================== -->
            <div class="col-12">
                <div class="card">
                    <div class="card-header card-header-with-button">
                      <form action="" method="GET" class="form-search">
                        <input class="form-control" name="term" placeholder="Type something..." value="{{request()->query('term')}}"/>
                        <button class="btn btn-success btn-sm">
                          <span class="fas fa-search"></span>
                          <span class="pl-1">Search</span>
                        </button>
                      </form>
                      <div class="d-flex">
                        <a href="{{route('admin.books.order')}}" class="btn btn-sm btn-info mr-3">Borrow Book</a>
                        <a href="{{route('admin.books.create')}}" class="btn btn-sm btn-success">Create</a>
                      </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="bg-light">
                                    <tr class="border-0">
                                        <th class="border-0 no-wrap">#</th>
                                        <th class="border-0 no-wrap">Thumbnail</th>
                                        <th class="border-0 no-wrap">Title</th>
                                        <th class="border-0 no-wrap">Author</th>
                                        <th class="border-0 no-wrap">Language</th>
                                        <th class="border-0 no-wrap">Status</th>
                                        <th class="border-0 no-wrap">Borrower</th>
                                        <th class="border-0 no-wrap">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($books as $key => $book)
                                        <tr>
                                            <td>{{ $book->id }}</td>
                                            <td>
                                                <div class="m-r-10">
                                                    <img src="{{ $book->thumbnail }}" alt="{{ $book->title }}" class="rounded" width="45">
                                                </div>
                                            </td>
                                            <td>{{ $book->title }}</td>
                                            <td>{{ optional($book->author)->name }}</td>
                                            <td>{{ $book->language }}</td>
                                            <td class="no-wrap">
                                              <span class="badge badge-status-{{$book->status}} mr-1">
                                                {{Constants::BOOK_STATUS[$book->status]}}
                                              </span> 
                                            </td>
                                            <td class="no-wrap">{{ optional($book->user)->name ?? '-' }}</td>
                                            <td>
                                              <div class="btn-groups mt-0">
                                                  @if($book->user_id)
                                                    <a class="btn btn-primary btn-xs link-remote" 
                                                        href="{{route('admin.books.order.return', $book->id)}}" 
                                                        data-method="PUT"
                                                        data-toggle="tooltip" 
                                                        data-placement="bottom" 
                                                        title="Returned Book"
                                                    >
                                                      <i class=" fas fa-share"></i>
                                                    </a>
                                                  @endif
                                                  <a class="btn btn-info btn-xs" 
                                                     href="{{route('admin.books.edit', $book->id)}}"
                                                     data-toggle="tooltip" 
                                                     data-placement="bottom" 
                                                     title="Detail Book"
                                                  >
                                                    <i class="fas fa-info-circle"></i>
                                                  </a>
                                              </div>
                                            </td>
                                        </tr>
                                      @empty
                                        <tr><td class="text-center py-4" colspan="8">EMPTY!</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer navigation">{{ $books->onEachSide(2)->links() }}</div>
                </div>
            </div>
            <!-- ============================================================== -->
        </div>
    </div>
@endsection
