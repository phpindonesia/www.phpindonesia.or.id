/*
 *  Document   : formsWizard.js
 *  Author     : pixelcave
 */
var FormsWizard = function () {
    return {
        init: function () {
            $("#basic-wizard").formwizard({
                focusFirstInput: !0,
                disableUIStyles: !0,
                inDuration: 0,
                outDuration: 0
            }), $("#advanced-wizard").formwizard({
                disableUIStyles: !0,
                validationEnabled: !0,
                validationOptions: {
                    errorClass: "help-block animation-slideDown",
                    errorElement: "span",
                    errorPlacement: function (e, a) {
                        a.parents(".form-group > div").append(e)
                    },
                    highlight: function (e) {
                        $(e).closest(".form-group").removeClass("has-success has-error").addClass("has-error"), $(e).closest(".help-block").remove()
                    },
                    success: function (e) {
                        e.closest(".form-group").removeClass("has-success has-error"), e.closest(".help-block").remove()
                    },
                    rules: {
                        val_username: {
                            required: !0,
                            minlength: 2
                        },
                        val_password: {
                            required: !0,
                            minlength: 5
                        },
                        val_confirm_password: {
                            required: !0,
                            equalTo: "#val_password"
                        },
                        val_email: {
                            required: !0,
                            email: !0
                        },
                        val_terms: {
                            required: !0
                        }
                    },
                    messages: {
                        val_username: {
                            required: "Please enter a username",
                            minlength: "Your username must consist of at least 2 characters"
                        },
                        val_password: {
                            required: "Please provide a password",
                            minlength: "Your password must be at least 5 characters long"
                        },
                        val_confirm_password: {
                            required: "Please provide a password",
                            minlength: "Your password must be at least 5 characters long",
                            equalTo: "Please enter the same password as above"
                        },
                        val_email: "Please enter a valid email address",
                        val_terms: "Please accept the terms to continue"
                    }
                },
                inDuration: 0,
                outDuration: 0
            })
        }
    }
}();