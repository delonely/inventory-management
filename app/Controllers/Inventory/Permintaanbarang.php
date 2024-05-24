<?php

namespace App\Controllers\Inventory;

use App\Controllers\BackendController;

class Permintaanbarang extends BackendController
{


  public function __construct()
  {
    parent::__construct();
    $this->data['page'] = 'permintaan';
    $this->mainModel = new \App\Models\inventory\PermintaanBarangModel();
  }

  public function permintaan_barang()
  {
    return $this->defaultView('inventory/permintaan_barang/Permintaanbarang', $this->data, 'inventory/permintaan_barang/footerPermintaanBarang');
  }

  public function permintaan_viewreq()
  {
    return $this->defaultView('inventory/permintaan_barang/ViewReq', $this->data, 'inventory/permintaan_barang/footerPermintaanBarang');
  }

  function add_permintaanbarang($id = 0)
  {
    $data = [];
    if ($id != 0) {
      $data['mainData'] = $this->mainModel->getCurrentData($id);
      $data['detailData'] = $this->mainModel->getDetailedData($id);
    }
    $this->data['currentData'] = $data;

    return $this->defaultView('inventory/permintaan_barang/Addpermintaan', $this->data, 'inventory/permintaan_barang/footerAddPermintaan');
  }

  function cari_barang()
  {
    $msg = [
      'data' => view('pages/inventory/permintaan_barang/Caribarang')
    ];
    echo json_encode($msg);
  }


