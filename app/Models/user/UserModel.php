<?php

namespace App\Models\user; 
use App\Models\BaseModel;
use CodeIgniter\HTTP\RequestInterface;

class UserModel extends BaseModel
{
    protected $table = 'm_user';
	protected $primaryKey = 'idUser';
	protected $returnType = 'object';
	protected $useSoftDeletes = false;
	protected $allowedFields = ['idRole', 'username','password', 'nama', 'status', 'createdBy','updatedBy'];
	protected $useTimestamps = true;
	protected $createdField  = 'createdAt';
	protected $updatedField  = 'updatedAt';
	protected $deletedField  = false;
	protected $validationRules    = [];
	protected $validationMessages = [];
	protected $skipValidation     = true;    


    protected $column_order = array(null, 'nama', null);
    protected $column_search = array('m_user.nama', 'mu.nama');
    protected $order = array('' => 'DESC');

	function _alterConnection(RequestInterface $request, $mode)
    {
        $this->db = db_connect();
        $this->request = $request;
        $this->dt = $this->db->table($this->table)
       // ->select($this->table.".*, mk.nama namaKategori, ms.nama namaSatuanTerkecil")
	   ->select(['du.idUser', 'du.idUnit', 'username', $this->table.'.nama namaUser', 'mu.nama namaUnit' , 'du.tglMutasi', $this->table.'.status', 'mr.nama namaRole'])
        ->join('(select * from dt_unituser du JOIN (SELECT MAX(idUnitUser) idUnitUser FROM dt_unituser WHERE status=1 GROUP BY idUser) du1 using (idUnitUser)) du', $this->table.'.idUser=du.idUser', 'inner')
		->join('m_role mr', $this->table.'.idRole=mr.idRole')
		->join('m_unit mu', 'du.idUnit=mu.idUnit');
		//$this->dt = $this->db->query("select idUser, idUnit, username, m.nama namaUser, mu.nama namaUnit, du.tglMutasi, m.status from m_user m join (select * from dt_unituser du JOIN (SELECT MAX(idUnitUser) idUnitUser FROM dt_unituser WHERE status=1 GROUP BY idUser) du1 using (idUnitUser)) du using (idUser) join m_unit mu USING (idUnit)");
    }

	function saveData($mainData, $detailData){

		$this->insert($mainData);
		$lastId = $this->insertID(); 

		//foreach($detailData as $dData){
			$detailData['idUser']=$lastId;
			$this->db->table('dt_unitUser')->insert($detailData);
		//} 

	}

	public function getSelect($where, $like, $id=0){
        $data = $this->db->table($this->table.' m')
        ->select ("idUser id, nama")
        ->where($where)->like($like)->get()->getResult();

        return $data;
    }
}

