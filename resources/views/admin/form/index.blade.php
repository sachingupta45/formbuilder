<x-admin-layout>
    @section('title', 'Form List')
    <section class="section">
        <div class="card">
            @include('admin.common.alert')
            <div class="card-header">
                <h4>Full Width</h4>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-md display" id="formdatatable">
                        @can('form-add')
                            <div class="dt-buttons btn-group">
                                <a href="{{ route('admin.form.create') }}" class="btn  buttons-csv btn-info" tabindex="0"
                                    aria-controls="tableExport"><span>Add</span></a>
                            </div>
                        @endcan
                        <tbody>
                            <tr>
                                <th>Sr. no.</th>
                                <th>Name</th>
                                <th>created_at</th>
                                {{-- <th>View</th> --}}
                                <th>Action</th>
                            </tr>
                            @forelse ($forms as $form)
                                <tr>
                                    <td>{{ $form->id ?? 'N/A' }}</td>
                                    <td>{{ $form->name ?? 'N/A' }}</td>
                                    <td>{{ $form->created_at ?? 'N/A' }}</td>
                                    <td>
                                        @can('form-view')
                                            <a href="{{ route('admin.form.show', ['form' => $form->id]) }}"
                                                class="btn btn-sm btn-primary">View</a>
                                        @endcan

                                        @can('form-edit')
                                            <a href="{{ route('admin.form.edit', ['form' => $form->id]) }}"
                                                class="btn btn-sm btn-success EDIT">Edit</a>
                                        @endcan

                                        @can('form-delete')
                                            <form action="{{ route('admin.form.destroy', ['form' => $form->id]) }}"
                                                method="POST" style="display: inline;" id="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger ABC"
                                                    onclick="confirmDelete(event)">Delete</button>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>

                            @empty
                                <tr>
                                    <td colspan="4" class="text-center ">
                                        Form data not available.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    @push('particular-scripts')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            function confirmDelete(event) {
                event.preventDefault();
                if (event.isTrusted) {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "Are you sure you want to delete this form?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#1B1B1B',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'Cancel',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('delete-form').submit();
                        }
                    });
                } else {
                    alert('Oho not authorize');
                }
            }
        </script>

        <script>
            $(document).ready(function() {
                function removeMsgFromUrl() {
                    const url = new URL(window.location.href);

                    if (url.searchParams.has('msg')) {
                        url.searchParams.delete('msg');
                        window.history.replaceState({}, document.title, url.toString());
                    }
                }

                setTimeout(removeMsgFromUrl, 1000);
                @php
                    Session::forget('success');
                @endphp
            });
        </script>
    @endpush
</x-admin-layout>
