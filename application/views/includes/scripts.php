<!-- JS FIles  -->
<script src="<?= base_url() ?>assets/js/jquery.min.js"></script>
<script src="<?= base_url() ?>assets/js/bootstrap.min.js"></script>
<script src="<?= base_url() ?>assets/js/owl.carousel.min.js"></script>
<script src="<?= base_url() ?>assets/js/owl.carousel.min.js"></script>
<script src="<?= base_url() ?>assets/js/jquery-slider-min.js"></script>
<script src="<?= base_url() ?>assets/js/jquery.mobile.custom.min.js"></script>
<script src="<?= base_url() ?>assets/js/main.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

<script type="text/javascript">
    $(function() {
        $("#code_price_slider,#generic_price_slider,#photo_price_slider").slider({
            range: "min",
            min: 0,
            max: 100,
            step: 25,
            slide: function(event, ui) {
                $("#code_slider_price,#generic_slider_price,#photo_slider_price").text(ui.value);
                $("#fullness").val(ui.value);
                $("#grade_fullness").val(ui.value);

            }
        });

        // Set the initial value of the hidden input field
        $("#fullness").val($("#code_price_slider").slider("value"));
        $("#generics_fullness").val($("#generic_price_slider").slider("value"));
        $("#grade_fullness").val($("#photo_price_slider").slider("value"));

        // Optionally, update the displayed value of the slider
        $("#code_slider_price").text($("#fullness").val());
        $("#generic_slider_price").text($("#generics_fullness").val());
        $("#photo_slider_price").text($("#grade_fullness").val());

    });

</script>

<!-- -----------------------------------------------Must Included--------------------------------------------------- -->
<script type="text/javascript" src="<?= base_url('assets/js/jquery.validate.min.js?v-' . $site_settings->site_version) ?>"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/js/toastr.min.js?v-<?= $site_settings->site_version ?>"></script>


<script type="text/javascript" src="<?= base_url('assets/js/custom-validation.js?v-' . $site_settings->site_version) ?>"></script>

<script type="text/javascript" src="<?= base_url('assets/js/custom.js?v-' . $site_settings->site_version) ?>"></script>
<?php if ($code_page) : ?>
    <script type="text/javascript" src="<?= base_url('assets/js/codes.js?v-' . $site_settings->site_version) ?>"></script>
<?php endif; ?>
<?php if ($generics_page) : ?>
    <script type="text/javascript" src="<?= base_url('assets/js/generics.js?v-' . $site_settings->site_version) ?>"></script>
<?php endif; ?>