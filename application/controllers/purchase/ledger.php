<?php

class Ledger extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->model('action');
    }

    public function index()
    {
        $this->data['meta_title']   = 'Packaging';
        $this->data['active']       = 'data-target="purchase_menu"';
        $this->data['subMenu']      = 'data-target="ledger"';

        // get all product
        $this->data['productList'] = get_result('materials', ['type' => 'raw', 'status' => 'available', 'trash' => 0], ['code', 'name']);
        
        $this->search();

        $this->load->view($this->data['privilege'] . '/includes/header', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/aside', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/headermenu', $this->data);
        $this->load->view('components/purchase/nav', $this->data);
        $this->load->view('components/purchase/ledger', $this->data);
        $this->load->view($this->data['privilege'] . '/includes/footer', $this->data);
    }
    
    
    private function search()
    {
        $results = [];
        
        $purchaseWhere       = ['sapitems.status' => 'purchase', 'sapitems.trash' => 0];
        $productionWhere     = ['production_items.status' => 'from', 'production_items.trash' => 0];
        $purchaseReturnWhere = ['sapreturn_items.status' => 'purchase_return', 'sapreturn_items.trash' => 0];
        
        $productCode = $this->input->post('product_code');
        $code = $this->input->get('code');
        
        $productCode = (!empty($productCode) ? $productCode : $code);
        
        $dateFrom = '';
        $dateTo = (!empty($_POST['dateTo']) ? $_POST['dateTo'] : date('Y-m-d'));
        if (!empty($productCode)) {
            
            $purchaseWhere["sapitems.product_code"] = $productCode;
            $productionWhere["production_items.product_code"] = $productCode;
            $purchaseReturnWhere["sapreturn_items.product_code"] = $productCode;
            
            
            if(!empty($_POST['dateFrom'])){
                $purchaseWhere["sapitems.sap_at >="] = $dateFrom = $_POST['dateFrom'];
                $productionWhere["production_items.created >="] = $_POST['dateFrom'];
                $purchaseReturnWhere["sapreturn_items.created_at >="] = $_POST['dateFrom'];
            }
            
            
                $purchaseWhere["sapitems.sap_at <="] = $dateTo;
                $productionWhere["production_items.created <="] = $dateTo;
                $purchaseReturnWhere["sapreturn_items.created_at <="] = $dateTo;
            
        
        
            // get previous quantity
            $previousQty = 0;
            if(!empty($dateFrom)){
                
                $pQuantity   = custom_query("SELECT IFNULL(SUM(quantity), 0) AS quantity FROM sapitems WHERE product_code='$productCode' AND status='purchase' AND trash=0 AND sap_at < '$dateFrom'", true)->quantity;
                $prQuantity  = custom_query("SELECT IFNULL(SUM(quantity), 0) AS quantity FROM sapreturn_items WHERE product_code='$productCode' AND status='purchase_return' AND trash=0 AND created_at < '$dateFrom'", true)->quantity;
                $proQuantity = custom_query("SELECT IFNULL(SUM(quantity), 0) AS quantity FROM production_items WHERE product_code='$productCode' AND status='from' AND trash=0 AND created < '$dateFrom'", true)->quantity;
                
                $previousQty = $pQuantity - ($prQuantity + $proQuantity);
            }
            
    
            // purchase info
            $purchaseInfo = get_left_join('sapitems', 'materials', 'sapitems.product_code=materials.code', $purchaseWhere, ['sapitems.*', 'materials.name']);
            if(!empty($purchaseInfo)){
                $itemList = [];
                foreach($purchaseInfo as $row){
                    $item = [];
                    
                    $item['date']            = $row->sap_at;
                    $item['voucher_no']      = $row->voucher_no;
                    $item['code']            = $row->product_code;
                    $item['name']            = $row->name;
                    $item['quantity']        = $row->quantity;
                    $item['purchase_price']  = $row->purchase_price;
                    $item['purchase_amount'] = ($row->purchase_price * $row->quantity);
                    
                    array_push($itemList, (object)$item);
                }
                
                if(!empty($itemList)){
                    array_push($results, (object)['title' => 'Purchase Info', 'type' => 'purchase', 'data' => $itemList]);
                }
            }
            
            
            // purchase return info
            $purchaseReturnInfo = get_left_join('sapreturn_items', 'materials', 'sapreturn_items.product_code=materials.code', $purchaseReturnWhere, ['sapreturn_items.*', 'materials.name']);
            if(!empty($purchaseReturnInfo)){
                $itemList = [];
                foreach($purchaseReturnInfo as $row){
                    $item = [];
                    
                    $item['date']            = $row->created_at;
                    $item['voucher_no']      = $row->voucher_no;
                    $item['code']            = $row->product_code;
                    $item['name']            = $row->name;
                    $item['quantity']        = $row->quantity;
                    $item['purchase_price']  = $row->purchase_price;
                    $item['purchase_amount'] = ($row->purchase_price * $row->quantity);
                    
                    array_push($itemList, (object)$item);
                }
                
                if(!empty($itemList)){
                    array_push($results, (object)['title' => 'Purchase Return Info', 'type' => 'purchase_return', 'data' => $itemList]);
                }
            }
            
            
            // production info
            $productionInfo = get_left_join('production_items', 'materials', 'production_items.product_code=materials.code', $productionWhere, ['production_items.*', 'materials.name']);
            if(!empty($productionInfo)){
                $itemList = [];
                foreach($productionInfo as $row){
                    $item = [];
                    
                    $item['date']            = $row->created;
                    $item['voucher_no']      = $row->voucher_no;
                    $item['code']            = $row->product_code;
                    $item['name']            = $row->name;
                    $item['quantity']        = $row->quantity;
                    $item['purchase_price']  = $row->purchase_price;
                    $item['purchase_amount'] = ($row->purchase_price * $row->quantity);
                    
                    array_push($itemList, (object)$item);
                }
                
                if(!empty($itemList)){
                    array_push($results, (object)['title' => 'Production  Info', 'type' => 'production', 'data' => $itemList]);
                }
            }
            
            $this->data['previousQty'] = $previousQty;
            $this->data['results']     = $results;
            $this->data['productInfo'] = get_row('stock', ['code' => $productCode]);
        }
    }

}