  //   /**Fungsi untuk ajax */
  public function getAll()
  {
    $request = \Config\Services::request();
    /**Konfigurasi untuk datatables */
    $where = array('m_request.status' => 1, 'm_request.idGudang' => $this->session->get('idunit'));
    /**End konfigurasi untuk datatables */
    $list = $this->mainModel->get_datatables($request, $where);
    $datas = [];
    $no = 1;

    foreach ($list as $value) {
      $row = array();
      $row[] = $no++;
      $row[] = $value->idRequest;
      $row[] = $value->tanggalRequest;
      $row[] = $value->nomorRequest;
      $row[] = $value->namaUnit;
      $row[] = $value->namaUser;
      $row[] = $value->status;
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

  function get_one($id = 0)
  {
    if ($this->request->isAJAX()) {

      // $data = $this->mainModel
      //   ->select(['m.idRequest', "CONCAT('REQ/',RIGHT(YEAR(m.createdAt),2),'/',LPAD(MONTH(m.createdAt),2,'0'),'/',LPAD(m.noUrut,4,'0')) nomorRequest", "m.status", "m.createdAt", "m.createdBy"]) 
      //   ->where('m_request.idRequest', $id)->first();

      $data = [];
      $data['mainData'] = $this->mainModel->getCurrentData($id);
      $data['detailData'] = $this->mainModel->getDetailedData($id);

      $hasil['success'] = $data != null;
      $hasil['result'] = $data;

      print json_encode($hasil);
    }
  }

  public function getUnapproved()
  {
    $request = \Config\Services::request();
    /**Konfigurasi untuk datatables */
    $where = array('m_request.status' => 1, 'ma.idApproval IS NULL' => NULL);
    $wheres = array('m_request.status' => 1);
    /**End konfigurasi untuk datatables */
    $list = $this->mainModel->get_datatables($request, $where, 1);
    $datas = [];
    $no = 1;

    foreach ($list as $value) {
      $row = array();
      $row[] = $no++;
      $row[] = $value->idRequest;
      $row[] = $value->urutRequest;
      $row[] = $value->tanggalRequest;
      $row[] = $value->idApproval;
      $row[] = $value->urutApprove;
      $row[] = $value->tanggalApprove;
      $row[] = $value->namaUnit;
      $row[] = $value->namaUser;
      $datas[] = $row;
    }

    $draw = $request->getPost("draw") == null ? 1 : $request->getPost("draw");
    $output = array(
      "draw" => $draw,
      "recordsTotal" => $this->mainModel->count_all($request, $wheres),
      "recordsFiltered" => $this->mainModel->count_filtered($request, $where, 1),
      "data" => $datas,
    );

    return json_encode($output);
  }

  function save()
  {
    if ($this->request->isAjax()) {
      $id = $this->request->getPost("id");
      $konten = json_decode($this->request->getPost("konten"));
      $idGudang = $this->session->get('idunit');
      $tglBon = $this->request->getPost("tanggal");

      $result = array(
        'isSuccess' => true,
        'message' => 'Berhasil menambahkan data barang'
      );

      $data = array(

        'updatedBy' => $this->session->get("id")
      );

      $detailData = [];
      $valueData = [];
      $usedStock = [];

      foreach ($konten->detailData as $dataBarang) {
        //Ambil dari stock history yg id barang dan unitnya sesuai, untuk keperluan ambil value dan unitnya
        $sql = "SELECT * FROM m_stockHistory WHERE idUnit=" . $idGudang . " AND idBarang=" . $dataBarang->idBarang . " AND ignoreFifo=0 AND usedItem<jumlah ORDER BY idStockHistory LIMIT 20";
        $fifoDatas = $this->mainModel->db->query($sql)->getResult();

        // disini untuk keperluan insert ke dt_Request
        $sData = array();
        // $sData['idDtRequest'] = '0';// $dataBarang->id;
        $sData['idBarang'] = $dataBarang->idBarang;
        $sData['idSatuanBarang'] = $dataBarang->idSatuanBarang;
        $sData['jumlah'] = $dataBarang->jumlah;
        $sData['status'] = 1;
       
        $dataSatuan = $this->mainModel->db->table('dt_satuanBarang')->where(array('idSatuanBarang'=>$dataBarang->idSatuanBarang))->get()->getResult();
        //$jumlah = $dataBarang->jumlah * $dataSatuan[0]->jumlahKonversi;
        $jumlahDibutuhkan = $dataBarang->jumlah * $dataSatuan[0]->jumlahKonversi;
        $curIndex = 0;

        $valueData = [];
        while ($jumlahDibutuhkan > 0) {
          $availStock = $fifoDatas[$curIndex]->jumlah - $fifoDatas[$curIndex]->usedItem;
          $jumlahDiproses = $availStock > $jumlahDibutuhkan ? $jumlahDibutuhkan : $availStock;
          $valueSatuan = $fifoDatas[$curIndex]->valueBarang;

          if ($availStock > 0) {
            //foreach ($fifoDatas as $f) {
            //simpan ke array untuk keperluan insert ke dt_request_detail
            $vData = array();
            $vData['idSatuanBarang'] = $dataBarang->idSatuanBarang;
            $vData['jumlah'] = $jumlahDiproses;
            $vData['valueSatuan'] = $valueSatuan;
            $vData['status'] = 1;
            $vData['createdAt'] = date('Y-m-d');
            $vData['createdBy'] = $this->session->get("id");
            $vData['updatedAt'] = date('Y-m-d');
            $vData['updatedBy'] = $this->session->get("id");
            $valueData[] = $vData;

            //update useditem di stockhistory
            $stockData = [];
            $curData = $fifoDatas[$curIndex];
            $stockData['idStockHistory'] = $curData->idStockHistory;
            $stockData['idUnit'] = $curData->idUnit;
            $stockData['idBarang'] = $curData->idBarang;
            $stockData['tanggal'] = $tglBon;
            $stockData['kodeTransaksi'] = 0;
            $stockData['jenisTransaksi'] = 3;
            $stockData['jumlah'] = $jumlahDiproses;
            $stockData['saldo'] = $jumlahDiproses;
            $stockData['valueBarang'] = $curData->valueBarang;
            $stockData['keterangan'] = '';
            $stockData['ignoreFifo'] = 0;
            $stockData['usedItem'] = $curData->usedItem + $jumlahDiproses;
            $stockData['createdAt'] = date('Y-m-d');
            $usedStock[] = $stockData;


            $jumlahDibutuhkan -= $jumlahDiproses;
          }

          $curIndex += 1;
        }
        $sData['valueData'] = $valueData;
        $detailData[] = $sData;
      }
      if ($konten->userRequest == null || $konten->userRequest <= 0) {

        $result = array(
          'isSuccess' => false,
          'message' => 'Klien harus dipilih terlebih dahulu'
        );
      } elseif (count($detailData) <= 0) {
        $result = array(
          'isSuccess' => false,
          'message' => 'Barang harus diisi terlebih dahulu'
        );
      } else {
        if ($id == null || $id == 0) {
          $data = array(
            //'idUnitUser' => $this->session->get("unitUser"),
            'idUnitUser' => $konten->userRequest,
            'idGudang' => $idGudang,
            'tanggal' => $this->request->getPost("tanggal"),
            'noUrut' => 0,
            'keteranganBatal' => '',
            'status' => 1,
            'createdBy' => $this->session->get("id"),
            'updatedBy' => $this->session->get("id")
          );

          $hasilSimpan = $this->mainModel->saveData($data, $detailData, $usedStock);
          $result['isSuccess'] = $hasilSimpan == "";
          $result['message'] = "simpan";
        } else {
          $this->mainModel->updateData($id, $data, $detailData);
          $result['message'] = "update";
        }
      }
      echo json_encode([$hasilSimpan, $data, $detailData, $stockData]);
      //echo json_encode($result);
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
      }

      print json_encode($hasil);
    }
  }

  function hitungPermintaan()
  {
    $id = $this->session->get('idunit');
    $where = ['YEAR(createdAt)' => date('Y'), 'idGudang' => $id, 'status' => 1];
    $result = $this->mainModel->db->table('m_request')
      ->SELECT('COUNT(*) jumlah')
      ->WHERE($where)
      ->get()->getResult();
    return json_encode($result);
  }
}
