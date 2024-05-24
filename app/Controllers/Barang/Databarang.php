<?php

namespace App\Controllers\Barang;

use App\Controllers\BackendController;

use Dompdf\Dompdf;

class Databarang extends BackendController
{

  public function __construct()
  {
    parent::__construct();
    $this->data['page'] = 'barang';
    $this->mainModel = new \App\Models\barang\DataBarangModel();
  }

  public function data_barang()
  {
    return $this->defaultView('barang/data_barang/Databarang', $this->data, 'barang/data_barang/footerDataBarang');
  }

  function add_databarang($id = 0)
  {
    $data = [];

    if ($id != 0) {
      $data['dataBarang'] = $this->mainModel->getCurrentData($id, $this->session->get('idunit'), $this->data['_userData']['roleid']);
      $data['dataSatuan'] = $this->mainModel->getSatuan($id);
      $data['dataGudang'] = $this->mainModel->getGudang($id);
    }

    $this->data['barang'] = $data;
    return $this->defaultView('barang/data_barang/Adddatabarang', $this->data, 'barang/data_barang/footerAddDataBarang');
  }

  public function getAll($idDef = 0)
  {
    $request = \Config\Services::request();
    $where = array();

    if ($idDef == 1) {
      $where['idUnit'] = $this->session->get('idunit');
      $where['r.status'] = 1;
    } else {
      $where['m_barang.status'] = 1;
    }

    $list = $this->mainModel->get_datatables($request, $where, $idDef);
    $datas = [];
    $no = 1;

    foreach ($list as $key => $value) {
      $row = array();
      $row[] = $no++;
      $row[] = $value->idBarang;
      $row[] = $value->idKategoriBarang;
      $row[] = $value->namaKategori;
      $row[] = $value->nama;
      if ($idDef == 1) {
        $row[] = $value->estimasiStok;
      }

      $row[] = $value->satuanTerkecil;
      $row[] = $value->satuanPengadaan;
      $row[] = $value->namaSatuanTerkecil;
      $row[] = $value->namaSatuanPengadaan;
      $row[] = $value->status;
      $datas[] = $row;
    }

    $draw = $request->getPost("draw") == null ? 1 : $request->getPost("draw");
    $output = array(
      "draw" => $draw,
      "recordsTotal" => $this->mainModel->count_all($request, $where, $idDef),
      "recordsFiltered" => $this->mainModel->count_filtered($request, $where, $idDef),
      "data" => $datas,
    );
    return json_encode($output);
  }

  function get_one($id = 0)
  {
    if ($this->request->isAjax()) {
      $data = [];
      $data['dataBarang'] = $this->mainModel->getCurrentData($id, $this->session->get('idunit'), $this->data['_userData']['roleid']);
      $data['dataSatuan'] = $this->mainModel->getSatuan($id);
      $data['dataGudang'] = $this->mainModel->getGudang($id);

      $hasil['success'] = $data != null;
      $hasil['result'] = $data;
      $hasil['dataSatuan'] = $this->mainModel->getSatuan($id);

      return json_encode($hasil);
    }
  }

