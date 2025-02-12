@extends('layouts.admin')
@section('title', 'View')
@section('content')
    <div class="card">
        <div class="card-header">
            <h4>User Details</h4>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="card author-box">
                        <div class="card-body">
                            <div class="author-box-center">
                                <div class="admin-profile-img">
                                    @if (isset($user->user_detail->profilePicUrl))
                                        <img src="{{ asset($user->user_detail->profilePicUrl) }}" alt="user-img" class="img-fluid"
                                            style="width: 135px; height: 135px;">
                                    @else
                                        <img src="{{ asset('assets/img/users/user-1.png') }}" alt="default-user-img"
                                            class="img-fluid" style="width: 135px; height: 135px;">
                                    @endif

                                </div>

                                <div class="clearfix"></div>
                                <div class="author-box-name">
                                    <a href="#">{{ $user->first_name }}</a>
                                </div>
                            </div>
                            <div class="py-4">
                                <p class="clearfix">
                                    <span class="float-left">Name </span>
                                    <span class="float-right ">
                                        {{ ($user->first_name ? $user->first_name : '-') . ' ' . $user->last_name }}
                                    </span>
                                </p>
                                <p class="clearfix">
                                    <span class="float-left">Email </span>
                                    <span class="float-right ">
                                        {{ $user->email }}
                                    </span>
                                </p>
                                <p class="clearfix">
                                    <span class="float-left">Status </span>
                                    <span class="float-right ">
                                        {{ $user->status }}
                                    </span>
                                </p>
                                <p class="clearfix">
                                    <span class="float-left">Phone Number</span>
                                    <span class="float-right ">
                                        {{ $user->user_detail->phone_number ?? 'n/a' }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary">Edit</a>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
@endsection
