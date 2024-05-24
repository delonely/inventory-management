<?php

namespace App\Controllers\User;

use App\Controllers\BackendController;

class User extends BackendController
{
  public function __construct()
  {
    parent::__construct();
    $this->data['page'] = 'user';
    $this->mainModel = new \App\Models\user\UserModel();
  }

  public function data_pengguna()
  {
    return $this->defaultView('user/User', $this->data, 'user/footerUser');
  }

  function add_user()
  {
    return $this->defaultView('user\Adduser', $this->data, 'user\footerAddUser');
  }

  function mutasi_user()
  {
    // $data = $this->mainModel
    // ->select('*')
    // ->where('idUser', $id)->first();
    // $this->data['dataUser']=$data;
    // $hasil['success'] = $data != null;
    // $hasil['result'] = $data;

    return $this->defaultView('user\Mutasiuser', $this->data, 'user\footerUser.php');
  }
  
  public function getAll()
  {
    $request = \Config\Services::request();
    $where = array('m_user.status' => 1);
    $list = $this->mainModel->get_datatables($request, $where);
    $datas = [];
    $no = 1;

    foreach ($list as $key => $value) {
      // $ops  = '<div class="me-3">';
      // $ops .= '<button type="button" class="btn btn-edit" onclick="edit(' . $value->idUser . ')"><img src="'.base_url('/assets/img/icons/edit.svg'). '" alt="img"></i></button>';
      // $ops .= '<button type="button" class="btn btn-delete" onclick="remove(' . $value->idUser . ')"><img src="'.base_url('/assets/img/icons/delete.svg'). '" alt="img"></i></button>';
      // $ops .= '</div>';

      $row = array();
      $row[] = $no;
      $row[] = $value->idUser;
      $row[] = $value->idUnit;
      $row[] = $value->username;
      $row[] = $value->namaUser;
      $row[] = $value->namaRole;
      $row[] = $value->namaUnit;
      $row[] = $value->tglMutasi;
      $row[] = $value->status; 
      //  $row[] = $ops;
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



  function get_one($id = 0)
  {
    if ($this->request->isAJAX()) {

      $data = $this->mainModel
        ->select(['idUser','m_user.nama namaUser','username', 'mr.idRole', 'mr.nama namaRole'])
        ->join('m_role mr', 'm_user.idRole=mr.idRole')
        ->where('idUser', $id)->first();

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
        'message' => 'Berhasil menambahkan user'
      );

      $data = array(
        //'idUser' => $konten->kategori,
        'idRole' => $konten->role,
        'username' => $konten->username,
        'password' => md5($konten->password),
        'nama' => $konten->namaUser,
        'updatedBy' => $this->session->get("id")
      );
 
      if ($id == null || $id == 0) {
        $unitData = array();
        $unitData['idUnit'] = $konten->unit;
        $unitData['tglMutasi'] = $konten->tgl;
        $unitData['createdBy'] = $this->session->get("id");
        $unitData['createdAt'] = date('Y-m-d');
        $unitData['updatedBy'] = $this->session->get("id");
        $unitData['updatedAt'] = date('Y-m-d');
        $unitData['status'] = 1;
        
        $data['createdBy'] = $this->session->get("id");
        //$this->mainModel->insert($data);
        $this->mainModel->saveData($data, $unitData);
        $result['message'] = "simpan";
      } else {
        $this->mainModel->update($id, $data);
        $result['message'] = "update";
      }

      echo json_encode($result);
    }
  }

  function mutasi($id = 0)
  {
    if ($this->request->isAJAX()) { 
      $konten = json_decode($this->request->getPost("konten"));
      $unitData = array();
      $unitData['idUnit'] = $konten->idUnit;
      $unitData['idUser'] = $id;
      $unitData['tglMutasi'] = $konten->tglMutasi;
      $unitData['createdBy'] = $this->session->get("id");
      $unitData['createdAt'] = date('Y-m-d');
      $unitData['updatedBy'] = $this->session->get("id");
      $unitData['updatedAt'] = date('Y-m-d');
      $unitData['status'] = 1;

      $hasil = $this->mainModel->db->table('dt_unitUser')->insert($unitData);
      $result['isSuccess'] = $hasil;
      $result['message'] = $hasil ? 'Berhasil memutasikan user' : 'Terjadi kesalahan, coba lagi';
      echo json_encode($result);
    }
 
  }

  function remove($id = 0)
  {
    if ($this->request->isAJAX()) {

      $data = ['status' => 0, 'updatedBy' => $this->session->get("id")];
      $hasil['success'] = true;
      $hasil['messages'] = "Berhasil menghapus data";


      if ($this->mainModel->update($id, $data) !== true) {
        $hasil['success'] = false;
        $hasil['messages'] = "Terjadi kesalahan saat menghapus data";
      } 

      print json_encode($hasil);
    }
  }

  public function getSelect()
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
}
