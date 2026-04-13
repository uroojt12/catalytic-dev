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
    $(document).on("change", "#fullness", function (e) {
        let fullness=$(this).val();
        let code_price=$("#code_price").val();
        calculate_price(code_price,fullness);
    })
    $(document).on("blur", "#code_price", function (e) {
        let code_price=$(this).val();
        let fullness=$("#fullness").val();
        calculate_price(code_price,fullness);
    })
    function calculate_price(code_price,fullness){
        if(code_price!=null && code_price!=undefined && code_price!=null){
            code_price=parseFloat(code_price);
            fullness=parseInt(fullness);
            if(fullness <100){
                fullness=100-fullness;
                let percent_price=(code_price * fullness)/100;
                code_price=code_price - percent_price;
            }
            $(".item_price_custom_code span").html("$"+code_price)
            return code_price;
        }
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
            }, 800);
          }
          toastr.success(rs.msg, "", optsuccess);
          $(".popup").fadeOut();
          $("body").removeClass("flow");
          $("#generic_slider_price").text("100");
          $("#code_slider_price").text("100");
          setTimeout(function () {
            frm.reset();
            frmIcon.addClass("hidden");
            frmIcon.css("display", "none");
            if (rs.redirect_url) {
              window.location.href = rs.redirect_url;
            } else {
              frmbtn.attr("disabled", false);
            }
          }, 800);
        } else {
          toastr.error(rs.msg, opterror);
          setTimeout(function () {
            if (rs.hide_msg) frmMsg.slideUp(500);
            frmbtn.attr("disabled", false);
            frmIcon.addClass("hidden");
            frmIcon.css("display", "none");

            if (rs.redirect_url) window.location.href = rs.redirect_url;
          }, 800);
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
          }, 800);
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
    var spinner = $(".closed-inventory-btn .spinner"); // Select the spinner inside the button
    spinner.removeClass("hidden"); // Remove hidden class when the image upload starts
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
                            <div class=" remove_identification" data-file="${
                              jsonResponse.file_name
                            }"></div>
                            <a href="${
                              jsonResponse.file_path
                            }" target="_blank" download>
                                <img src="${
                                  base_url + "assets/images/glyph-plus.svg"
                                }" />
                                <div class="content">
                                    <div class="details">
                                        <span class="name">${
                                          jsonResponse.name
                                        }</span>
                                    </div>
                                </div>
                                <i class="fi-check"></i>
                            </a>
                            <input type="hidden" name="identification_file" value="${
                              jsonResponse.file_name
                            }" />
                            <input type="hidden" name="identification_file_name" value="${
                              jsonResponse.name
                            }" />
                        </li>`;
            uploadedArea.html(progressHTML);
          } else uploadedArea.append(jsonResponse.error);
          needToConfirm = false;
          spinner.addClass("hidden"); // Hide the spinner after the upload is successful
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
        spinner.addClass("hidden"); // Hide the spinner when the upload ends
        // button.find("i").addClass("hidden");
      };

      xhr.open("POST", base_url + "ajax/uploadLotIdentifications");
      xhr.send(formData);
    });
  });
});

// $(document).on("change", "#uploadPhotoGrade", function () {
//   needToConfirm = true;
//   var frmbtn = $(".photo-grade-btn");
//   var frmIcon = frmbtn.find("i");
//   var progressBar = document.getElementById("myBar1");
//   var image_type = $(this).data("file");
//   $("#progress-contain-vehicle").show();
//   var elem = $(".pBar");
//   let uploadedArea = $(".uploaded-area");
//   // uploadedArea.html("Uploading...");
//   var myFileList = this.files;
//   console.log(myFileList);
//   var pst = $(this).data("store");
//   $.each(myFileList, function (i, file) {
//     var formData = new FormData();
//     formData.append("files", file);
//     var xhr = new XMLHttpRequest();
//     console.log(xhr);
//     xhr.onreadystatechange = function () {
//       if (this.readyState == 4 && this.status == 200) {
//         var data = this.responseText;
//         // console.log(data);
//         var jsonResponse = JSON.parse(data);

//         if (jsonResponse.upload_status == 1) {
//           // button.removeClass("active");
//           let progressHTML = `
//                         <li class="bid-row">
//                             <div class=" remove_identification" data-file="${
//                               jsonResponse.file_name
//                             }"></div>
//                             <a href="${
//                               jsonResponse.file_path
//                             }" target="_blank" download>
//                                 <img src="${
//                                   base_url + "assets/images/glyph-plus.svg"
//                                 }" />
//                                 <div class="content">
//                                     <div class="details">
//                                         <span class="name">${
//                                           jsonResponse.name
//                                         }</span>
//                                     </div>
//                                 </div>
//                                 <i class="fi-check"></i>
//                             </a>
//                             <input type="hidden" name="identification_file" value="${
//                               jsonResponse.file_name
//                             }" />
//                             <input type="hidden" name="identification_file_name" value="${
//                               jsonResponse.name
//                             }" />
//                         </li>`;
//           uploadedArea.html(progressHTML);
//         } else uploadedArea.append(jsonResponse.error);
//         needToConfirm = false;
//       }
//     };
//     xhr.upload.onloadstart = function (e) {
//       elem.removeClass("hidden");
//       progressBar.style.width = "0%";
//       frmIcon.removeClass("hidden");
//     };
//     xhr.upload.onprogress = function (e) {
//       if (e.lengthComputable) {
//         var ratio = Math.floor((e.loaded / e.total) * 100) + "%";
//         progressBar.style.width = ratio;
//       }
//       frmIcon.removeClass("hidden");
//     };
//     xhr.upload.onloadend = function (e) {
//       progressBar.style.width = "100%";
//       $("#progress-contain-vehicle").hide();
//       frmIcon.addClass("hidden");
//       // button.find("i").addClass("hidden");
//     };

