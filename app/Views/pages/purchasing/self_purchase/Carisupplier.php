<div class="modal fade" id="carisuppliermodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="min-width:70%">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Cari Supplier</h4>
                <button type="button" class="btn btn-close" data-bs-dismiss="modal">&times;
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-responsive" id="tabelSupp">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Id Supplier</th>
                            <th>Nama Supplier</th>  
                            <th>Kategori Supplier</th> 
                            <th>Alamat</th>  
                            <th>No Telepon</th>   
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>		
                    </tbody> 
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" id="okCari" class="btn btn-submit me-2" onclick="tambahSupp()">Ok</button>
                <button type="button" class="btn btn-cancel" onclick="batalCari()" >Batal</button>
            </div>
        </div>
    </div>
</div>
<!--End Modal--> 