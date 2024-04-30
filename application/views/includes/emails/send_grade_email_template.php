<table style="color: #333; font-size: 13px; font-family: Arial, sans-serif; line-height: 1.3; margin: auto; border-collapse: collapse;" width="100%" cellspacing="0" cellpadding="0" border="0" bgcolor="#fff">
    <tbody>
        <tr>
            <td style="
                    background: #fff;
                    height: 120px;
                    background-repeat: no-repeat;
                    background-position: center;
                    background-size: cover;
                ">
                <table width="100%">
                    <tr>
                        <td style="
                                text-align: center;
                                font-weight: 600;
                                font-size: 26px;
                                padding: 0px 50px;
                                line-height: 22px;
                                color: #083a2d;
                            ">
                            <?= $site_settings->site_name ?>
                        </td>
                    </tr>

                    <tr>
                        <td height="30"></td>
                    </tr>
                    <tr>
                        <td height="1" bgcolor="#F4F3F3"></td>
                    </tr>

                </table>
            </td>
        </tr>
        <tr>
            <td style="padding-top: 0px;">
                <table style="background: #fff; color: #333; font-size: 13px; border-collapse: collapse;" width="100%" cellspacing="0" cellpadding="5" border="0">
                    <tbody>
                        <tr style="font-size: 15px;">
                            <td style="padding: 10px;" colspan="2"><strong>Hello Admin,</strong></td>
                        </tr>
                        <tr>
                            <?php if ($mem_data['photo']->status == 'approved') { ?>
                                <td style="font-size: 15px; line-height: 20px;">
                                    Photo Grade has been <b>Completed</b> successfully.
                                </td>
                            <?php } elseif ($mem_data['photo']->status == 'rejected') { ?>
                                <td style="font-size: 15px; line-height: 20px;">
                                    Photo Grade has been <b>Rejected</b>.
                                </td>
                            <?php } else { ?>
                                <td style="font-size: 15px; line-height: 20px;">
                                    Photo Grade has been <b>Pending</b>.
                                </td>
                            <?php } ?>
                        </tr>

                        <tr>
                            <td style="font-size: 15px; line-height: 20px;">
                                Photo Grade: <img src="<?= get_site_image_src("photo_grade", $mem_data['photo']->grade_image); ?>" width="100">
                            </td>
                        </tr>
                        <tr>
                            <td style="font-size: 15px; line-height: 20px;">
                                Fullness: <b><?= $mem_data['photo']->grade_fullness ?></b>
                            </td>
                        </tr>
                        <tr>
                            <td style="font-size: 15px; line-height: 20px;">
                                Notes: <b><?= $mem_data['photo']->grade_notes ?></b>
                            </td>
                        </tr>
                        <?php if ($mem_data['photo']->status == 'approved') { ?>
                            <tr>
                                <td style="font-size: 15px; line-height: 20px;">
                                    Price: <b><?= format_amount($mem_data['photo']->price, 2) ?></b>
                                </td>
                            </tr>
                        <?php } ?>
                        <?php if ($mem_data['photo']->status == 'rejected') { ?>
                            <tr>
                                <td style="font-size: 15px; line-height: 20px;">
                                    Rejection Notes: <b><?= $mem_data['photo']->admin_notes ?></b>
                                </td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td style="font-size: 15px; line-height: 20px;">
                                Date: <b><?= format_date($mem_data['photo']->created_date, 'M d, Y'); ?></b>
                            </td>
                        </tr>
<!-- 
                        <tr>
                            <td style="padding: 10px; font-size: 15px; line-height: 29px;">
                                If you have any questions, please contact us at <a href="mailto:<?= $site_settings->site_email ?>" style="color:#083a2d;text-decoration: underline;"><?= $site_settings->site_email ?></a>
                                <br />
                            </td>
                        </tr> -->
                        <tr height="5"></tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>