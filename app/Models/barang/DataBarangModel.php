<?php

namespace App\Models\barang;

use CodeIgniter\HTTP\RequestInterface;
use App\Models\BaseModel;
use PDO;

class DataBarangModel extends BaseModel
{

	protected $table = 'm_barang';
	protected $primaryKey = 'idBarang';
	protected $returnType = 'object';
	protected $useSoftDeletes = false;
	protected $allowedFields = ['idKategoriBarang', 'nama', 'stokMinimal', 'satuanTerkecil', 'satuanPengadaan', 'status', 'createdBy', 'updatedBy'];
	protected $useTimestamps = true;
	protected $createdField  = 'createdAt';
	protected $updatedField  = 'updatedAt';
	protected $deletedField  = false;
	protected $validationRules = [];
	protected $validationMessages = [];
	protected $skipValidation = true;


	protected $column_order = array(null, 'm_barang.nama', null);
	protected $column_search = array('m_barang.nama', 'mk.nama');
	protected $order = array('' => 'DESC');

	function _alterConnection(RequestInterface $request, $mode)
	{
		$this->db = db_connect();
		$this->request = $request;
		if ($mode == 0) {
			$this->dt = $this->db->table($this->table)
				->select($this->table . ".*, mk.nama namaKategori, ms.nama namaSatuanTerkecil, ms1.nama namaSatuanPengadaan")
				->join('m_kategoribarang mk', $this->table . '.idKategoriBarang=mk.idKategoriBarang', 'inner')
				->join('m_satuan ms', $this->table . '.satuanTerkecil=ms.idSatuan')
				->join('m_satuan ms1', $this->table . '.satuanPengadaan=ms1.idSatuan');
		} else if ($mode == 1) {
			$this->dt = $this->db->table('r_barangUnit r')
				->select("m_barang.*, mk.nama namaKategori, ms.nama namaSatuanTerkecil, ms1.nama namaSatuanPengadaan, r.estimasiStok")
				->JOIN('m_barang', 'm_barang.idBarang=r.idBarang')
				->join('m_kategoribarang mk', 'm_barang.idKategoriBarang=mk.idKategoriBarang', 'inner')
				->join('m_satuan ms', 'm_barang.satuanTerkecil=ms.idSatuan')
				->join('m_satuan ms1', 'm_barang.satuanPengadaan=ms1.idSatuan');
		}
	}

	function getGudang($id)
	{
		return $this->db->table('r_barangunit dr')
			->select('dr.idUnit unit, dr.satuanRequest idSatuanRequest, mu.nama unitText, ms.nama satuanRequest, ROUND(stokMinimal) stokMinimal, IFNULL(msh.jumlah, 0) saldoAwal, IFNULL(msh.valueBarang, 0) hargaAwal, dr.estimasiStok')
			->join('m_unit mu', 'dr.idUnit=mu.idUnit')
			->join('dt_satuanBarang dsb', 'dr.satuanRequest=dsb.idSatuanBarang')
			->join('m_satuan ms', 'dsb.idSatuan=ms.idSatuan')
			->join('(SELECT * from m_stockHistory ms JOIN (SELECT min(idStockHistory) idStockHistory FROM m_stockHistory GROUP BY idBarang, idUnit) ms1 using (idStockHistory) ) msh', 'dr.idBarang=msh.idBarang AND dr.idUnit=msh.idUnit', 'left')
			->where(array('dr.idBarang' => $id, 'dr.status' => 1))->get()->getResult();
	}

	function getSatuan($id)
	{
		return $this->db->table('dt_satuanbarang dsb')
			->select("dsb.idSatuanBarang id, dsb.idSatuan, dsb.idBarang, mb.nama namaBarang, dsb.jumlahKonversi, ms.nama namaSatuan, mb.satuanTerkecil, ms1.nama namaSatuanTerkecil ")
			//->select(["dsb.idSatuanBarang id", "dsb.idSatuan", "dsb.idBarang", "mb.nama namaBarang", "dsb.jumlahKonversi", "ms.nama namaSatuan"])
			->join("m_barang mb", 'dsb.idBarang=mb.idBarang')
			->join("m_satuan ms", "dsb.idSatuan=ms.idSatuan")
			->join("m_satuan ms1", "mb.satuanTerkecil=ms1.idSatuan")
			->where(array('dsb.idBarang' => $id, 'dsb.status' => 1))->get()->getResult();
	}

