<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FormBuilder - Phone Number Field</title>

    <!-- jQuery and jQuery UI -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

    <!-- formBuilder and formRender -->
    <script src="https://formbuilder.online/assets/js/form-builder.min.js"></script>
    <script src="https://formbuilder.online/assets/js/form-render.min.js"></script>
    <!-- intlTelInput for country code dropdown -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/css/intlTelInput.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script>

    <style>
        .phone-container {
            display: flex;
            align-items: center;
            gap: 5px;
        }
    </style>
</head>
<body>

    <!-- Form Builder Container -->
    <div id="form-builder"></div>

    <!-- Button to Render the Form -->
    <button id="render-form">Render Form</button>

    <!-- Form Render Container -->
    <div id="form-render"></div>

    <script>
    jQuery(function($) {
        // ✅ Fix: Define fields as an array
        const customFields = [
            {
                label: "Phone Number",
                type: "phoneNumber",
                icon: "📞"
            }
        ];

        // ✅ Fix: Ensure templates are correctly formatted
        const templates = {
            phoneNumber: function(fieldData) {
                return `<div class="phone-container">
                            <input type="tel" class="phone-input form-control" placeholder="Enter phone number"/>
                        </div>`;
            }
        };

        // ✅ Fix: Pass fields as an array
        const formBuilder = $('#form-builder').formBuilder({
            fields: customFields, // <-- Now it's an array
            templates: templates
        });

        // Register the custom field in formRender
        $.fn.formRender.controls.phoneNumber = function(fieldData) {
            return {
                field: `<div class="phone-container">
                            <input type="tel" class="phone-input form-control" placeholder="Enter phone number"/>
                        </div>`,
                onRender: function() {
                    $(".phone-input").each(function() {
                        intlTelInput(this, {
                            initialCountry: "us",
                            separateDialCode: true,
                        });
                    });
                }
            };
        };

        // Button to render the form
        $('#render-form').on('click', function() {
            const formData = formBuilder.actions.getData(); // Get JSON form data
            $('#form-render').formRender({
                formData: formData
            });

            // Initialize intlTelInput in the rendered form
            $(".phone-input").each(function() {
                intlTelInput(this, {
                    initialCountry: "us",
                    separateDialCode: true,
                });
            });
        });
    });
    </script>

</body>
</html>
