 <div class="modal fade" id="carimodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="min-width:100%">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Cari Barang</h4>
                <button type="button" class="btn btn-close" data-bs-dismiss="modal">&times;
                </button>
            </div>
            <div class="modal-body">
            <table class="table table-responsive" id="tableBarang">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Id Barang</th>
                        <th>Id Kategori</th>
                        <th>kategori Barang</th>
                        <th>Nama Barang</th> 
                        <th>Stok</th>
                        <th>ID Satuan Pengadaan</th>
                        <th>ID Satuan Terkecil</th>
                        <th>Satuan Terkecil</th>
                        <th>Satuan Pengadaan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>		
                </tbody> 
            </table>
            </div>
            <div class="modal-footer">
                <button type="button" id="okCari" class="btn btn-submit me-2" onclick="okCari()">Ok</button>
                <button type="button" class="btn btn-cancel" onclick="batalCari()" >Batal</button>
            </div>
        </div>
    </div>
</div>
<!--End Modal--> 