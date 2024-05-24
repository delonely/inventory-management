<link rel="stylesheet" href="<?=base_url('assets/css/dataTables.bootstrap4.min.css')?>">
<!-- <link rel="stylesheet" href="<=base_url('assets/css/jquery.dataTables.min.css')?>"> -->
<link rel="stylesheet" href="<?=base_url('assets/css/select.dataTables.min.css')?>">
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Form Assignment</h4>
                <h6>Silahkan Assign Unit</h6>
            </div>
        </div>
        <form id="formSimpanAssign" class="row g-3 needs-validation" novalidate>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Nama Unit</label>
                                <div class="row">
                                    <div class="col-lg-11 col-sm-10 col-12">
                                        <input type="text" name="Assignnama" id="Assignnama" class="form-control" value="<?=$dataUnit->nama;?>" disabled>
                                    </div>
                                    <input type="hidden" name="AssigndataId" id="AssigndataId" value="<?=$dataUnit->idUnit;?>" />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-12">
                            <div class="form-group">
                                <label>Assign Unit</label>
                                <div class="row">
                                    <div class="col-lg-10 col-sm-10 col-10">
                                        <select name="assign" id="assign" class="select2-selection__rendered" aria-label="assign select" required>
                                            <option></option>
                                        </select>
                                        <div class="valid-feedback">Nama Unit Terpilih.</div>
                                        <div class="invalid-feedback">Mohon Assign Unit.</div>
                                    </div>
                                    <div class="col-lg-2 col-sm-2 col-2 ps-0">
                                        <div class="add-icon">
                                            <a href="javascript:void(0);"><img src="<?=base_url('assets/img/icons/plus1.svg')?>" alt="img" onclick="tambahUnit()"></a>
                                        </div>
                                        </div>
                                </div>
                              
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="card-body">
            <div class="row">
                <div class="table-responsive">
                    <table id="tabelUnit" class="table datanew table-striped table-bordered" >
                        <thead>
                            <tr>
                                <th>Id Unit</th>
                                <th>Nama Unit</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
                <div class="col-lg-12">
                    <button type="button" class="btn btn-submit me-2" onclick="Assignsimpan()">Simpan</button>
                    <button type="button" class="btn btn-cancel" onclick="Assignbatal()">Batal</button>
                </div>
            </div>
        </div>
    </div>
</div>