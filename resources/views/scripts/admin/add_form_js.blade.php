<script>
    jQuery(function($) {

        var $jq = jQuery.noConflict();
        var PreviousFormId = null;
        var previousFieldsData = @json($form['fields'] ?? []);
        PreviousFormId = @json($form['id'] ?? '');
        var options = {
            formData: previousFieldsData,
            dataType: 'json',
            fields: [{
                    label: "Salutation name",
                    type: "text",
                    subtype: "text_field",
                    icon: "Custom"
                },
                {
                    label: "First name",
                    type: "text",
                    subtype: "text_field",
                    icon: "Custom"
                },
                {
                    label: "Middle name",
                    type: "text",
                    subtype: "text_field",
                    icon: "Custom"
                },
                {
                    label: "Last name",
                    type: "text",
                    subtype: "text_field",
                    icon: "Custom"
                },
                {
                    label: "Email",
                    type: "text",
                    subtype: "email",
                    icon: "Custom"
                },
                {
                    label: "Street no",
                    type: "text",
                    subtype: "text_field",
                    icon: "Custom"
                },
                {
                    label: "Address line1",
                    type: "text",
                    subtype: "text_field",
                    icon: "Custom"
                },
                {
                    label: "City",
                    type: "text",
                    subtype: "text_field",
                    icon: "Custom"
                },
                {
                    label: "State",
                    type: "text",
                    subtype: "text_field",
                    icon: "Custom"
                },
                {
                    label: "Zipcode",
                    type: "text",
                    subtype: "text_field",
                    icon: "Custom"
                },
                {
                    label: "Country",
                    type: "text",
                    subtype: "text_field",
                    icon: "Custom"
                },
                {
                    label: "Phone Number",
                    type: "text",
                    icon: "Custom",
                    required: true
                },
                // {
                //     label: "File Upload",
                //     type: "file",
                //     subtype: "file",
                //     icon: "Custom",
                //     className: "form-control",
                //     multiple: true,
                //     required: false
                // }
            ],
            typeUserAttrs: {
                file: {
                    accepted_formats: {
                        label: 'Allowed File Types',
                        multiple: true,
                        options: {
                            'PDF': '.pdf',
                            'Word Documents': '.doc,.docx',
                            'Text Files': '.txt',
                            'Excel Files': '.xls,.xlsx',
                            'Images': '.jpg,.jpeg,.png',
                            'Audio Files': 'audio/*',
                            'Video Files': 'video/*'
                        }
                    },
                    max_file_size: {
                        label: 'Maximum File Size (MB)',
                        type: 'number',
                        value: '5',
                        min: '1',
                        max: '100'
                    },
                    max_files: {
                        label: 'Maximum Files Allowed',
                        type: 'number',
                        value: '1',
                        min: '1',
                        max: '10'
                    }
                }
            },
            disabledActionButtons: ['data'],
            controlPosition: 'left',
            disableFields: ['autocomplete', 'header', 'hidden', 'button', 'paragraph'],
            controlOrder: [
                'text',
                'textarea',
                'file'
            ],
            disabledAttrs: ['access'],
            onSave: function(evt, formData) {
                saveDta(evt, formData);
            },
            onAddField: function(fieldData) {
                if (fieldData.type === 'file') {
                    addFileValidation(fieldData);
                }
            }
        };

        function addFileValidation(fieldData) {
            var maxSize = parseInt(fieldData.max_file_size || 5) * 1024 * 1024;
            var maxFiles = parseInt(fieldData.max_files || 1);
            var acceptedFormats = fieldData.accepted_formats || '';

            $('[name="' + fieldData.name + '"]').on('change', function(e) {
                var files = e.target.files;
                var errors = [];

                if (files.length > maxFiles) {
                    errors.push('Maximum ' + maxFiles + ' files allowed');
                }

                Array.from(files).forEach(file => {
                    if (file.size > maxSize) {
                        errors.push('File "' + file.name + '" exceeds maximum size limit of ' + (maxSize / (1024 * 1024)) + 'MB');
                    }

                    if (acceptedFormats) {
                        var fileType = '.' + file.name.split('.').pop().toLowerCase();
                        var validType = acceptedFormats.split(',').some(format => {
                            if (format.includes('/*')) {
                                return file.type.startsWith(format.replace('/*', ''));
                            }
                            return format.toLowerCase().includes(fileType);
                        });

                        if (!validType) {
                            errors.push('File "' + file.name + '" has invalid format');
                        }
                    }
                });

                if (errors.length > 0) {
                    e.target.value = '';
                    errors.forEach(error => {
                        iziToast.error({
                            title: "Validation Error",
                            message: error,
                            position: "topCenter"
                        });
                    });
                }
            });
        }

        var formBuilder = $(document.getElementById('fb-editor')).formBuilder(options);

        function saveDta(evt, formFeid) {
            var formData = new FormData();
            formData.append("form_structure", formFeid);
            formData.append("previous_form_id", PreviousFormId);

            $('input[type="file"]').each(function() {
                var files = $(this)[0].files;
                Array.from(files).forEach(file => {
                    formData.append('files[]', file);
                });
            });

            fetch("{{ route('form.store') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                },
                body: formData,
            })
            .then(response => response.json())
            .then(response => {
                if (response.success === true && response.data) {
                      // localStorage.setItem("success_message",
                        //     "Your data has been saved successfully.");

                        // iziToast.success({
                        //     title: "Success",
                        //     message: response.message,
                        //     position: "topCenter",
                        // });
                    if (response.data) {
                        $('#main_editor_container').html(response.data);
                    }
                    window.location.href = '{{route('admin.form.index',['msg'=>'Your data has been saved successfully.' ])}}';
                } else if (response.errors) {
                    Object.values(response.errors).forEach(errorMessages => {
                        errorMessages.forEach(message => {
                            iziToast.error({
                                title: "Invalid Submission",
                                message: message,
                                position: "topCenter",
                            });
                        });
                    });
                } else {
                    iziToast.warning({
                        title: "Warning",
                        message: response['message'] || "Something went wrong.",
                        position: "topCenter"
                    });
                }
            })
            .catch(error => {
                iziToast.error({
                    title: "Error",
                    message: "An error occurred. Please try again.",
                    position: "topCenter"
                });
                console.error("Fetch error:", error);
            });
        }

        var formfield = @json($form->fields ?? []);
        if (!formfield) {
            return;
        }
        var formRenderOptions = {
            formData: formfield,
        }
        var formRenderInstance = $('#formbuilderdata').formRender(formRenderOptions);
        var form = $("#formdform");
        var validator = form.validate({});
        formRenderInstance.userData.forEach(function(field) {
            var fieldSelector = field.name ? "[name='" + field.name + "']" : "";
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

        function checkAndModify() {
            if ($('.sticky-controls').length) {
                let sticky = $('.sticky-controls');
                if (sticky.length) {
                    clearInterval(checkInterval);
                    $(sticky).parent().append("<div class='custom_options_tab'></div>");
                    $('.sticky-controls').appendTo('.custom_options_tab');
                    $('.sticky-controls').find('ul').prepend(
                        '<div class="inner_custom_switch_placement"><a class="active custom_entries" id="suggested">Suggested</a><a class="custom_entries" id="custom">Custom</a></div>'
                    );
                    hide_show('suggested', $('.sticky-controls').find('ul'));
                }
                $('.save-template').text('Save & Preview');
            }
        }

        function hide_show(value, element) {
            $('.custom_entries').removeClass('active');
            $('#' + value).addClass('active');
            var items = $(element).find('li');
            items.each(function(index, item) {
                var is_custom = $(item).find('span').find('span');
                if (value == "suggested") {
                    if (is_custom.length) {
                        $(is_custom).addClass('d-none');
                        $(item).removeClass('d-none');
                    } else {
                        $(item).addClass('d-none');
                    }
                } else {
                    if (is_custom.length) {
                        $(item).addClass('d-none');
                    } else {
                        $(item).removeClass('d-none');
                    }
                }
            });
        }

        $(document).on('click', '.custom_entries', function() {
            var value = $(this).attr('id');
            hide_show(value, $('.sticky-controls').find('ul'))
        });

        let checkInterval = setInterval(checkAndModify, 500);
    });
    </script>