//     xhr.open("POST", base_url + "ajax/uploadPhotoGrade");
//     xhr.send(formData);
//   });
// });


$(document).on("change", "#uploadPhotoGrade", function () {
  needToConfirm = true;
  var progressBar = document.getElementById("myBar1");
  var image_type = $(this).data("file");
  $("#progress-contain-vehicle").show();
  var elem = $(".pBar");
  let uploadedArea = $(".uploaded-area");
  var myFileList = this.files;
  var spinner = $(".photo-grade-btn .spinner"); // Select the spinner inside the button
  spinner.removeClass("hidden"); // Remove hidden class when the image upload starts

  $.each(myFileList, function (i, file) {
    var formData = new FormData();
    formData.append("files", file);
    var xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        var data = this.responseText;
        var jsonResponse = JSON.parse(data);

        if (jsonResponse.upload_status == 1) {
          let progressHTML = `
                        <li class="bid-row">
                            <div class=" remove_identification" data-file="${
                              jsonResponse.file_name
                            }"></div>
                            <a href="${
                              jsonResponse.file_path
                            }" target="_blank" download>
                                <img src="${
                                  base_url + "assets/images/glyph-plus.svg"
                                }" />
                                <div class="content">
                                    <div class="details">
                                        <span class="name">${
                                          jsonResponse.name
                                        }</span>
                                    </div>
                                </div>
                                <i class="fi-check"></i>
                            </a>
                            <input type="hidden" name="identification_file" value="${
                              jsonResponse.file_name
                            }" />
                            <input type="hidden" name="identification_file_name" value="${
                              jsonResponse.name
                            }" />
                        </li>`;
          uploadedArea.html(progressHTML);
        } else uploadedArea.append(jsonResponse.error);
        needToConfirm = false;
        spinner.addClass("hidden"); // Hide the spinner after the upload is successful
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
      spinner.addClass("hidden"); // Hide the spinner when the upload ends
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
        }, 800);
      },
    });
  });
});
/////////////////////////////////////////////////
// This button will increment the value
$(document).on("click", ".qtyplus", function (e) {
  e.preventDefault();
  var parnt = $(this).parent().children(".qty");
  console.log(parnt);
  let row_id = $(this).parent().children(".row_id");
  var currentVal = parnt.val();
  if (!isNaN(currentVal)) {
    parnt.val(parseInt(currentVal) + 1);
    updateCart(parseInt(currentVal) + 1, row_id);
  } else {
    parnt.val(0);
  }
});

