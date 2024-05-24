<?php
namespace App\Models\supplier; 
use CodeIgniter\HTTP\RequestInterface;
use App\Models\BaseModel;


class SupplierModel extends BaseModel
{
    protected $table = 'purchasing.m_supplier';
	protected $primaryKey = 'idSupplier';
	protected $returnType = 'object';
	protected $useSoftDeletes = false;
	protected $allowedFields = ['idKategoriSupplier','nama', 'alamat', 'telp', 'status', 'createdBy', 'updatedBy'];
	protected $useTimestamps = true;
	protected $createdField  = 'createdAt';
	protected $updatedField  = 'updatedAt';
	protected $deletedField  = false;
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = true;    


    protected $column_order = array(null, 'nama', null);
    protected $column_search = array('mk.nama', 'purchasing.m_supplier.nama');
    protected $order = array('' => 'DESC');

	function _alterConnection(RequestInterface $request, $mode)
    {
        $this->db = db_connect();
        $this->request = $request;
        $this->dt = $this->db->table($this->table)
        ->select($this->table.".*, mk.nama namaKategori")
        ->join('purchasing.m_kategoriSupplier mk', $this->table.'.idKategoriSupplier=mk.idKategoriSupplier', 'inner');
        // ->join('masteri AS t3', 'TRIM(ra.noreg)=TRIM(t3.NOREG) AND ra.KBUKU=t3.KBUKU', 'inner')
        // ->join('dokter as d','ra.KDDOK=d.KDDOK');
    }

	public function getSelect($where, $like, $id=0){
        $data = $this->db->table($this->table.' m')
        ->select ("idSupplier id, nama")
        ->where($where)->like($like)->get()->getResult();
        
        return $data;
    }
}

