<?php
namespace App\Models\barang; 
use CodeIgniter\HTTP\RequestInterface;
use App\Models\BaseModel;


class KategoriBarangModel extends BaseModel
{
    protected $table = 'm_kategoribarang';
	protected $primaryKey = 'idKategoriBarang';
	protected $returnType = 'object';
	protected $useSoftDeletes = false;
	protected $allowedFields = ['nama', 'parent', 'tree', 'status', 'createdBy', 'updatedBy'];
	protected $useTimestamps = true;
	protected $createdField  = 'createdAt';
	protected $updatedField  = 'updatedAt';
	protected $deletedField  = false;
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = true;    


    protected $column_order = array(null, 'nama', null);
    protected $column_search = array('nama');
    protected $order = array('' => 'DESC');

	function _alterConnection(RequestInterface $request, $mode)
    {
        $this->db = db_connect();
        $this->request = $request;
        $this->dt = $this->db->table($this->table." m")
		->join('m_kategoriBarang mb','m.parent=mb.idKategoriBarang','left')
		->SELECT(["m.idKategoriBarang id", "m.nama namaKategori", "IFNULL(m.parent,0) idParent", "IFNULL(mb.nama,'-') namaParent", "m.status", "m.createdAt", "m.createdBy"]);
        
    }

	public function getSelect($where, $like, $id=0){
        $data = $this->db->table($this->table.' m')
        ->select ("idKategoriBarang id, nama")
        ->where($where)->like($like)->get()->getResult();
        
        return $data;
    }
}

