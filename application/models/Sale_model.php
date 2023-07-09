<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sale_model extends CI_Model
{

    public function getInvoice()
    {
        $query = $this->db->query("SELECT MAX(MID(invoice,9,4)) AS invoice_no FROM sale WHERE MID(invoice,3,6) = DATE_FORMAT(CURDATE(), '%y%m%d')");
        if($query->num_rows() > 0){
            $row = $query->row();
            $n = ((int)$row->invoice_no) + 1;
            $no = sprintf("%'.04d", $n);
        } else {
            $no = "0001";
        }
        $invoice = "MP".date('ymd').$no;
        return $invoice;
    }

    public function getCart($params = null){
        $this->db->select('cart.*, product_item.barcode, product_item.name as item_name, cart.price as cart_price');
        $this->db->from('cart');
        $this->db->join('product_item', 'cart.item_id = product_item.id');
        if($params != null){
            $this->db->where($params);
        }
        $this->db->where('user_id', $this->session->userdata('user_id'));
        $query = $this->db->get();
        return $query;
    }

    public function addCart($data)
    {
        $query = $this->db->query("SELECT MAX(id) AS cart_no FROM cart");
        if($query->num_rows() > 0){
            $row = $query->row();
            $cart_no = ((int)$row->cart_no) + 1;
        } else {
            $cart_no = "1";
        }

        $params = [
			'id' => $cart_no,
			'item_id' => (int)$data['item_id'],
			'price' => $data['price'],
			'qty' => $data['qty'],
			'total' => ($data['qty'] * $data['price']),
			'user_id' => $this->session->userdata('user_id'),
			'created' => time()
		];

        $aksi = $this->db->insert('cart', $params); 
        if ($aksi) {
			echo 1;
		} else {
			echo 0;
		}
    }

    public function deleteCart($id)
    {
		$aksi = $this->db->where('id', $id)->delete('cart');
		if ($aksi) {
			echo 1;
		} else {
			echo 0;
		}
    }

    public function deleteCartbyUser()
    {
		$aksi = $this->db->where('user_id', $this->session->userdata('user_id'))->delete('cart');
		if ($aksi) {
			return 1;
		} else {
			return 0;
		}
    }

    function updateCartQty($data){
        $sql = "UPDATE cart SET price = '$data[price]', qty = qty + '$data[qty]', total = '$data[price]' * qty WHERE item_id = '$data[item_id]'";
        $aksi = $this->db->query($sql);
        if ($aksi) {
			echo 1;
		} else {
			echo 0;
		}
    }

    public function updatecart($data)
	{
        $id = $data['id'];
        $qty = $data['qty'];
        $total = $data['total'];
        $discount = $data['discount'];
        $updated = $data['updated'];

        $sql = "UPDATE cart SET qty = '$qty', discount_item = '$discount', total = '$total', updated = '$updated' WHERE id = '$id'";

        $aksi = $this->db->query($sql);

		if ($aksi) {
			echo 1;
		} else {
			echo 0;
		}
	
	}

    public function add_sale($data)
    {
        $params = array(
            'invoice' => $this->getInvoice(),
            'total_price' => $data['grandtotal'],
            'discount' => $data['discount'],
            'final_price' => ((int)$data['grandtotal'] - (int)$data['discount']),
            'cash' => $data['cash'],
            'remaining' => $data['change'],
            'note' => $data['note'],
            'user_id' => $this->session->userdata('user_id'),
            'date' => time(),
            'created' => time(),
        );

        $aksi = $this->db->insert('sale', $params); 
        if ($aksi) {
			return $this->db->insert_id();
		} else {
			echo 0;
		}
    }

    public function add_sale_detail($data)
    {
        $aksi = $this->db->insert_batch('sale_detail', $data);
        if ($aksi) {
			return 1;
		} else {
			return 0;
		}
    }

    // start datatables
    var $column_order = array(null, 'invoice', 'created', 'total_price', 'discount', 'cash'); 
    var $column_search = array('invoice', 'total_price', 'discount', 'cash'); 
    var $order = array('id' => 'asc'); 
 
    private function _get_datatables_query() {
        $this->db->select('sale.*, user.name as user_name, sale.created as sale_created');
        $this->db->from('sale');
        $this->db->join('user', 'sale.user_id = user.id');
        $i = 0;
        foreach ($this->column_search as $item) { 
            if(@$_POST['search']['value']) { 
                if($i===0) { 
                    $this->db->group_start(); 
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if(count($this->column_search) - 1 == $i) 
                    $this->db->group_end(); 
            }
            $i++;
        }
         
        if(isset($_POST['order'])) { 
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }  else if(isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables() {
        $this->_get_datatables_query();
        if(@$_POST['length'] != -1)
        $this->db->limit(@$_POST['length'], @$_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    function count_filtered() {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }
    function count_all() {
        $this->db->from('sale');
        return $this->db->count_all_results();
	}
	// end datatables

    // start datatables
 
    private function _get_datatables_range_date_query($todate, $fromdate) {
        $this->db->select('sale.*, user.name as user_name, sale.created as sale_created');
        $this->db->from('sale');
        $this->db->join('user', 'sale.user_id = user.id');
        $this->db->where('sale.created <=', (int)$todate);
        $this->db->where('sale.created >=', (int)$fromdate);
        $i = 0;
        foreach ($this->column_search as $item) { 
            if(@$_POST['search']['value']) { 
                if($i===0) { 
                    $this->db->group_start(); 
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if(count($this->column_search) - 1 == $i) 
                    $this->db->group_end(); 
            }
            $i++;
        }
         
        if(isset($_POST['order'])) { 
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }  else if(isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
    
    function get_datatables_range_date($todate, $fromdate) {
        $this->_get_datatables_range_date_query($todate, $fromdate);
        if(@$_POST['length'] != -1)
        $this->db->limit(@$_POST['length'], @$_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    function count_filtered_range_date($todate, $fromdate) {
        $this->_get_datatables_range_date_query($todate, $fromdate);
        $query = $this->db->get();
        return $query->num_rows();
    }
    function count_all_range_date() {
        $this->db->from('sale');
        return $this->db->count_all_results();
	}
	// end datatables

    public function getSale($id = null)
    {
        $this->db->select('sale.*, user.name as user_name, sale.created as sale_created');
        $this->db->from('sale');
        $this->db->join('user', 'sale.user_id = user.id');
        if($id != null){
            $this->db->where('sale.id', $id);
        }
        $query = $this->db->get();
        return $query;
    }

    public function get_sale_detail($sale_id = null)
    {
        $this->db->select('sale_detail.*, product_item.name as name');
        $this->db->from('sale_detail');
        $this->db->join('product_item', 'sale_detail.item_id = product_item.id');
        if($sale_id != null){
            $this->db->where('sale_detail.sale_id', $sale_id);
        }
        $query = $this->db->get();
        return $query;
    }


}
