/**
 *	Neon Login Script
 *
 *	Developed by Arlind Nushi - www.laborator.co
 */

var neonuserRegister = neonuserRegister || {};

;
(function ($, window, undefined)
{
    "use strict";

    $(document).ready(function ()
    {
        neonuserRegister.$container = $("#form_reg");


        // Login Form & Validation
        neonuserRegister.$container.validate({
            rules: {
                fname: {
                    required: true
                },
                lname: {
                    required: true
                },
                email: {
                    required: true,
                    email: true
                },
                pwd: {
                    required: true
                },
            },
            messages: {
                email: {
                    email: 'Invalid E-mail.'
                }
            },
            highlight: function (element) {
                $(element).closest('.input-group').addClass('validate-has-error');
            },
            unhighlight: function (element)
            {
                $(element).closest('.input-group').removeClass('validate-has-error');
            },
            submitHandler: function (ev)
            {
                 neonuserRegister.submit();
                /* 
                 Updated on v1.1.4
                 Login form now processes the login data, here is the file: data/sample-l.php
                 */




                // Hide Errors


                // We will wait till the transition ends				
              
            }
        });











    });

})(jQuery, window);