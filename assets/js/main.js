/*========== Toggle ==========*/
$(document).ready(function () {
  // Toggle button click event
  $(document).on("click", ".toggle", function () {
    console.log("Toggle Clicked"); // Debugging statement
    $(".toggle").toggleClass("active");
    $("body").toggleClass("flow");
    $("[nav]").toggleClass("active");
    $(".upperlay").toggleClass("active");
  });

  // Smooth scrolling for anchor links
  $(document).on("click", "[nav] a", function (e) {
    var targetId = $(this).attr("href");

    if (targetId.startsWith("#")) {
      e.preventDefault();

      // Close mobile menu if open
      $(".toggle").removeClass("active");
      $("body").removeClass("flow");
      $("[nav]").removeClass("active");
      $(".upperlay").removeClass("active");

      // Scroll to the target section
      $("html, body").animate(
        {
          scrollTop: $(targetId).offset().top,
        },
        800
      );
    }
  });

  $(document).on("click", ".mobile_accordian_custom", function (e) {
    let parent = $(this).closest(".custom_in_listing");
    parent.children("li").toggleClass("acc_ordian"); 
    $(this).toggleClass('active');
  });
});

// _____popup_____*/
$(document).on("click", ".popBtn", function () {
    var popUp = $(this).data("popup");
    var inventId = $(this).data("inventory_id");
    var lot_type = $(this).data("lot_type");
    var imageUrl = $(this).data("image-url");
    var code_name = $(this).data("code-name");
    var generic_name = $(this).data("generic-name");
    let generic_images = $(this).data("images");
    
    let gradeID = $(this).data("grade-id");
    let gradePrice = $(this).data("photo-grade-price");
    
    $("#grade_id").val(gradeID > 0 ? gradeID : 0);
    $("#grade_price").val(gradePrice > 0 ? gradePrice : 0);
    ///
    let getNames = $(this).data("options");

      if (getNames) {
            // Fetch updated lot options via AJAX
            $.ajax({
              url: base_url + "Ajax/get_lot_name_options_ajax/",
              method: "GET",
              dataType: "json",
              success: function (response) {
                var $select = $(
                  ".popup[data-popup=" + popUp + "] select[name='lot_id']"
                );
                $select.empty(); // Clear existing options
                // $select.append('<option value="">Select Lot</option>'); // Add default option
        
                // Add new options from the response
                response.forEach(function (item) {
                  $select.append(
                    '<option value="' + item.id + '">' + item.lot_name + "</option>"
                  );
                });
              },
              error: function (xhr, status, error) {
                console.error("Failed to fetch lot names:", error);
              },
            });
      }
      
      

    $("#inventory_id").val(inventId);
    $("#lot_type").val(lot_type);
    console.log(generic_images,imageUrl);

    // if (generic_images?.length > 0) {
        let images_html = `
            <div class="owl-carousel owl-theme">
                <div class="item"><img src="${imageUrl}" /></div>
        `;
        
        $.each(generic_images, function(index, generic_image) {
            images_html += `
                <div class="item">
                    <img src="${base_url + "uploads/images/" + generic_image?.image}" />
                </div>
            `;
        });
        
        images_html += '</div>'; 

        // Initialize Owl Carousel after the HTML is updated
         let $popup = $(`.popup[data-popup="${popUp}"]`);

    // Set names
    $popup.find('.popup_code_name').text(code_name);
    $popup.find('.popup_generic_name').text(generic_name);

    // Inject new HTML
    $popup.find('.pop_slider_images').html(images_html);

    // ✅ Open popup first
    $popup.fadeIn(200, function () {

        let $owl = $popup.find(".owl-carousel");

        // ✅ If owl exists earlier -> destroy to avoid duplicate stage
        if ($owl.hasClass("owl-loaded")) {
            $owl.trigger('destroy.owl.carousel');
        }

        // ✅ Force correct width BEFORE initializing
        let popupWidth = $popup.find('.inside').width();
        $popup.find(".owl-carousel .item").css("width", popupWidth + "px");

        // ✅ Now initialize
        $owl.owlCarousel({
            items: 1,
            loop: true,
            dots: true,
            nav: false,
            autoplay: true,
            autoplayTimeout: 3000,
        });

        // ✅ Recalculate sizes
        $owl.trigger("refresh.owl.carousel");
    });
    // }

    // Update other popup content
    
    
    
});
$(document).on("click", ".crosBtn", function () {
  $(".popup").fadeOut();
  $("body").removeClass("flow");
});
$(document).on("click", ".crosBtn_inner", function () {
  $(".popup").fadeOut();
  $("body").removeClass("flow");
});

