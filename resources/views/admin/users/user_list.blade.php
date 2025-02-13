<x-admin-layout>
    @section('title', 'User')
    <section class="section">

        <div class="card">
            @include('admin.common.alert')
            <div class="card-header">
                <h4>User List</h4>
                @can('user-add')
                    <a class="btn btn-dark" href="{{ route('admin.users.create') }}">Add User</a>
                @endcan
            </div>
            <div class="card-body">
                <table id="userTable" class="table table-striped">
                    <thead class="bg-table">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            {{-- <th>status</th> --}}
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg">
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->getRoleNames()[0] ?? 'N/A' }}</td>
                                {{-- <td>

                                <label class="switch">
                                    <input type="checkbox" class="custom-switch-input" data-user-id="{{ $user->id }}"
                                        data-route="{{ route('admin.users.status', $user->id) }}"
                                        @if ($user->status === 'ACTIVE') checked="checked" @endif>
                                    <span class="custom-switch-indicator"></span>
                                </label>
                            </td> --}}
                                <td>
                                    {{-- @can('user-view')
                                <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-sm btn-primary">Show</a>
                                @endcan --}}
                                    @can('user-edit')
                                        <a href="{{ route('admin.users.edit', $user->id) }}"
                                            class="btn btn-sm btn-success">Edit</a>
                                    @endcan
                                    @can('user-delete')
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                            style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
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

    @push('scripts')
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#userTable').DataTable({
                    searching: true,

                });
            });
        </script>
    @endpush
</x-admin-layout>
