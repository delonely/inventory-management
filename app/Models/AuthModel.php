<?php

namespace App\Models;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class AuthModel extends Model
{

    protected $table = 'm_user';
	protected $primaryKey = 'idUser';
	protected $returnType = 'object';
	protected $useSoftDeletes = false;
	protected $allowedFields = ['username', 'password', 'status', 'createdBy', 'updatedBy'];
	protected $useTimestamps = true;
	protected $createdField  = 'createdAt';
	protected $updatedField  = 'updatedAt';
	protected $deletedField  = false;
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = true;    


    // protected $column_order = array(null, 'm_barang.nama', null);
    // protected $column_search = array('m_barang.nama');
    // protected $order = array('' => 'DESC');

	public function getAuth($username){
		$where = array(
			'username'=>$username,
			'd.tglMutasi<='=>date('Y-m-d')
		);

		$data = $this->db->table($this->table.' m')
        ->select (['m.idUser','m.nama namaUser','m.password','m.status','mu.idUnit','mu.nama namaUnit', 'd.idUnitUser', 'COUNT(dr.idUnit) jumlahKlien', 'mr.nama namaRole', 'mr.idRole'])
		->join('(SELECT * FROM dt_unitUser d JOIN (SELECT MAX(idUnitUser) idUnitUser FROM dt_unitUser d WHERE d.status=1 AND date(tglMutasi)<=CURDATE() GROUP BY idUser) d1 USING (idUnitUser) ) d', 'm.idUser = d.idUser AND d.status=1')
		//->join('dt_unitUser d','m.idUser = d.idUser AND d.status=1')
		->join('m_role mr','m.idRole=mr.idRole')
		->join('m_unit mu', 'd.idUnit = mu.idUnit')
		->join('dt_requnit dr', 'dr.idUnitGudang=mu.idUnit AND dr.status=1','left')
        ->where($where)
		->groupBy(['m.idUser', 'd.idUnitUser', 'mu.idUnit'])
		->orderBy('d.tglMutasi', 'DESC')
		->limit(1)
		->get()->getResult();

        return $data;
	}
}
