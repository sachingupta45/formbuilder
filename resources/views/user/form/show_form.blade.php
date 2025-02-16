<x-admin-layout>
    <section class="section">
        <div class="card">
            <form id="formdform" action="{{ route('user.store') }}">
                <input type="hidden" name="form_id" value="{{ jsencode_userdata($form->id ?? '') }}">
                <div class="card">
                    <div class="card-body" id="formbuilderdata"></div>
                </div>

                <button class="btn btn-info" type="submit" id="submitform">Submit data</button>
            </form>
        </div>
    </section>
    @push('particular-scripts')
        <script>
            jQuery(function($) {

                var formfield = @json($form->fields ?? []);

                if (!formfield) {
                    return;
                }

                var formRenderOptions = {
                    formData: formfield,
                };
                var formRenderInstance = $('#formbuilderdata').formRender(formRenderOptions);

                var form = $("#formdform");
                var validator = form.validate();

                formRenderInstance.userData.forEach(function(field) {
                    var fieldSelector = field.name ? "[name='" + field.name + "']" : "";

                    if (fieldSelector) {
                        var rules = {};
                        var messages = {};

                        if (field.required) {
                            rules.required = true;
                            messages.required = field.label + " is required.";
                        }

                        if (field.type === 'number' && field.min) {
                            rules.min = field.min;
                            messages.min = field.label + " must be at least " + field.min + ".";
                        }

                        if (Object.keys(rules).length > 0) {
                            $(fieldSelector).rules("add", {
                                ...rules,
                                messages: messages,
                            });
                        }
                    }
                });

                $('#formdform').on('submit', function(e) {
                    e.preventDefault();
                    let url = form.attr('action');
                    let form_data = $(this).serialize()

                    if (form.valid()) {
                        let response = ajaxCall(url, 'post', form_data);
                        response.then((response) => {
                            if (response.status == true) {
                                iziToast.success({
                                    title: 'Success',
                                    message: 'Form submitted successfully!',
                                });
                            } else {
                                iziToast.error({
                                    title: 'Error',
                                    message: 'Failed to submit the form. Please check your input.',
                                });
                            }
                        });

                    }
                });


            });
        </script>
    @endpush

</x-admin-layout>
