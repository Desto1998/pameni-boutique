@extends('layouts.app')
@section('title','| FACTURES')
@section('css_before')
    <link href="{{asset('template/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{asset('template/vendor/sweetalert2/dist/sweetalert2.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('template/vendor/select2/css/select2.min.css')}}">
    <style>
        table thead tr th{
            color: white!important;
        }
        .hide{
            display: none;
        }
    </style>
@stop
@section('content')
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>GESTION DES FACTURES AVOIRS</h4>
                    {{--                    <p class="mb-0">Your business dashboard template</p>--}}
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Factures</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Avoir</a></li>
                </ol>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card px-3">
                    <div class="card-body">
                        <!-- Button trigger modal -->
                        <span class="float-left h4">Liste des factures avoirs</span>
                        <button type="button" class="btn btn-primary float-right align-self-end mb-3"
                                data-toggle="modal"
                                data-target=".bd-example-modal-lg"><i class="fa fa-plus">&nbsp; Ajouter</i></button>

                        <div class="table-responsive">
                            <table id="example" class="display text-center w-100">
                                <thead class="bg-primary">
                                <tr>
                                    <th>#</th>
                                    <th>Refernce</th>
                                    <th>Client</th>
                                    <th>Objet</th>
                                    <th>Date</th>
                                    <th>Ref. Facture</th>
                                    <th>Statut</th>
{{--                                    <th>Mon. HT</th>--}}
                                    <th>Net à déduire</th>
{{--                                    <th>Payé</th>--}}
                                    <th>Par</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>

                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('fature_avoir.modal')
