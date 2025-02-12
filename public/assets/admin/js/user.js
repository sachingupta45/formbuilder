$(document).ready(function () {
    const rules = {
        name: {
            required: true,
            minlength: 3,
            maxlength: 255,
            regex: /^[a-zA-Z\s]+$/,
        },
        email: {
            required: true,
            email: true,
            regex: /^(?=.{1,254}$)[a-zA-Z0-9]+([._+-]?[a-zA-Z0-9]+)*@[a-zA-Z0-9]+([._-][a-zA-Z0-9]+)*\.[a-zA-Z]{2,10}$/,
        },

        password: {
            required: true,
            minlength: 8,
            regex: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z\d]).{8,32}$/,
        },
        password_confirmation: {
            required: true,
            equalTo: "#password",
        },
        role: {
            required: true,
        },

    };

    const messages = {
        name: {
            required: "First name is required.",
            minlength: "First name must be at least 3 characters.",
            maxlength: "First name cannot exceed 255 characters.",
            regex: "First name can only contain letters and spaces.",
        },
        email: {
            required: "Email id is required.",
            email: "Enter a valid email id.",
            regex: "Enter a valid email id.",
        },
        password: {
            required: "Password is required.",
            minlength: "Password must be at least 8 characters.",
            regex: "Password must contain at least one uppercase letter, one lowercase letter, one digit, and one special character. It must be 8-32 characters long.",
        },
        password_confirmation: {
            required: "Confirm password is required.",
            equalTo: "Password does not match.",
        },
        role: {
            required: "Role selection is required.",
        },


    };

    handleValidation("user-form", rules, messages);
});
