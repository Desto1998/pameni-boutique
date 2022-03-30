@extends('layouts.app')
@section('title','| COMMANDES-DETAILS')
@section('css_before')
    <link href="{{asset('template/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{asset('template/vendor/sweetalert2/dist/sweetalert2.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('template/vendor/select2/css/select2.min.css')}}">
    <style>
        table thead tr th{
            color: white!important;
        }
    </style>
@stop
@section('content')
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>DETAILS COMMANDE "{{ $data[0]->reference_commande }}"</h4>
                    {{--                    <p class="mb-0">Your business dashboard template</p>--}}
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Commandes</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">{{ $data[0]->reference_commande }}</a></li>
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
                                    <a class="nav-link" data-toggle="tab" href="#message">Commentaires({{ count($commentaires) }})</a>
                                </li>
                            </ul>
                            <div class="d-flex justify-content-end mt-2">
                                <a href="{{ route('commandes.edit',['id'=>$data[0]->commande_id]) }}" title="Editer cette commande" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
                                <a href="{{ route('commandes.print',['id'=>$data[0]->commande_id]) }}" title="Imprimer cette commande" target="_blank" class="btn btn-sm btn-light ml-2"><i class="fa fa-print"></i></a>
                            </div>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="detail" role="tabpanel">
                                    <div class="pt-4">
                                        @include('commande.details.detail')
                                    </div>
                                </div>
                                {{--                                <div class="tab-pane fade" id="paiement">--}}
                                {{--                                    <div class="pt-4">--}}
                                {{--                                        @include('facture.details.paiement')--}}
                                {{--                                    </div>--}}
                                {{--                                </div>--}}
                                <div class="tab-pane fade" id="message">
                                    <div class="pt-4">
                                        @include('commande.details.comments')
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
                        url: "{{ route('commandes.valider') }}",
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
                        url: "{{ route('commandes.bloquer') }}",
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
    </script>
    <!-- Datatable -->
    <script src="{{asset('template/vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('template/js/plugins-init/datatables.init.js')}}"></script>
    <script src="{{asset('template/vendor/sweetalert2/dist/sweetalert2.min.js')}}"></script>
    <!-- Selet search -->
    <script src="{{asset('template/vendor/select2/js/select2.full.min.js')}}"></script>
    <script src="{{asset('template/js/plugins-init/select2-init.js')}}"></script>

@endsection
