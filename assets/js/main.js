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
});

// _____popup_____*/
$(document).on("click", ".popBtn", function () {
  var popUp = $(this).data("popup");
  var inventId = $(this).data("inventory_id");
  var lot_type = $(this).data("lot_type");
  // var genericId = $(this).data("generics_id");
  // alert(codeId);
  // alert(genericId);

  $("#inventory_id").val(inventId);
  $("#lot_type").val(lot_type);
  // $("#generics_id").val(genericId);

  $(".popup[data-popup= " + popUp + "]").fadeIn();
});
$(document).on("click", ".crosBtn", function () {
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
      items: 1.5,
    },
    1000: {
      items: 1.5,
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
