<x-admin-layout>
    <section class="section">
        <div class="card">
            <form id="formdform">
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
                }
                var formRenderInstance = $('#formbuilderdata').formRender(formRenderOptions);
                console.log(typeof(formRenderInstance.userData), formRenderInstance.userData);

                var form = $("#formdform");
                var validator = form.validate({
                    // Any global validation options can go here
                });
                formRenderInstance.userData.forEach(function(field) {
                    var fieldSelector = field.name ? "[name='" + field.name + "']" : "";
                    console.log(field.name, field.type);
                    if (fieldSelector) {
                        if (field.type == 'number') {
                            $(fieldSelector).rules("add", {
                                required: true,
                                min: 5,
                                messages: {
                                    required: field.label + " is required.",
                                    min: field.label + " minimum 5 number must be there."
                                }
                            });
                        } else {
                            $(fieldSelector).rules("add", {
                                required: true,
                                messages: {
                                    required: field.label + " is required."
                                }
                            });
                        }
                    }
                });

                jQuery('#submitform').validate({
                    submitHandler: function(form) {
                        form.submit();
                    }
                });
            });
        </script>
    @endpush
</x-admin-layout>
