<?php

namespace App\Controllers;

class BackendController extends BaseController
{
    protected $session = array();
    protected $data = array();
    protected $mainModel;
    protected $_templateBasePath = 'template/v1/';

    public function __construct()
    {
        
        $this->session = \Config\Services::session();
        if(!$this->session->has('nama')){
            header("Location: ".base_url('auth'));  
            exit();
           // return redirect()->to('auth'); 
            // echo 'Sudah login sebagai '.$this->session->get('nama');
            // echo '<br/><a href="'.base_url('/auth/out').'"> Keluar</a>';
        } 
        $_userData = array(
            'userid' =>  $this->session->get('id'),
            'unitid' =>  $this->session->get('idunit'),
            'roleid' =>  $this->session->get('idrole'),
            'usernama' => $this->session->get('nama'),
            'unitnama' =>  $this->session->get('namaUnit'),
            'unitUser' =>  $this->session->get('unitUser'),
            'namaRole' =>  $this->session->get('role'),
            'isGudang' =>  $this->session->get('isGudang')
        );

        $this->data['_userData'] = $_userData;
        //Cek token user available atau tidak -> Indikator sudah login
        //Cek token valid -> Jika tidak valid, forward ke login

        //Jika valid, masukkan informasi user ke $this->data
        $this->data['page'] = 'Page Not Set';
        $this->data['_title'] = 'SIP Inventori Unesa Tambah Joss';

        $css = array(
            //base_url('/assets/css/dataTables.bootstrap4.min.css'),
        );

        $js = array(
           // base_url('/assets/js/jquery.dataTables.min.js'),
           // base_url('/assets/js/dataTables.bootstrap4.min.js')
        );

        $this->data['_daftarCss'] = $css;
        $this->data['_daftarJs'] = $js;

       

        
        
    }

    protected function defaultView($page, $parameter = array(), $customFooter = "")
    {
        $view = view($this->_templateBasePath . 'head', $parameter)
            . view($this->_templateBasePath . 'header', $parameter)
            . view('pages/' . $page, $parameter)
            . view($this->_templateBasePath . 'sidebar', $parameter)
            . view($this->_templateBasePath . 'footer', $parameter);

            if($customFooter<>"")
                $view = $view.view('pages/'.$customFooter, $parameter);

        return $view;
    }
}
