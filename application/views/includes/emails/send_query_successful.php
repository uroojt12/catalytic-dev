<table
    style="color: #333; font-size: 13px; font-family: Arial, sans-serif; line-height: 1.3; margin: auto; border-collapse: collapse;"
    width="100%"
    cellspacing="0"
    cellpadding="0"
    border="0"
    bgcolor="#fff"
>
    <tbody>
        <tr>
            <td
                style="
                    background: #fff;
                    height: 120px;
                    background-repeat: no-repeat;
                    background-position: center;
                    background-size: cover;
                "
            >
                <table width="100%">
                    <tr>
                        <td
                            style="
                                text-align: center;
                                font-weight: 600;
                                font-size: 26px;
                                padding: 0px 50px;
                                line-height: 22px;
                                color: #00a78e;
                            "
                        >
                        <?=$site_settings->site_name?>
                        </td>
                    </tr>
                    
                    <tr>
                        <td height="30"></td>
                    </tr>
                    <tr><td height="1" bgcolor="#F4F3F3"></td></tr>
                    
                </table>
            </td>
        </tr>
        <tr>
            <td style="padding-top: 0px;">
                <table style="background: #fff; color: #333; font-size: 13px; border-collapse: collapse;" width="100%" cellspacing="0" cellpadding="5" border="0">
                    <tbody>
                        <tr style="font-size: 15px;">
                            <td style="padding: 10px;" colspan="2"><strong>Dear <?=$mem_data['name']?>,</strong></td>
                        </tr>
                        <tr>
                            <td style="padding: 10px; font-size: 15px; line-height: 29px;">
                                Thanks for contacting <?=$site_settings->site_name?>. We have received your query, and someone in our team will get back to you in the next 48 working hours. If you have not already done so, please check out our <a target="_blank" href="<?=$site_settings->site_domain?>faq">FAQs</a> page, where we have answered most of the questions. We only reply to your query if it is not answered on our <a target="_blank" href="<?=$site_settings->site_domain?>faq">FAQs</a> page.
                                <br/><br/>
                                Kind Regards<br/>
                                <?=$site_settings->site_name?>
                            </td>
                        </tr>
                        <tr height="5"></tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
