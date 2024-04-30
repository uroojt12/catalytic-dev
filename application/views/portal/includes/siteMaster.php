<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Admin Panel" />
    <meta name="author" content="" />
    <title>Portal - <?= $adminsite_setting->site_name; ?></title>
    <link rel="stylesheet" href="<?= base_url('adminassets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('adminassets/css/font-icons/entypo/css/entypo.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('adminassets/css/font-icons/font-awesome/css/font-awesome.min.css'); ?>">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic">
    <link rel="stylesheet" href="<?= base_url('adminassets/css/bootstrap.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('adminassets/css/neon-core.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('adminassets/css/neon-theme.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('adminassets/css/neon-forms.css'); ?>">
    <!-- <link type="text/css" rel="stylesheet" href="<?= base_url('assets/css/font-icon.css') ?>"> -->
    <link rel="stylesheet" href="<?= base_url('adminassets/css/skins/white.css') ?>">
    <link rel="stylesheet" href="<?= base_url('adminassets/css/custom.css'); ?>">
    <!-- Datepicker Css -->
    <link rel="stylesheet" href="<?= base_url('adminassets/css/datepicker.css'); ?>">
    <!-- autocomplete Css -->
    <link rel="stylesheet" href="<?= base_url('adminassets/css/autocomplete.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('adminassets/css/pick-a-color-1.2.3.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('adminassets/css/tagsinput.css') ?>">
    <link rel="stylesheet" href="<?= base_url('adminassets/css/jquery.rateyo.css') ?>">
    <link type="image/png" rel="icon" href="<?= base_url().SITE_IMAGES.'/images/'.$adminsite_setting->site_icon ?>">
    <script src="<?= base_url('adminassets/js/jquery-1.11.0.min.js'); ?>"></script>
    <script src="<?= base_url('adminassets/assets/js/jquery-ui.js') ?>"></script>
    <script>$.noConflict();</script>
    <script type="text/javascript"> var base_url = '<?= base_url(); ?>';</script>
    <script type="text/javascript" src="<?= base_url('adminassets/js/jquery-3.5.1.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url('adminassets/js/jquery.dataTables-1-13-1.min.js') ?>"></script>
    <script type="text/javascript" src="<?= base_url('adminassets/js/tagsinput.js') ?>"></script>

<?php if($video_page): ?>
    <link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css" />
    <?php endif;  ?>

    <script>
        var $j = jQuery.noConflict();
    </script>
</head>

