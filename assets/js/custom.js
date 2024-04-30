var optsuccess = {
  closeButton: true,
  debug: false,
  positionClass: "toast-bottom-right",
  onclick: null,
  showDuration: "300",
  hideDuration: "5000",
  timeOut: "5000",
  extendedTimeOut: "1000",
  showEasing: "swing",
  hideEasing: "linear",
  showMethod: "slideDown",
  hideMethod: "slideUp",
};

var opterror = {
  closeButton: true,
  debug: false,
  positionClass: "toast-bottom-right",
  onclick: null,
  showDuration: "300",
  hideDuration: "5000",
  timeOut: "5000",
  extendedTimeOut: "1000",
  showEasing: "swing",
  hideEasing: "linear",
  showMethod: "slideDown",
  hideMethod: "slideUp",
};

function shareFacebook(url, title) {
  window.open(
    "https://www.facebook.com/share.php?u=" + url + "&title=" + title,
    "sharer",
    "toolbar=0,status=0,width=548,height=325,top=170,left=400"
  );
}
function shareLinkedin(url, title, text, site_name) {
  window.open(
    "https://www.linkedin.com/shareArticle?mini=true&url=" +
    url +
    "&title=" +
    title +
    "&summary=" +
    text +
    "&source=" +
    site_name
  );
}
function shareTwitter(url, title) {
  window.open("https://twitter.com/intent/tweet?text=" + title + "&url=" + url);
}
function shareGoogle(url, title) {
  window.open(
    "https://plus.google.com/share?url=" + url + "&title=" + title,
    "sharer",
    "toolbar=0,status=0,width=548,height=325,top=170,left=400"
  );
}
function sharePinterest(url, image, title) {
  window.open(
    "https://pinterest.com/pin/create/button/?url=" +
    url +
    "&media=" +
    image +
    "&description=" +
    title,
    "sharer",
    "toolbar=0,status=0,width=548,height=325,top=170,left=400"
  );
}
function shareWhatsapp(title) {
  document.location = "whatsapp://send?text=" + title;
}
$(document).ready(function () {
  let usds = Intl.NumberFormat("en-US", {
    style: "currency",
    currency: "USD",
    useGrouping: false,
  });

  if (typeof recaptcha !== "undefined" && recaptcha) {
    var frmAjax = "";
    $(document).on("click", '.frmAjax button[type="submit"]', function (e) {
      e.preventDefault();
      frmAjax = $(this).parents(".frmAjax");

      if (frmAjax.valid()) {
        if ($("#g-recaptcha-response").val()) {
          frmAjax.submit();
        } else grecaptcha.execute();
      }
    });
    onSubmit = function (token) {
      frmAjax.submit();
    };
  } else {
    $(document).on("click", '.frmAjax button[type="submit"]', function (e) {
      let frm = $(this).parents(".frmAjax");
      $(frm).validate({
        errorPlacement: function () {
          return false; // suppresses error message text
        },
      });
    });
  }

  $(document).on("submit", ".frmAjax", function (e) {
    e.preventDefault();
    needToConfirm = true;
    var frmbtn = $(this).find("button[type='submit']");
    // console.log(frmbtn);
    var frmIcon = frmbtn.find("i");
    frmIcon.removeClass("hidden");

    frmIcon.attr("style", "");
    frmbtn.attr("disabled", true);
    // console.log(frmIcon); return;
    var frmMsg = $(this).find("div.alertMsg:first");
    var frm = this;

    frmMsg.hide();
    $.ajax({
      url: $(this).attr("action"),
      data: new FormData(frm),
      processData: false,
      contentType: false,
      dataType: "JSON",
      method: "POST",

      error: function (rs) {
        console.log(rs);
      },
      success: function (rs) {
        // console.log(rs); return;
        if (rs.session_login === 1) {
          localStorage.setItem("session_arr", rs.session_arr);
        }
        if (rs.status == 1) {
          if (rs.formSuccess == 1) {
            frm.reset();
            $(".popup").fadeOut();
            $("body").removeClass("flow");
            // $(this).parents('.popup').find('form').attr('action', '');
            setTimeout(function () {
              location.reload();
            }, 1000);
          }
          toastr.success(rs.msg, "", optsuccess);
          setTimeout(function () {
            frm.reset();
            frmIcon.addClass("hidden");
            frmIcon.css("display", "none");
            if (rs.redirect_url) {
              window.location.href = rs.redirect_url;
            } else {
              frmbtn.attr("disabled", false);
            }
          }, 3000);
        } else {
          toastr.error(rs.msg, opterror);
          setTimeout(function () {
            if (rs.hide_msg) frmMsg.slideUp(500);
            frmbtn.attr("disabled", false);
            frmIcon.addClass("hidden");
            frmIcon.css("display", "none");

            if (rs.redirect_url) window.location.href = rs.redirect_url;
          }, 3000);
        }
      },
      complete: function (rs) {
        needToConfirm = false;
      },
    });
  });

  $(document).on("click", ".btn_tabs", function () {
    $("#music_data").html(
      '<br><br><div class="text-center"><div class="spinner-border text-danger" style="width: 5rem; height: 5rem;" role="status"><span class="visually-hidden">Loading...</span></div></div>'
    );
    $(".btn_tabs").removeClass("active");
    let tab = $(this).data("tab");
    $(this).addClass("active");

    // alert(id);
    $.ajax({
      url: base_url + "Ajax/get_data/",
      data: { tab },
      dataType: "JSON",
      method: "POST",
      success: function (rs) {
        if (rs.status == true) {
          $("#music_data").html(rs.html);
        } else {
          window.location.href = rs.redirect_url;
        }
      },
      error: function (rs) {
        console.log(rs);
      },
      complete: function (rs) {
        // console.log(rs);
      },
    });
  });

  $(document).on("change", '[name="payment_type"]', function () {
    let type = $(this).val();
    console.log(type);
    if (type == "paypal") {
      $("#card-det-sec").hide();
    } else if (type == "credit-card") {
      $("#card-det-sec").show();
    }
  });

  $(document).on("change", '[name="payment_method"]', function () {
    let type = $(this).val();
    console.log(type);
    if (type == "cashapp") {
      $("#paypal-don").addClass("hidden");
      $("#cashapp-don").removeClass("hidden");
    } else if (type == "paypal") {
      $("#paypal-don").removeClass("hidden");
      $("#cashapp-don").addClass("hidden");
    }
  });

  $(document).on("change", "#country", function () {
    let country_id = $(this).val();
    $.ajax({
      url: base_url + "Ajax/get_states/" + country_id,
      dataType: "JSON",
      method: "GET",
      success: function (rs) {
        if (rs != "") {
          $("#state").html(rs);
        }
      },
      error: function (rs) {
        console.log(rs);
      },
      complete: function (rs) {
        // console.log(rs);
      },
    });
  });

  $(document).on("change", ".uploadFile[data-upload]", function () {
    $(".user_img_box").html(
      '<div class="text-center"><div class="spinner-border text-danger" role="status"><span class="visually-hidden">Loading...</span></div></div>'
    );
    let file_id = $(this).attr("id");
    needToConfirm = true;
    var progressBar = document.getElementById("myBar");
    var image_type = $(this).data("file");
    $("#progress-contain").show();
    var elem = $(".pBar");
    var myFileList = document.getElementById(file_id).files;
    console.log(myFileList);
    if (typeof myFileList[0] === "undefined" || !myFileList[0]) {
      alert("Please select a file!");
      return false;
    }
    var myFile = myFileList[0];
    var formData = new FormData();
    formData.append("image", myFile);
    formData.append("image_type", image_type);
    var xhr = new XMLHttpRequest();
    console.log(xhr);
    xhr.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        // Typical action to be performed when the document is ready:
        var data = this.responseText;
        console.log(data);
        var jsonResponse = JSON.parse(data);

        if (jsonResponse.upload_status == 1) {
          if (image_type == "cover_image") {
            $("#cover-image").css(
              "background-image",
              "url(" + jsonResponse.image + ")"
            );
          } else if (image_type == "intro_video_poster") {
            $("#intro-image").css(
              "background-image",
              "url(" + jsonResponse.image + ")"
            );
          } else {
            $("#userImage").attr("src", jsonResponse.image);
          }

          setTimeout(function () {
            location.reload();
          }, 1000);
        } else alert("Uploading Error!");
        needToConfirm = false;
      }
    };

    xhr.upload.onloadstart = function (e) {
      elem.removeClass("hidden");
      progressBar.style.width = "0%";
    };
    xhr.upload.onprogress = function (e) {
      if (e.lengthComputable) {
        var ratio = Math.floor((e.loaded / e.total) * 100) + "%";
        progressBar.style.width = ratio;
      }
    };
    xhr.upload.onloadend = function (e) {
      progressBar.style.width = "100%";
      $("#progress-contain").hide();
    };

    xhr.open("POST", base_url + "ajax/save_mem_images");
    xhr.send(formData);
  });
  $(document).on("click", ".remove_identification", function () {
    $(this).parent(".bid-row").remove();
  });
  $(document).on("change", "#uploadIdentification", function () {
    needToConfirm = true;
    var progressBar = document.getElementById("myBar1");
    var image_type = $(this).data("file");
    $("#progress-contain-vehicle").show();
    var elem = $(".pBar");
    let uploadedArea = $(".uploaded-area");
    // uploadedArea.html("Uploading...");
    var myFileList = this.files;
    console.log(myFileList);
    var pst = $(this).data("store");
    $.each(myFileList, function (i, file) {
      var formData = new FormData();
      formData.append("files", file);
      var xhr = new XMLHttpRequest();
      console.log(xhr);
      xhr.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          var data = this.responseText;
          // console.log(data);
          var jsonResponse = JSON.parse(data);

          if (jsonResponse.upload_status == 1) {
            // button.removeClass("active");
            let progressHTML = `
                        <li class="bid-row">
                            <div class=" remove_identification" data-file="${jsonResponse.file_name
              }"></div>
                            <a href="${jsonResponse.file_path
              }" target="_blank" download>
                                <img src="${base_url + "assets/images/glyph-plus.svg"
              }" />
                                <div class="content">
                                    <div class="details">
                                        <span class="name">${jsonResponse.name
              }</span>
                                    </div>
                                </div>
                                <i class="fi-check"></i>
                            </a>
                            <input type="hidden" name="identification_file" value="${jsonResponse.file_name
              }" />
                            <input type="hidden" name="identification_file_name" value="${jsonResponse.name
              }" />
                        </li>`;
            uploadedArea.html(progressHTML);
          } else uploadedArea.append(jsonResponse.error);
          needToConfirm = false;
        }
      };
      xhr.upload.onloadstart = function (e) {
        elem.removeClass("hidden");
        progressBar.style.width = "0%";
      };
      xhr.upload.onprogress = function (e) {
        if (e.lengthComputable) {
          var ratio = Math.floor((e.loaded / e.total) * 100) + "%";
          progressBar.style.width = ratio;
        }
      };
      xhr.upload.onloadend = function (e) {
        progressBar.style.width = "100%";
        $("#progress-contain-vehicle").hide();
        // button.find("i").addClass("hidden");
      };

      xhr.open("POST", base_url + "ajax/uploadLotIdentifications");
      xhr.send(formData);
    });
  });
});

