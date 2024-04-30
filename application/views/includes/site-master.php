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
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/responsive.css?v=<?= $site_settings->site_version ?>">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/colors.css?v=<?= $site_settings->site_version ?>">
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/style.css?v=<?= $site_settings->site_version ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">


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

    <style>
        /* :root {
            --body_bg: var(--section_bg);
            --primary-color: <?= $site_colors->primary_color ?>;
            --secondary-color: <?= $site_colors->secondary_color ?>;
            --teritary-color: <?= $site_colors->teritary_color ?>;
            --dark_bg: <?= $site_colors->dark_bg ?>;
            --light-color: <?= $site_colors->light_color ?>;
            --section_bg: <?= $site_colors->section_bg ?>;
            --p-color: <?= $site_colors->p_color ?>;
            --dark-a: <?= $site_colors->dark_a ?>;
            --testi-linear-1: <?= $site_colors->testi_linear_1 ?>;
            --testi-linear-2: <?= $site_colors->testi_linear_2 ?>;
            --section-linear-1: <?= $site_colors->section_linear_1 ?>;
            --textbox-bg: <?= $site_colors->textbox_bg ?>;
            --textbox-border: <?= $site_colors->textbox_border ?>;
            --light-btn-bg: <?= $site_colors->light_btn_bg ?>;
            --readBtn-bg: <?= $site_colors->readBtn_bg ?>;
            --dropdown-bg: <?= $site_colors->dropdown_bg ?>;
            --inner-bg: <?= $site_colors->inner_bg ?>;
            --qty-bg: <?= $site_colors->qty_bg ?>;
            --dark-color: <?= $site_colors->dark_color ?>;
        } */
    </style>

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