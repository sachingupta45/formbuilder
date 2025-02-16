<x-admin-layout>
    <section class="section">
        <div class="card">
            <form id="formdform" action="{{ route('user.form.store') }}" enctype="multipart/form-data">
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

                // Parse the fields from the JSON string
                const fields = JSON.parse(formfield);

                var formRenderOptions = {
                    formData: fields,
                };
                var formRenderInstance = $('#formbuilderdata').formRender(formRenderOptions);
                var form = $("#formdform");
                var validator = form.validate();

                // Custom validation methods for file inputs
                $.validator.addMethod("accept", function(value, element, param) {
                    const allowedTypes = param.split(',').map(type => type.trim());
                    const files = element.files;
                    for (let i = 0; i < files.length; i++) {
                        const fileType = files[i].type || files[i].name.split('.').pop().toLowerCase();
                        if (!allowedTypes.includes(fileType)) {
                            return false;
                        }
                    }
                    return true;
                });

                $.validator.addMethod("maxfilesize", function(value, element, param) {
                    const files = element.files;
                    for (let i = 0; i < files.length; i++) {
                        if (files[i].size > param) {
                            return false;
                        }
                    }
                    return true;
                });

                $.validator.addMethod("maxfiles", function(value, element, param) {
                    return element.files.length <= param;
                });

                fields.forEach(function(field) {
                    var fieldSelector = field.name ? "[name='" + field.name + "']" : "";
                    console.log("here", field);
                    console.log(field.accepted_formats)
                    if (fieldSelector) {
                        var rules = {};
                        var messages = {};

                        // Add required rule
                        if (field.required) {
                            rules.required = true;
                            messages.required = field.label + " is required.";
                        }

                        // Add file-specific validation rules
                        if (field.type === 'file') {
                            const acceptedFormats = field.accepted_formats.map(format => {
                                switch (format) {
                                    case 'Images':
                                        return '.jpg,.jpeg,.png';
                                    case 'PDF':
                                        return '.pdf';
                                    case 'Word Documents':
                                        return '.doc,.docx';
                                    case 'Text Files':
                                        return '.txt';
                                    case 'Excel Files':
                                        return '.xls,.xlsx';
                                    default:
                                        return '';
                                }
                            }).join(',');

                            rules.accept = acceptedFormats; // Allowed file types
                            rules.maxfilesize = (field.max_file_size || 5) * 1024 * 1024; // Convert MB to bytes
                            rules.maxfiles = field.max_files || 1;

                            messages.accept = `Only ${acceptedFormats} files are allowed.`;
                            messages.maxfilesize = `File size must not exceed ${field.max_file_size || 5} MB.`;
                            messages.maxfiles = `You can upload a maximum of ${field.max_files || 1} files.`;
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
                    let form_data = new FormData(this); // Use FormData to handle file uploads

                    if (form.valid()) {
                        let response = ajaxCall(url, 'post', form_data, {
                            processData: false, // Prevent jQuery from processing the data
                            contentType: false  // Prevent jQuery from setting the content type
                        });
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