$(document).on("change", "#uploadPhotoGrade", function () {
  needToConfirm = true;
  var progressBar = document.getElementById("myBar1");
  var image_type = $(this).data("file");
  $("#progress-contain-vehicle").show();
  var elem = $(".pBar");
  let uploadedArea = $(".uploaded-area");
  // uploadedArea.html("Uploading...");
  var myFileList = this.files;
  console.log(myFileList);
  var pst = $(this).data("store");
  $.each(myFileList, function (i, file) {
    var formData = new FormData();
    formData.append("files", file);
    var xhr = new XMLHttpRequest();
    console.log(xhr);
    xhr.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        var data = this.responseText;
        // console.log(data);
        var jsonResponse = JSON.parse(data);

        if (jsonResponse.upload_status == 1) {
          // button.removeClass("active");
          let progressHTML = `
                        <li class="bid-row">
                            <div class=" remove_identification" data-file="${jsonResponse.file_name
            }"></div>
                            <a href="${jsonResponse.file_path
            }" target="_blank" download>
                                <img src="${base_url + "assets/images/glyph-plus.svg"
            }" />
                                <div class="content">
                                    <div class="details">
                                        <span class="name">${jsonResponse.name
            }</span>
                                    </div>
                                </div>
                                <i class="fi-check"></i>
                            </a>
                            <input type="hidden" name="identification_file" value="${jsonResponse.file_name
            }" />
                            <input type="hidden" name="identification_file_name" value="${jsonResponse.name
            }" />
                        </li>`;
          uploadedArea.html(progressHTML);
        } else uploadedArea.append(jsonResponse.error);
        needToConfirm = false;
      }
    };
    xhr.upload.onloadstart = function (e) {
      elem.removeClass("hidden");
      progressBar.style.width = "0%";
    };
    xhr.upload.onprogress = function (e) {
      if (e.lengthComputable) {
        var ratio = Math.floor((e.loaded / e.total) * 100) + "%";
        progressBar.style.width = ratio;
      }
    };
    xhr.upload.onloadend = function (e) {
      progressBar.style.width = "100%";
      $("#progress-contain-vehicle").hide();
      // button.find("i").addClass("hidden");
    };

    xhr.open("POST", base_url + "ajax/uploadPhotoGrade");
    xhr.send(formData);
  });
});

