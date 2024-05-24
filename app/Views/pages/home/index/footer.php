<script>
    $(document).ready(function(){
        refreshTop();
    });

    function refreshTop(){
        $.ajax({
            type: "post",
            url: "<?= site_url('Unit/getUnits/0') ?>",

            dataType: "json",
            success: function(response){
                if (response.success == true){
                    var data = response.result.data;
                    $("#jumlahUnit").html(data.length); 
                }
            }
        });

        $.ajax({
            type: "post",
            url: "<?= site_url('Unit/client') ?>",

            dataType: "json",
            success: function(response) {
                    var data = response;
                    $("#jumlahKlien").html(data[0].jumlah);
            }
        });

        $.ajax({
            type: "post",
            url: "<?= site_url('Permintaanbarang/jumlah') ?>",

            dataType: "json",
            success: function(response){
                    var data = response; 
                    $("#jumlahPermintaan").html(data[0].jumlah);
            }
        });

        $.ajax({
            type: "post",
            url: "<?= site_url('Databarang/jumlah') ?>",

            dataType: "json",
            success: function(response){
                    var data = response; 
                    $("#jenisBarang").html(data[0].jumlah);
            }
        });
    }
</script>