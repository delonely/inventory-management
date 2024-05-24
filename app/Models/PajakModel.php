<?php
namespace App\Models;
use App\Models\BaseModel;

class PajakModel extends BaseModel{

    protected $table = 'purchasing.m_pajak';
    protected $primaryKey = 'idPajak';
    protected $returnType = 'object';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['nama', 'persen', 'notes', 'status', 'createdBy', 'updatedBy'];
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
        ->select ("idPajak id, CONCAT(nama, ' ', persen) nama, persen")
        ->where($where)->like($like)->get()->getResult();

        return $data;
    } 

}