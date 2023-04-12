<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model
{

    public function detailSales($status)
    {
        $query = $this->db->query("SELECT sale_detail.id AS saleid, sale.date, product_item.name, (SELECT SUM(sale_detail.qty)) AS sold, (SELECT SUM(sale.total_price)) AS total_penjualan
				FROM sale_detail
					INNER JOIN sale ON sale_detail.sale_id = sale.id
					INNER JOIN product_item ON sale_detail.item_id = product_item.id
				GROUP BY sale_detail.item_id
				ORDER BY sold DESC");
		$result = $query->result();
        
        $query2 = $this->db->query("SELECT SUM(stock * unit_price) AS outcome FROM item");
		$result2 = $query2->result();

        if($status == '' || $status == 'bulanan') {
            $query3 = $this->db->query("SELECT sale_detail.id AS saleid, sale.created, sale.date, product_item.name, (SELECT SUM(sale_detail.qty)) AS sold, (SELECT SUM(sale.total_price)) AS total_penjualan
                        FROM sale_detail
                            INNER JOIN sale ON sale_detail.sale_id = sale.id
                            INNER JOIN product_item ON sale_detail.item_id = product_item.id
                        WHERE (DATE_FORMAT(FROM_UNIXTIME(sale.created), '%m')) = MONTH(CURRENT_DATE()) AND (DATE_FORMAT(FROM_UNIXTIME(sale.created), '%Y') = YEAR(CURDATE()))
                        GROUP BY sale_detail.item_id
                        ORDER BY sold DESC");

            // $query4 = $this->db->query("SELECT SUM(CASE WHEN DATE_FORMAT(FROM_UNIXTIME(created), '%m') = MONTH(CURRENT_DATE()) AND (DATE_FORMAT(FROM_UNIXTIME(created), '%Y') = YEAR(CURDATE())) THEN 0 ELSE stock * unit_price END) AS outcome FROM item");
            
            $query5 = $this->db->query("SELECT stock * unit_price AS total_pengeluaran, created FROM item WHERE (DATE_FORMAT(FROM_UNIXTIME(created), '%m')) = MONTH(CURRENT_DATE()) AND (DATE_FORMAT(FROM_UNIXTIME(created), '%Y') = YEAR(CURDATE())) GROUP BY id");
		
        } else if ($status == 'mingguan') {
            $query3 = $this->db->query("SELECT sale_detail.id AS saleid, sale.created, sale.date, product_item.name, (SELECT SUM(sale_detail.qty)) AS sold, (SELECT SUM(sale.total_price)) AS total_penjualan
                        FROM sale_detail
                            INNER JOIN sale ON sale_detail.sale_id = sale.id
                            INNER JOIN product_item ON sale_detail.item_id = product_item.id
                            WHERE (YEARWEEK(DATE_FORMAT(FROM_UNIXTIME(sale.created), '%Y-%m-%d'), 1) >= YEARWEEK(CURDATE(), 1))
                        GROUP BY sale_detail.item_id
                        ORDER BY sold DESC");

            // $query4 = $this->db->query("SELECT SUM(CASE WHEN YEARWEEK(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), 1) >= YEARWEEK(CURDATE(), 1) THEN 0 ELSE stock * unit_price END) AS outcome FROM item");
		
            $query5 = $this->db->query("SELECT stock * unit_price AS total_pengeluaran, created FROM item WHERE (YEARWEEK(DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d'), 1) >= YEARWEEK(CURDATE(), 1)) GROUP BY id");
		
        } else if ($status == 'tahunan') {
            $query3 = $this->db->query("SELECT sale_detail.id AS saleid, sale.created, sale.date, product_item.name, (SELECT SUM(sale_detail.qty)) AS sold, (SELECT SUM(sale.total_price)) AS total_penjualan
                        FROM sale_detail
                            INNER JOIN sale ON sale_detail.sale_id = sale.id
                            INNER JOIN product_item ON sale_detail.item_id = product_item.id
                            WHERE (DATE_FORMAT(FROM_UNIXTIME(sale.created), '%Y') = YEAR(CURDATE()))
                        GROUP BY sale_detail.item_id
                        ORDER BY sold DESC");

            $query5 = $this->db->query("SELECT MONTHNAME(DATE_FORMAT(FROM_UNIXTIME(updated), '%Y-%m-%d')) AS tgl, stock * unit_price AS total_pengeluaran, updated FROM item WHERE (DATE_FORMAT(FROM_UNIXTIME(created), '%Y') = YEAR(CURDATE())) GROUP BY DATE_FORMAT(FROM_UNIXTIME(created), '%Y-%m-%d')");
		
        }

        $result3 = $query3->result();

        $query4 = $this->db->query("SELECT SUM(CASE WHEN (DATE_FORMAT(FROM_UNIXTIME(created), '%Y') = YEAR(CURDATE()) AND DATE_FORMAT(FROM_UNIXTIME(created), '%m') = MONTH(CURRENT_DATE()) ) THEN stock * unit_price ELSE 0 END) AS outcome FROM item");
		$result4 = $query4->result();

		$result5 = $query5->result();

		$total_penjualan = 0;
		$total_item_terjual = 0;
		foreach($result as $value){
			$total_penjualan += (int)$value->total_penjualan;
			$total_item_terjual += (int)$value->sold;
		}

		$total_penjualan_bulan_ini = 0;
		$total_item_terjual_bulan_ini = 0;
		foreach($result3 as $value){
			$total_penjualan_bulan_ini += (int)$value->total_penjualan;
			$total_item_terjual_bulan_ini += (int)$value->sold;
		}
		
		$data['chart'] = $result3;
		$data['chart2'] = $result5;
		$data['total_penjualan'] = indo_currency($total_penjualan);
		$data['total_item_terjual'] = $total_item_terjual;
		$data['total_pengeluaran'] = indo_currency($result2[0]->outcome);
		$data['total_penjualan_bulan_ini'] = indo_currency($total_penjualan_bulan_ini);
		$data['total_item_terjual_bulan_ini'] = $total_item_terjual_bulan_ini;
		$data['total_pengeluaran_bulan_ini'] = indo_currency($result4[0]->outcome);
		$data['title'] 	= 'Dashboard';

        return $data;
    }
}
