<?php

namespace App\Models\supplier; 
use CodeIgniter\HTTP\RequestInterface;
use App\Models\BaseModel;
//use CodeIgniter\Model;

class kategoriSupplierModel extends BaseModel
{
    protected $table = 'purchasing.m_kategoriSupplier';
	protected $primaryKey = 'idKategoriSupplier';
	protected $returnType = 'object';
	protected $useSoftDeletes = false;
	protected $allowedFields = ['nama','parent','status','createdBy','updatedBy'];
	protected $useTimestamps = true;
	protected $createdField  = 'createdAt';
	protected $updatedField  = 'updatedAt';
	protected $deletedField  = false;
	protected $validationRules    = [];
	protected $validationMessages = [];
	protected $skipValidation     = true;    


    protected $column_order = array(null, 'm.nama', null);
    protected $column_search = array('m.nama', 'mk.nama');
    protected $order = array('' => 'DESC');

	function _alterConnection(RequestInterface $request, $mode)
    {
        $this->db = db_connect();
        $this->request = $request;
        $this->dt = $this->db->table($this->table." m")
		->join('purchasing.m_kategoriSupplier mk','m.parent=mk.idKategoriSupplier','left')
		->SELECT(["m.idKategoriSupplier id", "m.nama namaSupplier", "IFNULL(m.parent,0) idParent", "IFNULL(mk.nama,'-') namaParent", "m.status"]);
        
    }

	public function getSelect($where, $like, $id=0){
        $data = $this->db->table($this->table.' m')
        ->select ("idKategoriSupplier id, nama")
        ->where($where)->like($like)->get()->getResult();
        
        return $data;
    }
}

