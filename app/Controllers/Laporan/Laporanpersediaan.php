<?php

namespace App\Controllers\Laporan;
use App\Controllers\BackendController;

use Dompdf\Dompdf;

class Laporanpersediaan extends BackendController
{
  public function __construct()
  {
    parent::__construct();
    $this->data['page'] = 'lapPersediaan';
    $this->mainModel = new \App\Models\barang\DataBarangModel();
  }

  public function index()
  {
    return $this->defaultView('laporan\lap_persediaan\viewCetakLaporanPersediaan', $this->data,'laporan\lap_persediaan\footerLaporanPersediaan');
  }
  
  public function generate($tanggal)
  {
    $where = [];
    $where['idUnit'] = $this->session->get('idunit');
    $where['r.status']=1;
    date_default_timezone_set('Asia/Jakarta');
    $filename = date('y-m-d-H-i-s') . '-Stok Barang Saya';

    //Generate data yang akan ditampilkan ke laporan
    $data['data'] = $this->mainModel->generateData($where);

    //Mulai Generate domPDF
    $dompdf = new Dompdf();
    // Masukkan html yang akan ditambahkan ke dompdf  
    
    $dompdf->loadHtml(view('pages\laporan\lap_persediaan\cetakLaporanPersediaan',$data));
    // (optional) atur ukuran kertas dan orientasi
    $dompdf->setPaper('A4', 'potrait');

    // render halaman sebagai pdf
    $dompdf->render();

    // output the generated pdf
    //Ini jika lihat langsung di browser
    //Jika download, hapus array attachment
    $dompdf->stream($filename, array("Attachment" => false));

  }
}




