<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sale_product extends CI_Controller {

    public function __construct() {
        parent:: __construct();
        $this->load->library('form_validation');
        $this->load->library('cart');
        $this->load->helper('settings_helper');
        $this->load->model('Company_Model');
        $this->load->model('Currency_settings_Model');
        $this->load->model('User_Model');
        $this->load->model('Product_Model');
        $this->load->model('Product_type_Model');
        $this->load->model('Client_Model');
        $this->load->model('Branch_Model');
        $this->load->model('Sale_product_Model');
        $this->load->model('Invoice_details_Model');
        $this->load->model('Challan_details_Model');
        $this->load->model('Gate_pass_details_Model');
        $this->load->model('Challan_product_Model');
        $this->load->model('Branchwise_product_store_Model');
        $this->load->model('Product_store_Model');
        $this->load->model('Payment_Model');
        $this->load->model('Client_sales_details_Model');
        $this->load->model('Client_transaction_details_Model');
        $this->load->model('Branch_stock_Model');
        $this->load->model('Request_for_discount_model');
        $this->load->model('Table_model');
    }

    public function index() {
        // echo $saleType; exit();
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('sales_access')) == TRUE))
        {
            $user_info = $this->session->userdata('user_session');
            // echo "<pre>"; print_r($user_info); exit();
            // echo "<pre>"; print_r($this->session->userdata()); exit();

            $saleType = "";

            if (!empty($this->session->userdata('saleType'))) {
                $saleType = $this->session->userdata('saleType');
            }

            if (!empty($this->session->userdata('sessionOutletId'))) {
                $sessionBranchInfo = $this->Branch_Model->get_branch($this->session->userdata('sessionOutletId'));
            }
            // echo "<pre>"; print_r($sessionBranchInfo); exit();

            if ($saleType == "factory_sale") {
                $this->data['title'] = "Factory Sale";
                // $status = 1;
                $customerType = "Factory";
                $factoryStatus = 1;
                $hotKitchenStatus = 0;
                if (!empty($sessionBranchInfo) && $sessionBranchInfo->factory_status != 1) {
                    $this->session->unset_userdata('sessionOutletId');
                    $this->session->unset_userdata('sessionOutletName');
                    $this->session->unset_userdata('sessionOutletBusinessType');
                    $this->destroySessionProductInfo(false);
                }
            }
            else{
                $this->data['title'] = "Outlet Sale";
                // $status = 0;
                $customerType = "Outlet";
                $factoryStatus = 0;
                $hotKitchenStatus = 0;
                if (!empty($sessionBranchInfo) && $sessionBranchInfo->factory_status == 1) {
                    $this->session->unset_userdata('sessionOutletId');
                    $this->session->unset_userdata('sessionOutletName');
                    $this->session->unset_userdata('sessionOutletBusinessType');
                    $this->destroySessionProductInfo(false);
                }
            }

            // $allOutlet = $this->Branch_Model->get_only_all_branch_by_id($user_info['outlet'],$status);
            $allOutlet = $this->Branch_Model->get_any_type_branch_by_id($user_info['outlet'],'AND',$factoryStatus,$hotKitchenStatus);
            // echo "<pre>"; print_r($status); exit();
            $this->data['saleType'] = $saleType;
            $this->data['userInfo'] = $user_info;
            $this->data['allOutlet'] = "";

            if (!empty($allOutlet)) {
                if (count($allOutlet) > 1) {
                    $this->data['allOutlet'] = $allOutlet;
                } else {
                    $singleOutlect = $allOutlet[0];                
                    $this->data['singleOutlect'] = $singleOutlect;
                    // echo "<pre>"; print_r($singleOutlect); exit();
                    $this->session->set_userdata('sessionOutletId',$singleOutlect->id);
                    $this->session->set_userdata('sessionOutletName',$singleOutlect->branch_name);
                    $this->session->set_userdata('sessionOutletBusinessType',$singleOutlect->business_type);

                    if (empty($this->session->userdata('invoiceId')) && empty($this->session->userdata('invoiceNumber'))) {
                        $this->getTokenNumber(false);
                    }
                }
            }

            $product_type_list = $this->Product_type_Model->get_product_type();
            $product_list = $this->Product_Model->get_product();
            $client_list = $this->Client_Model->get_any_type_client($customerType);
            $branch_list = $this->Branch_Model->get_branch();
            $product_total_price_session = $this->session->userdata('product_total_price');
            
            $sessionOutletId = $this->session->userdata('sessionOutletId');
            // echo "<pre>"; print_r($sessionOutletId); exit();
            $pendingOrderList = array();
            if ($sessionOutletId) {
                $pendingOrderList = $this->Invoice_details_Model->get_pending_order_list_by_branch_id($sessionOutletId);
            }
            // echo "<pre>"; print_r($pendingOrderList); exit();

            $this->data['invoice_number'] = $this->get_invoice_number();
            $this->data['challan_number'] = $this->get_challan_number();
            $this->data['product_total_price_session'] = $product_total_price_session;
            $this->data['product_type_list'] = $product_type_list;
            $this->data['product_list'] = $product_list;
            $this->data['pendingOrderList'] = $pendingOrderList;
            $this->data['client_list'] = $client_list;
            $this->data['branch_list'] = $branch_list;
            $this->data['company_info'] =  $this->Company_Model->get_company();;
            $this->data['currency_settings'] = $this->Currency_settings_Model->get_currency_settings();
            $this->data['business_type'] = $this->session->userdata('sessionOutletBusinessType');
            $this->load->view('header');
            $this->load->view('navigation');
            $this->load->view('sale/sale_product', $this->data);
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function outlet_sale() {
        if (get_user_permission('sale_product/outlet_sale') === false) {
            redirect(base_url('user_login'));
        }
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('sales_access')) == TRUE))
        {
            $this->session->set_userdata('saleType','outlet_sale');
            redirect(base_url('sale_product'));
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function factory_sale()
    {
        if (get_menu_permission('factory_access') == false)
        {
            return redirect(base_url('user_login'));
        }

        if (get_user_permission('sale_product/factory_sale') === false) {
            redirect(base_url('user_login'));
        }

        $this->session->set_userdata('saleType','factory_sale');
        redirect(base_url('sale_product'));
    }

    public function getTokenNumber($ajaxData = true)
    {
        if ($this->session->userdata('sessionOutletId')) {
            $outletId = $this->session->userdata('sessionOutletId');
        } else {
            $outletId = 0;
        }

        // echo $outletId; exit();

        $dateTimeNow = new DateTime('now', new DateTimezone('Asia/Dhaka'));
        $currentDateTime = $dateTimeNow->format("Y-m-d");
        $tokenNumberPrefix = "TN-".date('ymd')."-";

        $tokenNumberResult = $this->Invoice_details_Model->getMaxTokenNumber($currentDateTime,$outletId);

        if ($tokenNumberResult)
        {
            $maxTokenNumber = $tokenNumberResult->maxTokenNumber;

            $maxInvoiceDetailsId = substr($maxTokenNumber, strlen($tokenNumberPrefix));
            $tokenNumber = $tokenNumberPrefix.str_pad($maxTokenNumber + 1, 5, '0', STR_PAD_LEFT);
        }
        else
        {
            $tokenNumber = $tokenNumberPrefix."00001";
        }

        $tokenNumberForShow = str_replace("-".date('ymd'), "", $tokenNumber);

        $this->session->set_userdata('tokenNumber',$tokenNumber);
        $this->session->set_userdata('tokenNumberForShow',$tokenNumberForShow);

        if ($ajaxData == true) {
            $this->output->set_content_type('application/json')->set_output(json_encode(array(
                'tokenNumber' => $this->session->userdata('tokenNumber'),
                'tokenNumberForShow' => $this->session->userdata('tokenNumberForShow'),
            )));
        }
    }

    public function get_product_by_product_type()
    {
        $products = $this->Product_Model->get_product_by_product_type($this->input->post('productTypeId'));
        $this->data['company_info'] = $this->Company_Model->get_company();
        $this->data['products'] = $products;

        $output = $this->load->view('sale/product_by_product_type',$this->data,true);

        $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'products' => $products,
            'output' => $output
        )));
    }

    public function get_product_info_by_id()
    {
        $productInfo = $this->Product_Model->get_product_info_by_id($this->input->post('productId'));

        // echo "<pre>"; print_r($productInfo);

        $data = array(
            'id' => $productInfo->id,
            'qty'     => '1',
            'guest_qty'     => '1',
            'price'   => $productInfo->fixed_price,
            'name'    => $productInfo->product_name,
            'product_code' => $productInfo->product_code,
            'vat_rate' => $productInfo->vat_rate,
            'discount' => 0,
            'guest_discount' => 0,
            'discountAmount' => 0,
            'itemNote' => '',
            'bill_type' => ''
        );

        $this->cart->insert($data);
        $output = $this->load->view('sale/product_info_table','',true);
        echo $output;
    }

    public function get_table_info()
    {
        $outletId = $this->input->post('outletId');
        $this->data['table_list'] = $this->Table_model->get_all_by_branch_id($outletId);
        // echo "<pre>"; print_r($table_list);
        $output = $this->load->view('sale/show_lobby_info',$this->data,true);

        $this->output->set_content_type('application/json')->set_output(json_encode(array('output' => $output)));
    }

    public function set_table_info()
    {
        $table_id = $this->input->post('tableId');
        $table_info = $this->Table_model->get_table_by_id($table_id);
        $tableId = $table_info->id;
        $tableNumber = $table_info->table_number;

        $pendingOrderStatus = $this->session->userdata('pendingOrderStatus');
        $this->session->set_userdata('pendingOrderStatus','no');

        $this->session->set_userdata('tableId',$tableId);
        $this->session->set_userdata('tableNumber',$tableNumber);

        $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'tableId' => $tableId,
            'tableNumber' => $tableNumber,
            'pendingOrderStatus' => $pendingOrderStatus,
            'pendingOrderStatusInput' => $this->session->userdata('pendingOrderStatus'),
        )));
    }

    public function get_order_info()
    {
        $this->cart->destroy();
        $this->session->unset_userdata('tokenNumber');
        $this->session->unset_userdata('tokenNumberForShow');
        $this->session->unset_userdata('invoiceId');
        $this->session->unset_userdata('invoiceNumber');
        $this->session->unset_userdata('clientId');
        $this->session->unset_userdata('discountOption');
        $this->session->unset_userdata('overallDiscount');
        $this->session->unset_userdata('tableId');
        $this->session->unset_userdata('tableNumber');

        $invoiceId = $this->input->post('pendingOrderId');
        $tableId = $this->input->post('tableId');
        $totalQty = 0;

        $this->session->set_userdata('pendingOrderStatus','yes');

        $invoiceDetailsInfo = $this->Invoice_details_Model->get_only_invoice_details_by_id($invoiceId,$tableId);
        $saleProductInfo = $this->Sale_product_Model->getSaleProductInformationByInvoiceId($invoiceDetailsInfo->id);
        if ($invoiceDetailsInfo->table_id) {
            $tableInfo = $this->Table_model->get_table_by_id($invoiceDetailsInfo->table_id);
        }
        // echo "<pre>"; print_r($invoiceDetailsInfo); exit();

        $invoiceNumber = $invoiceDetailsInfo->invoice_number;
        $invoiceId = $invoiceDetailsInfo->id;
        $tableId = $invoiceDetailsInfo->table_id;
        $tableNumber = empty($tableInfo) ? '' : $tableInfo->table_number;
        $tokenNumber = $invoiceDetailsInfo->token_number;
        $orderDate = date_format(date_create($invoiceDetailsInfo->order_date),"ymd");
        $tokenNumberForShow = str_replace("-".$orderDate, "", $tokenNumber);
        $discountOption = $invoiceDetailsInfo->deduction_type;
        $orderNote = $invoiceDetailsInfo->order_note;
        if ($discountOption == 'fixed') {
            $overallDiscount = $invoiceDetailsInfo->deduction;
        }
        else {
            $overallDiscount = $invoiceDetailsInfo->deduction_rate;
        }
        // echo "<pre>"; print_r($invoiceDetailsInfo); exit();

        foreach ($saleProductInfo as $saleProduct) {
            $totalQty = $totalQty + $saleProduct->quantity;
            $data = array(
                'id' => $saleProduct->product_id,
                'qty' => $saleProduct->quantity,
                'guest_qty' => $saleProduct->quantity,
                'price' => $saleProduct->unit_price,
                'name' => $saleProduct->productName,
                'product_code' => $saleProduct->productCode,
                'vat_rate' => $saleProduct->productVatRate,
                'discount' => $saleProduct->discount_rate,
                'guest_discount' => $saleProduct->discount_rate,
                'discountAmount' => $saleProduct->discount_amount,
                'itemNote' => $saleProduct->item_note,
                'bill_type' => 'Guest Bill'
            );

            $this->cart->insert($data);
        }

        // echo "<pre>"; print_r($this->cart->contents()); exit();

        $productInfoTable = $this->load->view('sale/product_info_table','',true);

        $this->session->set_userdata('invoiceId',$invoiceId);
        $this->session->set_userdata('invoiceNumber',$invoiceNumber);
        $this->session->set_userdata('tokenNumber',$tokenNumber);
        $this->session->set_userdata('tokenNumberForShow',$tokenNumberForShow);
        $this->session->set_userdata('clientId',$invoiceDetailsInfo->client_id);
        $this->session->set_userdata('discountOption',$discountOption);
        $this->session->set_userdata('overallDiscount',$overallDiscount);
        $this->session->set_userdata('orderNote',$orderNote);
        $this->session->set_userdata('tableId',$tableId);
        $this->session->set_userdata('tableNumber',$tableNumber);
        // echo "<pre>"; print_r($invoiceDetailsInfo); exit();

        if ($this->session->userdata('sessionOutletBusinessType') == 0) {
            $showNumberInfo = $tableNumber;
        }
        else {
            $showNumberInfo = $tokenNumberForShow;
        }

        $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'invoiceDetailsInfo' => $invoiceDetailsInfo,
            'productInfoTable' => $productInfoTable,
            'invoiceId' => $invoiceId,
            'invoiceNumber' => $invoiceNumber,
            'tokenNumber' => $tokenNumber,
            'tokenNumberForShow' => $tokenNumberForShow,
            'discountOption' => $discountOption,
            'overallDiscount' => $overallDiscount,
            'orderNote' => $orderNote,
            'tableId' => $tableId,
            'tableNumber' => $tableNumber,
            'showNumberInfo' => $showNumberInfo,
            'pendingOrderStatus' => $this->session->userdata('pendingOrderStatus')
        )));
    }

    public function showProductInfo()
    {
        $userInfo = $this->session->userdata['user_session'];
        $userType = $userInfo['user_type'];
        $cardContents = $this->cart->contents();
        $totalGuestBill = 0;

        foreach ($cardContents as $content) {
            if ($content['bill_type'] == 'Guest Bill') {
                $totalGuestBill++;
            }
        }

        $output = $this->load->view('sale/product_info_table','',true);
        $sessionOrderNote = $this->session->userdata('orderNote');

        $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'output' => $output,
            'sessionOrderNote' => $sessionOrderNote,
            'totalGuestBill' => $totalGuestBill,
            'userType' => $userType,
        )));
    }

    public function updateSessionProductInfo()
    {
        // echo "<pre>"; print_r($this->input->post()); exit();
        $data = array(
            'rowid' => $this->input->post('cartRowId'),
            'qty' => $this->input->post('qty'),
            'discount' => $this->input->post('discount'),
            'discountAmount' => $this->input->post('discountAmount'),
            'itemNote' => $this->input->post('itemNote'),
        );

        $result = $this->cart->update($data);
        // echo "<pre>"; print_r($this->cart->contents()); exit();

        if ($result === TRUE)
        {
            $message = 'Product Updated Sucessfully.';
        }
        else
        {
            $message = 'Product Update Failed';
        }

        $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'result' => $result,
            'message' => $message,
        )));
    }

    public function removeSessionProductInfo()
    {
        $result = $this->cart->remove($this->input->post('cartRowId'));

        if ($result === TRUE)
        {
            $message = 'Product Remove Sucessfully.';
        }
        else
        {
            $message = 'Product Remove Failed';
        }

        $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'result' => $result,
            'message' => $message,
        )));
    }

    public function destroySessionProductInfo($ajaxData = true)
    {
        $tableId = $this->input->post('tableId');

        if ($tableId) {
            $table_info = $this->Table_model->get_table_by_id($tableId);
            if ($table_info->status == 1) {
                $this->session->unset_userdata('tableId');                
                $this->session->unset_userdata('tableNumber');                
            }
        }

        $this->cart->destroy();
        $this->getTokenNumber(false);
        $this->session->unset_userdata('invoiceId');
        $this->session->unset_userdata('invoiceNumber');
        $this->session->unset_userdata('clientId');
        $this->session->unset_userdata('discountOption');
        $this->session->unset_userdata('overallDiscount');
        $this->session->unset_userdata('orderNote');
        $this->session->set_userdata('pendingOrderStatus','no');

        if ($ajaxData == true) {
            $this->output->set_content_type('application/json')->set_output(json_encode(array(
                'message' => "Session Destroid Successfully",
            )));
        }
    }

    public function setOutletIdInSession()
    {
        $outletId = $this->input->post('outletVal');
        $outletName = $this->input->post('outletName');
        $branchInfo = $this->Branch_Model->get_branch($outletId);

        $this->session->set_userdata('sessionOutletId',$branchInfo->id);
        $this->session->set_userdata('sessionOutletName',$branchInfo->branch_name);
        $this->session->set_userdata('sessionOutletBusinessType',$branchInfo->business_type);
        $this->session->unset_userdata('tableId');
        $this->session->unset_userdata('tableNumber');

        $this->getTokenNumber(false);

        $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'outletId' => $branchInfo->id,
            'outletName' => $branchInfo->branch_name,
            'tokenNumber' => $this->session->userdata('tokenNumber'),
            'tokenNumberForShow' => $this->session->userdata('tokenNumberForShow'),
        )));
    }

    public function save()
    {

        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('sales_access')) == TRUE))
        {
            // echo "<pre>"; print_r($this->input->post()); exit();
            $saleType = $this->session->userdata('saleType');
            $branchId = $this->input->post('outlet');
            $userInfo = $this->session->userdata('user_session');

            $countProduct = count($this->input->post('productId'));
            for ($i=0; $i < $countProduct; $i++) {
                $productId = $this->input->post('productId')[$i];

                $productInfo = $this->Product_Model->getProductById($this->input->post('productId')[$i]);
                $stockProduct = 0;
                if ($saleType == 'outlet_sale') {
                    $stockBranchId = $this->Branch_Model->get_stock_branch_id($productId,$branchId);

                    if ($stockBranchId) {
                        $branchStock = $this->Branch_stock_Model->is_branch_stock_exists($stockBranchId,$this->input->post('productId')[$i]);
                        if ($branchStock) { $stockProduct = $branchStock->stock; }
                    }
                }
                else {
                    if ($productInfo) { $stockProduct = $productInfo->product_stock; }
                }
                // echo "<pre>"; print_r($branchStock); exit();

                // $stockProduct = 100;
                $status = true;
                if ($stockProduct > 0) {
                    if ($this->input->post('qty')[$i] > $stockProduct) {
                        $status = false;
                        $output = $productInfo->product_name." Has Insufficient Quantity. Available Stock is ".$stockProduct;
                        break;
                    }
                }
                else {
                    $status = false;
                    $output = $productInfo->product_name." Has Insufficient Quantity";
                    break;
                }
            }

            if ($status == true) {
                $dateTimeNow = new DateTime('now', new DateTimezone('Asia/Dhaka'));
                $currentDateTime = $dateTimeNow->format("Y-m-d H:i:s");

                $userInfo = $this->session->userdata('user_session');

                $discountOption = $this->input->post('discountOption');
                $overallDiscount = $this->input->post('overallDiscount');
                if ($discountOption == "" && $overallDiscount == 0) {
                    $discountOption = 'fixed';
                }

                if ($discountOption == 'fixed') {
                    $discount_rate = 0;
                } else {
                    $discount_rate = $overallDiscount;
                }

                $mode_of_payment = $this->input->post('paymentType');

                if ($this->input->post('buttonValue') == 'Submit') {
                    $mode_of_payment = 'pending';
                    $cash_payment = 0;
                    $card_payment = 0;
                    $paid_amount = 0;
                    $change_amount = 0;
                    $due_payment = 0;            
                }
                elseif ($mode_of_payment == 'Split') {
                    $cash_payment = $this->input->post('cashPayment');
                    $card_payment = $this->input->post('cardPayment');
                    $paid_amount = 0;
                    $change_amount = 0;
                    $due_payment = 0;
                }
                elseif ($mode_of_payment == 'Cash') {
                    $cash_payment = $this->input->post('totalPayable');
                    $card_payment = 0;
                    $paid_amount = $this->input->post('paidAmount');
                    $change_amount = $this->input->post('changeAmount');
                    $due_payment = 0;
                }
                elseif ($mode_of_payment == 'Due') {
                    $cash_payment = $this->input->post('cashAmount');
                    $card_payment = 0;
                    $paid_amount = 0;
                    $change_amount = 0;
                    $due_payment = $this->input->post('dueAmount');
                }
                else {
                    $cash_payment = 0;
                    $card_payment = $this->input->post('totalPayable');
                    $paid_amount = 0;
                    $change_amount = 0;
                    $due_payment = 0;
                }

                $tokenNumber = $this->input->post('tokenNumber');
                $outletId = $this->input->post('outlet');

                $isTokenNumberExists = $this->Invoice_details_Model->is_token_number_exists($tokenNumber,$outletId);

                $pendingInvoiceId = 0;

                if ($isTokenNumberExists) {
                    $pendingInvoiceId = (int) $this->input->post('invoiceId');
                    $invoiceNumber = $this->input->post('invoiceNumber');
                }
                else {
                    $invoicePrefix = "inv-";

                    $maxInvoiceDetailsId = $this->Invoice_details_Model->getMaxInvoiceDetailsId();
                    $maxId = $maxInvoiceDetailsId->maxId;

                    if ($maxInvoiceDetailsId)
                    {
                        $maxInvoiceDetailsId = substr($maxId, strlen($invoicePrefix));
                        $invoiceNumber = $invoicePrefix.str_pad($maxId + 1, 11, '0', STR_PAD_LEFT);
                    }
                    else
                    {
                        $invoiceNumber = $invoicePrefix."00000000001";
                    }
                }

                $discountValue = 0;

                if ($userInfo->invoice_discount_access > 0) {
                    $discountValue = $this->input->post('discountValue');
                }

                $invoiceDetailsData = array(
                    'client_id' => $this->input->post('customerId'),
                    'branch_id' => $this->input->post('outlet'),
                    'table_id' => $this->input->post('tableId'),
                    'user_id' => $userInfo['user_id'],
                    'invoice_number' => $invoiceNumber,
                    'token_number' => $this->input->post('tokenNumber'),
                    'order_date' => $currentDateTime,
                    'product_total' => $this->input->post('totalItem'),
                    'deduction_type' => $discountOption,
                    'deduction_rate' => $discount_rate,
                    'deduction' => $discountValue,
                    'gross_payable' => $this->input->post('subTotal'),
                    'amount_to_paid' => $this->input->post('totalPayable'),
                    'total_vat' => $this->input->post('totalVat'),
                    'mode_of_payment' => $mode_of_payment,
                    'cash_payment' => $cash_payment,
                    'paid_amount' => $paid_amount,
                    'change_amount' => $change_amount,
                    'card_payment' => $card_payment,
                    'due_payment' => $due_payment,
                    'order_note' => $this->input->post('order_notes'),
                );

                // Insert and Update Data To invoice_details Table Start Here
                if($pendingInvoiceId > 0){
                    unset($invoiceDetailsData['order_date']);

                    $this->db->where('id',$pendingInvoiceId);
                    $this->db->update('invoice_details', $invoiceDetailsData);
                    $lastInsertedInvoiceDetailsId = $pendingInvoiceId;
                }
                else {
                    $this->Invoice_details_Model->db->insert('invoice_details', $invoiceDetailsData);
                    $lastInsertedInvoiceDetailsId = $this->db->insert_id();
                }
                // Insert and Update Data To invoice_details Table End Here

                // Update Status To tables Table Start Here
                $this->session->unset_userdata('tableId');
                $this->session->unset_userdata('tableNumber');
                // Update Status To tables Table End Here

                // Insert Update and Delete Data To sale_product Table Start Here
                if($this->input->post('productId'))
                {
                    if($pendingInvoiceId > 0) {
                        $saleProducts = $this->Sale_product_Model->getSaleProductInformationByInvoiceId($pendingInvoiceId);
                    }

                    $countProduct = count($this->input->post('productId'));
                    for ($i = 0; $i < $countProduct; $i++) {
                        $salesProductData = array(
                            'invoice_id' => $lastInsertedInvoiceDetailsId,
                            'product_id' => $this->input->post('productId')[$i],
                            'quantity' => $this->input->post('qty')[$i],
                            'unit_price' => $this->input->post('price')[$i],
                            'discount_rate' => $this->input->post('discount')[$i],
                            'discount_amount' => $this->input->post('discountAmount')[$i],
                            'sales_price_excluding_vat' => $this->input->post('total')[$i],
                            'vat' => $this->input->post('productTotalVat')[$i],
                            'item_note' => $this->input->post('itemNote')[$i],
                        );                         

                        if($pendingInvoiceId > 0) { 
                            $isExists = false;
                            foreach ($saleProducts as $product) {                         
                                if ($product->product_id == $this->input->post('productId')[$i] && $isExists == false) {
                                    $isExists = true;

                                    $this->db->where('id',$product->id);
                                    $this->db->update('sale_product', $salesProductData);
                                }                          
                            }  
                            if ($isExists == false) {
                                $this->Sale_product_Model->db->insert('sale_product', $salesProductData);
                            }
                        }                            
                        else {
                            $this->Sale_product_Model->db->insert('sale_product', $salesProductData);
                        }

                        // Inventory Update Start Here
                        if ($this->input->post('buttonValue') == 'Complete') {
                            $productId = $this->input->post('productId')[$i];
                            $qty = $this->input->post('qty')[$i];

                            $productIdArray = array('0' => $productId);
                            $quantityArray = array('0' => $qty);

                            if ($saleType == "factory_sale") {
                                $this->Product_store_Model->product_store_save($productIdArray,$quantityArray,date('Y-m-d'),'sale_from_stock');
                                $this->Product_Model->update_product_stock($productId,$qty,'dec');
                            } else {
                                $stockBranchId = $this->Branch_Model->get_stock_branch_id($productId,$branchId);
                                $branchIdArray = array('0' => $stockBranchId);
                                $this->Branchwise_product_store_Model->product_store_save($branchIdArray,$productIdArray,$quantityArray,date('Y-m-d'),'sale_from_stock');
                                $this->Branch_stock_Model->update_branch_stock($stockBranchId,$productId,$qty,'dec');
                            }
                        }
                        // Inventory Update End Here
                    }

                    if($pendingInvoiceId > 0) {
                        foreach ($saleProducts as $product) {
                            $isExists = false;
                            for ($i = 0; $i < $countProduct ; $i++) {
                                if ($product->product_id == $this->input->post('productId')[$i]) {
                                    $isExists = true;
                                }
                            }
                            if ($isExists == false) {
                                $this->db->delete('sale_product', array('id' => $product->id));
                            }
                        }
                    }
                }
                // Insert, Update and Delete Data To sale_product Table End Here

                // Client Info Update Start Here
                if ($this->input->post('buttonValue') == 'Complete') {
                    $clientId = $this->input->post('customerId');
                    $amountToPaid = $this->input->post('totalPayable');
                    $totalPayment = $cash_payment + $card_payment;

                    if ($saleType == "factory_sale") {
                        if ($clientId) {
                            if ($totalPayment == 0) {
                                $paymentId = null;
                                $narration = '';
                            }
                            else {
                                $maxMRNumber = $this->Payment_Model->get_last_row_id();
                                $receipt_mr_no = !empty($maxMRNumber->max_receipt_mr_no) ? (((int) $maxMRNumber->max_receipt_mr_no) + 1) : 1000;
                                $data = array(
                                    'receipt_mr_no' => $receipt_mr_no,
                                    'receipt_date' => get_current_date_and_time(),
                                    'client_id' => $clientId,
                                    'amount_received' => (double) $totalPayment,
                                    'payment_type' => $mode_of_payment,
                                    'invoice_number' => $invoiceNumber,
                                );

                                $this->Payment_Model->db->insert('payment', $data);                
                                $paymentId = $this->db->insert_id();
                                $narration = 'MR No(' . $receipt_mr_no . ')';
                            }
                            $this->save_client_transaction_details($clientId,$paymentId,$lastInsertedInvoiceDetailsId,$totalPayment,$amountToPaid,$narration,$mode_of_payment);

                            $this->update_client_balance($clientId,$amountToPaid,$due_payment);
                            $this->client_sales_details_save_or_update($clientId,$amountToPaid,$totalPayment);
                        }
                    }
                }
                // Client Info Update End Here

                $this->cart->destroy();

                if ($this->input->post('buttonValue') == 'Submit') {
                    $output = "Order Submitted Successfully";
                    $status = 1;
                } else {
                    $status = 0;
                    $invoiceDetails = $this->Invoice_details_Model->getInvoiceDetailsById($lastInsertedInvoiceDetailsId);
                    $saleProducts = $this->Sale_product_Model->getSaleProductInformationByInvoiceId($lastInsertedInvoiceDetailsId);

                    $this->data['invoiceDetails'] = $invoiceDetails;
                    $this->data['saleProducts'] = $saleProducts;
                    $output = $this->load->view('sale/final_bill',$this->data,TRUE);
                }

                // Update table Table Status
                if ($this->input->post('tableId')) {
                    $this->db->set('status',$status);
                    $this->db->where('id',$this->input->post('tableId'));
                    $this->db->update('tables');
                }
            }

            $this->output->set_content_type('application/json')->set_output(json_encode(array(
                'output' => $output,
                'status' => $status,
            )));
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function update_client_balance($clientId,$amountToPaid,$dueAmount)
    {
        $clientInfo = $this->Client_Model->get_client($clientId);

        if ($dueAmount > 0) {
            $clientInfo->advance_balance -= $dueAmount;
            if ($clientInfo->advance_balance < 0) {
                $clientInfo->credit_balance += abs($clientInfo->advance_balance);
                $clientInfo->advance_balance = 0;
            }
            else {
                $clientInfo->credit_balance = 0;
            }
        }

        $clientData = array(
            'credit_balance' => $clientInfo->credit_balance,
            'total_sale' => $clientInfo->total_sale + $amountToPaid,
            'advance_balance' => $clientInfo->advance_balance,
        );

        $this->db->where('id',$clientId);
        $this->db->update('client_info', $clientData);
    }

    public function client_sales_details_save_or_update($clientId,$amountToPaid,$totalPayment)
    {
        $clientInfo = $this->Client_Model->get_client($clientId);
        $current_date = get_current_date();
        $currentSalesDetails = $this->Client_sales_details_Model->get_client_sales_details_by_date($clientId, $current_date);
        
        if ($currentSalesDetails) {
            $paymentFromAdvanced = $currentSalesDetails->total_advance_balance - $clientInfo->advance_balance;
            $currentSalesDetails->total_payment_from_advanced += $paymentFromAdvanced;
            $data = array(
                'client_id' => $clientId,
                'sale_date' => get_current_date_and_time(),
                'total_advance_balance' => $clientInfo->advance_balance,
                'total_credit_balance' => $clientInfo->credit_balance,
                'total_payment_from_advanced' => $currentSalesDetails->total_payment_from_advanced,
                'total_payment' => $currentSalesDetails->total_payment + $totalPayment,
                'total_sale' => $currentSalesDetails->total_sale + $amountToPaid,
            );
            $this->db->where('id', $currentSalesDetails->id);
            $this->db->update('client_sales_details', $data);
        }
        else {
            if ($clientInfo->credit_balance == 0) {
                $paymentFromAdvanced = abs($amountToPaid - $totalPayment);
            }
            else {
                $paymentFromAdvanced = abs($amountToPaid - ($clientInfo->credit_balance + $totalPayment));
            }

            $data = array(
                'client_id' => $clientId,
                'sale_date' => get_current_date_and_time(),
                'total_advance_balance' => $clientInfo->advance_balance,
                'total_credit_balance' => $clientInfo->credit_balance,
                'total_payment_from_advanced' => $paymentFromAdvanced,
                'total_payment' => $totalPayment,
                'total_sale' => $amountToPaid,
            );

            $this->db->insert('client_sales_details', $data);
        }
    }

    public function save_client_transaction_details($clientId,$paymentId,$invoiceId,$drAmount,$crAmount,$narration,$paymentType) {
        $user_info = $this->session->userdata('user_session');

        $clientInfo = $this->Client_Model->get_client($clientId);

        if ($clientInfo->advance_balance > 0) {
            $openingBalance = -1 * $clientInfo->advance_balance;
        }
        else {
            $openingBalance = $clientInfo->credit_balance;
        }

        $closingBalance = $openingBalance - $drAmount + $crAmount;

        $data = array(
            'client_id' => $clientId,
            'invoice_payment_id' => $paymentId,
            'invoice_id' => $invoiceId,
            'transaction_date' => get_current_date_and_time(),
            'opening_balance' => $openingBalance,
            'debit_amount' => $drAmount,
            'credit_amount' => $crAmount,
            'closing_balance' => $closingBalance,
            'narration' => $narration,
            'payment_type' => $paymentType,
            'user_id' => $user_info['user_id'],
        );

        $this->db->insert('client_transaction_details', $data);
    }

    public function get_guest_bill($discountValue = 0, $ajaxData = true)
    {
        // echo "<pre>"; print_r($this->input->post()); exit();
        $tokenNumber = $this->session->userdata('tokenNumber');
        $sessionOutletId = $this->session->userdata('sessionOutletId');
        $userInfo = $this->session->userdata('user_session');
        $output = "";

        $is_invoice_exists = $this->Invoice_details_Model->get_invoice_info_by_token_number_and_branch_id($sessionOutletId,$tokenNumber);
        // echo "<pre>"; print_r($is_invoice_exists); exit();

        if ($is_invoice_exists) {
            $tokenNumberForShow = $this->session->userdata('tokenNumberForShow');
            $dateTimeNow = new DateTime('now', new DateTimezone('Asia/Dhaka'));
            $currentDateTime = $dateTimeNow->format("Y-m-d H:i:s");
            $sessionOrderNote = $this->session->userdata('orderNote');
            $outletInfo = $this->Branch_Model->get_branch($sessionOutletId);
            $cartContents = $this->cart->contents();

            foreach ($cartContents as $content) {
                $data = array(
                    'rowid' => $content['rowid'],
                    'bill_type' => 'Guest Bill',
                    'guest_qty' => $content['qty'],
                    'guest_discount' => $content['discount'],
                );
                $this->cart->update($data);
            }

            $cartContents = $this->cart->contents();
            // echo "<pre>"; print_r($cartContents); exit();

            $this->data['tokenNumberForShow'] = $tokenNumberForShow;
            $this->data['orderAndPrintTime'] = $currentDateTime;
            $this->data['outletInfo'] = $outletInfo;
            $this->data['cartContents'] = $cartContents;
            if (empty($sessionOrderNote)) {
                $sessionOrderNote = $this->input->post('orderNote');
            }
            $this->data['sessionOrderNote'] = $sessionOrderNote;
            if ($discountValue == 0) {
                $this->data['discountValue'] = $this->input->post('discountValue');
            } else {
                $this->data['discountValue'] = $discountValue;
            }

            if ($userInfo->invoice_discount_access > 0) {
                $this->data['discountValue'] = 0;
            }

            $output = $this->load->view('sale/guest_bill',$this->data,TRUE);
        }

        if ($ajaxData == true) {      
            $this->output->set_content_type('application/json')->set_output(json_encode(array(
                'output' => $output,
            )));
        } else {
            return $output;
        }  
    }

    public function get_client_info_by_id()
    {
        $customerInfo = $this->Client_Model->get_client_info_by_id($this->input->post('customerId'));
        $this->data['customerInfo'] = $customerInfo;

        $output = $this->load->view('sale/client_info_table',$this->data,true);

        $this->output->set_content_type('application/json')->set_output(json_encode(array(
            // 'customerInfo' => $customerInfo
            'output' => $output
        )));
    }

    public function get_discount_info_by_token_key()
    {
        // echo "<pre>"; print_r($this->input->post()); exit();
        $discount_id = $this->input->post('discount_id');

        $discountInfo = $this->Request_for_discount_model->get_discount_info_by_id($discount_id);

        $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'discountInfo' => $discountInfo
        )));
    }

    public function is_exits_discount_info()
    {
        // echo "<pre>"; print_r($this->input->post()); exit();
        $token_number = $this->input->post('tokenNumber');
        $branch_id = $this->input->post('branchId');
        $isExists = $this->Request_for_discount_model->is_exists_request($token_number,$branch_id);

        $this->output->set_content_type('application/json')->set_output(json_encode(array(
            'isExists' => $isExists,
        )));
    }

    public function get_invoice_number() {
        $last_invoice_details_invoice_number = $this->Invoice_details_Model->get_last_invoice_details_invoice_number();
        $invoice_number = !empty($last_invoice_details_invoice_number->max_invoice_number) ? (((int) $last_invoice_details_invoice_number->max_invoice_number) + 1) : 1000;
        return $invoice_number;
    }

    public function get_challan_number() {
        $last_invoice_details_challan_number = $this->Invoice_details_Model->get_last_invoice_details_challan_number();
        $challan_number = !empty($last_invoice_details_challan_number->max_challan_number) ? (((int) $last_invoice_details_challan_number->max_challan_number) + 1) : 1000;
        return $challan_number;
    }

    public function get_product_session_total_price() {
        $product_total_price = 0;
        $products = $this->session->userdata('products');
        if (!empty($products)) {
            foreach ($products as $product) {
                $product_total_price += (double) $product['price'];
            }
        }
        $this->session->set_userdata('product_total_price', $product_total_price);
        return $product_total_price_session = $this->session->userdata('product_total_price');
    }

    public function get_data_in_table() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('sales_access')) == TRUE)) {
            if ($this->input->is_ajax_request()) {
                $this->data['invoice_number'] = $this->get_invoice_number();
                $this->data['challan_number'] = $this->get_challan_number();
                $product_id = (int) trim($this->input->post('product_id'));
                $quantity = (int) trim($this->input->post('quantity'));
                $unit_price = (double) trim($this->input->post('unit_price'));
                $this->data['product_list'] = $this->Product_Model->get_product();
                $this->data['client_list'] = $this->Client_Model->get_client();
                $this->data['currency_settings'] = $this->Currency_settings_Model->get_currency_settings();
                if (empty($product_id) || empty($quantity)) {
                    echo '<div class="error-message text-align-center">Please select product and input quantity.</div>';
                    $product_total_price_session = $this->get_product_session_total_price();
                    $this->data['product_total_price_session'] = $product_total_price_session;
                    $product_table_data = $this->load->view('sale/product_table', $this->data, TRUE);
                    $sale_details_information_data = $this->load->view('sale/sale_details_information_section', $this->data, TRUE);
                    $this->output
                            ->set_content_type('application/json')
                            ->set_output(json_encode(array(
                                'product_table_data' => $product_table_data,
                                'sale_details_information_data' => $sale_details_information_data,
                                'total_amount_data' => $product_total_price_session,
                    )));
                } else {
                    $products = $this->session->userdata('products');
                    $product_table_array = $products;
                    $product = $this->Product_Model->get_product($product_id);
                    $product_details = array(
                        'array_id' => time(),
                        'product_id' => $product->id,
                        'product_name' => $product->product_name,
                        'quantity' => $quantity,
                        'unit_price' => $unit_price,
                        'price' => (($quantity) * ($unit_price)),
                        'pack_size' => $product->pack_size,
                        'purchase_price' => !empty($product->purchase_price) ? get_floating_point_number($product->purchase_price) : 0,
                    );
                    if (!empty($product_table_array)) {
                        array_push($product_table_array, $product_details);
                    } else {
                        $product_table_array = array();
                        array_push($product_table_array, $product_details);
                    }
                    $this->session->set_userdata('products', $product_table_array);
                    $product_total_price_session = $this->get_product_session_total_price();
                    $this->data['product_total_price_session'] = $product_total_price_session;
                    $product_table_data = $this->load->view('sale/product_table', $this->data, TRUE);
                    $sale_details_information_data = $this->load->view('sale/sale_details_information_section', $this->data, TRUE);
                    $this->output
                            ->set_content_type('application/json')
                            ->set_output(json_encode(array(
                                'product_table_data' => $product_table_data,
                                'sale_details_information_data' => $sale_details_information_data,
                                'total_amount_data' => $product_total_price_session,
                    )));
                }
            } else {
                redirect(base_url());
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    // invoice_details (1st)
    //challan_details (2nd)
    //gate_pass_details (3rd)
    //challan_product (4th)
    //sale_product (5th)

    public function save_sale_details() {
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('sales_access')) == TRUE)) {
            $user_info = $this->session->userdata('user_session');
            $user_id = $user_info['user_id']; // session user id
            $products = $this->session->userdata('products');
            $gate_pass_remarks = trim($this->input->post('gate_pass_remarks'));
            //$pack_size = trim($this->input->post('pack_size'));
            //$delivery_certificate = trim($this->input->post('delivery_certificate'));
            $delivery_certificate = '';

            // invoice_details (1st)
            $invoice_number = trim($this->input->post('invoice_number'));
            $challan_number = trim($this->input->post('challan_number'));
            $invoice_number_exist_result = $this->Invoice_details_Model->is_exist_invoice_number(trim($invoice_number));
            if (!empty($invoice_number_exist_result) == TRUE) {
                $invoice_number = $invoice_number + 1;
            } else {
                $invoice_number = trim($this->input->post('invoice_number'));
            }
            $challan_number_exist_result = $this->Invoice_details_Model->is_exist_challan_number(trim($challan_number));
            if (!empty($challan_number_exist_result) == TRUE) {
                $challan_number = $challan_number + 1;
            } else {
                $challan_number = $this->input->post('challan_number');
            }
            $client_id = (int) trim($this->input->post('client_id'));
            $branch_id = trim($this->input->post('branch_id'));
            $mode_of_payment = trim($this->input->post('mode_of_payment'));
            $branch_information = $this->Branch_Model->get_branch($branch_id);
            $client_information = $this->Client_Model->get_client($client_id);
            $vat_registration_id = trim($this->input->post('vat_registration_id'));
            $date_of_issue = trim($this->input->post('date_of_issue'));
            $product_total_price_session = (double) $this->get_product_session_total_price();
            $delivery_charge = (double) trim($this->input->post('delivery_charge'));
            $others_charge = (double) trim($this->input->post('others_charge'));
            $deduction = (double) trim($this->input->post('deduction'));
            $order_number = trim($this->input->post('order_number'));
            $order_date = trim($this->input->post('order_date'));
            $delivery_address = trim($this->input->post('delivery_address'));
            if ($deduction == '' || $deduction == 0) {
                $deduction_type = '';
            } else {
                $deduction_type = trim($this->input->post('deduction_type'));
            }
            $vat = (double) trim($this->input->post('vat'));
            $client_advance_balance = (double) ($client_information->advance_balance);
            $client_advance_balance = 0;
            $gross_amount = (double) (($product_total_price_session + $delivery_charge + $others_charge + $vat) - ($deduction));
            $gross_payable = (double) ($gross_amount - $client_advance_balance);
            $advance_adjusted = (double) $client_advance_balance;
            $amount_to_paid = (double) $gross_payable;
            if (empty($client_id) || empty($branch_id) || empty($mode_of_payment)) {
                $this->session->set_flashdata('information_save_error_message', 'Client, Mode of Payment and Oulet Required.');
                redirect(base_url('sale_product'));
            }
            if ((empty($products))) { //product table session error check
                $this->session->set_flashdata('product_table_error_message', 'Add Product into the Table.');
                redirect(base_url('sale_product'));
            } else {
                $this->check_insufficient_product_stock($products, $branch_id); // if any any insufficient product found this function will redirect to sale product
                $invoice_details_data = array(
                    'invoice_number' => $invoice_number,
                    'employee_id' => $client_information->employee_id,
                    'dealer_id' => $client_information->dealer_id,
                    'challan_number' => $challan_number,
                    'client_id' => $client_id,
                    'branch_id' => $branch_id,
                    'vat_registration_id' => $vat_registration_id,
                    'date_of_issue' => $date_of_issue,
                    'product_total' => $product_total_price_session,
                    'delivery_charge' => $delivery_charge,
                    'others_charge' => $others_charge,
                    'deduction' => $deduction,
                    'deduction_type' => $deduction_type,
                    'gross_payable' => $gross_payable,
                    'advance_adjusted' => $advance_adjusted,
                    'amount_to_paid' => $amount_to_paid,
                    'mode_of_payment' => $mode_of_payment,
                    'user_id' => $user_id,
                    'order_number' => $order_number,
                    'order_date' => $order_date,
                    'delivery_address' => $delivery_address,
                );
                // invoice_details (1st)
                $this->Invoice_details_Model->db->insert('invoice_details', $invoice_details_data);
                $currently_inserted_invoice_details_id = $this->db->insert_id();
                //challan_details (2nd)
                if ($currently_inserted_invoice_details_id > 0) {
                    $challan_details_data = array(
                        'invoice_id' => $currently_inserted_invoice_details_id,
                        'branch_id' => $branch_id,
                        'delivery_certificate' => $delivery_certificate,
                        'date_of_issue' => $date_of_issue,
                        'user_id' => $user_id,
                    );
                    $this->Challan_details_Model->db->insert('challan_details', $challan_details_data);
                    $currently_inserted_challan_id = $this->db->insert_id();
                    //gate_pass_details (3rd)
                    if ($currently_inserted_challan_id > 0) {

                        $gate_pass_details_data = array(
                            'invoice_id' => $currently_inserted_invoice_details_id,
                            'challan_id' => $currently_inserted_challan_id,
                            'branch_id' => $branch_id,
                            'source' => trim($this->input->post('source')),
                            'date_of_issue' => $date_of_issue,
                            'user_id' => $user_id,
                        );
                        $this->Gate_pass_details_Model->db->insert('gate_pass_details', $gate_pass_details_data);
                        //challan_product (4th)
                        if (!empty($products)) {
                            foreach ($products as $product) {
                                $challan_product_data = array(
                                    'product_id' => $product['product_id'],
                                    'pack_size' => $product['pack_size'],
                                    'quantity' => $product['quantity'],
                                    'unit_price' => $product['unit_price'],
                                    'total_price' => $product_total_price_session,
                                    'challan_id' => $currently_inserted_challan_id,
                                    'branch_id' => $branch_id,
                                );
                                $this->Challan_product_Model->db->insert('challan_product', $challan_product_data);
                            }
                            //sale_product (5th)
                            foreach ($products as $product) {
                                $sale_product_data = array(
                                    'product_id' => $product['product_id'],
                                    'branch_id' => $branch_id,
                                    'pack_size' => $product['pack_size'],
                                    'quantity' => $product['quantity'],
                                    'unit_price' => $product['unit_price'],
                                    'sales_price_excluding_vat' => (($product['unit_price']) * ($product['quantity'])), //$product_total_price_session
                                    'vat' => $vat,
                                    'sales_price_including_vat' => (($product['unit_price']) * ($product['quantity'])), //$product_total_price_session + $vat
                                    'invoice_id' => $currently_inserted_invoice_details_id,
                                    'gate_pass_remarks' => $gate_pass_remarks,
                                    'purchase_price' => $product['purchase_price'],
                                );
                                $this->Sale_product_Model->db->insert('sale_product', $sale_product_data);
                            }
                            //branchwise_product_store_save
                            $this->branchwise_product_store_save($products, $branch_id, $date_of_issue);
                            //product_store_save
                            $this->product_store_save($products, $date_of_issue);
                            //Branch stock update
                            $this->update_branch_stock($products, $branch_id);
                            //product update
                            $this->update_stock_in_product($products);
                        }
                    }
                }
                $currently_inserted_payment_id = 0;
                if ((strtolower($mode_of_payment)) != 'credit') {
                    $this->save_payment_information($order_date, $client_information, $gross_amount, $mode_of_payment, $branch_id, $branch_information, $invoice_number);
                    $currently_inserted_payment_id = $this->db->insert_id();
                }

                $this->client_sales_details_save($client_information, $gross_amount, $mode_of_payment);
                $this->update_client_credit_balance($client_information, $gross_amount, $mode_of_payment);

                $invoice_payment_id = 0;
                if ((strtolower($mode_of_payment)) != 'credit') {
                    $invoice_payment_id = $currently_inserted_payment_id;
                } else {
                    $invoice_payment_id = $currently_inserted_invoice_details_id;
                }
                $narration = '';
                $narration = 'Invoice No(' . $invoice_number . ')';
                $this->client_transaction_details_save($client_information, $invoice_payment_id, $amount_to_paid, $narration, $user_id, $mode_of_payment);
                $this->session->unset_userdata('product_total_price');
                $this->session->unset_userdata('products');
                //sale_product_save_successful_message
                $this->session->set_flashdata('sale_product_save_successful_message', 'Products has been sold Successfully.');
                redirect(base_url('sale_product'));
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function check_insufficient_product_stock($products, $branch_id) { // insufficient stock check using php
        if (!empty($products) && ((int) $branch_id > 0)) {
            $arr = array();
            foreach ($products as $product) {
                $branch_stock_by_product_id_branch_id = $this->Branch_stock_Model->get_branch_stock_by_product_id_branch_id($product['product_id'], $branch_id);
                if (empty($branch_stock_by_product_id_branch_id) || (((int) $branch_stock_by_product_id_branch_id->stock) < (int) $product['quantity'])) {
//                    $this->session->set_flashdata('stock_insufficient_message', $product['product_name'] . ' ' . 'Stock Insufficient');
//                    redirect(base_url('sale_product'));
                    array_push($arr, $product['product_name'] . ' Stock Insufficient' . '<br>');
                }
            }
            if (!empty($arr)) {
                $this->session->set_flashdata('stock_insufficient_message', $arr);
                redirect(base_url('sale_product'));
            }
        }
    }

    public function check_insufficient_stock() { // insufficient stock check using ajax call
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('sales_access')) == TRUE)) {
            if ($this->input->is_ajax_request()) {
                $products = $this->session->userdata('products');
                $branch_id = (int) trim($this->input->post('branch_id'));
                if (!empty($products) && ((int) $branch_id > 0)) {
                    $arr = array();
                    foreach ($products as $product) {
                        $branch_stock_by_product_id_branch_id = $this->Branch_stock_Model->get_branch_stock_by_product_id_branch_id($product['product_id'], $branch_id);
                        if (empty($branch_stock_by_product_id_branch_id) || (((int) $branch_stock_by_product_id_branch_id->stock) < (int) $product['quantity'])) {
                            array_push($arr, $product['product_name'] . ' Stock Insufficient' . '<br>');
                        }
                    }
                    if (!empty($arr)) {
                        $this->output
                                ->set_content_type('application/json')
                                ->set_output(json_encode(array(
                                    'arr' => $arr,
                        )));
                    } else {
                        $this->output
                                ->set_content_type('application/json')
                                ->set_output(json_encode(array(
                                    'arr' => FALSE,
                        )));
                    }
                } else {
                    $this->output
                            ->set_content_type('application/json')
                            ->set_output(json_encode(array(
                                'arr' => FALSE,
                    )));
                }
            } else {
                redirect(base_url('sale_product'));
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function client_transaction_details_save($client_information, $invoice_payment_id, $amount, $narration, $user_id, $mode_of_payment) {
        $client_id = $client_information->id;
        $current_date_time = $this->User_Model->get_current_date_and_time();
        $last_client_transaction_details = $this->Client_transaction_details_Model->get_last_client_transaction_details($client_id);
        if (strtolower($mode_of_payment) == 'credit') {
            $opening_balance = !empty($last_client_transaction_details) ? ($last_client_transaction_details->closing_balance) : 0;
            $debit_amount = 0;
            $credit_amount = (double) $amount;
            $closing_balance = (!empty($last_client_transaction_details) ? ($last_client_transaction_details->closing_balance) : 0) - (double) $amount;
        } else {
            $opening_balance = !empty($last_client_transaction_details) ? ($last_client_transaction_details->closing_balance) : 0;
            $debit_amount = 0;
            $credit_amount = (double) $amount;
            $closing_balance = (!empty($last_client_transaction_details) ? ($last_client_transaction_details->closing_balance) : 0) - (double) $amount;
            $data = array(
                'client_id' => $client_id,
                'invoice_payment_id' => $invoice_payment_id,
                'transaction_date' => $current_date_time,
                'opening_balance' => $opening_balance,
                'debit_amount' => $debit_amount,
                'credit_amount' => $credit_amount,
                'closing_balance' => $closing_balance,
                'narration' => $narration,
                'payment_type' => $mode_of_payment,
                'user_id' => $user_id,
            );
            $this->Client_transaction_details_Model->db->insert('client_transaction_details', $data);

            $last_client_transaction_details = $this->Client_transaction_details_Model->get_last_client_transaction_details($client_id);
            $opening_balance = !empty($last_client_transaction_details) ? ($last_client_transaction_details->closing_balance) : 0;
            $debit_amount = $amount;
            $credit_amount = 0;
            $closing_balance = (!empty($last_client_transaction_details) ? (double) ($last_client_transaction_details->closing_balance) : 0) + (double) $amount;
        }
        $data = array(
            'client_id' => $client_id,
            'invoice_payment_id' => $invoice_payment_id,
            'transaction_date' => $current_date_time,
            'opening_balance' => $opening_balance,
            'debit_amount' => $debit_amount,
            'credit_amount' => $credit_amount,
            'closing_balance' => $closing_balance,
            'narration' => $narration,
            'payment_type' => $mode_of_payment,
            'user_id' => $user_id,
        );
        $this->Client_transaction_details_Model->db->insert('client_transaction_details', $data);
    }

    public function client_sales_details_save($client_information, $amount, $mode_of_payment) {
        $current_date = get_current_date();
        $client_id = $client_information->id;
        $current_client_sales_details_by_date = $this->Client_sales_details_Model->get_client_sales_details_by_date($client_id, $current_date);
        if (empty($current_client_sales_details_by_date)) {
            $data = array(
                'client_id' => $client_id,
                'sale_date' => $current_date,
                'total_credit_balance' => $client_information->credit_balance,
                'total_advance_balance' => $client_information->advance_balance,
                'total_sale' => 0,
                'total_payment' => 0,
            );
            $this->Client_sales_details_Model->db->insert('client_sales_details', $data);
        }
        if (empty($current_client_sales_details_by_date)) {
            $current_client_sales_details_by_date = $this->Client_sales_details_Model->get_client_sales_details_by_date($client_id, $current_date);
        }
        if (!empty($current_client_sales_details_by_date)) {
            $current_payment_amount = (double) $amount;
            $total_sale = $current_payment_amount;
            $credit_balance = 0;
            $client_advance_balance = 0;
            $total_payment = 0;
            if (strtolower($mode_of_payment) === 'credit') {
                $client_previous_advance = (double) $current_client_sales_details_by_date->total_advance_balance; //128960
                $advance_balance = 0;
                if ($client_previous_advance > 0) {
                    $advance_balance = (double) $client_previous_advance - (double) $amount; //128960-126880=2080
                }
                if ($advance_balance < 0) {
                    $credit_balance = abs($advance_balance);
                    $total_payment = $client_previous_advance;
                    $client_advance_balance = 0;
                } else if ($advance_balance > 0) {
                    $credit_balance = 0;
                    $total_payment = $current_payment_amount;
                    $client_advance_balance = abs($advance_balance);
                } else {
                    $credit_balance = $current_payment_amount;
                    $client_advance_balance = 0;
                    $total_payment = 0;
                }
            } else {
                $credit_balance = 0;
                $client_advance_balance = $current_client_sales_details_by_date->total_advance_balance;
                $total_payment = $current_payment_amount;
            }
            $data = array(
                'id' => $current_client_sales_details_by_date->id,
                'client_id' => $client_id,
                'sale_date' => $current_date,
                'total_credit_balance' => (double) $current_client_sales_details_by_date->total_credit_balance + (double) $credit_balance,
                'total_advance_balance' => (double) $client_advance_balance,
                'total_sale' => (double) $current_client_sales_details_by_date->total_sale + (double) $total_sale,
                'total_payment' => (double) $current_client_sales_details_by_date->total_payment + (double) $total_payment
            );
            $this->db->where('id', $data['id']);
            $this->Client_sales_details_Model->db->update('client_sales_details', $data);
        }
    }

    public function update_client_credit_balance($client_information, $amount, $mode_of_payment) {
        $current_amount = (double) $amount;
        $client_previous_credit = (double) $client_information->credit_balance;
        $client_previous_advance = (double) $client_information->advance_balance;
        $client_advance_balance = (double) $client_information->advance_balance;
        $advance_balance = 0;
        $credit_balance = 0;
        if (strtolower($mode_of_payment) == 'credit') {
            if ((double) $client_previous_advance > 0) {
                $advance_balance = $client_previous_advance - $amount;
            }
            if ((double) $advance_balance < 0) {
                $credit_balance = abs($advance_balance);
                $advance_balance = 0;
                $client_advance_balance = 0;
            } else if ((double) $advance_balance > 0) {
                $credit_balance = 0;
                $client_advance_balance = abs($advance_balance);
            } else {
                $credit_balance = 0;
                $client_advance_balance = 0;
            }
            if ((double) $client_previous_credit > 0) {
                $credit_balance = $current_amount;
                $client_advance_balance = 0;
            }
            if ((double) $client_previous_credit == 0 && (double) $client_previous_advance == 0) {
                $credit_balance = $current_amount;
                $client_advance_balance = 0;
            }
        }
        $client_credit_balance = (double) $client_information->credit_balance + (double) $credit_balance;
        $total_sale = (double) $client_information->total_sale + (double) $current_amount;
        $client_information_data = array(
            'id' => $client_information->id,
            'credit_balance' => $client_credit_balance,
            'total_sale' => $total_sale,
            'advance_balance' => $client_advance_balance,
        );
        $this->db->where('id', $client_information_data['id']);
        $this->Client_Model->db->update('client_info', $client_information_data);
    }

    public function save_payment_information($order_date, $client_information, $amount, $mode_of_payment, $branch_id, $branch_information, $invoice_number) {
        $payment_information_data = array(
            'receipt_mr_no' => '',
            'receipt_date' => $order_date,
            'client_id' => ($client_information->id),
            'amount_received' => $amount,
            'client_code' => ($client_information->client_code),
            'payment_type' => $mode_of_payment,
            'cheque_number' => '',
            'cheque_date' => '',
            'bank_id' => '',
            'branch_name' => '',
            'purpose' => '',
            'invoice_number' => $invoice_number,
            'remarks' => '',
        );
        $this->Payment_Model->db->insert('payment', $payment_information_data);
    }

    public function clear_sale_product_table_session() {  // clear assets table
        $this->session->unset_userdata('products');
        $this->session->unset_userdata('product_total_price');
        redirect(base_url('sale_product'));
    }

    public function delete_product_info() { //delete product info from table
        if (!empty($this->session->userdata('user_session')) && (($this->User_Model->get_user_permission('sales_access')) == TRUE)) {
            if ($this->input->is_ajax_request()) {
                $array_id = trim($this->input->post('array_id'));
                $products = $this->session->userdata('products');  // product table list session
                if ((!empty($products))) {
                    $product_array = array();
                    foreach ($products as $product) {
                        if ($array_id != $product['array_id']) {
                            array_push($product_array, $product);
                        }
                    }
                    $this->session->set_userdata('products', $product_array);
                    $product_total_price_session = $this->get_product_session_total_price();
                    $this->data['product_total_price_session'] = $product_total_price_session;
                    $this->data['product_list'] = $this->Product_Model->get_product();
                    $this->data['client_list'] = $this->Client_Model->get_client();
                    $this->data['currency_settings'] = $this->Currency_settings_Model->get_currency_settings();
                    $product_table_data = $this->load->view('sale/product_table', $this->data, TRUE);
                    $sale_details_information_data = $this->load->view('sale/sale_details_information_section', $this->data, TRUE);
                    $this->output
                            ->set_content_type('application/json')
                            ->set_output(json_encode(array(
                                'product_table_data' => $product_table_data,
                                'sale_details_information_data' => $sale_details_information_data,
                                'total_amount_data' => $product_total_price_session,
                    )));
//                redirect(base_url('sale_product'));
                } else {
                    redirect(base_url('sale_product'));
                }
            } else {
                redirect(base_url('sale_product'));
            }
        } else {
            redirect(base_url('user_login'));
        }
    }

    public function update_branch_stock($products, $branch_id) {
        if (!empty($products)) {
            foreach ($products as $product) {
                $product_id = $product['product_id'];
                $branch_stock_by_product_id_branch_id = $this->Branch_stock_Model->get_branch_stock_by_product_id_branch_id($product_id, $branch_id);
                if (!empty($branch_stock_by_product_id_branch_id)) {
                    $branch_stock_data = array(
                        'id' => $branch_stock_by_product_id_branch_id->id,
                        'stock' => (int) $branch_stock_by_product_id_branch_id->stock - (int) $product['quantity'],
                    );
                    $this->db->where('id', $branch_stock_data['id']);
                    $this->Branch_stock_Model->db->update('branch_stock', $branch_stock_data);
                }
            }
        }
    }

    public function branchwise_product_store_save($products, $branch_id, $date_of_issue) {
        foreach ($products as $product) {
            $branchwise_product_store_by_date = $this->Branchwise_product_store_Model->get_branchwise_product_store_by_date($date_of_issue, $product['product_id'], $branch_id);
            if (!empty($branchwise_product_store_by_date)) {
                $open_stock = (int) $branchwise_product_store_by_date->open_stock;
                $receive_stock = (int) $branchwise_product_store_by_date->receive_stock;
                $transfer_stock = (int) $branchwise_product_store_by_date->transfer_stock;
                $sale_from_stock = (int) $branchwise_product_store_by_date->sale_from_stock + (int) $product['quantity'];
                $damage_stock = (int) $branchwise_product_store_by_date->damage_stock;
                $closing_stock = (int) ($open_stock + $receive_stock - $transfer_stock - $sale_from_stock - $damage_stock);
                $branchwise_product_store_data = array(
                    'id' => $branchwise_product_store_by_date->id,
                    'product_store_date' => $date_of_issue,
                    'product_id' => $product['product_id'],
                    'branch_id' => $branch_id,
                    'open_stock' => $open_stock,
                    'receive_stock' => $receive_stock,
                    'transfer_stock' => $transfer_stock,
                    'sale_from_stock' => $sale_from_stock,
                    'damage_stock' => $damage_stock,
                    'closing_stock' => $closing_stock,
                );
                $this->db->where('id', $branchwise_product_store_data['id']);
                $this->Branchwise_product_store_Model->db->update('branchwise_product_store', $branchwise_product_store_data);
            } else {
                $current_date = get_current_date();
                $branchwise_product_store_from_previous_date = $this->Branchwise_product_store_Model->get_branchwise_product_store_from_previous_date_by_product_id_branch_id($current_date, $product['product_id'], $branch_id);
                if (!empty($branchwise_product_store_from_previous_date)) {
                    $open_stock = (int) $branchwise_product_store_from_previous_date->closing_stock;
                } else {
                    $open_stock = 0;
                }
                $receive_stock = 0;
                $transfer_stock = 0;
                $sale_from_stock = (int) $product['quantity'];
                $damage_stock = 0;
                $closing_stock = (int) ($open_stock + $receive_stock - $transfer_stock - $sale_from_stock - $damage_stock);
                $branchwise_product_store_data = array(
                    'product_store_date' => $date_of_issue,
                    'product_id' => $product['product_id'],
                    'branch_id' => $branch_id,
                    'open_stock' => $open_stock,
                    'receive_stock' => $receive_stock,
                    'transfer_stock' => $transfer_stock,
                    'sale_from_stock' => $sale_from_stock,
                    'damage_stock' => $damage_stock,
                    'closing_stock' => $closing_stock,
                );
                $this->Branchwise_product_store_Model->db->insert('branchwise_product_store', $branchwise_product_store_data);
            }
        }
    }

    public function product_store_save($products, $date_of_issue,$type) {
        foreach ($products as $product) {
            $product_store_by_date = $this->Product_store_Model->get_product_store_by_date($product['product_id'], $date_of_issue);
            if (!empty($product_store_by_date)) {
                $open_stock = (int) $product_store_by_date->open_stock;
                if($type=='receive'){
                           $product_store_by_date->receive_stock += (double) $product['quantity'];
                }
                $receive_stock = (int) $product_store_by_date->receive_stock;
                $transfer_stock = (int) $product_store_by_date->transfer_stock;
                $sale_from_stock = (int) $product_store_by_date->sale_from_stock + (int) $product['quantity'];
                $damage_stock = (int) $product_store_by_date->damage_stock;
                $closing_stock = (int) ($open_stock + $receive_stock - $transfer_stock - $sale_from_stock - $damage_stock);
                $product_store_data = array(
                    'id' => $product_store_by_date->id,
                    'product_store_date' => $date_of_issue,
                    'product_id' => $product['product_id'],
                    'open_stock' => $open_stock,
                    'receive_stock' => $receive_stock,
                    'transfer_stock' => $transfer_stock,
                    'sale_from_stock' => $sale_from_stock,
                    'damage_stock' => $damage_stock,
                    'closing_stock' => $closing_stock,
                );
                $this->db->where('id', $product_store_data['id']);
                $this->Product_store_Model->db->update('product_store', $product_store_data);
            } else {
                $current_date = get_current_date();
                $product_store_from_previous_date = $this->Product_store_Model->get_product_store_from_previous_date_by_product_id($current_date, $product['product_id']);

                if (!empty($product_store_from_previous_date)) {
                    $open_stock = (int) $product_store_from_previous_date->closing_stock;
                } else {
                    $open_stock = 0;
                }
                $receive_stock = 0;
                $transfer_stock = 0;
                $sale_from_stock = (int) $product['quantity'];
                $damage_stock = 0;
                $closing_stock = (int) ($open_stock + $receive_stock - $transfer_stock - $sale_from_stock - $damage_stock);
                $product_store_data = array(
                    'product_store_date' => $date_of_issue,
                    'product_id' => $product['product_id'],
                    'open_stock' => $open_stock,
                    'receive_stock' => $receive_stock,
                    'transfer_stock' => $transfer_stock,
                    'sale_from_stock' => $sale_from_stock,
                    'damage_stock' => $damage_stock,
                    'closing_stock' => $closing_stock,
                );
                $this->Product_store_Model->db->insert('product_store', $product_store_data);
            }
        }
    }

    public function update_stock_in_product($products) {
        if (!empty($products)) {
            foreach ($products as $product) {
                $product_information = $this->Product_Model->get_product($product['product_id']);
                if (!empty($product_information)) {
                    $product_data = array(
                        'id' => $product['product_id'],
                        'product_stock' => (int) $product_information->product_stock - (int) $product['quantity'],
                    );
                    $this->db->where('id', $product_data['id']);
                    $this->Product_Model->db->update('product', $product_data);
                }
            }
        }
    }

}
