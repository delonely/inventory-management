<?php
namespace App\Models\barang;
use App\Models\BaseModel;

class DetailSatuanBarangModel extends BaseModel{

    protected $table = 'dt_satuanbarang';
    protected $primaryKey = 'idSatuanBarang';
    protected $returnType = 'object';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['idSatuan', 'idBarang', 'jumlahKonversi', 'status', 'createdBy', 'updatedBy'];
    protected $useTimestamps = true;
    protected $createdField = 'createdAt';
    protected $updatedField = 'updatedAt';
    protected $deletedField = false;
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = true;

    protected $column_order = array (null, 'nama', null);
    protected $column_search = array ('nama');
    protected $order = array ('' => 'DESC');

    public function getSelect($where, $like, $id=0){
        $data = $this->db->table($this->table.' m')
        ->select ("idSatuan id, nama")
        ->where($where)->like($like)->get()->getResult();

        return $data;
    }
}