@php
    use App\Helpers\Constants;
    use App\Helpers\Common;
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
                    <h2 class="pageheader-title">Dashboard</h2>
                    <p class="pageheader-text">Nulla euismod urna eros, sit amet scelerisque torton lectus vel mauris
                        facilisis faucibus at enim quis massa lobortis rutrum.</p>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}" class="breadcrumb-link">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Home</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end pageheader  -->
        <!-- ============================================================== -->
        <div class="ecommerce-widget">

            <div class="row">
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="text-muted">Books</h5>
                            <div class="metric-value d-inline-block">
                                <h1 class="mb-1">{{$countBook}}</h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="text-muted">Readers</h5>
                            <div class="metric-value d-inline-block">
                                <h1 class="mb-1">{{$countUser}}</h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="text-muted">Borrowing</h5>
                            <div class="metric-value d-inline-block">
                                <h1 class="mb-1">{{$countBorrowing}}</h1>
                            </div>
                        </div>
                        <div id="sparkline-revenue3"></div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="text-muted">Overdues</h5>
                            <div class="metric-value d-inline-block">
                                <h1 class="mb-1">{{$countOverdue}}</h1>
                            </div>
                        </div>
                        <div id="sparkline-revenue4"></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- ============================================================== -->

                <!-- ============================================================== -->

                <!-- recent orders  -->
                <!-- ============================================================== -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-header card-header-with-button">
                          <h5 class="mb-0">Overdue Books</h5>
                          <a href="{{route('admin.notification.deadline')}}" data-method="POST" class="btn btn-sm btn-success link-remote">
                            <i class="fas fa-bell"></i>
                            <span class="ml-1">Notification</span>
                          </a>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="bg-light">
                                        <tr class="border-0">
                                            <th class="border-0 no-wrap">#</th>
                                            <th class="border-0 no-wrap">Thumbnail</th>
                                            <th class="border-0 no-wrap">Title</th>
                                            <th class="border-0 no-wrap">Author</th>
                                            <th class="border-0 no-wrap">Status</th>
                                            <th class="border-0 no-wrap">Borrower</th>
                                            <th class="border-0 no-wrap">Due date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($overdues as $book)
                                            @php
                                                $dueDate = optional($book->transaction)->due_date;
                                            @endphp
                                            <tr>
                                                <td>{{ $book->id }}</td>
                                                <td>
                                                    <div class="m-r-10">
                                                        <img src="{{ $book->thumbnail }}" alt="{{ $book->title }}"
                                                            class="rounded" width="45">
                                                    </div>
                                                </td>
                                                <td>{{ $book->title }}</td>
                                                <td>{{ optional($book->author)->name }}</td>
                                                <td class="no-wrap">
                                                    <span
                                                        class="badge badge-status-{{ $book->status }} mr-1">{{ Constants::BOOK_STATUS[$book->status] }}</span>
                                                </td>
                                                <td class="no-wrap">{{ optional($book->user)->name ?? '-' }}</td>
                                                <td class="no-wrap">{{ Common::formatDate($dueDate, 'd/m/Y H:i') }}</td>
                                            </tr>
                                          @empty
                                            <tr><td colspan="7" class="text-center py-4">EMPTY!</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer navigation">{{ $overdues->onEachSide(2)->links() }}</div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- end recent orders  -->
            </div>

        </div>
    </div>
@endsection