  function save()
  {
    if ($this->request->isAjax()) {
      $id = $this->request->getPost("id");
      $konten = json_decode($this->request->getPost("konten"));

      $result = array(
        'isSuccess' => true,
        'message' => $id . '00' . $konten->nama . 'Berhasil menambahkan data barang'
      );

      $data = array(
        'idKategoriBarang' => $konten->idKategori,
        'nama' => $konten->nama,
        'satuanTerkecil' => $konten->satuanTerkecil,
        'satuanPengadaan' => $konten->satuanPengadaan,
        'updatedBy' => $this->session->get("id")
      );

      $satuanData = [];
      foreach ($konten->satuanKonversi as $konversi) {
        $sData = array();
        $sData['idSatuanBarang'] = $konversi->idKonversi;
        $sData['idSatuan'] = $konversi->idKonversiSatuan;
        $sData['jumlahKonversi'] = $konversi->jumlah;
        $sData['status'] = 1;
        $sData['createdBy'] = $this->session->get("id");
        $sData['updatedBy'] = $this->session->get("id");
        $satuanData[] = $sData;
      }

      $gudangData = [];
      foreach ($konten->dataGudang as $gudang) {
        $sData = array();
        $sData['idUnit'] = $gudang->unit;
        $sData['stokMinimal'] = $gudang->stokMinimal;
        $sData['satuanRequest'] = $gudang->idSatuanRequest;
        $sData['estimasiStok'] = $gudang->saldoAwal;
        $sData['status'] = 1;
        $sData['history'] = array(
          'idUnit' => $gudang->unit,
          'kodeTransaksi' => 0,
          'jenisTransaksi' => 1,
          'jumlah' => $gudang->saldoAwal,
          'saldo' => $gudang->saldoAwal,
          'valueBarang' => $gudang->hargaAwal
        );
        $gudangData[] = $sData;
      }

      if ($id == null || $id == 0) {
        $data['createdBy'] = $this->session->get("id");
        $this->mainModel->saveData($data, $satuanData, $gudangData); //, $history);
        $result['message'] = "simpan";
      } else {
        $this->mainModel->updateData($id, $data, $satuanData, $gudangData);
        $result['message'] = "update";
      }

      echo json_encode($result);
    }
  }

  function remove_konversiSatuan($id = 0)
  {
    if ($this->request->isAJAX()) {


      $data = ['status' => 0, 'updatedBy' => $this->session->get("id")];
      $hasil['success'] = true;
      $hasil['messages'] = "Berhasil menghapus data";

      $satuanModel = new \App\Models\barang\DetailSatuanBarangModel();
      //if($this->mainModel->db->table('dt_satuanbarang')->update($data, $id) === False){
      if ($satuanModel->update($id, $data) === False) {
        $hasil['success'] = false;
        $hasil['messages'] = "Terjadi kesalahan saat menghapus data";
      }

      print json_encode($hasil);
    }
  }

  function remove_databarang($id = 0)
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

  function remove_gudang($id, $idBarang)
  {
    if ($this->request->isAJAX()) {


      $data = ['status' => 0];
      $hasil['isSuccess'] = true;
      $hasil['messages'] = "Berhasil menghapus gudang";

      $where = array(
        'idUnit' => $id,
        'idBarang' => $idBarang
      );

      //$satuanModel = new \App\Models\barang\DetailSatuanBarangModel();
      if ($this->mainModel->db->table('r_barangunit')->update($data, $where) === False) {
        //if($satuanModel->update($id, $data) === False){
        $hasil['isSuccess'] = false;
        $hasil['messages'] = "Terjadi kesalahan saat menghapus gudang";
      }

      print json_encode($hasil);
    }
  }

  function hitungBarang()
  {
    $id = $this->session->get('idunit');
    $where = ['idUnit' => $id, 'status' => 1];
    $result = $this->mainModel->db->table('r_barangUnit')
      ->SELECT('COUNT(*) jumlah')
      ->WHERE($where)
      ->get()->getResult();
    return json_encode($result);
  }

  // public function stokBarang()
  //   {
  //       $id = $this->request->getVar('id');


  //       date_default_timezone_set('Asia/Jakarta');
  //       $filename = date('y-m-d-H-i-s') . '-Stok Barang Saya';

  //       // instantiate and use the dompdf class
  //       $dompdf = new Dompdf();
  //       // load HTML content 
  //       //$dompdf->loadHtml(view($this->baseView . $this->controllerName . '/printout', $data));

  //       // (optional) setup the paper size and orientation
  //       $dompdf->setPaper('A4', 'potrait');

  //       // render html as PDF
  //       $dompdf->render();

  //       // output the generated pdf
  //       //Ini jika lihat langsung di browser
  //       //Jika download, hapus array attachment
  //       $dompdf->stream($filename, array("Attachment" => false));
  //   }
}