$(function () {
  $(document).on("click", "#rsnd-email", function (e) {
    e.preventDefault();

    let btn = $(this);

    if (btn.data("disabled")) return false;

    $("#resndCntnt").addClass("hide");

    $(".appLoad").removeClass("hide");

    btn.data("disabled", "disabled");

    $.ajax({
      url: base_url + "resend-email",

      data: { cmd: "resend" },

      dataType: "JSON",

      method: "POST",
      error: function (rs) {
        console.log(rs);
      },
      success: function (rs) {
        console.log(rs);
        toastr.success(rs.msg, "", optsuccess);
        //$('#resndCntnt').find('.alertMsg').remove().end().append(rs.msg);
      },

      complete: function () {
        btn.removeData("disabled");

        setTimeout(function () {
          $(".appLoad").addClass("hide");

          $("#resndCntnt").removeClass("hide");
        }, 3000);
      },
    });
  });
});
/////////////////////////////////////////////////
// This button will increment the value
$(document).on('click', '.qtyplus', function (e) {
  e.preventDefault();
  var parnt = $(this).parent().children(".qty");
  console.log(parnt)
  let row_id = $(this).parent().children(".row_id");
  var currentVal = parnt.val();
  if (!isNaN(currentVal)) {
    parnt.val(parseInt(currentVal) + 1);
    updateCart(parseInt(currentVal) + 1, row_id);
  } else {
    parnt.val(0);
  }
});
$(document).on('click', '.qtyminus', function (e) {
  // This button will decrement the value till 0
  e.preventDefault();
  var parnt = $(this).parent().children(".qty");
  let row_id = $(this).parent().children(".row_id");
  var currentVal = parnt.val();
  currentVal = parseInt(currentVal) - 1;
  updateCart(currentVal, row_id);
  if (!isNaN(currentVal) && currentVal > 0) {
    parnt.val(parseInt(currentVal));
  } else {
    parnt.val(currentVal + 1);
    updateCart(currentVal + 1, row_id);
  }
});
function updateCart(qty, row_id) {
  row_id = row_id.val();
  console.log(row_id);
  $.ajax({
    type: "POST",
    url: base_url + "ajax/update_cart", // Replace this with the actual URL to update the cart
    data: {
      row_id: row_id,
      qty: qty,
    },
    dataType: "JSON",
    success: function (response) {
      console.log(response);
      if (response.status) {
        toastr.success(response.msg);
        $("#inventory_update").html(response?.html)
        $(".grand_total").html(response?.grand_total)
        $(".average_price").html(response?.average_price)
      }
    },
    error: function (xhr, status, error) {
      // Handle error response from the server
      console.error("Error updating cart:", error);
    },
  });
}

// $(document).ready(function () {
//   $("#clear-all").click(function (e) {
//     e.preventDefault();

//     $.ajax({
//       url: base_url + "account/clear_all",
//       type: "POST",
//       dataType: "json",
//       success: function (response) {
//         if (response.status === true) {
//           location.reload();
//         } else {
//           location.reload();
//           // alert("Failed to clear notifications. Please try again.");
//         }
//       },
//       error: function (xhr, status, error) {
//         console.error(xhr.responseText);
//         location.reload();

//         // alert("Failed to clear notifications. Please try again.");
//       },
//     });
//   });
// });

// /////////Sorting data========
