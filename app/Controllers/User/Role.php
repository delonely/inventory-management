<?php

namespace App\Controllers\User;

use App\Controllers\BackendController;


class Role extends BackendController
{
    public function __construct()
  {
    parent::__construct();
    $this->data['page'] = 'role';
    $this->mainModel = new \App\Models\user\RoleModel();
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