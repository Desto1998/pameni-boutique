<script>

    function getId(id) {
        $('#modal-form #idcommande').val(id);
    }
    $('#select-currency').on('change', function (e){
        if ($('#select-currency').val()!="FCFA"){
            $('.for-amount').show(500);
            $('#montant').attr('required',true);
        }else {
            $('#montant').attr('required',false);
            $('.for-amount').hide(500);
        }
    });
    {{--// ajouter un paiement--}}
    {{--$("#modal-form").on("submit", function (event) {--}}

    {{--    $.ajaxSetup({--}}
    {{--        headers: {--}}
    {{--            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
    {{--        }--}}
    {{--    });--}}
    {{--    $('#modal-form .btn-primary').attr("disabled", true).html("En cours...")--}}
    {{--    var data = $('#modal-form').serialize()--}}
    {{--    $.ajax({--}}
    {{--        type: "POST",--}}
    {{--        url: "{{ route('factures.paiement.store') }}",--}}
    {{--        data: data,--}}
    {{--        dataType: 'json',--}}
    {{--        success: function (res) {--}}
    {{--            console.log(res);--}}
    {{--            if (res) {--}}
    {{--                toastr.success("Enregistré avec succès.", "Effectué!")--}}

    {{--                $('#modal-form .btn-primary').attr("disabled", false).html("Enregistrer")--}}
    {{--                $('#modal-form')[0].reset()--}}
    {{--                $('#paiement-modal').modal('hide');--}}
    {{--                loadFactures()--}}

    {{--            }--}}
    {{--            if (res === [] || res === undefined || res == null) {--}}
    {{--                toastr.error("Erreur lors de l'enregistrement.", "Désolé!",)--}}
    {{--                $('#modal-form .btn-primary').attr("disabled", false).html("Enregistrer")--}}
    {{--            }--}}

    {{--        },--}}
    {{--        error: function (resp) {--}}
    {{--            sweetAlert("Désolé!", "Une erreur s'est produite. Actualisez la page et reessayez.", "error");--}}
    {{--            $('#modal-form .btn-primary').attr("disabled", false).html("Enregistrer")--}}
    {{--        }--}}
    {{--    });--}}

    {{--});--}}
</script>
