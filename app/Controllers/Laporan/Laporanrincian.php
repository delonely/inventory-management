<?php

namespace App\Controllers\Laporan;
use App\Controllers\BackendController;

class Laporanrincian extends BackendController
{
  public function __construct()
  {
    parent::__construct();
    $this->data['page'] = 'lapRincianPersediaan';
  }

  public function index()
  {
    return $this->defaultView('laporan\lap_rincian\viewCetakLaporanRincian', $this->data,'laporan\lap_rincian\footerLaporanRincian');
  } 
}




