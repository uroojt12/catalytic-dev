<!DOCTYPE html>
<html>

<head>
    <title><?= $email_subject; ?></title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
</head>

<body>
    <table width="650" cellspacing="0" cellpadding="0" style="font-family:Arial;font-size:14px;color:#333;margin:0 auto;border:0">
        <tbody>
            <tr>
                <td>
                    <table width="100%" cellspacing="0" cellpadding="0" style="padding:20px;border:0;border-bottom:5px solid #2f2f2f">
                        <tbody>
                            <tr>
                                <td>
                                    <a href="<?php echo base_url(); ?>" style="display: inline-block;">
                                        <img src="<?= SITE_IMAGES . 'images/' . $site_settings->site_logo . '?v-' . $site_settings->site_version ?>" alt="<?= $site_settings->site_name ?> Logo" style="height: 50px" align="left">
                                    </a>
                                </td>
                                <td valign="top" style="font-size:12px; text-align:right">
                                    <strong><?= date("h:i a"); ?></strong>
                                    <br />
                                    <strong><?= date("m/d/Y"); ?><br></strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="background:#fafafa; padding:50px 15px; border:1px solid #eee; font-size:15px; line-height:1.6">
                    <?= $email_body; ?>
                </td>
            </tr>
            <tr>
                <td style="background:#2f2f2f;color:#fff;font-size:12px;padding:15px;text-align:center">
                    Copyright © <?= $site_settings->site_name ?>
                    <?= date('Y') ?>

                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>