$(document).on("click", ".qtyminus", function (e) {
  // This button will decrement the value till 1
  e.preventDefault();
  var parnt = $(this).parent().children(".qty");
  let row_id = $(this).parent().children(".row_id");
  var currentVal = parseInt(parnt.val());

  if (!isNaN(currentVal) && currentVal > 1) {
    currentVal = currentVal - 1;
    parnt.val(currentVal);
    updateCart(currentVal, row_id);
  } else {
    parnt.val(1);
    updateCart(1, row_id);
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
        $("#inventory_update").html(response?.html);
        $(".grand_total").html(response?.grand_total);
        $(".average_price").html(response?.average_price);
        $(".total_converters").html(response?.total_converters);
        $(".new_count").html(response?.count_html_output);
      }
    },
    error: function (xhr, status, error) {
      // Handle error response from the server
      console.error("Error updating cart:", error);
    },
  });
}
// $(document).on("click", ".qtyminus", function (e) {
//   // This button will decrement the value till 0
//   e.preventDefault();
//   var parnt = $(this).parent().children(".qty");
//   let row_id = $(this).parent().children(".row_id");
//   var currentVal = parnt.val();
//   currentVal = parseInt(currentVal) - 1;
//   updateCart(currentVal, row_id);
//   if (!isNaN(currentVal) && currentVal > 0) {
//     parnt.val(parseInt(currentVal));
//   } else {
//     parnt.val(currentVal + 1);
//     updateCart(currentVal + 1, row_id);
//   }
// });

$(document).on("click", "#del_row", function (e) {
  e.preventDefault();

  var row_id = $(this).data("row_id");
  deleteCart(row_id);
});

function deleteCart(row_id) {
  // console.log(row_id);
  $.ajax({
    type: "POST",
    url: base_url + "ajax/delete_cart",
    data: {
      row_id: row_id,
    },
    dataType: "JSON",
    success: function (response) {
      // console.log(response);
      if (response.status) {
        toastr.success(response.msg);
        $("#inventory_update").html(response?.html);
        $(".grand_total").html(response?.grand_total);
        $(".average_price").html(response?.average_price);
        $(".total_converters").html(response?.total_converters);
        $(".new_count").html(response?.count_html_output);
      }
    },
    error: function (xhr, status, error) {
      // Handle error response from the server
      console.error("Error updating cart:", error);
    },
  });
}

$(document).ready(function () {
  $(".flexSwitchCheckDefault").change(function () {
    var isChecked = $(this).prop("checked");
    // Make AJAX call
    $.ajax({
      url: base_url + "ajax/update_member",
      method: "POST",
      dataType: "JSON",
      data: { isChecked: isChecked ? 1 : 0 }, // Sending whether the switch is checked or not
      success: function (response) {
        if (response.status == 1) {
          toastr.success(response.msg);
          location.reload();
        }
        // Handle success response
        // console.log(response);
      },
      error: function (xhr, status, error) {
        // Handle error
        console.error(xhr.responseText);
      },
    });
  });
});

