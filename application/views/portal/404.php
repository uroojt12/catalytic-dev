<html lang="en">
    <?php $this->load->view("admin/includes/common-header"); ?>
    <body class="page-body login-page login-form-fall">
        <!-- This is needed when you send requests via Ajax -->
        <script type="text/javascript">
            var baseurl = '<?= base_url() ?>';
        </script>

        <div class="main-content">
            <div class="page-error-404">


                <div class="error-symbol">
                    <i class="entypo-attention"></i>
                </div>

                <div class="error-text">
                    <h2>404</h2>
                    <p>Page not found!</p>
                </div>

                <hr />

                <div class="error-text">

                   

                    <div class="input-group minimal">
                        

                      <a href="<?= base_url('admin') ?>" class="btn btn-success btn-block">Back to the website</a>
                    </div>

                </div>

            </div>
        </div>
       
    </body>
</html>