<script src="<?= base_url('assets/plugins/sweetalert/sweetalert2.all.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/sweetalert/sweetalerts.min.js') ?>"></script>
<script src="<?= base_url('assets/js/moment.min.js') ?>"></script>
<script src="<?= base_url('assets/js/bootstrap-datetimepicker.min.js') ?>"></script>
<script src="<?= base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/js/dataTables.bootstrap4.min.js') ?>"></script>
<script src="<?= base_url('assets/js/dataTables.select.min.js') ?>"></script>
<!-- <script src="<?= base_url('assets/js/select.dataTables.min.js') ?>"></script> -->
<script src="<?= base_url('assets/plugins/select2/js/select2.min.js') ?>"></script>

<script>
    $('#assign').select2({
        placeholder: "Pilih Unit",
        disabled: false,
        ajax: {
            url: "<?= site_url('Unit/select') ?>",
            dataType: 'json',
            method: 'get',
            data: function(term, page) {
                return {
                    q: term, //Search Term
                };
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(item) {
                        return {
                            text: item.nama,
                            id: item.id
                        }
                    })
                };
            }
        }
    });

    var listUnit = [];
    var tabelUnit = null;

    function tambahUnit() {
        idUnit = $("#assign option:selected").val();
        namaUnit = $("#assign option:selected").text();

        listUnit.push({
            idUnit: idUnit,
            nama: namaUnit,
            status: 1 
        });

        console.log(listUnit);
        initTable();

        // const formInput = document.querySelectorAll('#assign');
    }

    function initTable() {
        tabelUnit = $('#tabelUnit').DataTable({
            "processing": true,
            "serverSide": false,
            "autoWidth": false,
            "responsive": true,
            "bfilter": true,
            "sDom": 'ftlp',
            "paging": false,
            //"scrollY": '200px',
            "scrollCollapse": false,
            "ordering": false,
            "aaData": listUnit,
            "aoColumns": [{
                "data": "idUnit"
            }, {
                "data": "nama"
            },{
                "data": "status",
                "mRender": function (data, type, row) {
                   var hasil = '<a href="#" class="btn btn-sm btn-danger text-light">Tidak Aktif</a>';
                   if(data==1){
                    hasil = '<a href="#" class="btn btn-sm btn-success text-light">Aktif</a>';
                   }
                   return hasil;
                }
            }],
            "columnDefs": [{
                "targets": [3],
                "data": null,
                "defaultContent": '<div class="me-3"><button type="button" class="btn btn-delete"><img src="<?= base_url('assets/img/icons/delete.svg') ?>" alt="img"></button></div>'
            },{
                "targets": [0],
                "visible": false
            }],
            "bDestroy": true
        });

        $('#tabelUnit').on('click', '.btn-delete', function() {
            var data = tabelUnit.row($(this).parents('tr')).data();
            if (data == null) return;
            var found = 0;
            for (let i = 0; i < listUnit.length; i++) {
                if (listUnit[i]['idUnit'] == data['idUnit']) {
                    listUnit[i]['status'] = 0; 
                }
            };
            initTable();
        });
    }

    function Assignsimpan() {
        var formData = {};
        var dataId = $("#AssigndataId").val();
        var unitid = $("#assign").val();
         
        Swal.fire({
            title: "Apakah anda ingin menyimpan?",
            icon: "question",
            showCancelButton: !0,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Simpan",
            cancelButtonText: "Tidak",
            customClass: {
                confirmButton: "btn btn-primary",
                cancelButton: "btn btn-danger ml-1"
            },
            heightAuto: false,
            width: '30em',
            allowOutsideClick: false,
            allowEscapeKey: false,
            buttonsStyling: !1
        }).then((result) => {
            if (result.isConfirmed) {
                //window.history.back();
                $.ajax({
                    type: "POST",
                    url: "<?= base_url("UnitGudang") ?>",
                    data: {
                        idGudang: dataId,
                        listUnit: listUnit
                    },
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
                        if (response.isSuccess == true) {
                            Swal.fire({
                                title: "Data Assign Berhasil Tersimpan",
                                icon: "success",
                                customClass: {
                                    confirmButton: "btn btn-outline-success"
                                },
                                heightAuto: false,
                                width: '30em',
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                buttonsStyling: !1
                            }).then(function() {
                                window.history.back();
                            });
                        }
                    }
                });
            }
        })
    }

    function Assignbatal() {
        Swal.fire({
            title: "Apakah anda yakin?",
            text: "Anda akan keluar",
            icon: "warning",
            showCancelButton: !0,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, Batal input",
            cancelButtonText: "Tidak",
            customClass: {
                confirmButton: "btn btn-primary",
                cancelButton: "btn btn-danger ml-1"
            },
            heightAuto: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
            width: '30em',
            buttonsStyling: !1
        }).then((result) => {
            if (result.isConfirmed) {
                window.history.back();
            }
        })
    }

    $(document).ready(function() {
        var path = window.location.pathname.toString();
        var paths = path.split("/");

        if (paths.length == 5) {
            $.ajax({
                type: "post",
                url: "<?= site_url('Unit/getUnits/') ?>" + paths[4],

                dataType: "json",
                success: function(response) {
                    if (response.success == true) {
                        var data = response.result.data;
                        console.log(data);
                        data.forEach(function(d) {
                            listUnit.push({ //push into array
                                idUnit: d.idUnit,
                                nama: d.namaUnit,
                                status: d.status
                            });
                        });
                        console.log(listUnit);
                        initTable();
                    }
                }
            });
        }
    });
</script>