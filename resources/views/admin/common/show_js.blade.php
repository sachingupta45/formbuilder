<script>
    jQuery('.show-password').on('click', function() {
        let cls = jQuery(this).hasClass('fa-eye-slash');

        cls == true ? jQuery(this).removeClass("fa-eye-slash").addClass("fa-eye") : jQuery(this)
            .removeClass(
                "fa-eye").addClass("fa-eye-slash");

        var type = jQuery(this).closest(".form-group").find(".password-field").attr('type') ===
            "password" ?
            "text" : "password";

        jQuery(this).closest(".form-group").find(".password-field").attr('type', type);
    });
</script>
