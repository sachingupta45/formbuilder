@extends('layouts.admin')

@section('title', 'User')

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h4>Add User</h4>
            <a class="btn btn-dark" href="{{ route('admin.users.index') }}" style="align-items: end;">All User</a>
        </div>
        <form method="POST" action="{{ route('admin.users.store') }}" enctype="multipart/form-data" id="user-form">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="name">First Name</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                            name="name" value="{{ old('name') }}" autocomplete="name" autofocus>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email">Email</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" autocomplete="email">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="password">Password</label>
                        <input id="password" type="password" value="{{ old('password') }}"
                            class="form-control @error('password') is-invalid @enderror password-field" name="password"
                            autocomplete="new-password">
                            <div class="form-icon">
                                <span><i class="fa-regular fa-eye-slash show-password"></i></span>
                            </div>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="password_confirmation">Confirm Password</label>
                        <input id="password_confirmation" value="{{ old('password_confirmation') }}" type="password"
                            class="form-control password-field" name="password_confirmation" autocomplete="new-password">
                            <div class="form-icon">
                                <span><i class="fa-regular fa-eye-slash show-password"></i></span>
                            </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="role">Select Role</label>
                        <select class="form-control" id="role" name="role">
                            @foreach ($roles as $role)
                                @if ($role->name !== 'admin')
                                    <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-footer float-right">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
@endsection
@push('particular-scripts')
@include('admin.common.show_js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script src="{{ asset('assets/admin/js/user.js') }}"></script>
@endpush