@stop
@section('script')
    <script>
        // delete funtion

        function deleteFun(id) {
            var table = $('#example').DataTable();
            swal.fire({
                title: "Supprimer cette facture?",
                icon: 'question',
                text: "Cette facture sera supprimé de façon définitive.",
                type: "warning",
                showCancelButton: !0,
                confirmButtonText: "Oui, supprimer!",
                cancelButtonText: "Non, annuler !",
                reverseButtons: !0
            }).then(function (e) {
                if (e.value === true) {
                    // if (confirm("Supprimer cette tâches?") == true) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "POST",
                        url: "{{ route('avoir.delete') }}",
                        data: {id: id},
                        dataType: 'json',
                        success: function (res) {
                            if (res) {
                                swal.fire("Effectué!", "Supprimé avec succès!", "success")
                                table.row( $('#deletebtn'+id).parents('tr') )
                                    .remove()
                                    .draw();

                            } else {
                                sweetAlert("Désolé!", "Erreur lors de la suppression!", "error")
                            }

                        },
                        error: function (resp) {
                            sweetAlert("Désolé!", "Une erreur s'est produite.", "error");
                        }
                    });
                } else {
                    e.dismiss;
                }
            }, function (dismiss) {
                return false;
            })
            // }
        }

        // ajouter un paiement
        {{--$("#modal-form").on("submit", function (event) {--}}
        {{--    event.preventDefault();--}}
        {{--    swal.fire({--}}
        {{--        title: "Voulez-vous enregistre ce paiement?",--}}
        {{--        icon: 'question',--}}
        {{--        text: "Vous pouvez le modifier plus tard dans les details.",--}}
        {{--        type: "warning",--}}
        {{--        showCancelButton: !0,--}}
        {{--        confirmButtonText: "Oui, Continuer!",--}}
        {{--        cancelButtonText: "Non, annuler !",--}}
        {{--        reverseButtons: !0--}}
        {{--    }).then(function (e) {--}}
        {{--        if (e.value === true) {--}}
        {{--            $.ajaxSetup({--}}
        {{--                headers: {--}}
        {{--                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
        {{--                }--}}
        {{--            });--}}
        {{--            $('#modal-form .btn-primary').attr("disabled", true).html("En cours...")--}}
        {{--            var data = $('#modal-form').serialize()--}}
        {{--            $.ajax({--}}
        {{--                type: "POST",--}}
        {{--                url: "{{ route('factures.paiement.store') }}",--}}
        {{--                data: data,--}}
        {{--                dataType: 'json',--}}
        {{--                success: function (res) {--}}
        {{--                    console.log(res);--}}
        {{--                    if (res) {--}}
        {{--                        toastr.success("Enregistré avec succès.", "Effectué!")--}}

        {{--                        $('#modal-form .btn-primary').attr("disabled", false).html("Enregistrer")--}}
        {{--                        $('#modal-form')[0].reset()--}}
        {{--                        $('#paiement-modal').modal('hide');--}}
        {{--                        loadFactures()--}}

        {{--                    }--}}
        {{--                    if (res === [] || res === undefined || res == null) {--}}
        {{--                        toastr.error("Erreur lors de l'enregistrement.", "Désolé!",)--}}
        {{--                        $('#modal-form .btn-primary').attr("disabled", false).html("Enregistrer")--}}
        {{--                    }--}}

        {{--                },--}}
        {{--                error: function (resp) {--}}
        {{--                    sweetAlert("Désolé!", "Une erreur s'est produite. Actualisez la page et reessayez.", "error");--}}
        {{--                    $('#modal-form .btn-primary').attr("disabled", false).html("Enregistrer")--}}
        {{--                }--}}
        {{--            });--}}
        {{--        } else {--}}

        {{--            $('#modal-form .btn-primary').attr("disabled", false).html("Enregistrer")--}}
        {{--            $('#paiement-modal').modal('hide');--}}
        {{--            e.dismiss;--}}
        {{--        }--}}
        {{--    }, function (dismiss) {--}}
        {{--        $('#modal-form .btn-primary').attr("disabled", false).html("Enregistrer")--}}
        {{--        $('#paiement-modal').modal('hide');--}}
        {{--        return false;--}}
        {{--    })--}}

        {{--});--}}

        // fonction qui charge les produits : les elements du tableau
        function loadAvoir() {
            $('#example').dataTable().fnClearTable();
            $('#example').dataTable().fnDestroy();
            // $("#example").DataTable.destroy();
            $("#example")
                .on( 'error.dt', function ( e, settings, techNote, message ) {
                    alert('Erreur delai d\'attente expire, veillez actualiser la page.')
                    console.log( 'An error has been reported by DataTables: ', message );
                    console.log(e, settings, techNote,)
                } )
                .DataTable({
                Processing: true,
                searching: true,
                LengthChange: true, // desactive le module liste deroulante(d'affichage du nombre de resultats par page)
                iDisplayLength: 10, // Configure le nombre de resultats a afficher par page a 10
                bRetrieve: true,
                stateSave: true,
                ajaxSetup:{
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                ajax:{
                    url: "{{ route('avoir.loadAll',['id'=>-1]) }}",
                },

                columns: [
                    {data: 'DT_RowIndex',name:'DT_RowIndex'},
                    {data: 'reference_avoir',name:'reference_avoir'},
                    {data: 'client',name:'client'},
                    {data: 'objet',name:'objet'},
                    {data: 'date_avoir',name:'date_avoir'},
                    {data: 'facture',name:'facture'},
                    {data: 'statut',name:'statut'},
                    // {data: 'montantHT',name:'montantHT'},
                    {data: 'montantTTC',name:'montantTTC'},
                    // {data: 'paye',name:'paye'},
                    {data: 'firstname',name:'firstname'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},

                ],
                order: []
            })

        }

        $(document).ready(function () {
            loadAvoir();
        });

        // cette fonction defini un devis comme valide
        function validerFun(id) {
            swal.fire({
                title: "Valider cette facture?",
                icon: 'question',
                text: "Les produit de cette facture seront retourné en stock. Cette opération est irreversible",
                type: "warning",
                showCancelButton: !0,
                confirmButtonText: "Oui, valider!",
                cancelButtonText: "Non, annuler !",
                reverseButtons: !0
            }).then(function (e) {
                if (e.value === true) {
                    // if (confirm("Supprimer cette tâches?") == true) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "POST",
                        url: "{{ route('avoir.valider') }}",
                        data: {id: id},
                        dataType: 'json',
                        success: function (res) {
                            if (res) {
                                swal.fire("Effectué!", "Validé avec succès!", "success")
                                // toastr.success("Validé avec succès!");
                                loadAvoir();

                            } else {
                                sweetAlert("Désolé!", "Erreur lors de la validation!", "error")
                            }

                        },
                        error: function (resp) {
                            sweetAlert("Désolé!", "Une erreur s'est produite. Actulisez la page et reessayez", "error");
                        }
                    });
                } else {
                    e.dismiss;
                }
            }, function (dismiss) {
                return false;
            })
            // }
        }
        // cette fonction defini un devis comme Non valider
        function bloquerFun(id) {
            swal.fire({
                title: "Bloquer cette facture?",
                icon: 'question',
                text: "Il ne sera pas possible d'imprimer.",
                type: "warning",
                showCancelButton: !0,
                confirmButtonText: "Oui, bloquer!",
                cancelButtonText: "Non, annuler !",
                reverseButtons: !0
            }).then(function (e) {
                if (e.value === true) {
                    // if (confirm("Supprimer cette tâches?") == true) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "POST",
                        url: "{{ route('avoir.bloquer') }}",
                        data: {id: id},
                        dataType: 'json',
                        success: function (res) {
                            if (res) {
                                swal.fire("Effectué!", "Bloqué avec succès!", "success")
                                // toastr.success("Bloqué avec succès!");
                                loadAvoir();

                            } else {
                                sweetAlert("Désolé!", "Erreur lors de l'opération!", "error")
                            }

                        },
                        error: function (resp) {
                            sweetAlert("Désolé!", "Une erreur s'est produite. Actulisez la page et reessayez", "error");
                        }
                    });
                } else {
                    e.dismiss;
                }
            }, function (dismiss) {
                return false;
            })
            // }
        }
        $('.facture').on('change',function (e){
            var id = $('select[name="idfacture"]').val();
            // var id = $('.facture').val();
           // $('input [name="checkbox"]').each().prop('checked',false);
            $('.produit_f_id').prop('checked',false);
            $('.f-product-block').hide(800);
            $('#f-product-block'+id).show(800);
            $('#montantNet').val(0);
        })
        $('.produit_f_id').on('change', function (e){
            calulNetAPayer();
        })
        $('.quantite').on('change', function (e){
            calulNetAPayer();
        })
        // store function on form submit
        $('#newAvoir-form').on('submit', function (e){
            e.preventDefault();
            swal.fire({
                title: "Voulez-vous enregistrer cette facture avoir?",
                icon: 'question',
                text: "Cette opération est irreversible.",
                type: "warning",
                showCancelButton: !0,
                confirmButtonText: "Oui, Continuer!",
                cancelButtonText: "Non, annuler !",
                reverseButtons: !0
            }).then(function (e) {
                if (e.value === true) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $('#newAvoir-form #register-btn').attr("disabled", true).html("En cours...")
                    var data = $('#newAvoir-form').serialize()
                    console.log(data);
                    $.ajax({
                        type: "POST",
                        url: "{{ route('avoir.store') }}",
                        data: data,
                        dataType: 'json',
                        success: function (res) {
                            console.log(res);
                            if (res){
                                // swal.fire("Effectué!", "Enregistré avec succès!", "success")


                                $('#newAvoir-form #register-btn').attr("disabled", false).html("Enregistrer")
                                $('#newAvoir-form')[0].reset();
                                $('.bd-example-modal-lg').modal('hide');
                                // $('#single-select');
                                $('#single-select').val(null).trigger('change').select2();
                                loadAvoir();

                                swal.fire({
                                    icon: 'success',
                                    title: 'Effectué avec succès',
                                    text: "L'opération s'est bien terminé!",
                                    footer: '<a href="/dashboard/avoir/print/'+res.avoir_id+'" target="_blank"><i class="fa fa-eye"></i> Cliquer pour voir la facture avoir.</a>'
                                });

                            }else {
                                sweetAlert("Désolé!", "Erreur lors de l'enregistrement!", "error");
                                $('#newAvoir-form #register-btn').attr("disabled", false).html("Enregistrer");
                            }


                        },
                        error: function (resp) {
                            console.log(resp);
                            sweetAlert("Désolé!", "Une erreur s'est produite.", "error");
                            $('#newAvoir-form #register-btn').attr("disabled", false).html("Enregistrer");
                        }
                    });
                } else {

                    $('#newAvoir-form #register-btn').attr("disabled", false).html("Enregistrer");
                    $('.bd-example-modal-lg').modal('hide');
                    e.dismiss;
                }
            }, function (dismiss) {
                $('#newAvoir-form #register-btn').attr("disabled", false).html("Enregistrer");
                $('.bd-example-modal-lgl').modal('hide');
                return false;
            })
        });
        function calulNetAPayer(){
            var T_ID = [];
            // $('#montantNet').val(0);
            var total = 0;
            // var remise = 0;
            var tva_statut = $('tva_statut'+$('select[name="idfacture"]').val()).val();
            var tva = 0;
            $('input:checkbox[name="produit_f_id[]"]:checked').each(function(){
                T_ID.push($(this).val());
                var id = $(this).val();
                var remise = $('#remise'+id).val();
                var prix = $('#prix'+id).val();
                var qte = $('#qte'+id).val();
                remise = parseFloat(remise) * parseFloat(prix) * parseInt(qte)/100;
                total += -remise + prix * qte;
            });
            if (parseInt(tva_statut)===1){
                var mtva = (total *19.25)/100;
                total += mtva;
            }
            console.log(T_ID);
            $('#montantNet').val(Number(total).toFixed(2));
        }

    </script>
{{--    @include('facture.comon_script')--}}
    <!-- Datatable -->
    <script src="{{asset('template/vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('template/js/plugins-init/datatables.init.js')}}"></script>
    <script src="{{asset('template/vendor/sweetalert2/dist/sweetalert2.min.js')}}"></script>
    <!-- Selet search -->
    <script src="{{asset('template/vendor/select2/js/select2.full.min.js')}}"></script>
    <script src="{{asset('template/js/plugins-init/select2-init.js')}}"></script>

@stop
