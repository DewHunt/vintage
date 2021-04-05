<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Branch_Model extends CI_Model
{
    public $table_name = 'branch_info';
    protected $primary_key = 'id';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_branch($id = 0)
    {
        if ($id === 0) {
            /*$query = $this->db->get_where($this->table_name);
            return $query->result();*/
            $this->db->from($this->table_name);
            $this->db->order_by("branch_name", "asc");
            $query = $this->db->get();
            return $query->result();
        } else {
            $query = $this->db->get_where($this->table_name, array('id' => $id));
            return $query->row();
        }
    }

    public function get_any_type_branch($condition,$factoryStatus,$hotKitchenStatus)
    {
        $results = $this->db->query("SELECT * FROM branch_info WHERE factory_status = $factoryStatus $condition hot_kitchen_status = $hotKitchenStatus")->result();
        
        return $results;
    }

    public function getAllBranchById($outlets)
    {
        // echo "<pre>"; print_r($outlets); exit();
        $outletArray = implode(',',$outlets);

        if ($outletArray == 'all') {
            $results = $this->db->query("SELECT * FROM branch_info")->result();
        } else {
            $results = $this->db->query("SELECT * FROM branch_info WHERE id IN ($outletArray)")->result();
        }
        
        return $results;
    }

    public function get_any_type_branch_by_id($outlets,$condition,$factoryStatus,$hotKitchenStatus)
    {
        $outletArray = implode(',',$outlets);

        if ($outletArray == 'all') {
            $results = $this->db->query("SELECT * FROM branch_info WHERE factory_status = $factoryStatus $condition hot_kitchen_status = $hotKitchenStatus")->result();
        } else {
            $results = $this->db->query("SELECT * FROM branch_info WHERE id IN ($outletArray) AND factory_status = $factoryStatus $condition hot_kitchen_status = $hotKitchenStatus")->result();
        }        
        return $results;
    }

    public function get_only_all_branch_by_id($outlets,$status)
    {
        // echo $outlets; exit();
        $outletArray = implode(',',$outlets);

        if ($outletArray == 'all') {
            $results = $this->db->query("SELECT * FROM branch_info WHERE hot_kitchen_status <> 1 AND factory_status = $status")->result();
        } else {
            $results = $this->db->query("SELECT * FROM branch_info WHERE id IN ($outletArray) AND hot_kitchen_status <> 1 AND factory_status = $status")->result();
        }
        
        return $results;
    }

    public function get_factory()
    {
        $result = $this->db->query("SELECT * FROM `branch_info` WHERE `factory_status` = 1")->row();
        return $result;
    }

    public function get_hot_kitchen()
    {
        $result = $this->db->query("SELECT * FROM `branch_info` WHERE `hot_kitchen_status` = 1")->row();
        return $result;
    }

    public function get_all_branch_list_except_selected_branch_id($id,$condition,$factoryStatus,$hotKitchenStatus)
    {
        $result = $this->db->query("SELECT * FROM branch_info WHERE id <> $id AND (factory_status = $factoryStatus $condition hot_kitchen_status = $hotKitchenStatus)")->result();
        return $result;
    }

    public function get_assigned_branch_list($id = "")
    {
        if ($id == "") {
            $result = $this->db->query("
                SELECT `branch_one`.*
                FROM `branch_info` AS `branch_one`
                LEFT JOIN `branch_info` AS `branch_two` ON FIND_IN_SET (`branch_one`.`id`,`branch_two`.`assigned_branches`) 
                WHERE `branch_two`.`assigned_branches` IS NULL AND `branch_one`.`hot_kitchen_status` <> 1
            ")->result();
        }
        else {
            $result = $this->db->query("
                SELECT `branch_one`.*
                FROM `branch_info` AS `branch_one`
                LEFT JOIN `branch_info` AS `branch_two` ON FIND_IN_SET (`branch_one`.`id`,`branch_two`.`assigned_branches`) AND `branch_two`.`id` <> $id
                WHERE `branch_two`.`assigned_branches` IS NULL AND `branch_one`.`hot_kitchen_status` <> 1 AND `branch_one`.`id` <> $id
            ")->result();
        }

        return $result;
    }

    public function check_hot_kitchen($id)
    {
        $result = $this->db->query("SELECT * FROM `branch_info` WHERE FIND_IN_SET($id,`assigned_branches`)")->row();
        return $result;
    }

    public function get_stock_branch_id($product_id,$branchId)
    {
    	// $result = $this->db->query("
    	// 	SELECT
     //        IF((SELECT `product`.`hot_kitchen_status` FROM `product` WHERE `product`.`id` = $product_id) = 1,
     //        (SELECT `branch_info`.`id` FROM `branch_info` WHERE FIND_IN_SET($branchId,`branch_info`.`assigned_branches`)),
     //        $branchId)
     //        AS `branchId`
     //    ")->row();

        $findHotKitchenProduct = $this->db->query("SELECT `product`.`hot_kitchen_status` FROM `product` WHERE `product`.`id` = $product_id")->row();

        if ($findHotKitchenProduct->hot_kitchen_status == 1) {
            $findAssignedBranch = $this->db->query("SELECT `branch_info`.`id` FROM `branch_info` WHERE FIND_IN_SET($branchId,`branch_info`.`assigned_branches`)")->row();

            if ($findAssignedBranch) {
                $result = $findAssignedBranch->id;
            }
            else {
                $result = $branchId;
            }
        }
        else {
            $result = $branchId;
        }

    	return $result;
    }

    public function save_branch($id = 0)
    {
        $this->load->helper('url');
        $data = array(
            'id' => $this->input->post('id'),
            'branch_name' => $this->input->post('branch_name'),
            'branch_code' => $this->input->post('branch_code'),
            'branch_area' => $this->input->post('branch_area'),
            'manager_id' => $this->input->post('manager_id'),
            'address' => $this->input->post('address'),
            'mobile' => $this->input->post('mobile'),
            'phone' => $this->input->post('phone'),
        );
        if ($id === 0) {
            return $this->db->insert($this->table_name, $data);
        } else {
            $this->db->where('id', $id);
            return $this->db->update($this->table_name, $data);
        }
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete($this->table_name);
    }

    function is_branch_name_exists($branchName,$branchCode,$mobile)
    {
        $result = $this->db->query("SELECT * FROM branch_info WHERE branch_code = '$branchCode' OR branch_name = '$branchName' OR mobile = '$mobile'")->row();
        // return $result = $this->db->get_where($this->table_name, array('branch_name' => $name))->row();

        return $result;
    }

    function get_branch_by_id_for_duplicate_check($name, $id)
    {
        return $result = $this->db->query("SELECT * FROM branch_info WHERE branch_name = '$name' AND id != $id")->row();
    }
    
    public function get_comma_seperated_branch_names($branch_ids = array()) {
        $branch_ids = implode(',', $branch_ids);
        $query_result = $this->db->query("SELECT GROUP_CONCAT(branch_name SEPARATOR ', ') AS branch_names FROM $this->table_name WHERE id IN ($branch_ids)")->row();
        return !empty($query_result->branch_names) ? $query_result->branch_names : '';
    }
}
