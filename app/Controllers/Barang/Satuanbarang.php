<?php
namespace App\Controllers\Barang;
use App\Controllers\BackendController;

class Satuanbarang extends BackendController{

  public function __construct(){
    parent::__construct();
    $this->data['page'] = 'satuan';
    $this->mainModel = new \App\Models\barang\SatuanBarangModel();
  }

  public function satuan_barang(){
    return $this->defaultView('barang/satuan_barang/Satuanbarang', $this->data, 'barang/satuan_barang/footerSatuan');
  }

  public function getAll(){
    $request = \Config\Services::request();
    $where = array("status" => 1);
    $list = $this->mainModel->get_datatables($request, $where);
    $datas = [];
    $no = 1;

    foreach ($list as $value){
      $row = array();
      $row[] = $no++;
      $row[] = $value->idSatuan;
      $row[] = $value->nama;
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

  function get_one($id = 0){
    if($this->request->isAJAX()){

      $data = $this->mainModel
        ->select(['m_satuan.idSatuan', 'm_satuan.nama', 'm_satuan.status', 'm_satuan.createdAt', 'm_satuan.createdBy'])
        ->where('m_satuan.idSatuan', $id)->first();

      $hasil['success'] = $data != null;
      $hasil['result'] = $data;

      print json_encode($hasil);
    }
  }
 //line 59 yang ini karetnya ijo (update status harusnya hilang dari datatable dan status jadi 0)
  function save(){
    if($this->request->isAJAX()){
      $id = $this->request->getPost("id");
      $konten = json_decode($this->request->getPost("konten"));

      $result = array(
        'isSuccess' => true,
        'message' => 'Berhasil menambahkan satuan barang'
      );
      
      $data = array(
        'nama' => $konten->nama, 
        'updatedBy' => $this->session->get("id")
      );

      if($id == null || $id == 0){
        $data['createdBy'] = $this->session->get("id");
        $this->mainModel->insert($data);
        $result['message'] = "simpan";
      }
      else{
        $this->mainModel->update($id, $data);
        $result['message'] = "update";
      }

      echo json_encode($result);
    }
  }

  function remove_satuan($id = 0){
    if($this->request->isAJAX()){

      $data = ['status' => 0, 'updatedBy' => $this->session->get("id")];
      $hasil['success'] = true;
      $hasil['messages'] = "Berhasil menghapus data";

      if ($this->mainModel->update($id, $data) === False){

        $hasil['success'] = false;
        $hasil['messages'] = "Terjadi kesalahan saat menghapus data";
      }

      print json_encode($hasil);
    }
  }

  public function getSelect(){
    $query = $this->request->getVar('q');
    $id = $this->request->getVar('id');

    if($id == '') $id = 0;
    $like = [];
    $where = array('status' => '1');

    if (isset($query['term'])){
      if (trim($query['term']) != ''){
        $like = array('nama' => $query['term']);
      }
    }

    $response = $this->mainModel->getSelect($where, $like, $id);
    echo json_encode($response);
  }

  public function get_satuan($idBarang = 0){
    $query = $this->request->getVar('q');
   // $id = $this->request->getVar('id');

    //if($id == '') $id = 0;
    $like = [];
    $where = array('m.status' => '1', 'idBarang'=>$idBarang);

    if (isset($query['term'])){
      if (trim($query['term']) != ''){
        $like = array('nama' => $query['term']);
      }
    }

    $response = $this->mainModel->getSatuan($where, $like);
    echo json_encode($response);
  }
}