<body class="page-body  skin-white">
    <div class="page-container">
        <?php $this->load->view(SUBADMIN."/includes/sidebar"); ?>
        <div class="main-content">
            <?php $this->load->view(SUBADMIN."/includes/header"); ?>
            <?php $this->load->view($pageView); ?>
            <p>&nbsp;</p>
            <?php $this->load->view(SUBADMIN."/includes/footer"); ?>
        </div>
    </div>

    <!-- Bottom scripts (common) -->

    <script src="<?= base_url('adminassets/js/gsap/main-gsap.js'); ?>"></script>

    <script src="<?= base_url('adminassets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js'); ?>"></script>

    <script src="<?= base_url('adminassets/js/bootstrap.js'); ?>"></script>

    <script src="<?= base_url('adminassets/js/joinable.js'); ?>"></script>

    <script src="<?= base_url('adminassets/js/resizeable.js'); ?>"></script>

    <script src="<?= base_url('adminassets/js/neon-api.js'); ?>"></script>

    <script src="<?= base_url('adminassets/js/fileinput.js'); ?>"></script>

    <script src="<?= base_url('adminassets/js/jvectormap/jquery-jvectormap-1.2.2.min.js'); ?>"></script>

    <!-- <script src="<?= base_url('adminassets/js/bootstrap-datepicker.js'); ?>"></script> -->



    <script src="<?= base_url('adminassets/js/bootstrap-timepicker.min.js'); ?>"></script>

    <link rel="stylesheet" href="<?= base_url('adminassets/js/select2/select2-bootstrap.css'); ?>">

    <link rel="stylesheet" href="<?= base_url('adminassets/js/select2/select2.css'); ?>">

    <?php if (isset($enable_editor) && $enable_editor == TRUE): ?>

        <script src="<?= base_url('assets/ckeditor/ckeditor.js'); ?>"></script>

        <!--

        <script src="<?= base_url('adminassets/js/ckeditor/ckeditor.js'); ?>"></script>

        <script src="<?= base_url('adminassets/js/ckeditor/adapters/jquery.js'); ?>"></script>

        -->

        <script type="text/javascript">

            jQuery(document).ready(function ($) {

                

            });

        </script>

    <?php endif; ?>

    <?php if (isset($enable_dashboard) && $enable_dashboard == TRUE): ?>

        <script src="<?= base_url('adminassets/js/jvectormap/jquery-jvectormap-europe-merc-en.js'); ?>"></script>

        <script src="<?= base_url('adminassets/js/jquery.sparkline.min.js'); ?>"></script>

        <script src="<?= base_url('adminassets/js/rickshaw/vendor/d3.v3.js'); ?>"></script>

        <script src="<?= base_url('adminassets/js/rickshaw/rickshaw.min.js'); ?>"></script>

        <script src="<?= base_url('adminassets/js/raphael-min.js'); ?>"></script>

        <script src="<?= base_url('adminassets/js/morris.min.js'); ?>"></script>

        <script src="<?= base_url('adminassets/js/toastr.js'); ?>"></script>

        <script src="<?= base_url('adminassets/js/neon-chat.js'); ?>"></script>

    <?php endif; ?>

    <script src="<?= base_url('adminassets/js/pick-a-color-1.2.3.min.js'); ?>"></script>

        <script src="<?= base_url('adminassets/js/tinycolor-0.9.15.min.js'); ?>"></script>

        <script type="text/javascript">

            function initPickColor() {

                jQuery(".pick-a-color").pickAColor({

                    showSpectrum: true,

                    showSavedColors: true,

                    saveColorsPerElement: true,

                    fadeMenuToggle: true,

                    showAdvanced: true,

                    showBasicColors: true,

                    showHexInput: true,

                    allowBlank: true,

                    inlineDropdown: true

                });

            }

            jQuery(document).ready(function () {

                initPickColor();

            });

        </script>

        <?php if (isset($enable_datatable) && $enable_datatable == TRUE): ?>

            <script src="<?= base_url('adminassets/js/jquery.dataTables.min.js'); ?>"></script>

            <script src="<?= base_url('adminassets/js/datatables/TableTools.min.js'); ?>"></script>

            <link href="<?= base_url('adminassets/js/datatables/responsive/css/datatables.responsive.css'); ?>" rel="stylesheet">

            <link href="<?= base_url('adminassets/js/select2/select2-bootstrap.css'); ?>" rel="stylesheet">

            <link href="<?= base_url('adminassets/js/select2/select2.css'); ?>" rel="stylesheet">

            <script src="<?= base_url('adminassets/js/dataTables.bootstrap.js'); ?>"></script>

            <script src="<?= base_url('adminassets/js/datatables/jquery.dataTables.columnFilter.js'); ?>"></script>

            <script src="<?= base_url('adminassets/js/datatables/lodash.min.js'); ?>"></script>

            <script src="<?= base_url('adminassets/js/datatables/responsive/js/datatables.responsive.js'); ?>"></script>

            <script src="<?= base_url('adminassets/js/select2/select2.min.js'); ?>"></script>



           

                

               



            <script type="text/javascript">



                var responsiveHelper;

                var breakpointDefinition = {

                    tablet: 1024,

                    phone: 480

                };

                var tableContainer;

                jQuery(document).ready(function ($) {

                    let sortOrder = ($('th.sortBy').index()>-1)?$('th.sortBy').index():0;

                    let order = ($('th.sortBy').index()>-1 && $('th.sortBy').data("order"))?$('th.sortBy').data("order"):'asc';

                    tableContainer = $("#table-1");

                    tableContainer.dataTable({

                        "order": [[ sortOrder, order ]],

                        "sPaginationType": "bootstrap",

                        "aLengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],

                        "bStateSave": true,

                        // Responsive Settings

                        bAutoWidth: false,

                        fnPreDrawCallback: function () {

                            // Initialize the responsive datatables helper once.

                            if (!responsiveHelper) {

                                responsiveHelper = new ResponsiveDatatablesHelper(tableContainer, breakpointDefinition);

                            }

                        },

                        fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {

                            responsiveHelper.createExpandIcon(nRow);

                        },

                        fnDrawCallback: function (oSettings) {

                            responsiveHelper.respond();

                        }

                    });

                    $(".dataTables_wrapper select").select2({

                        minimumResultsForSearch: -1

                    });

                });

            </script>

        <?php endif; ?>

        <?php // if(isset($enable_popup) && $enable_popup == TRUE):   ?>

        <script>

            jQuery(document).ready(function ()

            {

                var initPhotoSwipeFromDOM = function (gallerySelector) {

        // parse slide data (url, title, size ...) from DOM elements

        // (children of gallerySelector)

        var parseThumbnailElements = function (el) {

            var thumbElements = el.childNodes,

            numNodes = thumbElements.length,

            items = [],

            figureEl,

            childElements,

            linkEl,

            size,

            item;

            for (var i = 0; i < numNodes; i++) {

        figureEl = thumbElements[i]; // <figure> element

            // include only element nodes

            if (figureEl.nodeType !== 1) {

                continue;

            }

            linkEl = figureEl.children[0]; // <a> element

            size = linkEl.getAttribute('data-size').split('x');

                // create slide object

                item = {

                    src: linkEl.getAttribute('href'),

                    w: parseInt(size[0], 10),

                    h: parseInt(size[1], 10)

                };

                if (figureEl.children.length > 1) {

                // <figcaption> content

                item.title = figureEl.children[1].innerHTML;

            }

            if (linkEl.children.length > 0) {

                // <img> thumbnail element, retrieving thumbnail url

                item.msrc = linkEl.children[0].getAttribute('src');

            }

                item.el = figureEl; // save link to element for getThumbBoundsFn

                items.push(item);

            }

            return items;

        };

                // find nearest parent element

                var closest = function closest(el, fn) {

                    return el && (fn(el) ? el : closest(el.parentNode, fn));

                };

                // triggers when user clicks on thumbnail

                var onThumbnailsClick = function (e) {

                    e = e || window.event;

                    e.preventDefault ? e.preventDefault() : e.returnValue = false;

                    var eTarget = e.target || e.srcElement;

                    var clickedListItem = closest(eTarget, function (el) {

                        return (el.tagName && el.tagName.toUpperCase() === 'FIGURE');

                    });

                    if (!clickedListItem) {

                        return;

                    }

                // find index of clicked item

                var clickedGallery = clickedListItem.parentNode,

                childNodes = clickedListItem.parentNode.childNodes,

                numChildNodes = childNodes.length,

                nodeIndex = 0,

                index;

                for (var i = 0; i < numChildNodes; i++) {

                    if (childNodes[i].nodeType !== 1) {

                        continue;

                    }

                    if (childNodes[i] === clickedListItem) {

                        index = nodeIndex;

                        break;

                    }

                    nodeIndex++;

                }

                if (index >= 0) {

                    openPhotoSwipe(index, clickedGallery);

                }

                return false;

            };

                // parse picture index and gallery index from URL (#&pid=1&gid=2)

                var photoswipeParseHash = function () {

                    var hash = window.location.hash.substring(1),

                    params = {};

                    if (hash.length < 5) {

                        return params;

                    }

                    var vars = hash.split('&');

                    for (var i = 0; i < vars.length; i++) {

                        if (!vars[i]) {

                            continue;

                        }

                        var pair = vars[i].split('=');

                        if (pair.length < 2) {

                            continue;

                        }

                        params[pair[0]] = pair[1];

                    }

                    if (params.gid) {

                        params.gid = parseInt(params.gid, 10);

                    }

                    if (!params.hasOwnProperty('pid')) {

                        return params;

                    }

                    params.pid = parseInt(params.pid, 10);

                    return params;

                };

                var openPhotoSwipe = function (index, galleryElement, disableAnimation) {

                    var pswpElement = document.querySelectorAll('.pswp')[0],

                    gallery,

                    options,

                    items;

                    items = parseThumbnailElements(galleryElement);

                // define options (if needed)

                options = {

                    index: index,

                // define gallery index (for URL)

                galleryUID: galleryElement.getAttribute('data-pswp-uid'),

                getThumbBoundsFn: function (index) {

                // See Options -> getThumbBoundsFn section of docs for more info

                var thumbnail = items[index].el.getElementsByTagName('img')[0], // find thumbnail

                pageYScroll = window.pageYOffset || document.documentElement.scrollTop,

                rect = thumbnail.getBoundingClientRect();

                return {x: rect.left, y: rect.top + pageYScroll, w: rect.width};

            },

                // history & focus options are disabled on CodePen

                // remove these lines in real life:

                history: false,

                focus: false

            };

            if (disableAnimation) {

                options.showAnimationDuration = 0;

            }

                // Pass data to PhotoSwipe and initialize it

                gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options);

                gallery.init();

            };

                // loop through all gallery elements and bind events

                var galleryElements = document.querySelectorAll(gallerySelector);

                for (var i = 0, l = galleryElements.length; i < l; i++) {

                    galleryElements[i].setAttribute('data-pswp-uid', i + 1);

                    galleryElements[i].onclick = onThumbnailsClick;

                }

                // Parse URL and open gallery if it contains #&pid=3&gid=1

                var hashData = photoswipeParseHash();

                if (hashData.pid > 0 && hashData.gid > 0) {

                    openPhotoSwipe(hashData.pid - 1, galleryElements[ hashData.gid - 1 ], true);

                }

            };

                // execute above function

                initPhotoSwipeFromDOM('.my-simple-gallery');

            });

        </script>

        <?php // endif;   ?>

        <script src="<?= base_url('adminassets/js/select2/select2.min.js'); ?>"></script>

        <script src="<?= base_url('adminassets/js/neon-custom.js'); ?>"></script>

        <script src="<?= base_url('adminassets/js/jquery.validate.min.js'); ?>"></script>

        <link rel="stylesheet" href="<?= base_url('adminassets/js/wysihtml5/bootstrap-wysihtml5.css'); ?>">

        <script src="<?= base_url('adminassets/js/neon-demo.js'); ?>"></script>

        <script src="<?= base_url('adminassets/js/wysihtml5/wysihtml5-0.4.0pre.min.js'); ?>"></script>

        <script src="<?= base_url('adminassets/js/wysihtml5/bootstrap-wysihtml5.js'); ?>"></script>

        <!-- <script type="text/javascript" src="<?= base_url('assets/js/jquery.rateyo.min.js?v-'.$site_settings->site_version)?>"></script> -->

        <!-- <script type="text/javascript" src="<?= base_url(); ?>assets/js/owl.carousel.js'); ?>"></script> -->

        <script type="text/javascript">

            jQuery(document).ready(function () {

                /*jQuery('#owl-brands').owlCarousel({

                autoplay: false,

                stopOnHover: true,

                nav: false,

                navText: ['<i class="fi-chevron-left"></i>', '<i class="fi-chevron-right"></i>'],

                //navText: [ 'prev', 'next' ],

                dots: false,

                loop: true,

                autoWidth: true,

                smartSpeed: 1000,

                autoplayTimeout: 4000,

                responsive: {

                0: {

                items: 3

                },

                600: {

                items: 6

                },

                1000: {

                items: 8

                }

                }

            });*/

        });



            (function($){

                $(function(){

                // $('.datepicker1').datepicker({ dateFormat: 'yy-mm-dd' });

                /*$('.rateYo').rateYo({

                    fullStar: true,

                    normalFill: '#ddd',

                    ratedFill: '#f6a623',

                    starWidth: '14px',

                    spacing: '2px'

                });*/



                $("#frmIco").validate();

                $(document).on('submit','.frmAjax',function(e){

                    e.preventDefault();

                    var frmbtn=$(this).find("button[type='submit']");

                    var frmIcon=$(this).find("button[type='submit'] i.fa-spinner");

                    var frmMsg=$(this).find("div.alertMsg");

                    var frm=this;



                    // frmbtn.attr("disabled", true);

                    frmMsg.hide();

                    frmIcon.removeClass("hidden");

                    $.ajax({

                        url: $(this).attr('action'),

                        data : new FormData(frm),

                        processData: false,

                        contentType: false,

                        dataType: 'JSON',

                        method: 'POST',

                        error: function (rs) {

                            console.log(rs);

                        },

                        success: function (rs) {

                            if (rs.status == 1) {

                                frmMsg.html(rs.msg).slideDown(500);

                                setTimeout(function () {

                                    if(rs.frm_reset){

                                        frm.reset();

                                    }

                                    if(rs.hide_msg)

                                        frmMsg.slideUp(500);

                                    frmIcon.addClass("hidden");

                                    if(rs.redirect_url){

                                        window.location.href = rs.redirect_url;

                                    }else{

                                        frmbtn.attr("disabled", false);

                                    }

                                }, 3000);

                            } else {

                                frmMsg.html(rs.msg).slideDown(500);

                                setTimeout(function () {

                                    if(rs.hide_msg)

                                        frmMsg.slideUp(500);

                                    frmbtn.attr("disabled", false);

                                    frmIcon.addClass("hidden");

                                }, 3000);

                            }

                            if(rs.scroll_top)

                                $('html, body').animate({ scrollTop: frmMsg.offset().top}, 'slow');

                        }

                    });

                })

                var mianUpload;

                var oldSrc='';

                $(document).on('click', '.uploadImgBtn', function(e){

                    e.preventDefault();

                    mianUpload=$(this).parents('.dynamicUpload');

                    $('.uploadFile').trigger('click');

                    $('.uploadFile').data('file',$(this).data('type'));

                });



                $(document).on('click', '.crosBtn', function () {

                    var imgSrc=$(this).data('image');

                    $(this).addClass('hidden');

                    mianUpload.find('.loadingImg').removeClass('hidden');

                    $.ajax({

                        url: scontent_url + 'ajax/remove_file',

                        data : {'image':imgSrc,'pk_key': '<?= doEncode('admin')?>'},

                        method: 'POST',

                        success: function (rs) {

                            mianUpload.find('img').attr("src", oldSrc);

                            mianUpload.find('img').data("image", '');

                            mianUpload.find('input[type="hidden"]').attr('disabled',true).val('');

                            mianUpload.find('.uploadImgBtn').removeClass('hidden');

                            mianUpload.find('.loadingImg').addClass('hidden');

                        }

                    })

                })



                $(document).on('change', '.uploadFile', function () {

                    oldSrc=mianUpload.find('img').attr("src");



                    var image_type = $(this).data('file');

                    var image = '';



                    var elem = mianUpload.find('.uploadBar');

                    var progressBar = elem.find(".myBar").get(0);

                    var myFileList = document.getElementById('uploadFile').files;

                    var myFile = myFileList[0];

                    var formData = new FormData();

                    formData.append('image', myFile);

                    formData.append('pk_key', '<?= doEncode('admin')?>');



                    var xhr = new XMLHttpRequest();





                    xhr.onreadystatechange = function () {

                        if (this.readyState == 4 && this.status == 200) {

                            var data = this.responseText;

                            var jsonResponse = JSON.parse(data);

                            if(jsonResponse.upload_status==1){



                                mianUpload.find('img').attr("src", jsonResponse.image_path);

                                mianUpload.find('.crosBtn').data("image", jsonResponse.image);



                                mianUpload.find('input[type="hidden"]').attr('disabled',false).val(jsonResponse.image);



                                mianUpload.find('.crosBtn').removeClass('hidden');

                                mianUpload.find('.uploadImgBtn').addClass('hidden');

                            }else{

                                alert('Uploading Error!');

                            }

                        }

                    };



                    xhr.upload.onloadstart = function (e) {

                        elem.removeClass("hidden");

                        progressBar.style.width = '0%';

                    }

                    xhr.upload.onprogress = function (e) {

                        if (e.lengthComputable) {

                            var ratio = Math.floor((e.loaded / e.total) * 100) + '%';

                            progressBar.style.width = ratio;



                        }

                    }

                    xhr.upload.onloadend = function (e) {

                        progressBar.style.width = '100%';

                        elem.addClass("hidden");

                    }

                    xhr.open("POST", scontent_url + 'ajax/save_image');

                    xhr.send(formData);

                });

                

                })

            }(jQuery))

        </script>



        <script>

            var rowIndexForClone = 10000;

            jQuery(".addNewRowTbl").click(function(){

                var isCkeditor = !!jQuery(this).closest('#newTable').attr('isCkeditor');

                var clonedRow = jQuery(this).closest('#newTable').find('tr:last-child').clone();

                let name = clonedRow.find('textarea').attr('name');



                clonedRow.find('input').val('').end();

                if(isCkeditor)

                    clonedRow.find('textarea').parent().empty().html(`<textarea name="${name}" id="id${++rowIndexForClone}" class="form-control ckeditor" placeholder="Text" rows="4"></textarea>`)

                else

                    clonedRow.find('textarea').val('').end();

                

                clonedRow.find('td:last-child').html('<td class="text-center"><a href="javascript:void(0)" class="delNewRowTbl" id="delNewRowTbl"><i class="fa fa-minus" aria-hidden="true"></i></a></td>');

                clonedRow.find('img').attr('src',base_url+'assets/images/no-image.svg');



                clonedRow.find('select').val('').end();



                jQuery(this).closest('#newTable').before().append(clonedRow);

                if(isCkeditor)

                    CKEDITOR.replace(`id${rowIndexForClone}`);

            });



            jQuery(document).on('click', '.delNewRowTbl', function () {

                jQuery(this).closest('tr').remove();

            });



            jQuery(document).on('change', '#newImgInput', function () {

                var preview = jQuery(this).closest("#imgDiv").find("#newImg");

                var oFReader = new FileReader();

                oFReader.readAsDataURL(jQuery(this)[0].files[0]);

                oFReader.addEventListener("load", function () {

                    preview.attr('src',oFReader.result);

                }, false);

            });



            jQuery(document).on('click', '#newImg', function () {

                jQuery(this).closest("#imgDiv").find('#newImgInput').trigger('click');

            });



            jQuery(".card-repeater-add-btn").click(function(){
                
                let total_items=parseInt(jQuery("#repeater_card .card_item").length) + 1;
                // alert(total_items)

                var clonedRow = jQuery(this).parents('#repeater_card').find('.card_item:last-child').clone();
            //    console.log(clonedRow);
            clonedRow.find('.panel-title').text('Banner Image '+total_items);
                clonedRow.find('input').val('').end();
                clonedRow.find('.card_repeater-remove-btn').html('<button id="remove-btn" class="btn btn-danger" type="button">Remove</button>');
                clonedRow.find('img').attr('src',base_url+'assets/images/no_image.jpg');
                jQuery(this).closest('#repeater_card').before().append(clonedRow);
            });
            
            jQuery(document).on('click', '.card_repeater-remove-btn button', function () {
                jQuery(this).parents('.card_item').remove();
            });


        </script>



    </body>

    </html>

