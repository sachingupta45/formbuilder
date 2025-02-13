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
                    subtype: "email",
                    icon: "Custom"
                },
                {
                    label: "Addresss line1",
                    type: "text",
                    subtype: "email",
                    icon: "Custom"
                },
                {
                    label: "City",
                    type: "text",
                    subtype: "email",
                    icon: "Custom"
                },
                {
                    label: "State",
                    type: "text",
                    subtype: "email",
                    icon: "Custom"
                },
                {
                    label: "Zipcode",
                    type: "text",
                    subtype: "email",
                    icon: "Custom"
                },
                {
                    label: "Country",
                    type: "text",
                    subtype: "email",
                    icon: "Custom"
                },
                {
                    label: "Phone Number",
                    type: "text",
                    icon: "Custom",
                    required: true
                }
            ],
            disabledActionButtons: ['data'],
            controlPosition: 'left',
            disableFields: ['autocomplete', 'header', 'hidden', 'button', 'paragraph'],
            controlOrder: [
                'text',
                'textarea'
            ],
            disabledAttrs: [
                'access'
            ],
            onSave: function(evt, formData) {
                saveDta(evt, formData);
            },

        };
        var formBuilder = $(document.getElementById('fb-editor')).formBuilder(options);

        function saveDta(evt, formFeid) {
            var formData = new FormData();
            formData.append("form_structure", formFeid);
            formData.append("previous_form_id", PreviousFormId);

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
                })
                .finally(() => {
                    submitButton.disabled = false;
                });
        };
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
