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
                    <h2 class="pageheader-title">Users</h2>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}" class="breadcrumb-link">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Users</li>
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
                        <input class="form-control" name="term" placeholder="Type something..." value="{{old('term')}}"/>
                        <button class="btn btn-success btn-sm">
                          <span class="fas fa-search"></span>
                          <span class="pl-1">Search</span>
                        </button>
                      </form>
                      <a href="{{route('admin.users.create')}}" class="btn btn-sm btn-success">Create</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="bg-light">
                                    <tr class="border-0">
                                        <th class="border-0 no-wrap"># Card Number</th>
                                        <th class="border-0 no-wrap">Name</th>
                                        <th class="border-0 no-wrap">Email</th>
                                        <th class="border-0 no-wrap">Address</th>
                                        <th class="border-0 no-wrap">Gender</th>
                                        <th class="border-0 no-wrap">Status</th>
                                        <th class="border-0 no-wrap">Bookings</th>
                                        <th class="border-0 no-wrap">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($users as $key => $user)
                                        <tr>
                                            <td>{{ $user->card_number }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->address }}</td>
                                            <td>{{ Constants::GENDER[$user->gender] }}</td>
                                            <td>
                                              @if($user->status)
                                                <div class="badge badge-success">Active</div>
                                              @else
                                                <div class="badge badge-secondary">Inactive</div>
                                              @endif
                                            </td>
                                            <td>{{ $user->books_count }}</td>
                                            <td>
                                              <div class="btn-groups mt-0">
                                                  <a class="btn btn-info btn-xs" 
                                                      href="{{route('admin.users.edit', $user->id)}}"
                                                      data-toggle="tooltip" 
                                                      data-placement="bottom" 
                                                      title="Detail User">
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
                    <div class="card-footer navigation">{{ $users->onEachSide(2)->links() }}</div>
                </div>
            </div>
            <!-- ============================================================== -->
        </div>
    </div>
@endsection
