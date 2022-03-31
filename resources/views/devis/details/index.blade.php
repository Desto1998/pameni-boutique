@extends('layouts.app')
@section('title','| DEVIS-DETAILS')
@section('css_before')
    <link href="{{asset('template/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{asset('template/vendor/sweetalert2/dist/sweetalert2.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('template/vendor/select2/css/select2.min.css')}}">
    <style>
        table thead tr th {
            color: white !important;
        }
    </style>
@stop
@section('content')
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>DETAILS DEVIS "{{ $data[0]->reference_devis }}"</h4>
                    {{--                    <p class="mb-0">Your business dashboard template</p>--}}
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Devis</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">{{ $data[0]->reference_devis }}</a>
                    </li>
                </ol>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card px-3">
                    <div class="card-body">
                        <div class="default-tab">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#detail">Details</a>
                                </li>
                                {{--                                <li class="nav-item">--}}
                                {{--                                    <a class="nav-link" data-toggle="tab" href="#profile">Produits({{ count($pocedes) }})</a>--}}
                                {{--                                </li>--}}
                                {{--                                <li class="nav-item">--}}
                                {{--                                    <a class="nav-link" data-toggle="tab" href="#paiement">Paiements({{ count($paiements) }})</a>--}}
                                {{--                                </li>--}}
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab"
                                       href="#message">Commentaires({{ count($commentaires) }})</a>
                                </li>
                            </ul>
                            <div class="d-flex justify-content-end mt-2">
                                @if (Auth::user()->is_admin==1 || $value->statut <=1)
                                    @if(Auth::user()->is_admin==1 || Auth::user()->id===$data[0]->id)
                                        <a href="{{ route('devis.edit',['id'=>$data[0]->devis_id]) }}"
                                           title="Editer ce devis" class="btn btn-sm btn-warning"><i
                                                class="fa fa-edit"></i></a>
                                    @endif
                                @endif

                                <a href="{{ route('devis.print',['id'=>$data[0]->devis_id]) }}"
                                   title="Imprimer ce devis" target="_blank" class="btn btn-sm btn-light ml-2"><i
                                        class="fa fa-print"></i></a>

                            </div>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="detail" role="tabpanel">
                                    <div class="pt-4">
                                        @include('devis.details.detail')
                                    </div>
                                </div>
                                {{--                                <div class="tab-pane fade" id="paiement">--}}
                                {{--                                    <div class="pt-4">--}}
                                {{--                                        @include('facture.details.paiement')--}}
                                {{--                                    </div>--}}
                                {{--                                </div>--}}
                                <div class="tab-pane fade" id="message">
                                    <div class="pt-4">
                                        @include('devis.details.comments')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('facture.modal')
