var elements = stripe.elements();
var style = {
    base: {
        color: "#32325d",
        background : "#e8e8e8"
    }
};

var card = elements.create("card", { style: style });
card.mount("#card-element");
card.on('change', ({ error }) => {
    // console.log(error);
    let displayError = document.getElementById('card-errors');
    if (error) {
        displayError.textContent = error.message;
        displayError.classList.add("alert");
        displayError.classList.add("alert-danger");
    } else {
        displayError.textContent = '';
        displayError.classList.remove("alert");
        displayError.classList.remove("alert-danger");
    }
});
let form = document.getElementById('payment-form');
function getFormObj(formId) {
    var formObj = {};
    var inputs = $('#' + formId).serializeArray();
    $.each(inputs, function (i, input) {
        formObj[input.name] = input.value;
    });
    return formObj;
}
let paymentErrors = document.getElementById('card-errors');
(function ($) {
	$.fn.getFormData = function () {
		var data = {};
		var dataArray = $(this).serializeArray();
		for (var i = 0; i < dataArray.length; i++) {

            if (dataArray[i].name == 'tracks[]') {
                let tracks = $('input[name="tracks[]"]');
                // console.log(tracks.length)
                if (tracks.length > 0) {
                    paymentErrors.textContent = '';
                    paymentErrors.classList.remove("alert");
                    paymentErrors.classList.remove("alert-danger");

                    let prds = [];
                    $.each(tracks, function (index, item) {
                        prds.push($(item).val());
                    });
                    data['tracks'] = prds;
                }
                else {
                    paymentErrors.textContent = 'Please select Tracks';
                    paymentErrors.classList.add("alert");
                    paymentErrors.classList.add("alert-danger");
                }
            }

			data[dataArray[i].name] = dataArray[i].value;
		}
		return data;
	}
})(jQuery);
let errors = document.getElementById('card-errors');
$(function () {
    $(document).on('submit', '#payment-form', function (e) {
        e.preventDefault();
        needToConfirm = true;
        let frmData = $(this).getFormData();

        console.log(frmData);

        $(this).find('button[type="submit"]').attr("disabled", true).find("i.spinner").removeClass("hidden");
        
        if ($('input[name="payment_type"]:checked').val() == 'paypal') {
            submit_form();
        } else if ($('input[name="payment_type"]:checked').val() == 'credit-card') {
            // createToken returns immediately - the supplied callback submits the form if there are no errors
            stripe.createPaymentMethod('card', card).then(function (result) {
                if (result.error) {
                    errors.textContent = result.error.message;
                    errors.classList.add("alert");
                    errors.classList.add("alert-danger");
                    document.getElementById("checkout_btn").disabled = false;
                    document.getElementById("checkout-spinner").classList.add("hidden");
                    var scrollDiv = errors.offsetTop;
                    window.scrollTo({ top: scrollDiv, behavior: 'smooth' });
                    return;
                }
                errors.textContent = "";
                errors.classList.remove("alert");
                errors.classList.remove("alert-danger");

                fetch(base_url + 'payment/create_payment', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        payment_method_id: result.paymentMethod.id,
                        card: result.paymentMethod.card,
                        data: frmData
                    })
                })
                    .then(function (responseBody) {
                        return responseBody.json()
                    })
                    .then(handleServerResponse);
            });
        }

        return false; // submit from callback
    });

    function handleServerResponse(response) {
        document.getElementById("payment-errors").textContent = '';
        document.getElementById("payment-errors").classList.remove("alert");
        document.getElementById("payment-errors").classList.remove("alert-danger");
        if (response.error) {

            document.getElementById("payment-errors").classList.add("alert");
            document.getElementById("payment-errors").classList.add("alert-danger");
            document.getElementById("checkout_btn").disabled = false;
            document.getElementById("checkout-spinner").classList.add("hidden");
            if (response.error.message) {
                document.getElementById("payment-errors").textContent = response.error.message;
            }
            else {
                document.getElementById("payment-errors").textContent = response.error;
            }
            var scrollDiv = document.getElementById("payment-errors").offsetTop;
            window.scrollTo({ top: scrollDiv, behavior: 'smooth' });
            setTimeout(function () {
                if (response.redirect_url) {
                    window.location.href = response.redirect_url;
                }
            }, 2000);
        } else if (response.requires_action) {
            document.getElementById("payment-errors").textContent = "Requires action";
            document.getElementById("payment-errors").classList.add("alert");
            document.getElementById("payment-errors").classList.add("alert-info");
            // Use Stripe.js to handle required card action
            handleAction(response);
        }
        else if (response.success) {
            document.getElementById("payment-errors").textContent = '';
            document.getElementById("payment-errors").classList.remove("alert");
            document.getElementById("payment-errors").classList.remove("alert-danger");
            submit_form(response.card);
        }
        else {
            document.getElementById("payment-errors").textContent = "Success!";
            document.getElementById("payment-errors").classList.add("alert");
            document.getElementById("payment-errors").classList.add("alert-success");
            document.getElementById("payment-form").submit();
        }
    }

    function handleAction(response) {
        console.log(response);
        stripe.handleCardAction(
            response.payment_intent_client_secret
        ).then(function (result) {
            // console.log(result);
            if (result.error) {
                document.getElementById("checkout_btn").disabled = false;
                document.getElementById("checkout-spinner").classList.add("hidden");
                document.getElementById("payment-errors").textContent = result.error.message;
                document.getElementById("payment-errors").classList.add("alert");
                document.getElementById("payment-errors").classList.add("alert-danger");
                var scrollDiv = document.getElementById("payment-errors").offsetTop;
                window.scrollTo({ top: scrollDiv, behavior: 'smooth' });
            } else {
                document.getElementById("payment-errors").textContent = '';
                document.getElementById("payment-errors").classList.remove("alert");
                document.getElementById("payment-errors").classList.remove("alert-danger");
                // The card action has been handled
                // The PaymentIntent can be confirmed again on the server
                fetch(base_url + 'payment/confirm_payment', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        payment_intent_id: result.paymentIntent.id,
                        card: response.card,
                    })
                }).then(function (confirmResult) {
                    return confirmResult.json();
                }).then(handleServerResponse);
            }
        });
    }


    function submit_form(card = '') {
        console.log(card);
        let form$ = $("#payment-form");
        let sbtn = form$.find("button[type='submit']");
        let frmIcon = form$.find("button[type='submit'] i.spinner");

        let frmData = new FormData(form$[0]);
        for (var key in card) {
            frmData.append(key, card[key]);
        }
        let frmMsg = form$.find("div.alertMsg:first");
        // if (!empty($nonce))
        //     frmData.append('nonce', $nonce);
        $.ajax({
            url: form$.attr('action'),
            data: frmData,
            dataType: 'JSON',
            method: 'POST',
            processData: false,
            contentType: false,
            success: function (rs) {
                console.log(rs);

                if (rs.status == 1) {
                    toastr.success(rs.msg, '', optsuccess);
                    setTimeout(function () {
                        frmIcon.addClass("hidden");
                        form$[0].reset();
                        window.location.href = rs.redirect_url;
                    }, 3000);
                } else {
                    toastr.error(rs.msg, '', opterror);
                    setTimeout(function () {
                        frmIcon.addClass("hidden");
                        sbtn.attr("disabled", false);
                    }, 3000);
                }
            },
            error: function (rs) {
                console.log(rs);
                // alert('Network error has occurred please try again!');
            },
            complete: function (rs) {
                needToConfirm = false;
            }
        });
    }


    $('#payment-form').validate({
        rules: {
            payment: "required",
            // card_holder_name: {
            //     required: true,
            // },
            // cardnumber: {
            //     required: true,
            //     maxlength: 19
            // },
            // exp_month: {
            //     required: true,
            // },
            // exp_year: {
            //     required: true,
            // },
            // cvc: {
            //     required: true,
            //     maxlength: 4
            // },
            full_name: {
                required: true,
            },
           
            email: {
                required: true,
                email: true
            },
            phone: {
                required: true,
            },
            address: {
                required: true,
            },
            city: {
                required: true,
            },
            state: {
                required: true,
            },
            country: {
                required: true,
            },
            postal_code: {
                required: true,
            },
            ship_fname: {
                required: true,
            },
            ship_email: {
                required: true,
                email: true
            },
            ship_phone: {
                required: true,
            },
            ship_address: {
                required: true,
            },
            ship_country: {
                required: true,
            },
            ship_state: {
                required: true,
            },
            ship_city: {
                required: true,
            },
            ship_zip: {
                required: true,
            },
            duration: {
                required: true,
            },
            card_holder_name: {
                required: true,
            },

        }, errorPlacement: function () {
            return false;
        }
    });
});
