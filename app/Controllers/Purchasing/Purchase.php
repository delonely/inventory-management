<?php

namespace App\Controllers\Purchasing;

use App\Controllers\BackendController;

class Purchase extends BackendController
{

    public function __construct()
    {
        parent::__construct();
        $this->data['page'] = 'pembelian';
        $this->mainModel = new \App\Models\Purchasing\PurchaseModel();
        $this->data['limitPajak'] = 2000000;
    }

    public function index()
    {
        return $this->defaultView('purchasing/self_purchase/PurchaseHome', $this->data,'purchasing/self_purchase/footerPurchase');
    }

    public function add_purchase()
    {
        return $this->defaultView('purchasing/self_purchase/PurchaseAdd', $this->data, 'purchasing/self_purchase/footerPurchaseAdd');
    }

    function cari_supplier()
    {
      $msg = [
        'data' => view('pages/purchasing/self_purchase/Carisupplier')
      ];
      echo json_encode($msg);
    }

    function cari_barang()
    {
      $msg = [
        'data' => view('pages/purchasing/self_purchase/Caribarang')
      ];
      echo json_encode($msg);
    }

    function cari_pajak()
    {
      $msg = [
        'data' => view('pages/purchasing/self_purchase/Caripajak')
      ];
      echo json_encode($msg);
    }

    /**Fungsi untuk ajax */
    public function getAll()
    {
      $request = \Config\Services::request();
      /**Konfigurasi untuk datatables */
      $where = array('m.status' => 1, 'd.idUnit'=>$this->session->get('idunit'));
      /**End konfigurasi untuk datatables */
      $list = $this->mainModel->get_datatables($request, $where);
      $datas = [];
      $no = 1;
  
      foreach ($list as $value) {
        $nilaiTotal = $value->priceTotal;
        if($nilaiTotal>=$this->data['limitPajak']){
          $nilaiTotal = ($nilaiTotal * (100+$value->persen))/100;
        }

        $row = array();
        $row[] = $no++;
        $row[] = $value->id;
        $row[] = $value->noNota; 
        $row[] = $value->namaUnit;
        $row[] = $value->namaUser;
        $row[] = $nilaiTotal;
        $row[] = $value->status;
        $row[] = $value->tanggalNota;
        $row[] = $value->createdAt;
        $row[] = $value->createdBy;
        $datas[] = $row;
      }
  
      $draw = $request->getPost("draw") == null ? 1 : $request->getPost("draw");
      $output = array(
        "draw" => $draw,
        "recordsTotal" => $this->mainModel->count_all($request, $where),
        "recordsFiltered" => $this->mainModel->count_filtered($request, $where),
        "data" => $datas,
      );
  
      return json_encode($output);
    }

//->SELECT(["idSelfPurchase id", "noNota", "tanggalNota", "notes catatan", "status", "createdAt", "createdBy"])
    //->select(["dp.idDtSelfPurchase id", "dp.idBarang", "dp.idPajak", "dp.idSatuanBarang", "mb.nama namaBarang", "dp.jumlah", "ms.nama namaSatuan", "dp.pricePerItem", "dp.priceTotal", "dp.discount", "dp.notes catatan", "dp.status"]) 
    public function get_one($id = 0)
    {
      if ($this->request->isAJAX()) {
        $data = [];
        $data['mainData'] = $this->mainModel->getCurrentData($id);
        $data['detailData'] = $this->mainModel->getDetailedData($id);
        $hasil['success'] = $data != null;
        $hasil['result'] = $data;
  
        print json_encode($hasil);
      }
    }

