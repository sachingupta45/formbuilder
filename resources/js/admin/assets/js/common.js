"use strict";

function handleValidation(formId, rules, messages) {
    $("#" + formId).validate({
        rules: rules,
        messages: messages,
        errorElement: "span",
        errorClass: "invalid-feedback",
        highlight: function (element) {
            $(element).addClass("is-invalid");
        },
        unhighlight: function (element) {
            $(element).removeClass("is-invalid");
        },
    });

    $.validator.addMethod(
        "regex",
        function (value, element, regexp) {
            if (regexp.constructor != RegExp) {
                regexp = new RegExp(regexp);
            } else if (regexp.global) {
                regexp.global = true;
            }

            return this.optional(element) || regexp.test(value);
        },
        "Enter a valid value"
    );

    $.validator.addMethod("mimes", function (value, element, allowedMimes) {
        var file = element.files[0];
        if (file) {
            return allowedMimes.split(',').includes(file.type);
        }
        return true; // If no file selected, validation passes
    }, "Invalid file type.");

    $.validator.addMethod("minsize", function (value, element, minSize) {
        var file = element.files[0];
        if (file) {
            return file.size >= minSize;
        }
        return true;
    }, "File is too small.");

    $.validator.addMethod("maxsize", function (value, element, maxSize) {
        var file = element.files[0];
        if (file) {
            return file.size <= maxSize;
        }
        return true;
    }, "File is too large.");
}

$(document).on('click', '.toggle-password', function () {
    const target = $(this).data('target');
    const input = $(target);
    const type = input.attr('type') === 'password' ? 'text' : 'password';
    input.attr('type', type);
    $(this).toggleClass('fa-eye fa-eye-slash');
});






