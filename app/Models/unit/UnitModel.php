<?php

namespace App\Models\unit; 
use App\Models\BaseModel;
use CodeIgniter\HTTP\RequestInterface;

class UnitModel extends BaseModel
{
    protected $table = 'm_unit';
	protected $primaryKey = 'idUnit';
	protected $returnType = 'object';
	protected $useSoftDeletes = false;
	protected $allowedFields = ['nama','status','createdBy','updatedBy'];
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

    function _alterConnection(RequestInterface $request, $mode)
    {
        $this->db = db_connect();
        $this->request = $request;
        if($mode == 0){
            $this->dt = $this->db->table($this->table);
        } 
        
        // elseif ($mode==1){
        //     $this->dt = $this->db->table('dt_requnit d')
        //     ->SELECT(['m.idUnit', 'm.nama namaUnit', 'd.status'])
        //     ->join('m_unit m','d.idUnit=m.idUnit');
        // }
    }

    function getAssignedUnit($id){
		return $this->db->table('dt_requnit d')
		->SELECT(['m.idUnit', 'm.nama namaUnit', 'd.status'])
		->join('m_unit m','d.idUnit=m.idUnit')
		->where(array('d.idUnitGudang'=>$id, 'd.status'=>1))->get()->getResult();
	}

	public function getSelect($where, $like, $id=0){
        $data = $this->db->table($this->table.' m')
        ->select ("idUnit id, nama")
        ->where($where)->like($like)->get()->getResult();

        return $data;
    }

	public function getClient($where, $like, $id=0){
        $data = $this->db->table($this->table.' m')
        ->select ("du.idUnitUser id, CONCAT(mu.nama, ' (Unit : ', m.nama, ') ' ) nama")
		->join("dt_requnit dr","dr.idUnit=m.idUnit")
        ->join("dt_unitUser du","m.idUnit=du.idUnit")
        ->join("m_user mu", "mu.idUser=du.idUser")
        ->where($where)->like($like)->get()->getResult();

        return $data;
    }

    public function hitungClient($where, $like){
        $data = $this->db->table($this->table.' m')
        ->select ("count(*) jumlah")
		->join("dt_requnit dr","dr.idUnit=m.idUnit")
        ->join("dt_unitUser du","m.idUnit=du.idUnit")
        ->join("m_user mu", "mu.idUser=du.idUser")
        ->where($where)->like($like)->get()->getResult();

        return $data;
    }
}

