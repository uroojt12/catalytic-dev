<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <?php
    $page_title = empty($site_content['page_title']) ? $page_title . " - " . $site_settings->site_name : $site_content['page_title'] . ' - ' . $site_settings->site_name;
    $meta_description = empty($site_content['meta_description']) ? $site_settings->site_meta_desc : $site_content['meta_description'];
    $meta_keywords = empty($site_content['meta_keywords']) ? $site_settings->site_meta_keyword : $site_content['meta_keywords'];
    $meta_image = empty($site_content['meta_image']) ? SITE_IMAGES . '/images/' . $site_settings->site_thumb . '?v-' . $site_settings->site_version : $site_content['meta_image'];
    ?>
    <meta name="title" content="<?= $page_title ?>">
    <meta name="description" content="<?= $meta_description ?>">
    <meta name="keywords" content="<?= $meta_keywords ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= currentURL() ?>">
    <meta property="og:title" content="<?= $page_title ?>">
    <meta property="og:description" content="<?= $meta_description ?>">
    <meta property="og:image" content="<?= $meta_image ?>">
    <meta property="twitter:card" content="thumbnail">
    <meta property="twitter:url" content="<?= currentURL() ?>">
    <meta property="twitter:title" content="<?= $page_title ?>">
    <meta property="twitter:description" content="<?= $meta_description ?>">
    <meta property="twitter:image" content="<?= $meta_image ?>">


    <!-- css files -->

    <link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/responsive.css?v=<?= $site_settings->site_version ?>26">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/style.css?v=<?= $site_settings->site_version ?>26">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">

    <?php if (!empty($site_settings->template_id)) { ?>
        <link rel="stylesheet" href="<?= get_site_image_src("templates", get_template($site_settings->template_id)) ?>">
    <?php } else { ?>
        <link rel="stylesheet" href="<?= base_url() ?>assets/css/color_2.css?v=29">
    <?php } ?>

    <!-- Media-Query Css -->

    <link type="text/css" rel="stylesheet" href="<?= base_url() ?>assets/css/toastr.min.css?v-<?= $site_settings->site_version ?>">
    <title><?= $page_title  ?></title>
    <!-- JS Files -->
    <script type="text/javascript">
        var base_url = "<?= base_url() ?>";
    </script>
    <?= $site_settings->site_google_ad ?>
    <!-- Favicon -->
    <link type="image/png" rel="icon" href="<?= base_url() . 'uploads/images/' . $site_settings->site_icon . '?v-' . $site_settings->site_version ?>">



</head>

<body id="home-page">

    <?php echo showMsg(); ?>
    <?php
    if ($page_404 != true && $footer == true) {
        if ($dashboard == true) {
            $this->load->view('includes/header_2');
        } else {
            $this->load->view('includes/header');
        }
    }
    ?>
    <?php echo showMsg(); ?>
    <?php $this->load->view($pageView); ?>
    <?php
    if ($page_404 != true && $footer == true)
        $this->load->view('includes/footer');
    $this->load->view('includes/scripts');
    ?>

</body>


</html>