@endsection
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
                        url: "{{ route('factures.delete') }}",
                        data: {id: id},
                        dataType: 'json',
                        success: function (res) {
                            if (res) {
                                swal.fire("Effectué!", "Supprimé avec succès!", "success")
                                table.row($('#deletebtn' + id).parents('tr'))
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


        // cette fonction defini un devis comme valide
        function validerFun(id) {
            swal.fire({
                title: "Valider cette facture?",
                icon: 'question',
                text: "Elle ne sera plus modifiable aprés validation.",
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
                        url: "{{ route('factures.valider') }}",
                        data: {id: id},
                        dataType: 'json',
                        success: function (res) {
                            if (res) {
                                swal.fire("Effectué!", "Validé avec succès!", "success")
                                // toastr.success("Validé avec succès!");
                                loadFactures();

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
                        url: "{{ route('factures.bloquer') }}",
                        data: {id: id},
                        dataType: 'json',
                        success: function (res) {
                            if (res) {
                                swal.fire("Effectué!", "Bloqué avec succès!", "success")
                                // toastr.success("Bloqué avec succès!");
                                loadDevis();

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

        function getId(id) {
            $('#modal-form #idfacture').val(id);

        }

        // ajouter un paiement
        $("#modal-form").on("submit", function (event) {
            event.preventDefault();
            swal.fire({
                title: "Voulez-vous enregistre ce paiement?",
                icon: 'question',
                text: "Vous pouvez le modifier plus tard dans les details.",
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
                    $('#modal-form .btn-primary').attr("disabled", true).html("En cours...")
                    var data = $('#modal-form').serialize()
                    $.ajax({
                        type: "POST",
                        url: "{{ route('factures.paiement.store') }}",
                        data: data,
                        dataType: 'json',
                        success: function (res) {
                            console.log(res);
                            if (res) {
                                toastr.success("Enregistré avec succès.", "Effectué!")

                                $('#modal-form .btn-primary').attr("disabled", false).html("Enregistrer")
                                $('#modal-form')[0].reset()
                                $('#paiement-modal').modal('hide');
                                loadFactures()

                            }
                            if (res === [] || res === undefined || res == null) {
                                toastr.error("Erreur lors de l'enregistrement.", "Désolé!",)
                                $('#modal-form .btn-primary').attr("disabled", false).html("Enregistrer")
                            }

                        },
                        error: function (resp) {
                            sweetAlert("Désolé!", "Une erreur s'est produite. Actualisez la page et reessayez.", "error");
                            $('#modal-form .btn-primary').attr("disabled", false).html("Enregistrer")
                        }
                    });
                } else {

                    $('#modal-form .btn-primary').attr("disabled", false).html("Enregistrer")
                    $('#paiement-modal').modal('hide');
                    e.dismiss;
                }
            }, function (dismiss) {
                $('#modal-form .btn-primary').attr("disabled", false).html("Enregistrer")
                $('#paiement-modal').modal('hide');
                return false;
            })

        });

        function closeComment() {
            $('.commentForm').hide(200);
        }

        function edtiComment(id) {
            $('.commentForm').hide(200);
            $('#commentForm' + id).show(200);
        }

        function deleteComment(id) {
            if (confirm("Supprimer ce commentaire?") === true) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: "{{ route('comment.delete') }}",
                    data: {id: id},
                    dataType: 'json',
                    success: function (res) {
                        if (res) {
                            toastr.success("Supprimé avec succès!");
                            window.location.reload(200);

                        } else {
                            toastr.error("Une erreur s'est produite!");
                        }

                    }
                });
            }
        }

        $("#modal-form").on("submit", function (event) {
            event.preventDefault();
            swal.fire({
                title: "Voulez-vous enregistre ce paiement?",
                icon: 'question',
                text: "Vous pouvez le modifier plus tard dans les details.",
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
                    $('#modal-form .btn-primary').attr("disabled", true).html("En cours...")
                    var data = $('#modal-form').serialize()
                    $.ajax({
                        type: "POST",
                        url: "{{ route('factures.paiement.store') }}",
                        data: data,
                        dataType: 'json',
                        success: function (res) {
                            console.log(res);
                            if (res) {
                                toastr.success("Enregistré avec succès.", "Effectué!")

                                $('#modal-form .btn-primary').attr("disabled", false).html("Enregistrer")
                                $('#modal-form')[0].reset()
                                $('#paiement-modal').modal('hide');
                                window.location.reload();

                            }
                            if (res === [] || res === undefined || res == null) {
                                toastr.error("Erreur lors de l'enregistrement.", "Désolé!",)
                                $('#modal-form .btn-primary').attr("disabled", false).html("Enregistrer")
                            }

                        },
                        error: function (resp) {
                            sweetAlert("Désolé!", "Une erreur s'est produite. Actualisez la page et reessayez.", "error");
                            $('#modal-form .btn-primary').attr("disabled", false).html("Enregistrer")
                        }
                    });
                } else {

                    $('#modal-form .btn-primary').attr("disabled", false).html("Enregistrer")
                    $('#paiement-modal').modal('hide');
                    e.dismiss;
                }
            }, function (dismiss) {
                $('#modal-form .btn-primary').attr("disabled", false).html("Enregistrer")
                $('#paiement-modal').modal('hide');
                return false;
            })

        });

        function deletePaiement(id) {
            swal.fire({
                title: "Supprimer ce?",
                icon: 'question',
                text: "Ce paiement sera supprimé de façon définitive.",
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
                        url: "{{ route('factures.paiement.delete') }}",
                        data: {id: id},
                        dataType: 'json',
                        success: function (res) {
                            if (res) {
                                swal.fire("Effectué!", "Supprimé avec succès!", "success")
                                window.location.reload();
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
    </script>
    <!-- Datatable -->
    <script src="{{asset('template/vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('template/js/plugins-init/datatables.init.js')}}"></script>
    <script src="{{asset('template/vendor/sweetalert2/dist/sweetalert2.min.js')}}"></script>
    <!-- Selet search -->
    <script src="{{asset('template/vendor/select2/js/select2.full.min.js')}}"></script>
    <script src="{{asset('template/js/plugins-init/select2-init.js')}}"></script>

@endsection
