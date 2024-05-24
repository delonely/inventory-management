<?php

namespace App\Controllers\Supplier;
use App\Controllers\BackendController;

class Kategorisupplier extends BackendController
{
  public function __construct()
  {
    parent::__construct();
    $this->data['page'] = 'kategorisupplier';
    $this->mainModel = new \App\Models\supplier\KategoriSupplierModel();
  }

  public function kategori_supplier()
  {
    return $this->defaultView('supplier/kategori_supplier/Kategorisupplier', $this->data,'supplier/kategori_supplier/footerKategoriSupplier');
  } 

  public function getAll(){
    $request = \Config\Services::request();
    $where = array('m.status' => 1);
    $list = $this->mainModel->get_datatables($request, $where);
    $datas = [];
    $no = 1;

    foreach ($list as $key => $value){
      // $ops  = '<div class="me-3">';
      // $ops .= '<button type="button" class="btn btn-edit" onclick="edit(' . $value->idKategoriSupplier . ')"><img src="'.base_url('/assets/img/icons/edit.svg'). '" alt="img"></i></button>';
      // $ops .= '<button type="button" class="btn btn-delete" onclick="remove(' . $value->idKategoriSupplier . ')"><img src="'.base_url('/assets/img/icons/delete.svg'). '" alt="img"></i></button>';
      // $ops .= '</div>';

      $row= array();
      $row[] = $no;
      $row[] = $value->id;
      $row[] = $value->idParent;
      $row[] = $value->namaSupplier;
      $row[] = $value->namaParent;
      $row[] = $value->status; 
      //$row[] = $ops;
      $datas[] = $row;
      $no++;
    }

    $draw = $request->getPost("draw") == null ? 1 : $request->getPost("draw");
    $output = array(
      "draw" => $draw,
      "recordsTotal" =>$this->mainModel->count_all($request, $where),
      "recordsFiltered" =>$this->mainModel->count_filtered($request, $where),
      "data" => $datas,
    );
    return json_encode($output);
  }

  function add_kategorisupplier(){
    return $this->defaultView('supplier/kategori_supplier/Addkategorisupplier', $this->data,'supplier/kategori_supplier/footerAddKategoriSupplier');
  }

  function get_one($id = 0){
    if($this->request->isAJAX()){
       
      $data = $this->mainModel
      ->select(['purchasing.m_kategoriSupplier.idKategoriSupplier', 'purchasing.m_kategoriSupplier.nama', 'purchasing.m_kategoriSupplier.parent', 'ifnull(m.nama,\'\') namaParent', 'purchasing.m_kategoriSupplier.status', 'purchasing.m_kategoriSupplier.createdAt', 'purchasing.m_kategoriSupplier.createdBy'])
      ->join('purchasing.m_kategoriSupplier m','purchasing.m_kategoriSupplier.parent=m.idKategoriSupplier','left')
      ->where('purchasing.m_kategoriSupplier.idKategoriSupplier', $id)->first();

      $hasil['success'] = $data != null;
      $hasil['result'] = $data;

      print json_encode($hasil);
    }
  } 
 
  function save(){
    if($this->request->isAJAX()){
      $id = $this->request->getPost("id");
      $konten = json_decode($this->request->getPost("konten"));
 
      $sql = "CALL addKategoriSupplier(?, ?, ?, ?, 1)";
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

  function remove($id = 0){
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




