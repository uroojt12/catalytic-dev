<?php

$CI = &get_instance();
function get_header()
{
    $CI = get_instance();
    if ($CI->session->has_userdata('mem_id') && $CI->session->has_userdata('mem_type'))
        $CI->load->view('includes/header-logged');
    else
        $CI->load->view('includes/header');
}

function siteSettingsData($site_settings)
{
    $data = (object)[
        'site_id' => $site_settings->site_id,
        'site_domain' => $site_settings->site_domain,
        'site_name' => $site_settings->site_name,
        'site_email' => $site_settings->site_email,
        'site_order_email' => $site_settings->site_order_email,
        'site_general_email' => $site_settings->site_general_email,
        'site_noreply_email' => $site_settings->site_noreply_email,
        'site_phone' => $site_settings->site_phone,
        'site_fax' => $site_settings->site_fax,
        // 'site_paypal_environment' => $site_settings->site_paypal_environment,
        // 'site_sandbox_paypal' => $site_settings->site_sandbox_paypal,
        // 'site_live_paypal' => $site_settings->site_live_paypal,
        // 'site_stripe_secret_key' => $site_settings->site_stripe_secret_key,
        // 'site_stripe_public_key' => $site_settings->site_stripe_public_key,
        'site_ip' => $site_settings->site_ip,
        'site_logo' => $site_settings->site_logo,
        'site_footer_logo' => $site_settings->site_footer_logo,
        'site_icon' => $site_settings->site_icon,
        'site_thumb' => $site_settings->site_thumb,
        'site_address' => $site_settings->site_address,
        'site_about' => $site_settings->site_about,
        'site_city' => $site_settings->site_city,
        'site_state' => $site_settings->site_state,
        'site_zip' => $site_settings->site_zip,
        'site_country' => $site_settings->site_country,
        'site_copyright' => $site_settings->site_copyright,
        'site_facebook' => $site_settings->site_facebook,
        'site_twitter' => $site_settings->site_twitter,
        'site_google' => $site_settings->site_google,
        'site_instagram' => $site_settings->site_instagram,
        'site_linkedin' => $site_settings->site_linkedin,
        'site_youtube' => $site_settings->site_youtube,
        'site_discord' => $site_settings->site_discord,
        'site_contact_map' => $site_settings->site_contact_map,
        'site_google_ad' => $site_settings->site_google_ad,
        'site_meta_desc' => $site_settings->site_meta_desc,
        'site_meta_keyword' => $site_settings->site_meta_keyword,
        'site_meta_copyright' => $site_settings->site_meta_copyright,
        'site_meta_author' => $site_settings->site_meta_author,
        'site_accept_order' => $site_settings->site_accept_order,
        'site_first_section_heading' => $site_settings->site_first_section_heading,
        'site_footer_text' => $site_settings->site_footer_text,
        'site_second_section_heading' => $site_settings->site_second_section_heading,
        'site_third_section_heading' => $site_settings->site_third_section_heading,
        'site_fourth_section_heading' => $site_settings->site_fourth_section_heading,
        'site_field_heading' => $site_settings->site_field_heading,
        'site_field_text' => $site_settings->site_field_text,
        'site_after_field_heading' => $site_settings->site_after_field_heading,
        'site_pre_footer_heading' => $site_settings->site_pre_footer_heading,
        'site_pre_footer_tagline' => $site_settings->site_pre_footer_tagline,
        'site_pre_footer_field_text' => $site_settings->site_pre_footer_field_text,
        'site_pre_footer_button_text' => $site_settings->site_pre_footer_button_text,
        'site_first_section_sub_1' => $site_settings->site_first_section_sub_1,
        'site_first_section_sub_2' => $site_settings->site_first_section_sub_2,
        'site_first_section_sub_3' => $site_settings->site_first_section_sub_3,
        'site_fourth_section_sub_1' => $site_settings->site_fourth_section_sub_1,
    ];
    return $data;
}

function get_pages()
{
    return [
        '/'             => 'Home Page',
        '/code' => 'Code Page',
        '/inventory' => 'Inventory Page',
        '/generics' => 'Generics Page',
        '/photo_grade' => 'Photo Grade Page',

    ];
}

function get_sub_service_title($id)
{
    $CI = get_instance();
    $service = $CI->master->getRow('sub_services', array('id' => $id));
    return $service->title;
}
function get_service_name($id)
{
    $CI = get_instance();
    $service = $CI->master->getRow('services', array('id' => $id));
    return $service->name;
}
function get_services()
{
    $CI = get_instance();
    return $CI->master->getRows('services', array('status' => 1));
}
function get_partners()
{
    $CI = get_instance();
    return $CI->master->getRows('partners', array('status' => 1));
}

function get_papular_products($limit)
{
    $CI = get_instance();
    $CI->db->select("p.*, (SELECT GROUP_CONCAT(DISTINCT size SEPARATOR ' ') FROM `tbl_product_sizes` WHERE p_id = p.id) as sizes", FALSE);
    $CI->db->where('status', 1);
    $CI->db->limit($limit);
    $CI->db->order_by('id', 'desc');
    return $CI->db->get('products p')->result();
}

function get_main_cats($type = 'product')
{
    $CI = get_instance();
    return $CI->master->fetch_rows("SELECT * FROM `tbl_categories` WHERE type = '$type' AND parent_id = 0 AND status = 1");
}

