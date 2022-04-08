<script>

    function getId(id) {
        $('#modal-form #idfacture').val(id);
    }

    // function checkMontant()
    $('#montant').on('blur', function (e) {
        var id = $('#idfacture').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            url: "{{ route('factures.checkAmount') }}",
            data: {id: id},
            dataType: 'json',
            success: function (res) {
                if (res) {
                    if (res>=$('#montant').val()){
                        $('#montant').attr({"max": res});
                        $('#alert').html('<label class="text-success" id="notValidAmount">Montant accepté <i class="fa fa-check"></i></label>').show(500);
                    }else {
                        $('#alert').html('<label class="text-danger" id="ValidAmount"><i class="fa fa-close"></i> Montant non acceptabel  il doit être inférieure ou égale à <strong>' + res+' </strong></label>' ).show(500);
                        $('#montant').attr({"max": res});
                    }
                    //$('#notValidAmount').hide(500)

                   // $('#ValidAmount').show(500)
                }
            },
            error: function (resp) {
                return false;
            }
        });
    });
</script>
