<?php

namespace App\Models\inventory;

use CodeIgniter\HTTP\RequestInterface;
use App\Models\BaseModel;


class PermintaanBarangModel extends BaseModel
{
	protected $table = 'm_request';
	protected $primaryKey = 'idRequest';
	protected $returnType = 'object';
	protected $useSoftDeletes = false;
	protected $allowedFields = ['idUnitUser', 'idGudang', 'idUnitUser', 'noUrut', 'tanggal', 'keteranganBatal', 'status', 'createdBy', 'updatedBy'];
	protected $useTimestamps = true;
	protected $createdField  = 'createdAt';
	protected $updatedField  = 'updatedAt';
	protected $deletedField  = false;
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = true;


	protected $column_order = array(null, 'nama', null);
	protected $column_search = array('mu.nama', 'mus.nama', 'nomorRequest');
	protected $order = array('' => 'DESC');


	function _alterConnection(RequestInterface $request, $mode)
	{
		$this->db = db_connect();
		$this->request = $request;

		if ($mode == 0) { // Ini adalah mode normal dimana data request ditampilkan di halaman request
			$this->dt = $this->db->table($this->table)
				->SELECT(["m_request.idRequest", "CONCAT('REQ/',RIGHT(YEAR(m_request.createdAt),2),'/',LPAD(MONTH(m_request.createdAt),2,'0'),'/',LPAD(m_request.noUrut,4,'0')) nomorRequest", "m_request.status", "m_request.createdAt", "m_request.createdBy", "mu.nama namaUnit", "mus.nama namaUser", "m_request.tanggal tanggalRequest"])
				->JOIN("dt_unituser d", 'm_request.idUnitUser=d.idUnitUser')
				->JOIN("m_unit mu", "d.idUnit=mu.idUnit")
				->JOIN("m_user mus", "d.idUser = mus.idUser");
		} elseif ($mode == 1) { // Ini adalah mode dimana data request ditampilkan pada bagian approval, hanya yg belum di approve yg tampil
			$this->dt = $this->db->table($this->table)
				->distinct('m_request.idRequest')
				->SELECT(["m_request.idRequest", "m_request.noUrut urutRequest", "m_request.tanggal tanggalRequest", "IF(IFNULL(ma.status,0)=1,ma.idApproval,'') idApproval", "IF(IFNULL(ma.status,0)=1,ma.noUrut,'') urutApprove", "IF(IFNULL(ma.status,0)=1,ma.createdAt,m_request.createdAt) tanggalApprove"])
				->JOIN('dt_request dr', 'm_request.idRequest = dr.idRequest')
				->JOIN('dt_approval da', 'da.idDtRequest = dr.idDtRequest', 'left')
				->JOIN('m_approval ma', 'ma.idApproval = da.idApproval AND ma.status=1', 'left');
		}
	}

	function getCurrentData($id)
	{
		return $this
			->select(['idRequest', "CONCAT('REQ/',RIGHT(YEAR(m_request.createdAt),2),'/',LPAD(MONTH(m_request.createdAt),2,'0'),'/',LPAD(m_request.noUrut,4,'0')) nomorRequest", 'status', 'createdAt', 'createdBy'])
			->where('idRequest', $id)->first();
	}


	function getDetailedData($id)
	{
		return $this->db->table('dt_request dr')
			->select(["dr.idDtRequest", "dr.idBarang", "dr.idSatuanBarang", "mb.nama namaBarang", "ms.nama namaSatuan", "jumlah"])
			->join("m_barang mb", 'dr.idBarang=mb.idBarang')
			->join("dt_satuanbarang ds", "dr.idSatuanBarang=ds.idSatuanBarang")
			->join("m_satuan ms", "ds.idSatuan=ms.idSatuan")
			->where(array('dr.idRequest' => $id))->get()->getResult();
	}



	function saveData($mainData, $detailData, $stockData)
	{
		$this->transBegin();
		try {
			$this->insert($mainData);
			$lastId = $this->insertID();

			//$detailModel = new \App\Models\inventory\PermintaanBarangModel();
			
			//Insert ke dt request
			foreach ($detailData as $dData) {
				$valueData = $dData['valueData'];
				$idBarang=$dData['idBarang'];
				unset($dData['valueData']);
				unset($dData['idBarang']);
				// $sql = "SELECT * FROM m_stockHistory WHERE idUnit=".$mainData['idGudang']." AND idBarang=".$dData['idBarang']." AND ignoreFifo=0 AND usedItem<jumlah ORDER BY idStockHistory";
				// $fifoDatas = $this->db->query($sql)->getResult();
				 
				$dData['idRequest'] = $lastId;
				
				$this->db->table('dt_request')->insert($dData);
				$detailId = $this->insertID();
				//insert valueData
				foreach ($valueData as $vData){
					$vData['idDtRequest'] = $detailId;
					$this->db->table('dt_requestDetail')->insert($vData);
				}

				$sql = "UPDATE r_barangUnit SET estimasiStok = estimasiStok - ".$dData['jumlah']. " WHERE idBarang=".$idBarang." AND idUnit=".$mainData['idGudang'];
            	$result = $this->db->query($sql); 
				
			} 

			//insert ke stockhistory untuk keperluan fifo dan update stockhistory lama (useditemnya)
			foreach ($stockData as $sData){
				$this->db->table('m_stockhistory')->update(array('usedItem'=>$sData['usedItem']), $sData['idStockHistory']);

				$sData['usedItem'] = 0;
				unset($sData['idStockHistory']);
				$this->db->table('m_stockHistory')->insert($sData);
			}
			$this->transCommit();
			return '';
		} catch (\Exception $e) {
			$this->transRollback();
			return $e->getMessage();
		}

		// $history['idBarang']=$lastId;
		// $this->db->table('mstockhistory')->insert($history);

	}

	function updateData($id, $mainData, $detailData)
	{
		$this->update($id, $mainData);

		foreach ($detailData as $dData) {
			if ($dData['idDtRequest'] == 0) {
				$dData['idRequest'] = $id;
				$this->db->table('dt_request')->insert($dData);
			}
		}
	}


	// 	SELECT
	// DISTINCT
	// m_request.idRequest, m_request.noUrut, m_request.createdAt,
	// IF(IFNULL(ma.status,0)=1,ma.idApproval,'') idApproval, IF(IFNULL(ma.status,0)=1,ma.noUrut,'') noUrut, IF(IFNULL(ma.status,0)=1,ma.createdAt,m_request.createdAt) createdAt
	// FROM
	// m_request m
	// JOIN dt_request dr using (idRequest)
	// LEFT JOIN dt_approval da using (idDtRequest)
	// LEFT JOIN m_approval ma on da.idApproval=ma.idApproval and ma.status=1
	// WHERE
	// m_request.status=1;
}
