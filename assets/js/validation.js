$(document).ready(function () {

 /*   $("#customer_login_form").validate({
        rules: {
            email: {
                required: true,
                email: true
            },
            password: {
                required: true
            }
        },
        messages: {
            email: {
                required: "Please Provide Email Address",
                email: "Enter A Valid Email Address"
            },
            password: "Please Provide Your Password"
        },

        errorElement: "em",
        errorPlacement: function (error, element) {
            // Add the `help-block` class to the error element
            error.addClass("help-block");

            if (element.prop("type") === "checkbox") {
                error.insertAfter(element.parent("label"));
            } else {

                error.insertAfter(element.parent("div"));
            }
        },
        highlight: function (element, errorClass, validClass) {
            $(element).parents(".error-message").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".error-message").addClass("has-success").removeClass("has-error");
        },
        submitHandler: function (form) {
            $.post($("#customer_login_form").attr('action'), $("#customer_login_form").serialize(), function (data) {
                location.reload();
            });
        }

    });*/


    $('#customer-registration-form').validate({
        rules: {
            first_name: "required",

            email: {
                required: true,
                email: true
            },
            password:{
                required: true,
                minlength: 5,
            },
            confirm_password: {
                required: true,
                minlength: 5,
                equalTo:'#password-reg'
            }

        },
        messages: {
            first_name: "Please Enter First Name",
            email: {
                required: "Please Provide Email Address",
                email: "Enter A Valid Email Address"
            },
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 5 characters long"
            },
            confirm_password: {
                required: "Please provide a confirm password",
                minlength: "Your password must be at least 5 characters long",
                equalTo: "Password does not match"
        }

            /* profile_pic:{
             required:"Please Browse Profile picture",
             extension:"Image Should Be JPG OR PNG format"
             }*/
        },

        errorElement: "em",
        errorPlacement: function (error, element) {
            // Add the `help-block` class to the error element
            error.addClass("help-block");

            if (element.prop("type") === "checkbox") {
                error.insertAfter(element.parent("label"));
            } else {
                error.insertAfter(element);
            }
        },
        highlight: function (element, errorClass, validClass) {
            $(element).parents(".error-message").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".error-message").addClass("has-success").removeClass("has-error");
        },


        submitHandler: function (form) {

            $.post($('#customer-registration-form').attr('action'), $("#customer-registration-form").serialize(), function (data) {
                location.reload();

            });
        }
    });
    $('#customer-update-form').validate({

        rules: {
            first_name: "required",

            email: {
                required: true,
                email: true
            },

            password: {
                required: true,
                minlength: 5,
            },
            confirm_password: {
                required: true,
                equalTo: '#password'
            }

        },
        messages: {
            first_name: "Please Enter First Name",
            email: {
                required: "Please Provide Email Address",
                email: "Enter A Valid Email Address"
            },

            password: {
                required: "Please Provide A Password",
                minlength: "Your password must be at least 5 characters long"
            },
            confirm_password: {
                required: "Please Provide Confirm Password",
                equalTo: "Password Match",
            }
            /* profile_pic:{
             required:"Please Browse Profile picture",
             extension:"Image Should Be JPG OR PNG format"
             }*/
        },

        errorElement: "em",
        errorPlacement: function (error, element) {
            // Add the `help-block` class to the error element
            error.addClass("help-block");

            if (element.prop("type") === "checkbox") {
                error.insertAfter(element.parent("label"));
            } else {
                error.insertAfter(element);
            }
        },
        highlight: function (element, errorClass, validClass) {
            $(element).parents(".error-message").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".error-message").addClass("has-success").removeClass("has-error");
        },


        submitHandler: function (form) {
            $.post($('#customer-update-form').attr('action'), $("#customer-update-form").serialize(), function (data) {
                location.reload();

            });
        }
    });


    $("#customer-registration-form #email:input").on('focusout', function () {
        $.ajax({
            type: "POST",
            url: 'my_account/is_email_exist',
            data: {'email': $(this).val()},
            success: function (data) {
                $('.message-email-exist').empty();
                $(data).insertAfter('#customer-registration-form #email:input');
            },
            error: function (error) {
                console.log("error occured");
            }
        });
    });

    $("#contact-us-form").validate({
        rules: {

            name: {
                required: true
            },
            email: {
                required: true,
                email: true
            },
            phone: {
                required: true
            },
            message: {
                required: true
            }

        },
        messages: {
            name: "Please Enter You Name",
            email: {
                required: "PLease Enter a email address",
                email: "PLease Enter a Valid Email"
            },
            phone: "Please Enter Phone Number",
            message: "Please Write Message",
        },

        errorElement: "em",
        errorPlacement: function (error, element) {
            // Add the `help-block` class to the error element

            error.addClass("help-block");


            if (element.prop("type") === "checkbox") {
                error.insertAfter(element.parent("label"));
            } else {
                error.insertAfter(element);
            }
        },
        highlight: function (element, errorClass, validClass) {
            $(element).parents(".error-message").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).parents(".error-message").addClass("has-success").removeClass("has-error");
        },


        submitHandler: function (form) {
            $.post(form.attr('action'), form.serialize(), function (data) {
                $('.contact-us').html(data);
            });
        }
    });
});
