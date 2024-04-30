<!-- JS FIles  -->
<script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
<script src="<?= base_url() ?>assets/js/bootstrap.min.js"></script>
<script src="<?= base_url() ?>assets/js/owl.carousel.min.js"></script>
<script src="<?= base_url() ?>assets/js/owl.carousel.min.js"></script>
<script src="<?= base_url() ?>assets/js/jquery-slider-min.js"></script>
<script src="<?= base_url() ?>assets/js/jquery.mobile.custom.min.js"></script>
<script src="<?= base_url() ?>assets/js/main.js"></script>


<!-- -----------------------------------------------Must Included--------------------------------------------------- -->
<script type="text/javascript" src="<?= base_url('assets/js/jquery.validate.min.js?v-' . $site_settings->site_version) ?>"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/js/toastr.min.js?v-<?= $site_settings->site_version ?>"></script>


<script type="text/javascript" src="<?= base_url('assets/js/custom-validation.js?v-' . $site_settings->site_version) ?>"></script>

<script type="text/javascript" src="<?= base_url('assets/js/custom.js?v-' . $site_settings->site_version) ?>"></script>
<?php if($code_page): ?>
<script type="text/javascript" src="<?= base_url('assets/js/codes.js?v-' . $site_settings->site_version) ?>"></script>
<?php endif; ?>
<?php if($generics_page): ?>
<script type="text/javascript" src="<?= base_url('assets/js/generics.js?v-' . $site_settings->site_version) ?>"></script>
<?php endif; ?>