@extends('layouts.app')
@section('title','| FACTURES-EDIT')
@section('css_before')
    <link rel="stylesheet" href="{{asset('template/vendor/select2/css/select2.min.css')}}">
    <link href="{{asset('template/vendor/sweetalert2/dist/sweetalert2.min.css')}}" rel="stylesheet">

    <style>
        .hidden {
            display: none;
        }
    </style>
@stop
@section('content')
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Editer la facture "{{ $data[0]->reference_fact }}"</h4>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Factures</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Editer</a></li>
                </ol>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card px-3">
                    <div class="card-body">
                        <!-- Button trigger modal -->
                        {{--                        <h4 class="w-50">Ajouter un devis</h4>--}}
                        <form action="{{ route('divers.factures.edit.store') }}" method="post" id="devis-form" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" value="{{ $data[0]->facture_id }}" name="facture_id">
                            {{--                            <input type="hidden" value="{{ $data }}" name="olddata[]">--}}
                            {{--                            <input type="hidden" value="{{ $pocedes }}" name="oldproduct[]">--}}
                            <div class="row">
                                <div class="col-md-5 float-left d-flex">
                                    <div class="form-group col-md-6">
                                        <label for="date">Date de la facture <span class="text-danger">*</span> </label>
                                        <input type="date" value="{{ $data[0]->date_fact }}" name="date" id="date" class="form-control" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="statut_tva">Inclure la TVA/IS?  <span class="text-danger">*</span>  </label>
                                        <select class="form-control" name="tva_statut">
                                            <option {{ $data[0]->tva_statut==0?"selected":"" }} value="0">Aucun</option>
                                            <option {{ $data[0]->tva_statut==1?"selected":"" }} value="1">TVA</option>
                                            <option {{ $data[0]->tva_statut==2?"selected":"" }} value="2">IS</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-7 float-right d-flex" id="client-block">
                                    <div class="form-group col-md-6">
                                        <label for="echeance">Client  <span class="text-danger">*</span> </label>
                                        <select name="idclient" id="single-select" class="form-control" required>
                                            @foreach($clients as $cl)
                                                <option {{ $data[0]->client_id==$cl->client_id?"selected":"" }}
                                                        value="{{ $cl->client_id }}">{{ $cl->nom_client }} {{ $cl->prenom_client }}{{ $cl->raison_s_client }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="text-center pl-3">Coordonnées du client</label>
                                        @foreach($clients as $cl)
                                            <div class="hidden infos_client pl-3" id="infos_client{{ $cl->client_id }}">
                                                <label
                                                    class="h5 font-weight-bold mt-1">{{ $cl->nom_client }} {{ $cl->prenom_client }}{{ $cl->raison_s_client }}</label><br>
                                                <label
                                                    class="h5 font-weight-bold mt-1">Tel: {{ $cl->phone_1_client }}  {{ $cl->phone_client }}</label><br>
                                                <label
                                                    class="h5 font-weight-bold mt-1">Bp: {{ $cl->postale }}</label><br>
                                                {{--                                                <label class="h5 font-weight-bold mt-1"> {{ $cl->rcm }}</label><br>--}}
                                                {{--                                                <label class="h5 font-weight-bold mt-1">NC: {{ $cl->contribuabe }}</label><br>--}}
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="objet">Objet <span class="text-danger"></span>: </label>
                                <input type="text" name="objet" id="objet" value="{{ $data[0]->objet }}"
                                       class="form-control" required>
                            </div>
                            <h4 class="float-left align-self-start text-uppercase mb-3">Produits</h4>
                            <button type="button" class="btn btn-primary float-right align-self-end mb-3"
                                    data-toggle="modal" title="Ajouter des produit" id="displayProductModal"
                                    data-target=".bd-example-modal-lg"><i class="fa fa-plus">&nbsp; Ajouter</i></button>
                            <div class="for-produit table-responsive" style="max-height: 400px;">
                                <table class="w-100 table table-striped table-bordered table-active" id="validated-element">
                                    <thead class="bg-primary text-white text-center">
                                    <tr class="text-center">
                                        <th style="border:1px solid #eaeaea;">Titre</th>
                                        <th style="border:1px solid #eaeaea;">Quantité</th>
                                        <th style="border:1px solid #eaeaea;">P.U.HT.</th>
                                        <th style="border:1px solid #eaeaea;">Remise</th>
                                        <th style="border:1px solid #eaeaea;">Description</th>
                                        <th style="border:1px solid #eaeaea;">M. HT(FCFA)</th>
                                        <th style="border:1px solid #eaeaea; width: 30px" title="Supprimer la ligne"><i
                                                class="fa fa-trash-o"></i></th>
                                    </tr>

                                    </thead>
                                    <tbody style="color: #000000!important;">
                                    @php
                                        $montantTTC = 0;
                                        $montantHT=0;
                                        $montantTVA=0;
                                    @endphp

                                    @foreach($pocedes as $item)
                                        @php
                                            $remise = ($item->prix * $item->quantite *$item->remise)/100;
                                            $montant = ($item->quantite * $item->prix) - $remise;
                                            $HT = $montant;

                                            $montantHT += $montant;
                                            $tva = ($montant * $item->tva)/100;
                                            $montant = $tva + $montant;
                                            $TTC = $montant;
                                            $montantTVA += $montant;
                                        @endphp
                                        <tr class="text-black  produit-input font-weight-bold"
                                            id="product-row{{ -$item->produit_f_id }}">

                                            <td style="width: 270px;">
                                                <input type="hidden" name="produit_f_id[]" value="{{ $item->produit_f_id }}">
                                                <input type="hidden" name="ref[]" value="{{ $item->reference_pf }}">
                                                <input type="text" required name="titre[]" class="form-control" value="{{ $item->titre_pf }}">
                                            </td>
                                            <td><input type="number" min="0" value="{{ $item->quantite }}"
                                                       name="quantite[]" onchange="calculeHT({{ -$item->produit_f_id }})"
                                                       id="quantite{{ -$item->produit_f_id }}"
                                                       class="form-control quantite"
                                                       required></td>
                                            <td><input type="number" min="0" value="{{ $item->prix }}" name="prix[]"
                                                       onchange="calculeHT({{ -$item->produit_f_id }})"
                                                       id="prix{{ -$item->produit_f_id }}" class="form-control prix"
                                                       required></td>
                                            <td><input type="number" min="0" max="100" value="{{ $item->remise }}" name="remise[]"
                                                       onchange="calculeHT({{ -$item->produit_f_id }})" step="any"
                                                       id="remise{{ -$item->produit_f_id }}"
                                                       class="form-control remise" required></td>
                                            <td>
                                                <textarea name="description[]" class="form-control"> {{ $item->description_pf }} </textarea>
                                            </td>
                                            <td><input type="number" min="0" readonly name="totalHT[]" value="{{ $HT }}"
                                                       step="any" id="totalHT{{ -$item->produit_f_id }}"
                                                       class="form-control totalHT"></td>
                                            {{--                                            <td><input type="number" min="0" value="{{ $TTC }}" readonly--}}
                                            {{--                                                       name="totalTTC[]" step="any" id="totalTTC{{ -$item->produit_f_id }}"--}}
                                            {{--                                                       class="form-control totalTTC"></td>--}}

                                            <td class="text-center">
                                                <button type="button" onclick="removeProduit({{ $item->produit_f_id }})"
                                                        class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-12 d-flex py-3">

                                <div class="col-md-12 d-flex">
                                    <div class="d-flex form-group col-md-4">
                                        <label class="text-center">Montant HT &nbsp;&nbsp;</label>
                                        <input type="number" readonly name="ht" value="0" id="ht" class="form-control">
                                    </div>
                                    <div class="d-flex form-group col-md-4">
                                        <label class="text-center">Montant TVA &nbsp;&nbsp;</label>
                                        <input type="number" readonly name="mtva" id="mtva" value="0" class="form-control">
                                    </div>
                                    <div class="d-flex form-group col-md-4">
                                        <label class="text-center">Montant TTC &nbsp;&nbsp;</label>
                                        <input type="number" readonly name="ttc" id="ttc" value="0" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 row">
                                <div class="col-md-6">
                                    <label class="nav-label text-center">Informations du bon de commande</label>
                                    <div class="form-group">
                                        <label for="ref_bon">Reference du bon de commande</label>
                                        <input type="hidden" name="piece_id" value="{{ isset($piece[0])?$piece[0]->piece_id:'' }}">
                                        <input type="hidden" name="chemin" value="{{ isset($piece[0])?$piece[0]->chemin:'' }}">
                                        <input type="text" name="ref_bon" value="{{ isset($piece[0])?$piece[0]->ref:'' }}" id="ref_bon" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>date du bon de commande</label>
                                        <input type="date" value="{{ isset($piece[0])?$piece[0]->date_piece:'' }}" name="date_bon" id="ref_bon" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="logo-upload">Joindre un fichier</label>
                                        <input type="file" name="logo" id="logo-upload" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row mb-3 ml-5" title="Cliquer pour selectioner une image">
                                        <img id="logo-zone" style="width: 300px; height: 300px; min-height: 200px; min-width: 200px" src="{{ isset($piece[0]->chemin)?asset('images/piece/'.$piece[0]->chemin):asset('images/logo-thumbnail.png') }}" alt="Ouopps! Auncune image disponible">
                                    </div>
                                    {{--                                    <div class="kv-avatar-hint">--}}
                                    {{--                                        <small>Sélectionner un fichier< 1500 KB</small>--}}
                                    {{--                                    </div>--}}
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="reset" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-primary">Enregistrer</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>


    @include('divers.proformat.modal')
@stop
@section('script')
    <script>

        $(document).ready(function () {
            // ici on affiche les informations du client en fonction du client selectionneee
            var idclient = $('#single-select').val();
            $('.infos_client').hide(200);
            //on affiche l'info client correspondant
            $('#infos_client' + idclient).show(250);
            total();
        });


        // traitement de l'image
        $("#logo-zone").click(function(e) {
            $("#logo-upload").click();
        });
        function fasterPreview( uploader ) {
            if ( uploader.files && uploader.files[0] ){
                $('#logo-zone').attr('src',
                    window.URL.createObjectURL(uploader.files[0]) );
            }
        }
        $("#logo-upload").change(function(){
            fasterPreview( this );
        });
        $('#edit-btn').click(function (e){
            $('.form-control').removeAttr('disabled');
            $('.btn-primary').removeAttr('disabled');
        });

        // cette methode retire un produit depuid la bd
        function removeProduit(id) {

            if ($('#table-produit tbody').find("tr").length > 1) {

                swal.fire({
                    title: "Supprimer ce produit?",
                    icon: 'question',
                    text: "Ce produit sera retiré.",
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
                            url: "{{ route('factures.remove.produit') }}",
                            data: {id: id},
                            dataType: 'json',
                            success: function (res) {
                                if (res) {
                                    // swal.fire("Effectué!", "Supprimé avec succès!", "success")
                                    toastr.success("Supprimé avec succès!");
                                    $('#product-row' + (-id)).remove()
                                    total();
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
            } else {
                alert("Vous ne pouvez pas supprimer tous les elements.");
            }
        }

    </script>
    @include('divers.common_script')
    <!-- Selet search -->
    <script src="{{asset('template/vendor/select2/js/select2.full.min.js')}}"></script>
    <script src="{{asset('template/js/plugins-init/select2-init.js')}}"></script>
    <script src="{{asset('template/vendor/sweetalert2/dist/sweetalert2.min.js')}}"></script>

@stop
