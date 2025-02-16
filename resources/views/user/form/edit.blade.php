<x-admin-layout>
    <section class="section">
        <div class="card">
            <form id="formdform" action="{{ route('user.form.update', $form) }}">
                <div class="card">
                    <div class="card-body" id="formbuilderdata"></div>
                </div>
                <button class="btn btn-info" type="submit" id="submitform">Update Data</button>
            </form>
        </div>
    </section>

    @push('particular-scripts')
        <script>
            jQuery(function($) {

                var formfield = @json($formStructure);
                var formData = @json($formData);

                if (!formfield) {
                    return;
                }

                // Render the form structure
                var formRenderOptions = {
                    formData: formfield,
                };
                var formRenderInstance = $('#formbuilderdata').formRender(formRenderOptions);

                // Populate form with existing data
                for (var key in formData) {
                    var field = $("[name='" + key + "']");
                    if (field.length) {
                        field.val(formData[key]); // Set the field value
                    }
                }

                // Validation setup
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

                // Handle form submission
                $('#formdform').on('submit', function(e) {
                    e.preventDefault();
                    let url = form.attr('action');
                    let form_data = $(this).serialize();
                    if (form.valid()) {
                        let response = ajaxCall(url, 'post', form_data);
                        response.then((response) => {
                            if (response.status == true) {
                                iziToast.success({
                                    title: 'Success',
                                    message: 'Form updated successfully!',
                                });
                            } else {
                                iziToast.error({
                                    title: 'Error',
                                    message: 'Failed to update the form.',
                                });
                            }
                        });
                    }
                });
            });
        </script>
    @endpush
</x-admin-layout>
