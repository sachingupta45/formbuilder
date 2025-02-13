<x-admin-layout>
    @section('title', 'Roles')
    <section class="section">
        <div class="card">
            @include('admin.common.alert')
            <div class="card-header">
                <h4>Roles</h4>
                @can('role-add')
                    <a class="btn btn-dark" href="{{ route('admin.roles.createOrUpdate') }}">Add
                        Role</a>
                @endcan
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $role->name }}</td>
                                <td>
                                    @can('role-edit')
                                        <a href="{{ route('admin.roles.createOrUpdate', ['role' => $role->id]) }}"
                                            class="btn btn-sm btn-success">Edit</a>
                                    @endcan
                                    @can('role-delete')
                                        <form action="{{ route('admin.roles.destroy', ['role' => $role->id]) }}"
                                            method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this role?')">Delete</button>
                                        </form>
                                    @endcan
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</x-admin-layout>
