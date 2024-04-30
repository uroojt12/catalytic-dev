/**
 *	Neon Login Script
 *
 *	Developed by Arlind Nushi - www.laborator.co
 */

var neonChange = neonChange || {};

(function ($, window, undefined) {
  "use strict";

  $(document).ready(function () {
    neonChange.$container = $("#form_reset");

    // Login Form & Validation
    neonChange.$container.validate({
      rules: {
        opwd: {
          required: true,
        },
        npwd: {
          required: true,
        },
        cpwd: {
          required: true,
          equalTo: "#npwd",
        },
      },
      highlight: function (element) {
        $(element).closest(".input-group").addClass("validate-has-error");
      },
      unhighlight: function (element) {
        $(element).closest(".input-group").removeClass("validate-has-error");
      },
      submitHandler: function (ev) {
        /* 
                  Updated on v1.1.4
                  Login form now processes the login data, here is the file: data/sample-l.php
                  */

        $(".login-page").addClass("logging-in"); // This will hide the login form and init the progress bar

        // Hide Errors
        $(".form-login-error").slideUp("fast");

        // We will wait till the transition ends
        setTimeout(function () {
          var random_pct = 25 + Math.round(Math.random() * 30);

          // The form data are subbmitted, we can forward the progress to 70%
          neonChange.setPercentage(40 + random_pct);

          // Send data to the server
          $.ajax({
            url: baseurl + "settings/pass",
            method: "POST",
            dataType: "json",
            data: {
              opwd: $("input#opwd").val(),
              npwd: $("input#npwd").val(),
              cpwd: $("input#cpwd").val(),
            },
            error: function (response) {
              console.log(response);
              //console.log(response.login_status);

              alert("An error occoured!");
            },
            success: function (response) {
              // Login status [success|invalid]
              var login_status = response.login_status;

              // Form is fully completed, we update the percentage
              neonChange.setPercentage(100);

              // We will give some time for the animation to finish, then execute the following procedures
              setTimeout(function () {
                // If login is invalid, we store the
                if (login_status == "invalid") {
                  console.log(response);
                  $(".login-page").removeClass("logging-in");
                  $("#msg").find("p").html(response.invalid_respnse);
                  neonChange.resetProgressBar(true);
                  $("#opwd").focus();
                } else if (login_status == "success") {
                  // Redirect to login page
                  setTimeout(function () {
                    var redirect_url = baseurl;

                    if (response.redirect_url && response.redirect_url.length) {
                      redirect_url = response.redirect_url;
                    }

                    window.location.href = redirect_url;
                  }, 400);
                }
              }, 1000);
            },
          });
        }, 650);
      },
    });

    // Lockscreen & Validation
    var is_lockscreen = $(".login-page").hasClass("is-lockscreen");

    if (is_lockscreen) {
      neonChange.$container = $("#form_lockscreen");
      neonChange.$ls_thumb = neonChange.$container.find(".lockscreen-thumb");

      neonChange.$container.validate({
        rules: {
          password: {
            required: true,
          },
        },
        highlight: function (element) {
          $(element).closest(".input-group").addClass("validate-has-error");
        },
        unhighlight: function (element) {
          $(element).closest(".input-group").removeClass("validate-has-error");
        },
        submitHandler: function (ev) {
          /* 
                      Demo Purpose Only 
                      
                      Here you can handle the page login, currently it does not process anything, just fills the loader.
                      */

          $(".login-page").addClass("logging-in-lockscreen"); // This will hide the login form and init the progress bar

          // We will wait till the transition ends
          setTimeout(function () {
            var random_pct = 25 + Math.round(Math.random() * 30);

            neonChange.setPercentage(random_pct, function () {
              // Just an example, this is phase 1
              // Do some stuff...

              // After 0.77s second we will execute the next phase
              setTimeout(function () {
                neonChange.setPercentage(
                  100,
                  function () {
                    // Just an example, this is phase 2
                    // Do some other stuff...

                    // Redirect to the page
                    setTimeout("window.location.href = '../../'", 600);
                  },
                  2
                );
              }, 820);
            });
          }, 650);
        },
      });
    }

    // Login Form Setup
    neonChange.$body = $(".login-page");
    neonChange.$login_progressbar_indicator = $(
      ".login-progressbar-indicator h3"
    );
    neonChange.$login_progressbar = neonChange.$body.find(
      ".login-progressbar div"
    );

    neonChange.$login_progressbar_indicator.html("0%");

    if (neonChange.$body.hasClass("login-form-fall")) {
      var focus_set = false;

      setTimeout(function () {
        neonChange.$body.addClass("login-form-fall-init");

        setTimeout(function () {
          if (!focus_set) {
            neonChange.$container.find("input:first").focus();
            focus_set = true;
          }
        }, 550);
      }, 0);
    } else {
      neonChange.$container.find("input:first").focus();
    }

    // Focus Class
    neonChange.$container.find(".form-control").each(function (i, el) {
      var $this = $(el),
        $group = $this.closest(".input-group");

      $this.prev(".input-group-addon").click(function () {
        $this.focus();
      });

      $this.on({
        focus: function () {
          $group.addClass("focused");
        },
        blur: function () {
          $group.removeClass("focused");
        },
      });
    });

    // Functions
    $.extend(neonChange, {
      setPercentage: function (pct, callback) {
        pct = parseInt((pct / 100) * 100, 10) + "%";

        // Lockscreen
        if (is_lockscreen) {
          neonChange.$lockscreen_progress_indicator.html(pct);

          var o = {
            pct: currentProgress,
          };

          TweenMax.to(o, 0.7, {
            pct: parseInt(pct, 10),
            roundProps: ["pct"],
            ease: Sine.easeOut,
            onUpdate: function () {
              neonChange.$lockscreen_progress_indicator.html(o.pct + "%");
              drawProgress(parseInt(o.pct, 10) / 100);
            },
            onComplete: callback,
          });
          return;
        }

        // Normal Login
        neonChange.$login_progressbar_indicator.html(pct);
        neonChange.$login_progressbar.width(pct);

        var o = {
          pct: parseInt(
            (neonChange.$login_progressbar.width() /
              neonChange.$login_progressbar.parent().width()) *
              100,
            10
          ),
        };

        TweenMax.to(o, 0.7, {
          pct: parseInt(pct, 10),
          roundProps: ["pct"],
          ease: Sine.easeOut,
          onUpdate: function () {
            neonChange.$login_progressbar_indicator.html(o.pct + "%");
          },
          onComplete: callback,
        });
      },
      resetProgressBar: function (display_errors) {
        TweenMax.set(neonChange.$container, { css: { opacity: 0 } });

        setTimeout(function () {
          TweenMax.to(neonChange.$container, 0.6, {
            css: { opacity: 1 },
            onComplete: function () {
              neonChange.$container.attr("style", "");
            },
          });

          neonChange.$login_progressbar_indicator.html("0%");
          neonChange.$login_progressbar.width(0);

          if (display_errors) {
            var $errors_container = $(".form-login-error");

            $errors_container.show();
            var height = $errors_container.outerHeight();

            $errors_container.css({
              height: 0,
            });

            TweenMax.to($errors_container, 0.45, {
              css: { height: height },
              onComplete: function () {
                $errors_container.css({ height: "auto" });
              },
            });

            // Reset password fields
            neonChange.$container.find('input[type="password"]').val("");
          }
        }, 800);
      },
    });

    // Lockscreen Create Canvas
    if (is_lockscreen) {
      neonChange.$lockscreen_progress_canvas = $("<canvas></canvas>");
      neonChange.$lockscreen_progress_indicator = neonChange.$container.find(
        ".lockscreen-progress-indicator"
      );

      neonChange.$lockscreen_progress_canvas.appendTo(neonChange.$ls_thumb);

      var thumb_size = neonChange.$ls_thumb.width();

      neonChange.$lockscreen_progress_canvas.attr({
        width: thumb_size,
        height: thumb_size,
      });

      neonChange.lockscreen_progress_canvas =
        neonChange.$lockscreen_progress_canvas.get(0);

      // Create Progress Circle
      var bg = neonChange.lockscreen_progress_canvas,
        ctx = (ctx = bg.getContext("2d")),
        imd = null,
        circ = Math.PI * 2,
        quart = Math.PI / 2,
        currentProgress = 0;

      ctx.beginPath();
      ctx.strokeStyle = "#eb7067";
      ctx.lineCap = "square";
      ctx.closePath();
      ctx.fill();
      ctx.lineWidth = 3.0;

      imd = ctx.getImageData(0, 0, thumb_size, thumb_size);

      var drawProgress = function (current) {
        ctx.putImageData(imd, 0, 0);
        ctx.beginPath();
        ctx.arc(
          thumb_size / 2,
          thumb_size / 2,
          70,
          -quart,
          circ * current - quart,
          false
        );
        ctx.stroke();

        currentProgress = current * 100;
      };

      drawProgress(0 / 100);

      neonChange.$lockscreen_progress_indicator.html("0%");

      ctx.restore();
    }
  });
})(jQuery, window);
