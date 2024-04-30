<?php

    if (!empty($post['item_name']) && !empty($post['amount']) && !empty($post['custom'])) {
        // pr($post);
?>
    <html>
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <title>Redirecting to Paypal...</title>
        </head>
        <body onLoad="document.getElementById('frmpay').submit()">
        <center>Redirecting to Paypal...</center>
        <?php if ($setting['sandbox'] == true): ?>
            <form name="frmpay" id="frmpay" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
            <?php else: ?>
            <form name="frmpay" id="frmpay" action="https://www.paypal.com/cgi-bin/webscr" method="post">
            <?php endif; ?>
                <input type="hidden" name="cmd" value="_xclick">
                <?php if ($setting['sandbox'] == true): ?>
                    <input type="hidden" name="business" value="<?php echo trim($setting['sandbox_paypal']); ?>">
                <?php else: ?>
                    <input type="hidden" name="business" value="<?php echo trim($setting['live_paypal']); ?>">
                <?php endif; ?>
                <input type="hidden" name="item_name" value="<?php echo $post['item_name']; ?>">
                <input type="hidden" name="currency_code" value="<?php echo $post['currency']; ?>">
                <input type="hidden" name="amount" value="<?php echo floatval($post['amount']); ?>">
                <input type="hidden" name="custom" value="<?php echo $post['custom']; ?>">
                <input type="hidden" name="notify_url" value="<?php echo $setting['notify_url']; ?>">
                <input type="hidden" name="cancel_return" value="<?php echo $setting['cancel_url']; ?>">
                <input type="hidden" name="return" value="<?php echo $setting['return_url']; ?>">
               
            </form>
            <script type="text/javascript">document.getElementById('frmpay').submit();</script>
        </body>
    </html>
    <?php
}else {
    pr("false");
    ?><script type="text/javascript">
        document.location = '<?php echo $setting['url']; ?>';</script><?php
}
?>