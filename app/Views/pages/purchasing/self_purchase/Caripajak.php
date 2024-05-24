<div class="modal fade" id="caripajakmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="min-width:50%">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Cari Pajak</h4>
                <button type="button" class="btn btn-close" data-bs-dismiss="modal">&times;
                </button>
            </div>
            <div class="modal-body">
            <table class="table table-responsive" id="tabelPajak">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Id Pajak</th>
                        <th>Nama Pajak</th>
                        <th>Persen</th>
                        <th>Notes</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>		
                </tbody> 
            </table>
            </div>
            <div class="modal-footer">
                <button type="button" id="okCari" class="btn btn-submit me-2" onclick="tambahPajak()">Ok</button>
                <button type="button" class="btn btn-cancel" onclick="batalCari()" >Batal</button>
            </div>
        </div>
    </div>
</div>
<!--End Modal--> 