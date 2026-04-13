$(document).ready(function () {
  var offset = 16;
  var limit = 16;
  var loading = false;
  let allProductsLoaded = 0;
  // let totalFetchedGen = 0;
  // Function to fetch posts via AJAX
  function fetchCodes() {
    if (loading) return; // Prevent multiple AJAX requests
    loading = true;
    $("#loading_generics").removeClass("hidden");
    var sort_order = $("#generics_sort_order").val();
    var search_generics = $("#search_generics").val();
    $.ajax({
      url: base_url + "/page/get_generics/" + offset,
      type: "POST",
      data: { sort_order: sort_order, search_generics: search_generics },
      dataType: "json",
      success: function (data) {
        console.log("filtergenerics", data);
        if (parseInt(data?.total) > 0) {
          $("#filter_generics").append(data.html);
          offset += limit;
          // totalFetchedGen += parseInt(data.total);
          // $("#total_gen_count").text(totalFetchedGen);
        } else {
          loading = true;
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

  // fetchCodes();

  $(window).scroll(function () {
    var scrollPosition = $(window).scrollTop();
    var windowHeight = $(window).height();
    var sectionOffset =
      $("#filter_generics").offset().top + $("#filter_generics").outerHeight(); // Offset of the end of the post container

    if (!allProductsLoaded && scrollPosition + windowHeight >= sectionOffset) {
      // console.log(allProductsLoaded);
      fetchCodes();
    } else {
      $("#loading_generics").addClass("hidden");
    }
    $("#search_items").addClass("hidden");
  });
  $("#generics_sort_order").change(function () {
    allProductsLoaded = false;
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
        $(".searches span").html(response.total_results);
        $("#g_pagination").html(response?.links);
        if (parseInt(response?.total_results) < 16) {
          allProductsLoaded = true;
        }
      },
    });
  });

  // Function to perform the generics filtering
  function generics_filter(page = 1) {
    allProductsLoaded = false;
    $("#loading_generics").addClass("hidden");
    $("#filter_generics").html(
      '<div class="lds-ring"><i class="fa fa-spinner fa-spin"></i><div>'
    );
    var sort_order = $("#generics_sort_order").val();
    var search_generics = $("#search_generics").val();
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
        console.log(data);
        $("#filter_generics").html(data.html);
        $(".searches span").html(data.total_results);
        $("#g_pagination").html(data?.links);
        if (parseInt(data?.total_results) < 16) {
          allProductsLoaded = true;
        }
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
        }, 5);

        $(".filters").removeClass("active");
        scrollToTopOfDivGen();
      },
    });
  }

  // $("#sort_order").change();

  $("#filter-form-gen").submit(function (e) {
    // Prevent the default form submission behavior
    e.preventDefault();

    // Call the generics_filter function to perform the search
    generics_filter(1);
  });

  $("#filter-form-gen button").click(function () {
    // e.preventDefault();
    generics_filter(1); // Call generics_filter when search button is clicked
  });

  // Listen for Enter key press in the search input
  $("#search_generics").keypress(function (e) {
    if (e.which === 13) {
      // 13 is the Enter key code
      e.preventDefault(); // Prevent form submission
      generics_filter(1); // Call generic_filter when Enter is pressed
    }
  });

  function scrollToTopOfDivGen() {
    var $targetDiv = $("#result_data_gen");
    if ($targetDiv?.length) {
      $("html, body").animate(
        {
          scrollTop: $targetDiv.offset().top,
        },
        // "slow"
        5
      );
    }
  }

  // // Function to reset data when the form is cleared
  // function resetDataGen() {
  //   // Clear form fields
  //   $("#search_generics").val("");

  //   // Trigger the generics_filter function to reload all data
  //   generics_filter(1);
  // }

  // Function to scroll to the top of the result div

  // $(document).ready(function () {
  //   // Listen for click on the search button
  // });

  // Wrap the code inside a function
  function initializeGenericFilter() {
    // Function to reset data when the form is cleared
    function resetDataGen() {
      // Clear form fields
      $("#search_generics").val("");

      // Trigger the code_filter function to reload all data
      generics_filter(1);
    }

    // Function to perform the code filtering

    // Function to scroll to the top of the result div
  }

  // Call the initialization function when the document is ready
  $(document).ready(function () {
    initializeGenericFilter();
  });

  $(document).on("keyup", "#search_generics", function () {
    var value = $(this).val();
    
    // console.log(value.length);
    if (value.length > 0) {
      $(".remove-data").removeClass("hidden");
      $.ajax({
        url: base_url + "Ajax/get_search_generic_data",
        data: { word: value },
        dataType: "JSON",
        method: "POST",
        success: function (rs) {
          // console.log(rs);
          if (rs.status == true) {
            $("#search_items").removeClass("hidden");

            $("#search_items").html(rs.data);
          } else {
            $("#search_items").html(
              "<li style='color: black;'>There is no generic with this name</li>"
            );
          }
        },
        error: function (rs) {
          console.log(rs);
        },
        complete: function (rs) {
          console.log(rs);
        },
      });
    } else {
      $("#search_items").addClass("hidden");
      $("#search_items").html("");
      $(".remove-data").addClass("hidden");

    }
  });


$(document).on("click", "#search_items li", function () {
    // scrollToTopOfDiv();
    let search_generics = $(this).data("generic");
    var selectedValue = $(this).text().trim();
    $("#search_generics").val(selectedValue);
    $("#search_items").addClass("hidden");

    $("#filter_generics").html("");
    $("#loading_generics").removeClass("hidden");
    var sort_order = $("#generics_sort_order").val();
    $.ajax({
      url: base_url + "/page/get_generics/" + 0,
      type: "POST",
      data: { sort_order: sort_order, search_generics: search_generics },
      dataType: "json",
      success: function (data) {
        // console.log("generics", data);
        // if (parseInt(data?.total) > 0) {
        $("#filter_generics").append(data.html);
        $(".remove-data").addClass("hidden");

        offset += limit;
        // totalFetchedCodes += parseInt(data.total);
        $(".searches > p > span").text(parseInt(data.total));
        // } else {
        //   allProductsLoaded = true;
        // }
        if (parseInt(data?.total) < 16) {
          allProductsLoaded = true;
        }
      },
      error: function (res) {
        console.log(res);
      },
      complete: function () {
        // console.log("called gen");
        // Hide loading indicator when request is complete
        $("#loading_generics").addClass("hidden");
        loading = false; // Reset loading flag
      },
    });
  });

});
