@extends('layouts.admin.layout')

@section('title', 'Role')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Add Role</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.role.store', ['role' => $role->id]) }}" id="role-permission">
                @csrf
                <div class="form-group">
                    <label for="name">Role Name</label>
                    <input type="text" name="name" id="name"
                           class="form-control @error('name') is-invalid @enderror" value="{{ $role->name }}"
                           placeholder=" ">
                    @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-12">
                        <label for="permissions">Permissions</label>
                        @forelse($permissions as $groupName => $groupPermissions)
                            <div class="form-group">
                                <h5>{{ ucfirst($groupName) }}</h5>
                                @foreach($groupPermissions as $permission)
                                    <div class="form-check">
                                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }} "
                                               class="form-check-input" id="permission-{{ $permission->id }}">
                                        <label class="form-check-label" for="permission-{{ $permission->id }}">
                                            {{ $permission->label }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        @empty
                            <p>No permissions found</p>
                        @endforelse
                        @error('permissions')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Create</button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
    <script src="{{ asset('assets/admin/js/rolePermission.js') }}"></script>
@endpush

