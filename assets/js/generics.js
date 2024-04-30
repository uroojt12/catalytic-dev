$(document).ready(function () {
  var offset = 0;
  var limit = 16;
  var loading = false;
  let allProductsLoaded = 0;
  let totalFetchedGen = 0;
  // Function to fetch posts via AJAX
  function fetchCodes() {
    if (loading) return; // Prevent multiple AJAX requests
    loading = true;
    $("#loading_generics").removeClass("hidden");
    var search_generics = $("#search_generics").val();
    var sort_order = $("#generics_sort_order").val();
    $.ajax({
      url: base_url + "/page/get_generics/" + offset,
      type: "POST",
      data: { sort_order: sort_order, search_generics: search_generics },
      dataType: "json",
      success: function (data) {
        if (parseInt(data?.total) > 0) {
          $("#filter_generics").append(data.html);
          offset += limit;
          totalFetchedGen += parseInt(data.total);
          $("#total_gen_count").text(totalFetchedGen);
        } else {
          allProductsLoaded = true;
        }
      },
      error: function (res) {
        console.log(res);
      },
      complete: function () {
        // Hide loading indicator when request is complete
        $("#loading_generics").addClass("hidden");
        loading = false; // Reset loading flag
      },
    });
  }

  fetchCodes();

  $(window).scroll(function () {
    var scrollPosition = $(window).scrollTop();
    var windowHeight = $(window).height();
    var sectionOffset =
      $("#filter_generics").offset().top + $("#filter_generics").outerHeight(); // Offset of the end of the post container

    if (!allProductsLoaded && scrollPosition + windowHeight >= sectionOffset) {
      console.log(allProductsLoaded);
      fetchCodes();
    } else {
      $("#loading_generics").addClass("hidden");
    }
  });
  $("#generics_sort_order").change(function () {
    console.log("hi");
    var sort_order = $(this).val();
    // alert(sort_order);
    var search_generics = $("#search_generics").val();
    $.ajax({
      type: "POST",
      dataType: "JSON",
      url: base_url + "ajax/generics_filter/",
      data: {
        sort_order: sort_order,
        search_generics: search_generics,
      },
      success: function (response) {
        // console.log(response)
        $("#filter_generics").html(response.html);
        $(".searches strong").html(response.total_results);
        $("#g_pagination").html(response?.links);
      },
    });
  });

  // $("#sort_order").change();
});

$("#filter-form-gen").submit(function (e) {
  // Prevent the default form submission behavior
  e.preventDefault();

  // Call the generics_filter function to perform the search
  generics_filter(1);
});

// Function to reset data when the form is cleared
function resetDataGen() {
  // Clear form fields
  $("#search_generics").val("");

  // Trigger the generics_filter function to reload all data
  generics_filter(1);
}

// Function to scroll to the top of the result div
function scrollToTopOfDivGen() {
  var $targetDiv = $("#result_data_gen");
  if ($targetDiv?.length) {
    $("html, body").animate(
      {
        scrollTop: $targetDiv.offset().top,
      },
      "slow"
    );
  }
}

// Function to perform the generics filtering
function generics_filter(page = 1) {
  $("#filter_generics").html(
    '<div class="lds-ring"><i class="fa fa-spinner fa-spin"></i><div>'
  );

  var search_generics = $("#search_generics").val();
  var sort_order = $("#generics_sort_order").val();
  $.ajax({
    method: "POST",
    dataType: "JSON",
    url: base_url + "ajax/generics_filter/" + page,
    data: {
      search_generics: search_generics,
      sort_order: sort_order,
    },
    error: function (rs) {
      console.log(rs);
    },
    success: function (data) {
      $("#filter_generics").html(data.html);
      $(".searches strong").html(data.total_results);
      $("#g_pagination").html(data?.links);
      scrollToTopOfDivGen();
      setTimeout(function () {
        if (page == 1) {
        } else {
          $(".pagination li a").removeClass("active");
          $(".pagination li").removeClass("active");
          $(
            '.pagination li a[data-ci-pagination-page="' +
              page +
              '"]:not([rel="next"])'
          ).addClass("active");
          $(
            '.pagination li a[data-ci-pagination-page="' +
              page +
              '"]:not([rel="next"])'
          )
            .parent()
            .addClass("active");
        }
      }, 50);

      $(".filters").removeClass("active");
    },
  });
}

$(document).ready(function () {
  // Listen for click on the search button
  $("#filter-form-gen button").click(function (e) {
    e.preventDefault();
    generics_filter(1); // Call generics_filter when search button is clicked
  });
});