    function save()
    {
      if($this->request->isAjax()){
        $id = $this->request->getPost("id");
        $idSupplier = $this->request->getPost("supplier");
        $noNota = $this->request->getPost("nomorNota");
        $tgNota = $this->request->getPost("tanggalNota");
        $discount = $this->request->getPost("diskon") == null ? $this->request->getPost("diskon") : 0;
        $notes = $this->request->getPost("catatan") == null ? $this->request->getPost("catatan") : '';
        $konten = json_decode($this->request->getPost("konten"));
        $idPajak = $this->request->getPost("idPajak");
        $idSatuanBrg = $this->request->getPost("idSatuanBarang");
  
        $result = array(
          'isSuccess' => true,
          'message' => 'Berhasil menambahkan data pembelian barang'
        );
  
        $data = array('updatedBy' => $this->session->get("id"));
  
        $detailData=[];
        foreach($konten->detailData as $dataBarang){
          //Cek apakah ada data setelah tanggal ini
          $sql = "SELECT * FROM m_stockHistory WHERE idUnit=".$this->session->get('idunit')." AND idBarang=".$dataBarang->idBarang." AND jenisTransaksi=2 AND ignoreFifo=0 AND tanggal>".$tgNota;
          $validasiData = $this->mainModel->db->query($sql)->getResult();
          if(count($validasiData)>0){
            $result = array(
              'isSuccess' => false,
              'message' => 'Tidak dapat menambahkan data karena terdapat barang yang sudah diinput pembeliannya setelah tanggal ini.'
            );  
            return json_encode($result);
          }


          $sData = array();
         // $sData['idDtRequest'] = '0';// $dataBarang->id;
          $sData['idPajak'] = $idPajak;
          $sData['idBarang'] = $dataBarang->idBarang;
          $sData['idSatuanBarang'] = $dataBarang->idSatuanBarang;
          $sData['quantity'] = $dataBarang->jumlah;
          $sData['pricePerItem'] = $dataBarang->hargaSatuan;
          $sData['priceTotal'] = $dataBarang->totalHarga;
          $sData['discount'] =0;// $dataBarang->diskon;
          $sData['notes'] ='';// $dataBarang->catatan;
          $sData['status'] = 1;

          $dataSatuan = $this->mainModel->db->table('dt_satuanBarang')->where(array('idSatuanBarang'=>$dataBarang->idSatuanBarang))->get()->getResult();
          $sql = "SELECT * FROM m_stockHistory rb JOIN (SELECT max(idStockHistory) idStockHistory FROM m_stockHistory rb WHERE idUnit=".$this->session->get('idunit')." AND idBarang=".$dataBarang->idBarang.") a using (idStockHistory)";
          $lastHistory = $this->mainModel->db->query($sql)->getResult();
          //$stokSekarang = $this->mainModel->db->table('r_barangUnit')->where(array('idBarang'=>$dataBarang->idBarang, 'idUnit'=>$this->session->get('idunit')))->get()->getResult();
          
          $jumlah = $dataBarang->jumlah * $dataSatuan[0]->jumlahKonversi;
          $stokAfter = $jumlah + $lastHistory[0]->saldo;
          //$valueAfter = $dataBarang->totalHarga + $lastHistory[0]->valueBarang;
          $sData['history'] = array(
            'idUnit' => $this->session->get('idunit'),
            'idBarang' => $dataBarang->idBarang,
            'tanggal' => $tgNota,
            'kodeTransaksi'=>0,
            'jenisTransaksi'=>2,
            'jumlah'=> $jumlah,
            'saldo'=>$stokAfter, 
            'valueBarang'=>$dataBarang->totalHarga,
            'createdAt' => date('Y-m-d H:i:s')
          );

          $detailData[]=$sData;
        }  
        
        if($id == null || $id == 0){
          $data = array( 
            'idUnitUser' => $this->session->get("unitUser"),
            'noUrut' => 0,
            'idSupplier' => $idSupplier,
            'noNota' => $noNota,
            'tanggalNota' => $tgNota,
            'discount' => $discount,
            'notes' => $notes,
            'keteranganBatal' => '',
            'status' => 1, 
            'createdBy' => $this->session->get("id")
          );
  
          $this->mainModel->saveData($data, $detailData);
          $result['message'] = "simpan";
        }
        else{
          $this->mainModel->updateData($id, $data, $detailData);
          $result['message'] = "update";
        }
  
        echo json_encode($result);
      }
    }

    function remove($id = 0)
    {
        if ($this->request->isAJAX()) {

            $data = ['status' => 0, 'updatedBy' => $this->session->get("id")];
            $hasil['success'] = true;
            $hasil['messages'] = "Berhasil menghapus data";

            

            if ($this->mainModel->update($id, $data) === False) {
                $hasil['success'] = false;
                $hasil['messages'] = "Terjadi kesalahan saat menghapus data";
            } else {
             //update r_barangunit
              $sql = "UPDATE r_barangUnit r, (SELECT * FROM m_stockHistory rb WHERE jenisTransaksi=2 AND kodeTransaksi=".$id.") a set r.estimasiStok = r.estimasiStok-a.jumlah WHERE r.idBarang=a.idBarang AND r.idUnit=a.idUnit ";
              $result = $this->mainModel->db->query($sql);

             //insert into stok history
             $sql = "INSERT INTO m_stockHistory (idUnit, idBarang, kodeTransaksi, jenisTransaksi, jumlah, saldo, valueBarang, keterangan, createdAt, ignoreFifo) SELECT idUnit, idBarang, kodeTransaksi, -2, jumlah*-1, saldo-jumlah, valueBarang*-1, 'Dibatalkan oleh user', NOW(), 1 FROM m_stockHistory rb WHERE jenisTransaksi=2 AND kodeTransaksi=".$id;
             $result = $this->mainModel->db->query($sql);

             //void stok history sebelumnya
             $sql = "UPDATE m_stockHistory SET ignoreFifo=1 WHERE jenisTransaksi=2 AND kodeTransaksi=".$id;
             $result = $this->mainModel->db->query($sql);
              // //Ambil data history berdasarkan kode transaksi
              // $sql = "SELECT * FROM m_stockHistory rb WHERE jenisTransaksi=2 AND kodeTransaksi=".$id;
              // $lastHistory = $this->mainModel->db->query($sql)->getResult();

              // //Dapatkan stok sekarang berdasarkan history transaksi
              // $sql = "SELECT * FROM r_barangUnit rb WHERE idBarang=".$lastHistory[0]->idBarang." AND idUnit=".$lastHistory[0]->idUnit;
              // $dataBarang = $this->mainModel->db->query($sql)->getResult();

              // $sql = "UPDATE r_barangUnit SET estimasiStok = estimasiStok - ".$lastHistory[0]->jumlah. " WHERE idBarang=".$lastHistory[0]->idBarang." AND idUnit=".$lastHistory[0]->idUnit;
              // $result = $this->mainModel->db->query($sql); 

              // $history = array(
              //   'idUnit' => $lastHistory[0]->idUnit,
              //   'idBarang' => $lastHistory[0]->idBarang,
              //   'kodeTransaksi'=>$id,
              //   'jenisTransaksi'=>-2,
              //   'jumlah'=> $lastHistory[0]->jumlah * -1,
              //   'saldo'=> $dataBarang[0]->estimasiStok - $lastHistory[0]->jumlah,
              //   'valueBarang'=>$lastHistory[0]->valueBarang * -1
              // );

              // $this->mainModel->db->table('m_stockhistory')->insert($history);
            }



            print json_encode($hasil);
        }
    }
}
