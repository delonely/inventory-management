<?php

namespace App\Models;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\Model;

class BaseModel extends Model
{

    protected $db;
    protected $dt;
    protected $request;

    function _alterConnection(RequestInterface $request, $mode)
    {
        $this->db = db_connect();
        $this->request = $request;
        $this->dt = $this->db->table($this->table);
    }

    /** Fungsi untuk datatables */
    function get_datatables(RequestInterface $request, $where, $mode = 0)
    {
        $this->_alterConnection($request, $mode);
        $this->_get_datatables_query();

        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));

        $this->dt->where($where);
        $query = $this->dt->get();
        return $query->getResult();
    }

    private function _get_datatables_query()
    {
        $i = 0;
        foreach ($this->column_search as $item) {
            if ($this->request->getPost('search') != null) {
                if ($this->request->getPost('search')['value']) {
                    if ($i === 0) {
                        $this->dt->groupStart();
                        $this->dt->like($item, $this->request->getPost('search')['value']);
                    } else {
                        $this->dt->orLike($item, $this->request->getPost('search')['value']);
                    }
                    if (count($this->column_search) - 1 == $i)
                        $this->dt->groupEnd();
                }
            }
            $i++;
        }

        if ($this->request->getPost('order')) {
            $this->dt->orderBy($this->column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->dt->orderBy(key($order), $order[key($order)]);
        }
    }


    function count_filtered(RequestInterface $request, $where, $mode = 0)
    {
        $this->_alterConnection($request, $mode);
        $this->_get_datatables_query();

        $this->dt->where($where);
        return $this->dt->countAllResults();
    }

    public function count_all(RequestInterface $request, $where, $mode = 0)
    {
        $this->_alterConnection($request, $mode);
        $tbl_storage = $this->dt->where($where);
        // $tbl_storage = $this->db->table($this->table)
        //     ->where($where);
        return $tbl_storage->countAllResults();
    }

    /** End Keperluan Datatables */
}