//

$(document).on("click", "[nav] a", function (e) {
  // Check if it's a link with a hash
  if (this.hash !== "") {
    e.preventDefault(); // Prevent the default behavior of the link

    // Get the target section
    var targetSection = $(this.hash);

    // Check if the target section is on the current page
    if (targetSection.length) {
      // Scroll to the target section
      $("html, body").animate(
        {
          scrollTop: targetSection.offset().top,
        },
        800
      );
    } else {
      // If the target section is not on the current page, navigate to the link's href
      window.location.href = this.href;
    }
  }
});

// money=============
$(".testi-carousel").owlCarousel({
  autoplay: true,
  nav: false,
  navText: [
    '<i class="fa fa-long-arrow-left"></i>',
    '<i class="fa fa-long-arrow-right"></i>',
  ],
  // navText: [ 'prev', 'next' ],
  dots: true,
  loop: true,
  autoWidth: false,
  autoHeight: true,
  smartSpeed: 1000,
  autoplayTimeout: 10000,
  margin: 20,
  autoplayHoverPause: true,
  responsive: {
    0: {
      items: 1,
      autoplay: true,
      autoHeight: true,
      dots: true,
      nav: false,
    },
    600: {
      items: 2,
    },
    991: {
      items: 1,
    },
    1000: {
      items: 1,
    },
  },
});
$(".wipe-carousel").owlCarousel({
  autoplay: true,
  nav: true,
  navText: [
    '<i class="fa fa-long-arrow-left"></i>',
    '<i class="fa fa-long-arrow-right"></i>',
  ],
  // navText: [ 'prev', 'next' ],
  dots: true,
  loop: true,
  autoWidth: false,
  autoHeight: true,
  smartSpeed: 1000,
  autoplayTimeout: 10000,
  margin: 20,
  autoplayHoverPause: true,
  responsive: {
    0: {
      items: 1,
      autoplay: true,
      autoHeight: true,
      dots: true,
      nav: true,
    },
    600: {
      items: 1,
    },
    991: {
      items: 1,
    },
    1000: {
      items: 1,
    },
  },
});

$(".pop_slider_images").owlCarousel({
  autoplay: true,
  nav: true,
  navText: [
    '<i class="fa fa fa-chevron-left"></i>',
    '<i class="fa fa fa-chevron-right"></i>',
  ],
  // navText: [ 'prev', 'next' ],
  dots: false,
  loop: true,
  smartSpeed: 1000,
  autoplayTimeout: 10000,
  autoplayHoverPause: true,
  touchDrag: true,
  mouseDrag: true,
  responsive: {
    0: {
      items: 1,
      autoplay: true,
      dots: true,
      nav: true,
    },
    600: {
      items: 1,
    },
    991: {
      items: 1,
    },
    1000: {
      items: 1,
    },
  },
});
// =======

// $(document).ready(function () {
//   $("#togglePassword").click(function () {
//     var passwordInput = $("#password");
//     var eyeIcon = $(this).find("img");

