@extends('layouts.admin')

@section('content')
    <div class="card card-primary">
        @include('admin.common.alert')
        <div class="card-header">
            <h4>Edit User</h4>
        </div>
        <form method="POST" action="{{ route('admin.users.update', $user->id) }}" enctype="multipart/form-data" id="user-form">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-6">
                        <label for="name">First Name</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                            name="name" value="{{ old('name', $user->name) }}" autocomplete="name" autofocus>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col-6">
                        <label for="email">Email</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email', $user->email) }}" autocomplete="email">
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
                        <input id="password" type="password" value="{{ old('password',jsdecode_userdata($user->encrypt_password)) }}"
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
                        <input id="password_confirmation" value="{{ old('password_confirmation',jsdecode_userdata($user->encrypt_password)) }}" type="password"
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
                                <option value="{{ $role->id }}" @if ($user->roles->isNotEmpty() && $role->id === $user->roles->first()->id) selected @endif>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>
            </div>
            <div class="card-footer d-flex gap-4 float-right">
                <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-danger">Cancel</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>

    </div>
@endsection

@push('particular-scripts')
@include('admin.common.show_js')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script src="{{ asset('assets/admin/js/user.js') }}"></script>
@endpush
