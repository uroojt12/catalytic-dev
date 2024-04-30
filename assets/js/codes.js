$(document).ready(function () {
  var offset = 0;
  var limit = 16;
  var loading = false;
  let allProductsLoaded = 0;
  let totalFetchedCodes = 0;


  // Function to fetch posts via AJAX
  function fetchCodes() {
    if (loading) return; // Prevent multiple AJAX requests
    loading = true;
    $("#loading_codes").removeClass("hidden");
    var sort_order = $("#sort_order").val();
    var search_code = $("#search_code").val();
    $.ajax({
      url: base_url + "/page/get_codes/" + offset,
      type: "POST",
      data: { sort_order: sort_order, search_code: search_code },
      dataType: "json",
      success: function (data) {
        if (parseInt(data?.total) > 0) {
          $("#filter_code").append(data.html);
          offset += limit;
          totalFetchedCodes += parseInt(data.total); 
          $("#total_codes_count").text(totalFetchedCodes);
        } else {
          allProductsLoaded = true;
        }
      },
      error: function (res) {
        console.log(res);
      },
      complete: function () {
        console.log("called");
        // Hide loading indicator when request is complete
        $("#loading_codes").addClass("hidden");
        loading = false; // Reset loading flag
      },
    });
  }

  fetchCodes();

  $(window).scroll(function () {
    var scrollPosition = $(window).scrollTop();
    var windowHeight = $(window).height();
    var documentHeight = $(document).height();
    var sectionOffset =
      $("#filter_code").offset().top + $("#filter_code").outerHeight(); // Offset of the end of the post container

    if (!allProductsLoaded && scrollPosition + windowHeight >= sectionOffset) {
      console.log(allProductsLoaded);
      fetchCodes();
    } else {
      $("#loading_codes").addClass("hidden");
    }
  });
  $("#sort_order").change(function () {
    allProductsLoaded = false;
    var sort_order = $(this).val();
    // alert(sort_order);
    var search_code = $("#search_code").val();
    $.ajax({
      type: "POST",
      dataType: "JSON",
      url: base_url + "ajax/code_filter/",
      data: {
        sort_order: sort_order,
        search_code: search_code,
      },
      success: function (response) {
        // console.log(response)
        $("#filter_code").html(response.html);
        $(".searches span").html(response.total_results);
        $("#pagination").html(response?.links);
      },
    });
  });
  function code_filter(page = 1) {
    allProductsLoaded = false;
    $("#filter_code").html(
      '<div class="lds-ring"><i class="fa fa-spinner fa-spin"></i><div>'
    );
    var sort_order = $("#sort_order").val();
    var search_code = $("#search_code").val();
    $.ajax({
      method: "POST",
      dataType: "JSON",
      url: base_url + "ajax/code_filter/" + page,
      data: {
        search_code: search_code,
        sort_order: sort_order,
      },
      error: function (rs) {
        console.log(rs);
      },
      success: function (data) {
        // console.log(data)
        $("#filter_code").html(data.html);
        $(".searches span").html(data.total_results);
        $("#pagination").html(data?.links);
        scrollToTopOfDiv();
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

  // Call the code_filter function when the form is submitted
  $("#filter-form").submit(function (e) {
    // Prevent the default form submission behavior
    e.preventDefault();

    // Call the code_filter function to perform the search
    code_filter(1);
  });

  // Listen for click on the search button
  $("#filter-form button").click(function () {
    code_filter(1); // Call code_filter when search button is clicked
  });

  // Listen for Enter key press in the search input
  $("#search_code").keypress(function (e) {
    if (e.which === 13) {
      // 13 is the Enter key code
      e.preventDefault(); // Prevent form submission
      code_filter(1); // Call code_filter when Enter is pressed
    }
  });
  function scrollToTopOfDiv() {
    var $targetDiv = $("#result_data");
    if ($targetDiv?.length) {
      $("html, body").animate(
        {
          scrollTop: $targetDiv.offset().top,
        },
        "slow"
      );
    }
  }
  // Wrap the code inside a function
  function initializeCodeFilter() {
    // Function to reset data when the form is cleared
    function resetData() {
      // Clear form fields
      $("#search_code").val("");

      // Trigger the code_filter function to reload all data
      code_filter(1);
    }

    // Function to perform the code filtering

    // Function to scroll to the top of the result div
  }

  // Call the initialization function when the document is ready
  $(document).ready(function () {
    initializeCodeFilter();
  });
});
