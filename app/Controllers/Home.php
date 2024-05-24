<?php

namespace App\Controllers;
use App\Controllers\BackendController;

class Home extends BackendController
{
  public function __construct()
  {
    parent::__construct();
    $this->data['page'] = 'home';
  }

  public function index(){
    $viewPath = 'home/index/home';
    $footerPath = 'home/index/footer';
    
    if($this->data['_userData']['roleid'] == 1 || $this->data['_userData']['isGudang'] == 1 ){
      $viewPath = 'home/gudang/home';
      $footerPath = 'home/gudang/footer';
    }elseif($this->data['_userData']['roleid'] == 2){
      $viewPath = 'home/user/home';
      $footerPath = 'home/user/footer';
    }

    return $this->defaultView($viewPath, $this->data, $footerPath);
  }
}
