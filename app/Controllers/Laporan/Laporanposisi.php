<?php

namespace App\Controllers\Laporan;
use App\Controllers\BackendController;

class Laporanposisi extends BackendController
{
  public function __construct()
  {
    parent::__construct();
    $this->data['page'] = 'lapPosisiPersediaan';
  }

  public function index()
  {
    return $this->defaultView('laporan\lap_posisi\viewCetakLaporanPosisi', $this->data,'laporan\lap_posisi\footerLaporanPosisi');
  } 
}




