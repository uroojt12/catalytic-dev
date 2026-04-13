<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Inventory Details</title>
    <style type="text/css">
        body {
            font-family: 'Poppins', sans-serif;
            background: #f8f9ff;
            margin: 0;
            padding: 20px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #eee;
            text-align: left;
        }

        .container {
            width: 600px;
            margin: 0 auto;
            background: #fff;
            box-shadow: 0 1rem 2rem -0.3rem rgb(47 42 73 / 5%);
            border-radius: 4px;
            padding: 20px;
        }

        .header {
            border-bottom: 3px solid #6e6efd;
        }

        .header img {
            display: block;
            width: 140px;
            margin: 0 auto;
        }

        .summary th,
        .summary td {
            border: none;
            border-bottom: 1px dashed #eee;
        }

        .summary tfoot th,
        .summary tfoot td {
            border: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <?php
            $path = base_url() . 'uploads/images/' . $sub_admin_row->site_logo;
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $data = file_get_contents($path);
            $logo = 'data:image/' . $type . ';base64,' . base64_encode($data);
            ?>
            <a href="<?= base_url() ?>">
                <img src="<?= $logo ?>" alt="<?= $sub_admin_row->site_name ?> Logo">
            </a>
        </div>
        <table>
            <tr>
                <td><strong>Buyer</strong>
                    <p><?= $inventory_detail->email ?></p>
                </td>
                <td><strong>Customer</strong>
                    <p>N/A</p>
                </td>
            </tr>
        </table>
        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Code</th>
                    <th>Type</th>
                    <th>Brand</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $count_avg = count($codes_arr);
                $grand_total = 0;
                ?>
                <?php foreach ($codes_arr as $code_row) : ?>
                <?php $folder = 'code' ?>
                <?php $code_img=get_site_code_image_src($folder, $code_row->code_image, $super_admin_settings);  ?>
                    <?php if ($code_row->id) : ?>
                    <?php
                        $c_path = $code_img;
                        $c_type = pathinfo($c_path, PATHINFO_EXTENSION);
                        $c_data = file_get_contents($c_path);
                        $c_logo = 'data:image/' . $c_type . ';base64,' . base64_encode($c_data);
                    ?>
                        <?php
                        $pump_cal_price = calculatedAllPrice($super_admin_settings->site_o_pt_price, $super_admin_settings->site_live_pt_price, $super_admin_settings->site_o_pd_price, $super_admin_settings->site_live_pd_price, $super_admin_settings->site_o_rh_price, $super_admin_settings->site_live_rh_price, $this->session->web_id, $code_row->id, $this->session->mem_id);
                        $price = $code_row->amount * $code_row->qty;
                        // $price = $code_row->amount;
                        $grand_total += $price;
                        ?>
                        <tr>
                            <td><img src="<?= $c_logo ?>" alt="<?= $code_row->code ?> code" style="width:60px;height:60px;object-fit:contain" width="60" height="60"></td>
                            <td><?= $code_row->code ?></td>
                            <td><?= (!empty($code_row->new_type)) ? strtoupper($code_row->new_type) : 'N/A' ?></td>
                            <td><?= get_brand_name($code_row->cat_id) ?></td>
                            <td><?= $code_row->qty ?></td>
                            <td><?= format_amount($price) ?></td>
                        </tr>
                    <?php else : ?>
                                        

                    <?php
                        $c_path = $code_img;
                        $c_type = pathinfo($c_path, PATHINFO_EXTENSION);
                        $c_data = file_get_contents($c_path);
                        $c_logo = 'data:image/' . $c_type . ';base64,' . base64_encode($c_data);
                    ?>
                        <?php
                        $price = $code_row->code_price * $code_row->qty;
                        // $price = $code_row->amount;
                        $grand_total += $price;
                        ?>
                        <tr>
                            <td><img src="<?= $c_logo ?>" alt="<?= $code_row->code ?> code" style="width:60px;height:60px;object-fit:contain" width="60" height="60"></td>
                            <td><?= $code_row->code_name ?></td>
                            <td>N/A</td>
                            <td>N/A</td>
                            <td><?= $code_row->qty ?></td>
                            <td><?= format_amount($price) ?></td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>

            <tfoot>
                <?php
                $total_converters = 0;
                foreach ($codes_arr as $code_row_qty) :
                    $total_converters += $code_row_qty->qty;
                endforeach;
                ?>
                <tr>
                    <th colspan="5">Total Converters</th>
                    <td><?= $total_converters ?></td>
                </tr>
                 <?php if(!empty($new_type_values)): ?>
                    <?php foreach($new_type_values as $new_type_value):?>
                     <tr>
                        <th colspan="5">Total <?=$new_type_value->new_type?> :</th>
                        <td><?=$new_type_value->count?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                
                <tr>
                    <th colspan="5">Average Converter Price</th>
                    <td><?= format_amount_decimal($total_converters > 0 ? $grand_total / $total_converters : 0,2) ?></td>
                </tr>
                <tr>
                    <th colspan="5">Grand Total</th>
                    <td><?= format_amount($grand_total) ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>

</html>