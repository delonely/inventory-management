<?php

namespace App\Controllers;
use App\Controllers\BackendController;

class Pajak extends BackendController
{
  public function __construct()
  {
    parent::__construct();
    $this->data['page'] = 'pajak';
    $this->mainModel = new \App\Models\PajakModel();
  }

  public function data_pajak()
  {
    return $this->defaultView('pajak/Pajak', $this->data,'pajak/footerDataPajak');
  }

  function get_one($id = 0){
    if($this->request->isAJAX()){

      $data = $this->mainModel
        ->select(['idPajak id', 'nama', 'persen', 'notes', 'status'])
        ->where('idPajak', $id)->first();

      $hasil['success'] = $data != null;
      $hasil['result'] = $data;

      print json_encode($hasil);
    }
  }

  public function getAll(){
    $request = \Config\Services::request();
    $where = array('status' => 1);
    $list = $this->mainModel->get_datatables($request, $where);
    $datas = [];
    $no = 1;

    foreach ($list as $key => $value){
      // $ops  = '<div class="me-3">';
      // $ops .= '<button type="button" class="btn btn-edit" onclick="tambah(' . $value->idPajak . ')"><img src="'.base_url('/assets/img/icons/edit.svg'). '" alt="img"></i></button>';
      // $ops .= '<button type="button" class="btn btn-delete" onclick="remove(' . $value->idPajak . ')"><img src="'.base_url('/assets/img/icons/delete.svg'). '" alt="img"></i></button>';
      // $ops .= '</div>';

      $row= array();
      $row[] = $no;
      $row[] = $value->idPajak;
      $row[] = $value->nama;
      $row[] = $value->persen;
      $row[] = $value->notes;
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

  function add_pajak(){
    return $this->defaultView('pajak/Adddatapajak', $this->data,'pajak/footerAddPajak');
  }

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
        'persen' => $konten->persen,
        'notes' => $konten->keterangan,
        'status' => 1,
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




