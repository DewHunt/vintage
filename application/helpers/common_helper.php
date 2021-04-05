<?php

function upload_image($inputName = '',$maxSize = 0,$maxWidth = 0,$maxHeight = 0,$upload_path = '',$link = '')
{
    $ci = &get_instance();

	if (empty($inputName)) {
        $ci->session->set_flashdata('error','Something Went Wrong. Please Try Again');
        redirect(base_url($link));
	}

    if ($maxSize > 0 && (int) $_FILES[$inputName]["size"] > ($maxSize * 1024)) {
        $ci->session->set_flashdata('error','Image size can not be more than '.$maxSize.' KB');
        redirect(base_url($link));
    }
    
	$imagePath = '';

	if (!empty($_FILES[$inputName]['name'])) {
	    list($width,$height) = getimagesize($_FILES[$inputName]['tmp_name']);

	    if (($maxWidth > 0 && $width > $maxWidth) || ($maxHeight > 0 && $height > $maxHeight)) {
	        $ci->session->set_flashdata('error','Image Width And Height Can Not Be More Than '.$maxWidth.'px And '.$maxHeight.'px');
	        redirect(base_url($link));
	    }

	    $imageName = $_FILES[$inputName]['name'];
	    $config['file_name'] = date("YmdHis");
	    $config['upload_path'] = './'.$upload_path;
	    $config['allowed_types'] = 'gif|jpg|png|jpeg';

	    $ci->load->library('upload', $config);
	    if ($ci->upload->do_upload($inputName)) {
	    	$upload_info = $ci->upload->data();
	        $imagePath  = str_replace('.','',$upload_path).$upload_info['file_name'];
	    } else {
	        $ci->session->set_flashdata('error','Something Went Wrong. Please Try Again');
	        redirect(base_url($link));
	    }	
	}
	return $imagePath;	
}

function data_form_post($dataFields) {
    $ci = &get_instance();
    $dataArray = array();
    foreach ($dataFields as $field) {
        $dataArray[$field] = $ci->input->post($field);
    }
    return $dataArray;
}

function get_menu_permission($menu_access_name = '')
{
	if ($menu_access_name == '') { return false; }

    $ci = &get_instance();
    $company_info = $ci->Company_Model->get_company();
    
    if (empty($company_info->menu_permission)) { return false; }

    $menu_permission = '';
	$menu_permission_list = json_decode($company_info->menu_permission,true);
	$menu_permission = array_key_exists($menu_access_name,$menu_permission_list) ? $menu_permission_list[$menu_access_name] : 1;

	if ($menu_permission == 0) { return false; }

	return true;
}

function get_root_menu_list($user_id = 0,$menu_permission = false)
{
    $ci = &get_instance();
    $query = "";
    if ($user_id > 0 && $menu_permission === true) {
    	$user_info = $ci->User_Model->get_user($user_id);
    	$query = "id IN ($user_info->menu_permission) AND";
    }
    $result = $ci->db->query("SELECT * FROM menus WHERE $query parent_menu IS NULL AND status = 1 ORDER BY order_by ASC")->result();
    return $result;
}

function get_menu_list($menu_id,$user_id = 0,$menu_permission = false)
{
    $ci = &get_instance();
    $query = "";
    if ($user_id > 0 && $menu_permission === true) {
    	$user_info = $ci->User_Model->get_user($user_id);
    	$query = "id IN ($user_info->menu_permission) AND";
    }
    $result = $ci->db->query("SELECT * FROM menus WHERE $query parent_menu = $menu_id AND status = 1 ORDER BY order_by ASC")->result();
    return $result;
}

function checke_menu_permission($menu_id,$menu_permission)
{
	$checked = "";
    if (in_array($menu_id,$menu_permission)) { 
    	$checked = "checked";
    }

    return $checked;
}

function get_user_permission($menu_link = '')
{
    $ci = &get_instance();
	if (empty($menu_link) || empty($ci->session->userdata('user_session'))) {
		return false;
	}

	$result = $ci->db->query("
		SELECT `menus`.*
		FROM `menus`
		RIGHT JOIN `user_info` ON FIND_IN_SET(`menus`.`id`,`user_info`.`menu_permission`)
		WHERE `menu_link` = '$menu_link'
	")->row();

	if (empty($result)) {
		return false;
	}

	return true;
}