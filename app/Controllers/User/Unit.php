<?php

namespace App\Controllers\User;

use App\Controllers\BackendController;


class Unit extends BackendController
{


  public function __construct()
  {
    parent::__construct();
    $this->data['page'] = 'unit';
    $this->mainModel = new \App\Models\unit\UnitModel();
  }

  public function data_unit()
  {
    return $this->defaultView('unit/Unit', $this->data, 'unit/footerUnit');
  }

  function add_unit()
  {
    $msg = [
      'data' => view('pages/unit/Addunit')
    ];
    echo json_encode($msg);
  }

  public function add_assign($id = 0)
  {
    $data = $this->mainModel
      ->select('*')
      ->where('idUnit', $id)->first();
    $this->data['dataUnit'] = $data;
    return $this->defaultView('unit/Addassign', $this->data, 'unit/footerAddAssign.php');
  }


  /**Fungsi untuk ajax */
  public function getAll()
  {
    $request = \Config\Services::request();
    /**Konfigurasi untuk datatables */
    $where = array('status' => 1);
    /**End konfigurasi untuk datatables */

    $list = $this->mainModel->get_datatables($request, $where);
    $datas = [];

    $no = 1;

    foreach ($list as $key => $value) {

      $row = array();
      $row[] = $no;
      $row[] = $value->idUnit;
      $row[] = $value->nama;
      $row[] = $value->status;
      $row[] = $value->createdAt;
      $row[] = $value->createdBy;
      // $row[] = $ops;
      $datas[] = $row;
      $no++;
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

  public function getUnits($id = 0)
  {
    if ($this->request->isAjax()) {
      if($id == 0 ) $id = $this->session->get('idunit');
      // $data = $this->mainModel->select(['idBarang','idKategoriBarang','nama','stokMinimal','satuanTerkecil','satuanPengadaan','status'])->where('idBarang', $id)->first();
      $data = [];
      $data['data'] = $this->mainModel->getAssignedUnit($id);
      $hasil['success'] = $data != null;
      $hasil['result'] = $data;

      return json_encode($hasil);
    }
  }

  function get_one($id = 0)
  {
    if ($this->request->isAJAX()) {

      $data = $this->mainModel
        ->select('*')
        ->where('idUnit', $id)->first();

      $hasil['success'] = $data != null;
      $hasil['result'] = $data;

      print json_encode($hasil);
    }
  }

  function save()
  {
    if ($this->request->isAJAX()) {
      $id = $this->request->getPost("id");
      $konten = json_decode($this->request->getPost("konten"));

      $result = array(
        'isSuccess' => true,
        'message' => 'Berhasil menambahkan unit'
      );

      $data = array(
        'idUnit' => $this->request->getPost("id"),
        'nama' => $konten->nama,
        'updatedBy' => $this->session->get("id")
      );

      if ($id == null || $id == 0) {
        $data['createdBy'] = $this->session->get("id");
        $this->mainModel->insert($data);
        $result['message'] = "simpan";
      } else {
        $this->mainModel->update($id, $data);
        $result['message'] = "update";
      }

      echo json_encode($result);
    }
  }

  function assignUnit()
  {
    $idGudang = $this->request->getPost("idGudang");
    //$idUnit = $this->request->getPost("idUnit");
    $listUnit = $this->request->getPost("listUnit");

    $suksesCount = 0;
    $gagalCount = 0;
    foreach ($listUnit as $unit) {
      $data = array();
      $data[] = $idGudang;
      $data[] = $unit['idUnit'];
      $data[] = $unit['status'];
      $data[] = $this->request->getPost("id");
      $data[] = $this->request->getPost("id");
      $data[] = $unit['status'];
      $data[] = $this->request->getPost("id");

      if ($idGudang != $unit['idUnit']) {
        $sql = "INSERT INTO dt_requnit (idUnitGudang, idUnit, status, createdAt, createdBy, updatedAt, updatedBy) VALUES (?, ?, ?, NOW(), ?, NOW(), ?) ON DUPLICATE KEY UPDATE status=?, updatedAt=NOW(), updatedBy=?";

        $result = $this->mainModel->db->query($sql, $data);
        if ($result) {
          $suksesCount++;
        } else {
          $gagalCount++;
        }
      } else {
        $gagalCount++;
      }
    }
    $message = '';

    if ($gagalCount == 0) {
      $message = 'Berhasil menyimpan data unit request';
    } else {
      if ($suksesCount > 0) {
        $message = 'Sebagian data tidak tersimpan. Silahkan ulangi proses';
      } else {
        $message = 'Semua data tidak tersimpan. Silahkan laporkan pada tim IT';
      }
    }

    $result = array(
      'isSuccess' => $suksesCount > 1 || $gagalCount==0,
      'message' => $message
    );
    echo json_encode($result);
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

      echo json_encode($hasil);
    }
  }

  public function getSelect($idGudang = 0)
  {
    $query = $this->request->getVar('q');
    $id = $this->request->getVar('id');

    if ($id == '') $id = 0;
    $like = [];
    $where = array('status' => '1');

    if (isset($query['term'])) {
      if (trim($query['term']) != '') {
        $like = array('nama' => $query['term']);
      }
    }

    $response = $this->mainModel->getSelect($where, $like, $id);
    echo json_encode($response);
  }

  public function getClient()
  {
    $query = $this->request->getVar('q');
    $id = $this->request->getVar('id');

    if ($id == '') $id = 0;
    $like = [];
    $where = array('dr.status' => '1', 'dr.idUnitGudang' => $this->session->get('idunit'));

    if (isset($query['term'])) {
      if (trim($query['term']) != '') {
        $like = array("CONCAT(mu.nama, ' (Unit : ', m.nama, ') ' )" => $query['term']);
      }
    }

    $response = $this->mainModel->getClient($where, $like, $id);
    echo json_encode($response);
  }

  public function hitungClient()
  {

    $like = [];
    $where = array('dr.status' => '1', 'dr.idUnitGudang' => $this->session->get('idunit'));
    $response = $this->mainModel->hitungClient($where, $like);

    echo json_encode($response);
  }
}
