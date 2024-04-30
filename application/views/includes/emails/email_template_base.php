<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body>
        <table width="650" cellspacing="0" cellpadding="0" border="0" align="center">
            <tbody>
                
                <tr>
                    <td height="10">
                        <table width="100%" cellspacing="0" cellpadding="0" border="0">
                            <tbody></tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table width="100%" cellspacing="0" cellpadding="0" border="0">
                            <tbody>
                                <tr>
                                    <td style="padding: 15px;" valign="top" bgcolor="#fafafa">
                                        <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                            <tbody>
                                                <tr>
                                                    <td style="padding-left: 10px; padding-bottom: 5px; padding-right: 10px;" height="2"></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                                            <tbody>
                                                                <tr>
                                                                    <td
                                                                        style="
                                                                            background-color: #ffffff;
                                                                            border: 1px solid #f0f0f0;
                                                                            padding-top: 10px;
                                                                            padding-left: 10px;
                                                                            padding-bottom: 10px;
                                                                            padding-right: 10px;
                                                                            font-family: Arial;
                                                                            font-size: 14px;
                                                                            color: #333;
                                                                            line-height: 25px;
                                                                        "
                                                                        align="center"
                                                                    >
                                                                        <?php echo $email_body?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <table width="100%" border="0" style="background: #f5f5f5;">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td width="100%" align="center">
                                                                                        <a href="<?=$site_settings->site_domain?>" target="_blank">
                                                                                            <img src="<?= !empty($site_settings->site_logo) ? get_site_image_src('images', $site_settings->site_logo) : base_url('assets/images/logo.svg') ?>" style="margin: 20px auto 10px; width: 220px;" class="CToWUd" />
                                                                                        </a>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td align="center">
                                                                                        <a href="<?=$site_settings->site_facebook?>">
                                                                                            <img src="<?=get_site_image_src('social_icons', 'facebook.svg')?>" style="margin: 20px auto 10px; width: 30px;" />
                                                                                        </a>
                                                                                        <a href="<?=$site_settings->site_linkedin?>">
                                                                                            <img src="<?=get_site_image_src('social_icons', 'linkedin.svg')?>" style="margin: 20px auto 10px; width: 30px;" />
                                                                                        </a>
                                                                                        <a href="<?=$site_settings->site_twitter?>">
                                                                                            <img src="<?=get_site_image_src('social_icons', 'twitter.svg')?>" style="margin: 20px auto 10px; width: 30px;" />
                                                                                        </a>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr height="15"></tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <table align="center">
                                                                            <tbody></tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </body>
</html>
