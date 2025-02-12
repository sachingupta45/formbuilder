$(document).ready(function () {
    // Validation rules
    const rules = {
        name: {
            required: true,
            minlength: 3,
            maxlength: 255,
        },
        category_id: {
            required: true,
        },
        status: {
            required: true,
        },
    };

    // Validation messages
    const messages = {
        name: {
            required: "name is required",
            minlength: "name must be at least 3 characters",
            maxlength: "name cannot exceed 255 characters",
        },
        category_id: {
            required: "category name is required",
        },
        status: {
            required: "status name is required",
        },
    };

    handleValidation("role-permission", rules, messages);
});
