<?php
namespace App\Controllers\Barang;
use App\Controllers\BackendController;

class Kategoribarang extends BackendController{

  public function __construct(){
    parent::__construct();
    $this->data['page'] = 'kategori';
    $this->mainModel = new \App\Models\barang\KategoriBarangModel();
  }

  public function kategori_barang(){
    return $this->defaultView('barang/kategori_barang/Kategoribarang', $this->data, 'barang/kategori_barang/footerBarang');
  }

  /**Fungsi untuk ajax */
  public function getAll(){
    $request = \Config\Services::request();
    /**Konfigurasi untuk datatables */
    $where = array('m.status' => 1);
    /**End konfigurasi untuk datatables */
    $list = $this->mainModel->get_datatables($request, $where);
    $datas = [];
    $no = 1;

    foreach ($list as $value){
      $row = array();
      $row[] = $no++;
      $row[] = $value->id;
      $row[] = $value->idParent;
      $row[] = $value->namaKategori;
      $row[] = $value->namaParent;
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
      ->select(['m_kategoriBarang.idKategoriBarang', 'm_kategoriBarang.nama', 'm_kategoriBarang.parent', 'ifnull(m.nama,\'\') namaParent', 'm_kategoriBarang.status', 'm_kategoriBarang.createdAt', 'm_kategoriBarang.createdBy'])
      ->join('m_kategoriBarang m','m_kategoriBarang.parent=m.idKategoriBarang','left')
      ->where('m_kategoriBarang.idKategoriBarang', $id)->first();

      $hasil['success'] = $data != null;
      $hasil['result'] = $data;

      print json_encode($hasil);
    }
  } 
 
  function save(){
    if($this->request->isAJAX()){
      $id = $this->request->getPost("id");
      $konten = json_decode($this->request->getPost("konten"));
 
      $sql = "CALL addKategoriBarang(?, ?, ?, ?, 1)";
      $alteredId = $id == null ? 0 : $id;
      $parent = isset($konten->parent) ? $konten->parent : null;
      $this->mainModel->query($sql, [$konten->nama, $this->session->get("id"), $parent, $alteredId]);

      $result = array(
        'isSuccess'=> true,
        'message'=>'Berhasil menambahkan kategori barang'
      );

      echo json_encode($result);
    }
  }

  function remove_kategori($id = 0){
    if($this->request->isAJAX()){

      $data = ['status' => 0, 'updatedBy'=>$this->session->get("id")];
      $hasil['success'] = true;
      $hasil['messages'] = "Berhasil menghapus data";


      if($this->mainModel->update($id, $data) === False){
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
    
    if(isset($query['term'])){
        if(trim($query['term']) != ''){
            $like = array('nama' => $query['term']);
        }
    }
    
    $response = $this->mainModel->getSelect($where, $like, $id);
    echo json_encode($response);
  }
}
