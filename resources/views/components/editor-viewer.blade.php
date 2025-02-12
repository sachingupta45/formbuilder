<div class="col-12 col-md-6 col-lg-6">
    <div class="card">
        <div class="card-header">
            <h4>Editor</h4>
        </div>
        <div class="card-body">
            {{-- <div class="py-12"> --}}
            {{-- <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"> --}}
            <div class="bg-gray-300 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6  border-b border-gray-200 text-black">
                    <div id="fb-editor"></div>
                </div>
            </div>
            {{-- </div> --}}
            {{-- </div> --}}
        </div>
    </div>
</div>
<div class="col-12 col-md-6 col-lg-6">
    <div class="card">
        <div class="card-header">
            <h4>viewer</h4>
        </div>
        <div class="card-body">
            <form id="formdform">
                <div class="card">
                    <div class="card-body" id="formbuilderdata"></div>
                </div>

                <button class="btn btn-info" type="submit" id="submitform">Submit data</button>
            </form>
        </div>
    </div>
</div>

@push('styles')
    <style>
        .inner_custom_switch_placement a.active {
            border-bottom: 3px solid #000;
        }

        .inner_custom_switch_placement a {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            padding-bottom: 10px;
            border-bottom: 1px solid #0000003b;
            cursor: pointer;
        }

        .inner_custom_switch_placement {
            display: flex;
            padding: 10px 0;
        }

        .form-wrap.form-builder .cb-wrap {
            width: 100% !important;
        }

        .custom_options_tab {
            width: auto;
        }

        button {
            font-size: 12px !important;
            padding: 10px !important;
        }
    </style>
@endpush
@prepend('particular-scripts')
@include('scripts.admin.add_form_js')
@endprepend
