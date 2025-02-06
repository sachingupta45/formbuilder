<script>
    jQuery(function ($) {

        var PreviousFormId=null;
        var previousFieldsData= @json($form['fields'] ?? []);
            PreviousFormId=@json($form['id'] ?? '');
        var options = {
            formData: previousFieldsData,
            dataType: 'json',
            onSave: function(evt, formData) {
             console.error('asfdjlasjldfjalsd');
             saveDta(evt,formData);
            },
        };

    // };

        // Initialize FormBuilder
        const formBuilder = $(document.getElementById('fb-editor')).formBuilder(options);

        // jQuery('#saveData').click(function (event) {
            function saveDta(evt,formFeid){
            // jQuery(this).disabled = true; // Disable button to prevent multiple submissions
            // var formFeid = formBuilder.actions.getData('json', true);
            const formData = new FormData();
            formData.append("form_structure", formFeid);
            formData.append("previous_form_id", PreviousFormId);

            fetch("{{route('form.store')}}", {
                method: "POST",
                headers: {
                  "X-CSRF-TOKEN": "{{ csrf_token() }}",
                },
                body: formData,
            })
            .then(response => response.json()) // Convert response to JSON
            .then(response => {
                if (response.success === true && response.redirect) 
                {
                    // Store success message for display after redirect
                    localStorage.setItem("success_message", "Your data has been saved successfully.");
                    // Redirect user
                    window.location.href = response.redirect;

                    iziToast.success({
                        title: "Success",
                        message: response.message,
                        position: "topCenter",
                    });

                    if (response.redirect) {
                        setTimeout(() => {
                            // window.location.href = response.redirect || "/";
                        }, 2000);
                    }
                }else if (response.errors) 
                {
                        // Handle validation errors
                        Object.values(response.errors).forEach(errorMessages => {
                            errorMessages.forEach(message => {
                                iziToast.error({
                                    title: "Invalid Submission",
                                    message: message,
                                    position: "topCenter",
                                });
                            });
                        });
                }else 
                {
                    // Handle warnings or unexpected responses
                    iziToast.warning({
                        title: "Warning",
                        message: response['message'] || "Something went wrong.",
                        position: "topCenter"
                    });
                }
            })
            .catch(error => {
                // Handle network errors
                iziToast.error({
                    title: "Error",
                    message: "An error occurred. Please try again.",
                    position: "topCenter"
                });
                console.error("Fetch error:", error);
            })
            .finally(() => {
                submitButton.disabled = false; // Re-enable button
            });
        };
        // });

    });
</script>