<script>
    $(document).ready(function(){
        refreshTop();
    });

    function refreshTop(){
        $.ajax({
            type: "post",
            url: "<?= site_url('Permintaanbarang/jumlah') ?>",

            dataType: "json",
            success: function(response){
                var data = response; 
                $("#jumlahPermintaan").html(data[0].jumlah);
            }
        });
    }
</script>