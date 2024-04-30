$(document).ready(function () {
	/*var input = document.querySelector("#phone")
	if((typeof input !== 'undefined') && input)
	{
		var errorMap = [ "Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];
		var iti = window.intlTelInput(input, {
			// initialCountry: "auto",
			separateDialCode: true ,
			hiddenInput: "full_phone",
			// nationalMode: true,
			allowDropdown: true,
			onlyCountries: ["al", "ad", "at", "by", "be", "ba", "bg", "hr", "cz", "dk",
  "ee", "fo", "fi", "fr", "de", "gi", "gr", "va", "hu", "is", "ie", "it", "lv",
  "li", "lt", "lu", "mk", "mt", "md", "mc", "me", "nl", "no", "pl", "pt", "ro",
  "ru", "sm", "rs", "sk", "si", "es", "se", "ch", "ua", "gb"],
			initialCountry: 'nl',
			geoIpLookup: function(callback) {
				$.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
					var countryCode = (resp && resp.country) ? resp.country : "";
					callback(countryCode);
				});
			},
			utilsScript: base_url+"assets/intltelinput/utils.js"
		});
		iti.promise.then(function() {
			// input.value = iti.getNumber();
		});
		var itihandleChange = function() {
			iti.setNumber(input.value)
		};
		input.addEventListener('change', itihandleChange);
		input.addEventListener('keyup', itihandleChange);

		$.validator.addMethod(
			"valid_phone", 
			function(value, element) {
				if (input.value.trim()) {
					if (iti.isValidNumber()) {
						// $('#phnMsg').addClass('vald').removeClass('hide invald').text('Valid');
						$('#phnMsg').addClass('hide').removeClass('hide invald invald').text('');
						// element.value =iti.getNumber();
						return true;
					} else {
						var errorCode = iti.getValidationError();
						$('#phnMsg').addClass('invald').removeClass('hide vald').text(errorMap[errorCode]);
						return false;
					}
				}
			}
			);
		}*/
	/*
	$.validator.addMethod("pwcheck", function(value) {
		return /^[A-Za-z0-9\d=!\-@._*]*$/.test(value) // consists of only these
		&& /[a-z]/.test(value) // has a lowercase letter
		&& /\d/.test(value) // has a digit
		&& /([!,%,&,@,#,$,^,*,?,_,~])/.test(value) // has a special char
	}, "Please select strong password!");
	*/


	$.validator.addMethod("pwcheck", function (value, element) {
		/*if (value.length<8) {
			$(element).data('error', "Password must contains at least 8 character");
			return false;
		}*/
		if (!(/[a-z]/.test(value))) {
			$(element).data('error', "Password must contains at least 1 small letter");
			return false;
		}
		if (!(/[A-Z]/.test(value))) {
			$(element).data('error', "Password must contains at least 1 capital letter");
			return false;
		}
		if (!(/\d/.test(value))) {
			$(element).data('error', "Password must contains at least 1 number");
			return false;
		}
		if (!(/([!,%,&,@,#,$,^,*,?,_,~])/.test(value))) {
			$(element).data('error', "Password must contains at least 1 special character");
			return false;
		}
		$(element).data('error', "");
		return true;
	}, function (params, element) {
		return $(element).data('error');
	});

	$.validator.addMethod("atlease_one", function (value, elem, param) {
		return $(".atlst_one:checkbox:checked").length > 0;
	}, "You must select at least one!");

	$.validator.addClassRules({
		arrFld: {
			required: true,
			number: true,
			minlength: 1,
			maxlength: 1,
			min: 0,
			max: 9
		}
	});
	$.validator.addClassRules({
		strArrFld: {
			required: true
		}
	});
	$.validator.addClassRules({
		atlst_one: {
			atlease_one: true,
		}
	});
	$.validator.addMethod(
		"multiemail",
		function (value, element) {
			if (this.optional(element))
				return true;
			var emails = value.split(',');
			// var emails = value.split(/[;,]+/);
			valid = true;
			for (var i in emails) {
				value = emails[i];
				valid = valid && $.validator.methods.email.call(this, $.trim(value), element);
			}
			return valid;
		},
		'Please enter all emails in valid format'
	);


	$('#frmContact').validate({
		rules: {
			name: {
				required: true,
			},

			// lname: {
			// 	required: true,
			// },


			email: {
				required: true,
				email: true
			},
			phone: {
				required: true,
			},
			subject: {
				required: true,
			},
			post_code: {
				required: true,
			},
			msg: {
				required: true,
				minlength: 2,
			},
			confirm: "required"
		},
		errorPlacement: function () {
			return false;  // suppresses error message text
		}
	});



	$('#frmSignup').validate({
		rules: {
			full_name: {
				required: true,
			},
			// lname: {
			// 	required: true,
			// },
			phone: {
				required: true,
			},
			email: {
				required: true,
				email: true
			},
			password: {
				required: true,
				minlength: 8
			},
			cpswd: {
				required: true,
				minlength: 8,
				equalTo: '#password'
			},
			// confirm:{
			//     required: true
			// } 
		},
		errorPlacement: function () {
			return false;  // suppresses error message text
		}
	})
	$('#lot_finish_form').validate({
		rules: {
			email: {
				required: true,
				email: true
			},
			buisness_name: {
				required: true,
			},
		},
		errorPlacement: function () {
			return false;  // suppresses error message text
		}
	})



	$('#frmRequest').validate({
		rules: {
			payment_type: "required",
			card_holder_name: {
				required: true,
			},
			check_in: {
				required: true,
				date: true,
			},

			check_out: {
				required: true,
				date: true,

				// email: true
			},
			no_of_guests: {
				required: true,
			},

			fname: {
				required: true,
			},
			lname: {
				required: true,
			},
			email: {
				required: true,
				email: true,
			},
			phone: {
				required: true,
			},
			address1: {
				required: true,
			},
			country: {
				required: true,
			},

			state: {
				required: true,
			},

			city: {
				required: true,
			},

			zip_code: {
				required: true,
			},


			gst_fname: {
				required: true,
			},
			gst_lname: {
				required: true,
			},
			gst_email: {
				required: true,
				email: true,
			},
			gst_phone: {
				required: true,
			},
			gst_address1: {
				required: true,
			},
			gst_country: {
				required: true,
			},

			gst_state: {
				required: true,
			},

			gst_city: {
				required: true,
			},

			gst_zip_code: {
				required: true,
			},


		},
		errorPlacement: function () {
			return false;  // suppresses error message text
		}
	});

	$('#payment-form').validate({
		rules: {
			fname: {
				required: true,
			},
			lname: {
				required: true,
			},
			email: {
				required: true,
				email: true
			},
			address: {
				required: true,
			},

			city: {
				required: true,
			},

			country: {
				required: true,
			},

			state: {
				required: true,
			},

			postal_code: {
				required: true,
			},

			card_holder_name: {
				required: true,
			},

		},
		errorPlacement: function () {
			return false;  // suppresses error message text
		}
	});

	$('#frmNewsletter').validate({
		rules: {
			email: {
				required: true,
				email: true,
			}
		},
		errorPlacement: function () {
			return false;  // suppresses error message text
		}
	});
	$('#frmSetting').validate({
		rules: {
			fname: {
				required: true,
			},
			lname: {
				required: true,
			},
			dob: {
				required: true,
			},
			phone: {
				required: true,
			},
			zip: {
				required: true,
			},
			country: {
				required: true,
			}
		},
		errorPlacement: function () {
			return false;  // suppresses error message text
		}
	})
	$('#frmChangePass').validate({
		// errorElement: 'div',
		rules: {
			pswd: {
				required: true,
			},
			npswd: {
				required: true,
				// pwcheck: true,
				minlength: 8
			},
			cpswd: {
				required: true,
				// pwcheck: true,
				minlength: 8,
				equalTo: '#npswd'
			}
		},
		errorPlacement: function (error, element) {
			return false;
		}
	});
	$('#frmReset').validate({
		// errorElement: 'div',
		rules: {
			password: {
				required: true,
				// pwcheck: true,
				minlength: 8
			},
			cpswd: {
				required: true,
				// pwcheck: true,
				minlength: 8,
				equalTo: '#password'
			}
		},
		errorPlacement: function (error, element) {
			return false;
		}
	});
	$('#frmLogin').validate({
		rules: {
			email: {
				required: true,
				email: true
			},
			password: {
				required: true,
			}
		},
		errorPlacement: function () {
			return false;  // suppresses error message text
		}
	})
	$('#frmForgot').validate({
		rules: {
			email: {
				required: true,
				email: true
			}
		},
		errorPlacement: function () {
			return false;  // suppresses error message text
		}/*,
        messages: {
            email:{
                required: "Email required",
                email: "Please enter valid email"
            }
        }*/
	});

	$('#frmProfile').validate({
		rules: {
			full_name: {
				required: true,
			},
			lname: {
				required: true,
			},
			country: {
				required: true,
			},

			dob: {
				required: true,
			},
			gender: {
				required: true,
			},

			phone: {
				required: true,
			},
			city: {
				required: true,
			},
			state: {
				required: true,
			},
			address: {
				required: true,
			},
			zip_code: {
				required: true,
			},
			// bio: {
			//     required: true,
			// },
		},
		errorPlacement: function () {
			return false;  // suppresses error message text
		}
	})


	$('#frmCode').validate({
		rules: {
			code: {
				required: true,
			},
			expire_date: {
				required: true,
			},
			discount_type: {
				required: true,
			},

			discount_percentage: {
				required: true,
			},
			discount_price: {
				required: true,
			},


		},
		errorPlacement: function () {
			return false;  // suppresses error message text
		}
	})





});
