<?php

namespace App\Models\user; 
use App\Models\BaseModel;
use CodeIgniter\HTTP\RequestInterface;

class RoleModel extends BaseModel
{
    protected $table = 'm_role';
	protected $primaryKey = 'idRole';
	protected $returnType = 'object';
	protected $useSoftDeletes = false;
	protected $allowedFields = ['nama', 'status', 'createdBy', 'updatedBy'];
	protected $useTimestamps = true;
	protected $createdField  = 'createdAt';
	protected $updatedField  = 'updatedAt';
	protected $deletedField  = false;
	protected $validationRules    = [];
	protected $validationMessages = [];
	protected $skipValidation     = true;    


    protected $column_order = array(null, 'nama', null);
    protected $column_search = array('nama');
    protected $order = array('' => 'DESC');

	 

	public function getSelect($where, $like, $id=0){
        $data = $this->db->table($this->table.' m')
        ->select ("idRole id, nama")
        ->where($where)->like($like)->get()->getResult();

        return $data;
    }
}

