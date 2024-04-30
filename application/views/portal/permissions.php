<?= getBredcrum(ADMIN, array('#' => 'Permissions')); ?>
<div class="row margin-bottom-10">
    <div class="col-md-6">
        <h2 class="no-margin"><i class="entypo-key"></i> Site <strong>Permissions</strong></h2>
    </div>
    <div class="col-md-6 text-right">
        <a href="<?= site_url(ADMIN . '/sub-admin'); ?>" class="btn btn-lg btn-default"><i class="fa fa-arrow-left"></i> Back</a>
    </div>
</div>
<div>
    <hr>
    <div class="row col-md-12">
        <form action=""  role="form" class="form-horizontal frmAjax" method="post" enctype="multipart/form-data">
            <div class="alertMsg" style="display:none"></div>
            <div class="col-md-12">
                <h3><i class="entypo-key"></i> Permissions to <?=$row->site_admin_name?></h3>
                <hr class="hr-short">
                    <div class="form-group">
                <?php foreach($permissions as $key=>$permission):?>
                        <div class="col-md-6">
                            <div class="checkbox">
                                <label><input type="checkbox" name="permissions[]" <?=has_permissions($permission->id,$row->site_id)?'checked':'';?> value="<?=$permission->id?>"> <?=$permission->permission?></label>
                            </div>
                        </div>
                <?php endforeach?>
                    </div>
                <hr class="hr-short">
                <div class="form-group text-right">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary btn-lg col-md-3 pull-right"><i class="fa fa-save"></i> Save <i class="fa fa-spinner fa-pulse fa-1x fa-fw hidden"></i></button>
                    </div>
                </div>
            </div>
        </form>
        <div class="clearfix"></div>
    </div>
    <script type="text/javascript">
        (function($){
            $('.frmAjax button[type="submit"]').click(function(){
                var x=$('input:checkbox').filter(':checked').length;
                if(x==0){
                    alert('Select at least one permission');
                    return false;
                }
            })
        }(jQuery));
    </script>