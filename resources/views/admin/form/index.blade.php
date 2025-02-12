<x-admin-layout>
    <section class="section"> 
        <div class="card">
            <div class="card-header">
              <h4>Full Width</h4>
            </div>
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table table-striped table-md display" id="formdatatable">
                  <div class="dt-buttons btn-group">          
                    <a href="{{route('admin.form.create')}}" class="btn  buttons-csv btn-info" tabindex="0" aria-controls="tableExport"><span>Add</span></a> 
                  </div>
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
                            <td>{{ $form->name ??'N/A' }}</td>
                            <td>{{ $form->created_at ??'N/A' }}</td>
                            {{-- <td><a href="{{route('admin.form.show',['form'=>$form->id])}}" class="btn bg-pink">View</a></td> --}}
                            <td><a href="{{route('admin.form.edit',['form'=>$form->id])}}" class="btn btn-primary">Edit</a></td>
                        </tr>

                      @empty
                        <tr>
                          <td colspan="4" class="text-center ">
                            Data not available

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
    <script>

        // document.addEventListener("DOMContentLoaded", (event) => {
        // console.log("DOM fully loaded and parsed");
        // });
    </script>
        
    @endpush
</x-admin-layout>
