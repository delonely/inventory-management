<?php

namespace App\Controllers;

class Auth extends BaseController
{
    protected $data = array();
    protected $session;
    protected $mainModel;
    protected $_templateBasePath = 'template/v1/';

    public function __construct()
    {
        //parent::__construct();
        //$this->data['page'] = 'barang';
        $this->session = \Config\Services::session();
        $this->mainModel = new \App\Models\AuthModel();
        $this->data['page'] = 'Page Not Set';
        $this->data['_title'] = 'SIP Inventori Unesa Tambah Joss';

    }

    public function index()
    {
        //return $this->defaultView('home', $this->data);
        //echo 'mmhm';
        if($this->session->has('nama')){
            return redirect()->to('/'); 
            // echo 'Sudah login sebagai '.$this->session->get('nama');
            // echo '<br/><a href="'.base_url('/auth/out').'"> Keluar</a>';
        } else {
            // $parameter = $this->data;
            // $view = view($this->_templateBasePath . 'head', $parameter)
            // . view($this->_templateBasePath . 'header', $parameter)
            // . view('pages/Login')
            // . view($this->_templateBasePath . 'sidebar', $parameter)
            // . view($this->_templateBasePath . 'footer', $parameter);

            
        // $parameter = array(
        //     'templatePath' => $this->_templateBasePath
        // );
        $this->data['templatePath'] = $this->_templateBasePath;
        return view('login', $this->data);
            //return $this->defaultView('data_barang/Databarang', $this->data,'data_barang/footerDataBarang');
            //echo 'logged out';
        }
    }

    /**Fungsi ajax di bawah */
    public function login()
    {
        $user = $this->request->getPost("u");
        $pass = $this->request->getPost("p");
        
       // $data = $this->mainModel->select(['idUser','nama','password','status'])->where('username', $user)->first();
       $data = $this->mainModel->getAuth($user);
        if(is_array($data) && count($data)>0) $data = $data [0];
        
       // if(count($data)>0) $data = $data [0];
        $result['success'] = true;
        $result['Aidi Anda'] = 0;
        $result['message'] = 'hehe';
        
        if($data == null){
            $result['success'] = false;
             $result['message'] = 'Username tidak ditemukan';
        } else {
            //Data ditemukan, cek status
            if($data->status == 0){
                $result['success'] = false;
                $result['message'] = 'Akun tidak aktif';
            } elseif ($data->password != md5($pass)){
                $result['success'] = false;
                $result['message'] = 'Password salah';
            } else {
                //Sampai sini berarti akun aktif dan password benar
                $result['Aidi Anda'] = $data->idUser;
                $result['success'] = true;
                $result['message'] = 'Berhasil login '.$data->namaUser;
                
                
                $login = array(
                    'id' => $data->idUser,
                    'idunit' => $data->idUnit,
                    'idrole' => $data->idRole,
                    'nama' => $data->namaUser,
                    'namaUnit' => $data->namaUnit,
                    'unitUser' => $data->idUnitUser,
                    'role' => $data->namaRole,
                    'logged' => true,
                    'isGudang' => $data->jumlahKlien>0

                );

                $this->session->set($login);
            }
        }

        echo json_encode($result); 
    }

    public function logout(){
        $this->session->destroy();

        $result['success'] = true;
        $result['message'] = 'Berhasil Log Out';
        
        return redirect()->to('auth'); 
        //echo json_encode($result);
    }
}