	function getCurrentData($id, $idGudang, $idRole)
	{
		$arrayWhere = array('m_barang.idBarang' => $id);
		if ($idRole <> 1) {
			$arrayWhere['IFNULL(idUnit,' . $idGudang . ')'] = $idGudang;
		}
		return $this->select(['m_barang.idBarang', 'mk.idKategoriBarang', 'mk.nama namaKategori', 'm_barang.nama namaBarang', 'IFNULL(stokMinimal,0) stokMinimal', 'satuanTerkecil idSatuanTerkecil', 'ms.nama namaSatuanTerkecil', 'satuanPengadaan idSatuanPengadaan', 'ms1.nama namaSatuanPengadaan', 'mk.status'])
			->join('m_kategoribarang mk', 'm_barang.idKategoriBarang=mk.idKategoriBarang')
			->join("m_satuan ms", "m_barang.satuanTerkecil=ms.idSatuan")
			->join("m_satuan ms1", "m_barang.satuanPengadaan=ms1.idSatuan")
			->join("r_barangunit rb", "m_barang.idBarang=rb.idBarang", 'LEFT')
			->where($arrayWhere)->first();
	}

	function saveData($mainData, $satuanData, $gudangData)
	{ //, $history){

		$this->insert($mainData);
		$lastId = $this->insertID();

		$satuanModel = new \App\Models\barang\DetailSatuanBarangModel();
		foreach ($satuanData as $satuan) {
			$satuan['idBarang'] = $lastId;
			$satuanModel->insert($satuan);
			//$this->db->table('dt_satuanbarang')->insert($satuan);
		}

		foreach ($gudangData as $gudang) {
			$dataG = $gudang;
			$dataG['idBarang'] = $lastId;
			$history = $dataG['history'];

			unset($dataG['history']);
			//$satuanModel->insert($satuan);
			$this->db->table('r_barangunit')->insert($dataG);

			$history['idBarang'] = $lastId;
			$history['tanggal'] = date('Y-m-d');
			$this->db->table('m_stockhistory')->insert($history);
		}
	}

	function updateData($id, $mainData, $satuanData, $gudangData)
	{
		$this->update($id, $mainData);

		foreach ($satuanData as $satuan) {
			if ($satuan['idSatuanBarang'] == 0) {
				$satuan['idBarang'] = $id;
				$this->db->table('dt_satuanbarang')->insert($satuan);
			}
		}

		foreach ($gudangData as $gudang) {
			$data = [];
			$data[] = $gudang['idUnit'];
			$data[] = $id;
			$data[] = $gudang['stokMinimal'];
			$data[] = $gudang['satuanRequest'];
			$data[] = $gudang['estimasiStok'];
			$data[] = $gudang['status'];
			$data[] = $gudang['stokMinimal'];
			$data[] = $gudang['satuanRequest'];
			$data[] = $gudang['estimasiStok'];
			$data[] = $gudang['status'];


			$dt = $this->db
				->table('r_barangUnit')
				->select(['count(*) jumlah'])
				->where(array('idUnit' => $gudang['idUnit'], 'idBarang' => $id))->get()->getResult();

			if ($dt[0]->jumlah < 1) {
				$dataG = $gudang;
				$dataG['idBarang'] = $id;
				$history = $dataG['history'];

				// unset($dataG['history']);
				// //$satuanModel->insert($satuan);
				// $this->db->table('r_barangunit')->insert($dataG);

				$history['idBarang'] = $id;
				$history['tanggal'] = date('Y-m-d');

				$this->db->table('m_stockhistory')->insert($history);
			}

			$sql = "INSERT INTO r_barangunit (idUnit, idBarang, stokMinimal, satuanRequest, estimasiStok, status) VALUES (?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE stokMinimal=?, satuanRequest=?, estimasiStok=?, status=?";

			$result = $this->db->query($sql, $data);
		}
	}

	function generateData($where)
	{
		return $this->db->table('r_barangUnit r')
			->select("m_barang.*, mk.nama namaKategori, ms.nama namaSatuanTerkecil, ms1.nama namaSatuanPengadaan, r.estimasiStok")
			->JOIN('m_barang', 'm_barang.idBarang=r.idBarang')
			->join('m_kategoribarang mk', 'm_barang.idKategoriBarang=mk.idKategoriBarang', 'inner')
			->join('m_satuan ms', 'm_barang.satuanTerkecil=ms.idSatuan')
			->join('m_satuan ms1', 'm_barang.satuanPengadaan=ms1.idSatuan')
			->where($where)->get()->getResult();
	}
}
