@extends('admin.layout')

@section('admin_content')
    <div class="container-fluid dashboard-content ">
        <!-- ============================================================== -->
        <!-- pageheader  -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h2 class="pageheader-title">Book Borrow</h2>
                    <p class="pageheader-text">Nulla euismod urna eros, sit amet scelerisque torton lectus vel mauris
                        facilisis faucibus at enim quis massa lobortis rutrum.</p>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"
                                        class="breadcrumb-link">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('admin.books') }}"
                                        class="breadcrumb-link">Books</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Borrow</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end pageheader  -->
        <!-- ============================================================== -->
        <div class="row">
            <!-- ============================================================== -->
            <!-- basic table -->
            <!-- ============================================================== -->
            <div class="col-8 offset-2">
                <div class="card">
                    <div class="card-body">
                        {!! Form::open()->post()->route('admin.books.order.post')->attrs(['class' => 'form-remote']) !!}
                        <div class="row">
                            <div class="col-12">
                                {!! Form::select('user_id', 'User', $users)->attrs(['class' => 'selectable', 'data-placeholder' => 'Choose User']) !!}
                                {!! Form::select('book_id[]', 'Book', $books)
                                        ->attrs(['class' => 'selectable', 'data-placeholder' => 'Choose Books', 'data-maximum-selection-length' => 5])
                                        ->multiple(true) !!}

                                <div class="form-group">
                                  <label>Return date</label>
                                  <div class="input-group input-daterange">
                                      <input type="text" class="datepicker form-control" name="due_date" data-format="dd/mm/yyyy" readonly/>
                                  </div>
                                </div>

                                <div class="btn-groups">
                                    <a class="btn btn-danger btn-sm" href="{{route('admin.books')}}">Cancel</a>
                                    <button class="btn btn-success btn-sm btn-submit">
                                        <span>Submit</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
        </div>
    </div>
@endsection