$(document).ready(function () {
  $("#inventory_export").click(function () {
    var id = $(this).data("id");
    var btn = $(this);
    btn.attr("disabled", true);
    btn.find(".spinner").removeClass("hidden");

    $.ajax({
      url: base_url + "ajax/pdf_export/" + id,
      method: "POST",
      dataType: "JSON",
      success: function (response) {
        console.log(response);
        if (response.status == 1) {
          toastr.success(response.msg);

          var fileName = response.pdf.substring(
            response.pdf.lastIndexOf("/") + 1
          );
          var downloadLink = document.createElement("a");
          downloadLink.href = response.pdf;
          downloadLink.download = fileName;
          downloadLink.style.display = "none";
          document.body.appendChild(downloadLink);
          downloadLink.click();
          document.body.removeChild(downloadLink);
        } else {
          toastr.error(response.msg);
        }
      },
      error: function (xhr, status, error) {
        btn.removeAttr("disabled");
        btn.find(".spinner").addClass("hidden");
        console.error(xhr.responseText);
        toastr.error("An error occurred while processing your request.");
      },
      complete: function () {
        setTimeout(function () {
          btn.removeAttr("disabled");
          btn.find(".spinner").addClass("hidden");
        }, 800);
      },
    });
  });
});

// $(".inventory-link").click(function () {
//   var url = $(this).find("a").attr("href");
//   window.location.href = url;
// });

$(document).ready(function () {
  const $sortOrderSelect = $("#sort_order");

  const savedSortOrder = localStorage.getItem("sort_order");
  if (savedSortOrder) {
    $sortOrderSelect.val(savedSortOrder);
  }
  $sortOrderSelect.on("change", function () {
    const selectedValue = $(this).val();
    localStorage.setItem("sort_order", selectedValue);
  });

  const $genericSortOrderSelect = $("#generics_sort_order");
  const savedGenericSortOrder = localStorage.getItem("generics_sort_order");
  if (savedGenericSortOrder) {
    $genericSortOrderSelect.val(savedGenericSortOrder);
  }
  $genericSortOrderSelect.on("change", function () {
    const selectedValueGen = $(this).val();
    localStorage.setItem("generics_sort_order", selectedValueGen);
  });
});

$(document).ready(function () {
  const $filterCode = $("#filter_code");
  const $filterGen = $("#filter_generics");

  const $opt1 = $(".horizontal-opt1").parent();
  const $opt2 = $(".horizontal-opt2").parent();

  function setViewMode(mode) {
    if (mode === "grid") {
      $opt2.addClass("active");
      $opt1.removeClass("active");
      $filterCode.removeClass("horizontal_code");
      $filterGen.removeClass("horizontal_code");
    } else {
      $opt2.removeClass("active");
      $opt1.addClass("active");
      $filterCode.addClass("horizontal_code");
      $filterGen.addClass("horizontal_code");
    }
    localStorage.setItem("view_mode", mode);
  }

  if (!localStorage.getItem("view_mode")) {
    setViewMode("grid");
  }

  const savedViewMode = localStorage.getItem("view_mode");
  if (savedViewMode) {
    setViewMode(savedViewMode);
  }

  $opt1.on("click", function (event) {
    event.preventDefault();
    setViewMode("list");
  });

  $opt2.on("click", function (event) {
    event.preventDefault();
    setViewMode("grid");
  });
});

$(document).ready(function () {
  $(".remove-data").click(function () {
    $(".search_code").val("");
    $("#search_generics").val("");
    $(".search_items_code").addClass("hidden");
    $("#search_items").addClass("hidden");
    $(".remove-data").addClass("hidden");
  });
});



$(document).on('click', '.delete-lot', function(e) {
    e.preventDefault();
    e.stopImmediatePropagation();

    if (!confirm('Are you sure you want to delete this lot?')) return;

    var lotId = $(this).data('lot-id');
    var row = $(this).closest('.cols'); 

    $.ajax({
        url: base_url + "ajax/delete_lot",
        type: "POST",
        data: { lot_id: lotId },
        dataType: "json",
        success: function(res) {
            if (res.status) {
                
                row.fadeOut(300, function() { $(this).remove(); });
               
                toastr.success(res.message);
                setTimeout(function() {
                    location.reload(); 
                }, 800);
            } else {
                toastr.error(res.message);
            }
        },
        error: function() {
            toastr.error('Something went wrong!');
        }
    });
});


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