function get_sub_cats($type = 'product')
{
    $CI = get_instance();
    return $CI->master->fetch_rows("SELECT * FROM `tbl_categories` WHERE type = '$type' AND parent_id<>0 AND status = 1");
}

function get_group_colors()
{
    $CI = get_instance();
    return $CI->master->fetch_rows("SELECT color, color_name FROM `tbl_product_colors` GROUP BY color_name");
}

function get_group_sizes()
{
    $CI = get_instance();
    return $CI->master->fetch_rows("SELECT size FROM `tbl_product_sizes` GROUP BY size");
}

function get_max_price()
{
    $CI = get_instance();
    $CI->db->select_max('default_price');
    $query = $CI->db->get('products');
    return floatval($query->row()->default_price);
}

/*** stats ***/

function get_review_rate($mem_id)
{
    $CI = get_instance();
    $CI->db->select('AVG(rating) as total')
        ->where('mem_id', $mem_id)
        ->where('parent_id', NULL)
        ->where("TIMESTAMPDIFF(DAY, date, NOW())<=", 60);
    $query = $CI->db->get('reviews');
    $total = $query->row()->total;
    return round(floatval($total), 1);
}

function count_repeat_stays($sitter_id)
{
    $CI = get_instance();
    $row = $CI->master->fetch_row("SELECT SUM(count) as total FROM (SELECT count(id) as count FROM `tbl_bookings` WHERE `sitter_id` = $sitter_id AND `status` = 2 AND `canceled` = 0 AND `completed` = 2 GROUP BY `owner_id` HAVING count>1) as a");
    return intval($row->total);
}

function get_response_rate($sitter_id)
{
    $CI = get_instance();
    $CI->db->select("((SELECT COUNT(*) FROM tbl_chat where (mem_one=$sitter_id or mem_two=$sitter_id) and response_time is not NULL and TIMESTAMPDIFF(DAY, response_date, NOW()) <= 60)/COUNT(*))*100 as rate");
    $CI->db->group_start()
        ->where("mem_one", $sitter_id)
        ->or_where("mem_two", $sitter_id)
        ->group_end();
    $CI->db->where("TIMESTAMPDIFF(DAY, time, NOW())<=", 60);
    $query = $CI->db->get('chat');
    return round($query->row()->rate);
}

function get_response_time($sitter_id)
{
    $CI = get_instance();
    $CI = get_instance();
    $CI->db->select("AVG(response_time) as total");

    $CI->db->group_start()
        ->where("mem_one", $sitter_id)
        ->or_where("mem_two", $sitter_id)
        ->group_end();
    $CI->db->where("TIMESTAMPDIFF(DAY, response_date, NOW())<=", 60);
    $res[0] = $response_time = round($CI->db->get('chat')->row()->total);
    if ($response_time > 0) {

        $strTime = array("Second", "Minute", "Hour", "Day", "Month", "Year");
        // $strTime = array(" sec", " min", " hr", " day", " month", " year");
        $length = array("60", "60", "24", "30", "12", "10");

        for ($i = 0; $response_time >= $length[$i] && $i < count($length) - 1; $i++) {
            $response_time = $response_time / $length[$i];
        }
        $response_time = round($response_time);
        $s = $response_time > 1 ? 's' : '';
        $res[1] = $response_time . " <small>" . $strTime[$i] . $s . "</small>";
        return $res;
    }

    return 0;
}
/*** end stats ***/



function get_yes_no($status)
{
    return $status == 1 ? 'Yes' : 'No';
}


//***** PERMISSIONS*******///
function has_access($permission_id = 0)
{
    $CI = get_instance();
    if (is_admin())
        return true;
    if (!in_array($permission_id, $CI->session->permissions)) {
        // if($permission_id>0 && !is_admin() && !in_array($permission_id,$CI->session->userdata('permissions'))){
        show_404();
        exit;
    }
    return $CI->session->loged_in['id'];
}

function access($permission_id)
{
    $CI = get_instance();
    if (is_admin()) return true;
    return in_array($permission_id, $CI->session->permissions);
}

function is_admin()
{
    $CI = get_instance();
    return $CI->session->loged_in['admin_type'] == 'admin' ? true : false;
}

function has_permissions($permission_id, $id = 0)
{
    $CI = get_instance();
    if ($id < 1)
        $id = $CI->session->loged_in['id'];
    return $CI->master->getRow('permissions_admin', array('permission_id' => $permission_id, 'admin_id' => $id));
}

function get_size_weight($size)
{
    $weights = array('small' => '0-15lbs', 'medium' => '16-40lbs', 'large' => '41-100lbs', 'giant' => '101+lbs');
    return $weights[$size];
}
//***** end PERMISSIONS*******///

function get_location_detail($zipcode, $country = 'gb')
{
    $url = 'https://geocoder.api.here.com/6.2/geocode.json?app_id=IAcDhEZWhrGYOn6m3JnI&app_code=52n2G76qxgU7qRyswkqYaw%20&searchtext=' . urlencode($zipcode) . ',%20' . $country;
    $headers = array(
        'Accept: application/json',
        'Content-Type: application/json'
    );
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $data = curl_exec($ch);
    if (curl_error($ch)) {
        echo $error_msg = curl_error($ch);
    }
    curl_close($ch);
    $response = json_decode($data);
    return $response->Response->View[0]->Result[0]->Location->DisplayPosition;
        /*echo $response->Response->View[0]->Result[0]->Location->DisplayPosition->Latitude.'<br>';
    echo $response->Response->View[0]->Result[0]->Location->DisplayPosition->Longitude*/;
}