//     if (passwordInput.attr("type") === "password") {
//       passwordInput.attr("type", "text");
//       eyeIcon.attr("src", "images/hide.png");
//     } else {
//       passwordInput.attr("type", "password");
//       eyeIcon.attr("src", "images/view.png");
//     }
//   });
// });
$(document).ready(function () {
  $(".toggle-password").click(function () {
    var passwordInput = $(this).siblings(".txtBox");
    var eyeIcon = $(this).find("img");

    togglePasswordVisibility(passwordInput, eyeIcon);
  });

  function togglePasswordVisibility(passwordInput, eyeIcon) {
    if (passwordInput.attr("type") === "password") {
      passwordInput.attr("type", "text");
      eyeIcon.attr("src", base_url + "assets/images/hide.png"); // Replace with path to hide image
    } else {
      passwordInput.attr("type", "password");
      eyeIcon.attr("src", base_url + "assets/images/view.png"); // Replace with path to view image
    }
  }
});
// ========
$(document).ready(function () {
  $(".toggle-pass").click(function () {
    var passwordInput = $(this).siblings(".txtBox");
    var eyeIcon = $(this);

    togglePasswordVisibility(passwordInput, eyeIcon);
  });

  function togglePasswordVisibility(passwordInput, eyeIcon) {
    if (passwordInput.attr("type") === "password") {
      passwordInput.attr("type", "text");
      eyeIcon.attr("data-icon", "hide");
    } else {
      passwordInput.attr("type", "password");
      eyeIcon.attr("data-icon", "view");
    }
  }
});

// =======
/*____ FAQ's ____*/
$(document).on("click", ".faqBlk > .up_grid", function () {
  $(".faqBlk")
    .not($(this).parent().toggleClass("active"))
    .removeClass("active");
  $(".faqBlk  .img_grid")
    .not($(this).parent().children(".img_grid").slideToggle())
    .slideUp();
});

// =======
// $(function () {
//   $(".example").createSlide({
//     maxvalue: 100,
//     firstvalue: "0",
//     progress: true,
//     // output: ".output",
//   });
// });

// ======
$(document).ready(function () {
  // upload file
  var imgFile;
  $(document).on("click", ".uploadImg", function () {
    $(this).parents("form").find(".uploadFile").trigger("click");
    $(this).parents("form").find(".uploadFile2").trigger("click");
  });

  $(document).on("change", ".uploadFile2", function () {
    var fileName = $(this).val().split("\\").pop();
    $("#fileName").text(fileName);
  });
});
// =============filter dropdown===========

$("._dropBtn").click(function (e) {
  e.stopPropagation();
  var $this = $(this).parent().children("._dropCnt");
  $("._dropCnt").not($this).removeClass("active");
  var $parent = $(this).parent("._dropDown");
  $parent.children("._dropCnt").toggleClass("active");
});
$(document).on("click", "._dropCnt", function (e) {
  e.stopPropagation();
});
$(document).on("click", function () {
  $("._dropCnt").removeClass("active");
});
$(document).on("click", "#more", function () {
  $(this).addClass("active");
  $("#book_event").removeClass("active");
  $("#event_block").addClass("hide");
  $("#tour_block").removeClass("hide");
});
// =================
$(document).ready(function () {
  $(".toggle-horizontal").click(function (e) {
    e.preventDefault(); // Prevent default link behavior

    // Remove 'active' class from all list items
    $("ul li").removeClass("active");

    // Add 'active' class to clicked list item
    $(this).closest("li").addClass("active");

    // Remove 'horizontal_code' class from .flex
    $(".flex").removeClass("horizontal_code");

    // Check if clicked image has class 'horizontal-opt1'
    if ($(this).hasClass("horizontal-opt1")) {
      // Add 'horizontal_code' class to .flex
      $(".flex").addClass("horizontal_code");
    }
  });
});
$(document).ready(function () {
  var scrollThreshold = 183;

  $(window).scroll(function () {
    if ($(window).width() <= 512) {
      if ($(this).scrollTop() >= scrollThreshold) {
        $(".small_banner .mobile_inner").addClass("fixed_bar");
      } else {
        $(".small_banner .mobile_inner").removeClass("fixed_bar");
      }
    }
  });
});
