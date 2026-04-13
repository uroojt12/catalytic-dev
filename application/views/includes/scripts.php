<!-- JS FIles  -->
<script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
<script src="<?= base_url() ?>assets/js/bootstrap.min.js"></script>
<script src="<?= base_url() ?>assets/js/owl.carousel.min.js"></script>
<script src="<?= base_url() ?>assets/js/owl.carousel.min.js"></script>
<script src="<?= base_url() ?>assets/js/jquery-slider-min.js"></script>
<!-- <script src="<?= base_url() ?>assets/js/jquery.mobile.custom.min.js"></script> -->
<script src="<?= base_url() ?>assets/js/main.js?v-11"></script>
<!-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script> -->

<script type="text/javascript">
    function updateSliderValue(value) {
        // console.log('Slider value:', value);
        document.getElementById('code_slider_price').textContent = value;
        document.getElementById('generic_slider_price').textContent = value;
        document.getElementById('custom_code_slider_price').textContent = value;

        
    }

    function updatePhotoSliderValue(value) {
        // console.log('Slider value:', value);
        document.getElementById('photo_slider_price').textContent = value;

    }
    function updateMarginSliderValue(value) {
        document.getElementById('user_margin_percentage').textContent = value;

    }

</script>

<!-- -----------------------------------------------Must Included--------------------------------------------------- -->
<script type="text/javascript" src="<?= base_url('assets/js/jquery.validate.min.js?v-' . $site_settings->site_version) ?>"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/js/toastr.min.js?v-<?= $site_settings->site_version ?>"></script>


<script type="text/javascript" src="<?= base_url('assets/js/custom-validation.js?v-' . $site_settings->site_version) ?>"></script>

<script type="text/javascript" src="<?= base_url('assets/js/custom.js?v-' . $site_settings->site_version) ?>-12"></script>
<?php if ($code_page) : ?>
    <script type="text/javascript" src="<?= base_url('assets/js/codes.js?v-' . $site_settings->site_version) ?>"></script>
<?php endif; ?>
<?php if ($generics_page) : ?>
    <script type="text/javascript" src="<?= base_url('assets/js/generics.js?v-' . $site_settings->site_version) ?>"></script>
<?php endif; ?>