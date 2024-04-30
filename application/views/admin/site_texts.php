<?= showMsg(); ?>
<?= getBredcrum(ADMIN, array('#' => 'Notifications Management')); ?>
<h2><i class="fa fa-cogs"></i> Notifications <strong>Management</strong></h2>
<div class="row col-md-12" style="display: none;">
    <form action=""  role="form" class="form-horizontal" method="post" enctype="multipart/form-data">
        <input type="hidden" name="addnewForm" value="posted">
        <div class="col-md-12">
            <div class="form-group">
                <div class="col-md-6">
                    <label class="control-label">Type</label>
                    <div class="form-group">
                        <div class="col-md-12">
                            <select name="txt_type" class="form-control">
                                <option value="alert">Alert</option>
                                <option value="email">Email</option>
                            </select>
                        </div>
                    </div> 
                </div>
                <div class="col-md-6">
                    <label class="control-label">Label</label>
                    <input type="text" name="txt_label" class="form-control" required>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6">
                    <label class="control-label">Key</label>
                    <div class="form-group">
                        <div class="col-md-12">
                            <input type="text" name="txt_key" class="form-control" required>
                        </div>
                    </div> 
                </div>
                <div class="col-md-6">
                    <label class="control-label">Value</label>
                    <textarea  name="txt_value" rows="3" class="form-control"></textarea>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-12">                
            <hr class="hr-short">
            <div class="form-group text-right">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary btn-lg col-md-3 pull-right"><i class="fa fa-save"></i> Save</button>
                </div>
            </div>
        </div>
        <br>
        <br>
    </form>
</div>
<hr>
<form role="form" class="form-horizontal" action="" method="post">
    <input type="hidden" name="textsForm" value="posted">
    <div class="row col-md-12">
        <?php
            $total_texts = countlength($email_texts);
            if ($total_texts > 0):
        ?>
        <h3><i class="fa fa-envelope-o"></i> Emails</h3>
        <p>Please don't change $name in email body</p>
        <hr class="hr-short"> 
        <div class="col-md-6">
            <?php for ($i = 0; $i < ceil($total_texts/2); $i++): ?>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label"><?= $email_texts[$i]->txt_label; ?> Subject</label>
                        <input type="text" name="txt_subject[<?= $email_texts[$i]->txt_id; ?>]" value="<?= $email_texts[$i]->txt_subject; ?>" class="form-control" required>
                    </div>
                </div> 
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label"><?= $email_texts[$i]->txt_label; ?> Body <span class="symbol required"></span></label>
                        <textarea rows="5" name="txt_value[<?= $email_texts[$i]->txt_id; ?>]" class="form-control  ckeditor"><?= $email_texts[$i]->txt_value; ?></textarea>
                    </div>
                </div>
                <?php if (!empty($email_texts[$i]->txt_is_sms)): ?>
                    <div class="form-group">
                        <div class="col-md-12">
                            <label class="control-label">SMS Text <span class="symbol required"></span></label>
                            <textarea rows="2" maxlength="120" name="txt_msg[<?= $email_texts[$i]->txt_id; ?>]" class="form-control"><?= $email_texts[$i]->txt_msg; ?></textarea>
                            <small>Maximum 120 Characters </small>
                        </div>
                    </div>
                <?php endif ?>
                <hr> 
            <?php endfor; ?>
        </div>
        <div class="col-md-6">
            <?php for ($i; $i < $total_texts; $i++): ?>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label"><?= $email_texts[$i]->txt_label; ?> Subject</label>
                        <input type="text" name="txt_subject[<?= $email_texts[$i]->txt_id; ?>]" value="<?= $email_texts[$i]->txt_subject; ?>" class="form-control" required>
                    </div>
                </div> 
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="control-label"><?= $email_texts[$i]->txt_label; ?> Body <span class="symbol required"></span></label>
                        <textarea rows="5" name="txt_value[<?= $email_texts[$i]->txt_id; ?>]" class="form-control  ckeditor"><?= $email_texts[$i]->txt_value; ?></textarea>
                    </div>
                </div>
                <?php if (!empty($email_texts[$i]->txt_is_sms)): ?>
                    <div class="form-group">
                        <div class="col-md-12">
                            <label class="control-label">SMS Text <span class="symbol required"></span></label>
                            <textarea rows="2" maxlength="120" name="txt_msg[<?= $email_texts[$i]->txt_id; ?>]" class="form-control"><?= $email_texts[$i]->txt_msg; ?></textarea>
                            <small>Maximum 120 Characters </small>
                        </div>
                    </div>
                <?php endif ?>
                <hr> 
            <?php endfor; ?>
        </div>
    <?php endif; ?>
    </div>
    <div class="row col-md-12">
        <?php $total_alerts = countlength($alert_texts) ?>
        <?php if ($total_alerts > 0): ?>
            <h3><i class="fa fa-bell-o"></i> Alerts</h3>
            <hr class="hr-short"> 
            <div class="col-md-6">
                <?php for ($i = 0; $i < ceil($total_alerts/2); $i++): ?>
                    <div class="form-group">
                        <div class="col-md-12">
                            <strong class="control-label"><?= $alert_texts[$i]->txt_label; ?> <span class="symbol required"></span></strong>
                            <textarea rows="5" name="txt_value[<?= $alert_texts[$i]->txt_id; ?>]" class="form-control"><?= $alert_texts[$i]->txt_value; ?></textarea>
                        </div>
                    </div> 
                <?php endfor; ?>
            </div>
            <div class="col-md-6">
                <?php for ($i; $i < $total_alerts; $i++): ?>
                    <div class="form-group">
                        <div class="col-md-12">
                            <strong class="control-label"><?= $alert_texts[$i]->txt_label; ?> <span class="symbol required"></span></strong>
                            <textarea rows="5" name="txt_value[<?= $alert_texts[$i]->txt_id; ?>]" class="form-control"><?= $alert_texts[$i]->txt_value; ?></textarea>
                        </div>
                    </div> 
                <?php endfor; ?>
            </div>
        <?php endif; ?>
        <div class="clearfix"></div>
        <div class="col-md-12"><hr class="hr-short">
            <div class="form-group text-right">
                <div class="col-md-12">
                    <input type="submit" class="btn btn-green btn-lg" value="Update Texts">
                </div>
            </div>
        </div>   
        <br><br>
    </div>
</form>