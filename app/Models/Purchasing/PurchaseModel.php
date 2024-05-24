<?php

namespace App\Models\Purchasing;
use CodeIgniter\HTTP\RequestInterface;
use App\Models\BaseModel;

class PurchaseModel extends BaseModel
{
    protected $DBGroup          = 'default';
    protected $table            = 'purchasing.m_selfPurchase';
    protected $primaryKey       = 'idSelfPurchase';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['idUnitUser', 'tanggalNota', 'idSupplier', 'noNota', 'noUrut', 'discount', 'notes', 'status', 'createdAt', 'createdBy', 'updatedAt', 'updatedBy'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'createdAt';
    protected $updatedField  = 'updatedAt';
    //protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    //Datatables
    protected $column_order = array(null, 'noNota', null);
    protected $column_search = array('noNota', 'tanggalNota');
    protected $order = array('' => 'DESC');

    function _alterConnection(RequestInterface $request, $mode)
    {
        $this->db = db_connect();
        $this->request = $request;
		
        $this->dt = $this->db->table($this->table." m")
		->select("m.idSelfPurchase id, m.noNota, m.tanggalNota, m.notes catatan, m.status, m.createdAt, m.createdBy, mu.nama namaUnit, mus.nama namaUser, ds.priceTotal, mp.persen")
        ->JOIN("(SELECT ds.idSelfPurchase, idPajak, sum(priceTotal) priceTotal FROM purchasing.dt_selfPurchase ds WHERE status=1 GROUP BY ds.idSelfPurchase, ds.idPajak) ds", "m.idSelfPurchase=ds.idSelfPurchase")
        ->JOIN("dt_unituser d",'m.idUnitUser=d.idUnitUser')
        ->JOIN("purchasing.m_pajak mp", "ds.idPajak=mp.idPajak")
		->JOIN("m_unit mu","d.idUnit=mu.idUnit")
		->JOIN("m_user mus","d.idUser = mus.idUser");
		 
    }

	function getCurrentData($id){
		return $this
		->select(["idSelfPurchase id", "noNota", "DATE_FORMAT(tanggalNota,'%d-%m-%Y') tanggalNota", "notes catatan", "status", "createdAt", "createdBy"])
      	->where('idSelfPurchase', $id)->first();
	}
 
	function getDetailedData($id){
		return $this->db->table('purchasing.dt_selfPurchase dp')
		->select(["dp.idDtSelfPurchase id", "dp.idBarang", "dp.idPajak", "dp.idSatuanBarang", "mb.nama namaBarang", "dp.quantity jumlah", "ms.nama namaSatuan", "dp.pricePerItem hargaSatuan", "dp.priceTotal totalHarga", "dp.discount", "dp.notes catatan", "dp.status"]) 
		->join("pengadaan.m_barang mb",'dp.idBarang=mb.idBarang')
        ->join("purchasing.m_pajak mp",'dp.idPajak=mp.idPajak')
		->join("dt_satuanbarang ds","dp.idSatuanBarang=ds.idSatuanBarang")
		->join("m_satuan ms", "ds.idSatuan=ms.idSatuan")  
		->where(array('dp.idSelfPurchase'=>$id))->get()->getResult(); 
	}

    function saveData($mainData, $detailData){

		$this->insert($mainData);
		$lastId = $this->insertID();

		//$detailModel = new \App\Models\inventory\PermintaanBarangModel();
		foreach($detailData as $dData){
			$dData['idSelfPurchase']=$lastId;
            $history = $dData['history'];
            unset($dData['history']);

			$this->db->table('purchasing.dt_selfPurchase')->insert($dData);
            
            $history['kodeTransaksi'] = $lastId;
			$this->db->table('m_stockhistory')->insert($history);

            $sql = "UPDATE r_barangUnit SET estimasiStok = estimasiStok + ".$history['jumlah']. " WHERE idBarang=".$dData['idBarang']." AND idUnit=".$history['idUnit'];
            $result = $this->db->query($sql); 
		}
 

	}

	function updateData($id, $mainData, $detailData){ 
		$this->update($id, $mainData);
		  
		foreach($detailData as $dData){
			if($dData['idDtSelfPurchase']==0){
				$dData['idSelfPurchase']=$id;
				$this->db->table('purchasing.dt_selfPurchase')->insert($dData);
			}
		}  
	}

}
