<?php
namespace App\Models\barang;
use App\Models\BaseModel;

class SatuanBarangModel extends BaseModel{

    protected $table = 'm_satuan';
    protected $primaryKey = 'idSatuan';
    protected $returnType = 'object';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['nama', 'status', 'createdBy', 'updatedBy'];
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

    public function getSatuan($where, $like){
        $data = $this->db->table('dt_satuanBarang m')
        ->select ("m.idSatuanBarang id, ms.nama, m.jumlahKonversi")
        ->join('m_satuan ms','m.idSatuan=ms.idSatuan')
        ->where($where)->like($like)->get()->getResult();

        return $data;
    }

}