@extends('layouts.app')
@section('title','| FACTURE-EDIT')
@section('css_before')
    <link rel="stylesheet" href="{{asset('template/vendor/select2/css/select2.min.css')}}">
    <link href="{{asset('template/vendor/sweetalert2/dist/sweetalert2.min.css')}}" rel="stylesheet">

    <style>
        .hidden {
            display: none;
        }
    </style>
    {{--@endsection--}}
@stop
@section('content')
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Editer la proformat "{{ $data[0]->reference_devis }}"</h4>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Devis</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Editer</a></li>
                </ol>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card px-3">
                    <div class="card-body">
                        <!-- Button trigger modal -->
                        <h4 class="w-50"></h4>
                        <form action="{{ route('divers.proformat.edit.update') }}" method="post" id="devis-form">
                            @csrf
                            <input type="hidden" value="{{ $data[0]->devis_id }}" name="devis_id">
                            <div class="row">
                                <div class="col-md-5 float-left d-flex">
                                    <div class="form-group col-md-6">
                                        <label for="date">Date de la profomat<span class="text-danger"> *</span> </label>
                                        <input type="date" value="{{ $data[0]->date_devis }}" name="date" id="date" class="form-control" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="statut_tva">Inclure la TVA/IS? <span class="text-danger"> *</span></label>
                                        <select class="form-control" name="tva_statut">
                                            <option {{ $data[0]->tva_statut==0?"selected":"" }} value="0">Aucun</option>
                                            <option {{ $data[0]->tva_statut==1?"selected":"" }} value="1">TVA</option>
                                            <option {{ $data[0]->tva_statut==2?"selected":"" }} value="2">IS</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-7 float-right d-flex" id="client-block">
                                    <div class="form-group col-md-6">
                                        <label for="echeance">Client <span class="text-danger"> *</span> </label>
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
                            <div class="form-group mb-2">
                                <label for="objet">Objet<span class="text-danger"> *</span> </label>
                                <input type="text" name="objet" id="objet" value="{{ $data[0]->objet }}"
                                       class="form-control" required>
                            </div>
                            <h4 class="float-left align-self-start text-uppercase">Produits</h4>
                            <button type="button" class="btn btn-primary float-right align-self-end mb-3"
                                    data-toggle="modal" title="Ajouter des produit" id="displayProductModal"
                                    data-target=".bd-example-modal-lg"><i class="fa fa-plus">&nbsp; Ajouter</i></button>
                            <div class="for-produit table-responsive" style="max-height: 400px;">
                                <label class="nav-label">Produits</label>
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
                                            id="product-row{{ -$item->pocede_id }}">

                                            <td style="width: 270px;">
                                                <input type="hidden" name="pocede_id[]" value="{{ $item->pocede_id }}">
                                                <input type="hidden" name="ref[]" value="{{ $item->reference_pocede }}">
                                                <input type="text" required name="titre[]" class="form-control" value="{{ $item->titre_pocede }}">
                                            </td>
                                            <td><input type="number" min="0" value="{{ $item->quantite }}"
                                                       name="quantite[]" onchange="calculeHT({{ -$item->pocede_id }})"
                                                       id="quantite{{ -$item->pocede_id }}"
                                                       class="form-control quantite"
                                                       required></td>
                                            <td><input type="number" min="0" value="{{ $item->prix }}" name="prix[]"
                                                       onchange="calculeHT({{ -$item->pocede_id }})"
                                                       id="prix{{ -$item->pocede_id }}" class="form-control prix"
                                                       required></td>
                                            <td><input type="number" min="0" value="{{ $item->remise }}" name="remise[]"
                                                       onchange="calculeHT({{ -$item->pocede_id }})" step="any"
                                                       id="remise{{ -$item->pocede_id }}"
                                                       class="form-control remise" required></td>
                                            <td>
                                                <textarea name="description[]" class="form-control"> {{ $item->description_pocede }} </textarea>
                                            </td>
                                            <td><input type="number" min="0" readonly name="totalHT[]" value="{{ $HT }}"
                                                       step="any" id="totalHT{{ -$item->pocede_id }}"
                                                       class="form-control totalHT"></td>

                                            <td class="text-center">
                                                <button type="button" onclick="removeProduit({{ $item->pocede_id }})"
                                                        class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-12 mt-3 pt-2 d-flex">

                                <div class="col-md-12 d-flex">
                                    <div class="d-flex form-group col-md-4">
                                        <label class="text-center">Montant HT &nbsp;&nbsp;</label>
                                        <input type="number" readonly name="ht" value="0" id="ht" class="form-control">
                                    </div>
                                    <div class="d-flex form-group col-md-4">
                                        <label class="text-center">Montant TVA/IS &nbsp;&nbsp;</label>
                                        <input type="number" readonly name="mtva" id="mtva" value="0" class="form-control">
                                    </div>
                                    <div class="d-flex form-group col-md-4">
                                        <label class="text-center">Montant TTC &nbsp;&nbsp;</label>
                                        <input type="number" readonly name="ttc" id="ttc" value="0" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-md-3 form-group">
                                    <label for="validite">Validité de l'offre(en semaine)<span
                                            class="text-danger"> *</span></label>
                                    <input type="number" id="validite" required min="0" name="validite"
                                           value="{{ $data[0]->validite }}" class="form-control">
                                </div>
                                <div class="col-md-3 form-group">
                                    <label for="disponibilite">Disponibilité<span class="text-danger"> *</span></label>
                                    <select class="form-control" name="disponibilite" id="disponibilite">
                                        <option {{ $data[0]->disponibilite=="En stock"?'selected':'' }}>En stock</option>
                                        <option {{ $data[0]->disponibilite=="Non disponible en stock"?'selected':'' }}>Non disponible en stock</option>
                                        <option {{ $data[0]->disponibilite=="Disponible dans 10 jours"?'selected':'' }}>Disponible dans 10 jours</option>
                                        <option {{ $data[0]->disponibilite=="Disponible dans 15 jours"?'selected':'' }}>Disponible dans 15 jours</option>
                                        <option {{ $data[0]->disponibilite=="Disponible dans 20 jours"?'selected':'' }}>Disponible dans 20 jours</option>
                                        <option {{ $data[0]->disponibilite=="Disponible dans 25 jours"?'selected':'' }}>Disponible dans 25 jours</option>
                                        <option {{ $data[0]->disponibilite=="Disponible dans 30 jours"?'selected':'' }}>Disponible dans 30 jours</option>
                                        <option {{ $data[0]->disponibilite=="Disponible dans 40 jours"?'selected':'' }}>Disponible dans 40 jours</option>
                                        <option {{ $data[0]->disponibilite=="Disponible dans 50 jours"?'selected':'' }}>Disponible dans 50 jours</option>
                                        <option {{ $data[0]->disponibilite=="Disponible dans 60 jours"?'selected':'' }}>Disponible dans 60 jours</option>
                                        <option {{ $data[0]->disponibilite=="Disponible dans 70 jours"?'selected':'' }}>Disponible dans 70 jours</option>
                                        <option {{ $data[0]->disponibilite=="Disponible dans 80 jours"?'selected':'' }}>Disponible dans 80 jours</option>
                                        <option {{ $data[0]->disponibilite=="Disponible dans 90 jours"?'selected':'' }}>Disponible dans 90 jours</option>
                                        <option {{ $data[0]->disponibilite=="Disponible dans 100 jours"?'selected':'' }}>Disponible dans 100 jours</option>
                                        <option {{ $data[0]->disponibilite=="Disponible dans 120 jours"?'selected':'' }}>Disponible dans 120 jours</option>
                                        <option {{ $data[0]->disponibilite=="Disponible dans 150 jours"?'selected':'' }}>Disponible dans 150 jours</option>
                                        <option {{ $data[0]->disponibilite=="Dès réception accompte"?'selected':'' }}>Dès réception accompte</option>
                                    </select>
                                    {{--                                    <input type="text" id="disponibilite" required minlength="5" name="disponibilite"--}}
                                    {{--                                           value="{{ $data[0]->disponibilite }}" class="form-control">--}}
                                </div>
                                <div class="col-md-3 form-group">
                                    <label>Garantie(en mois)<span class="text-danger"> *</span></label>
                                    <input type="number" min="0" name="garentie" class="form-control"
                                        {{ $data[0]->garentie }}>
                                </div>
                                <div class="col-md-3 form-group">
                                    <label for="condition">Conditions financières<span
                                            class="text-danger"> *</span></label>
                                    <select class="form-control" name="condition">
                                        <option {{ $data[0]->condition=="100% à la commande"?'selected':'' }}>100% à la commande</option>
                                        <option {{ $data[0]->condition=="50% à la commande"?'selected':'' }}>50% à la commande</option>
                                        <option {{ $data[0]->condition=="15 jours après la commande"?'selected':'' }}>15 jours après la commande</option>
                                        <option {{ $data[0]->condition=="30 jours après la commande"?'selected':'' }}>30 jours après la commande</option>
                                        <option {{ $data[0]->condition=="60 jours après la commande"?'selected':'' }}>60 jours après la commande</option>
                                        <option {{ $data[0]->condition=="90 jours après la commande"?'selected':'' }}>90 jours après la commande</option>
                                        <option {{ $data[0]->condition=="120 jours après la commande"?'selected':'' }}>120 jours après la commande</option>
                                        <option {{ $data[0]->condition=="150 jours après la commande"?'selected':'' }}>150 jours après la commande</option>
                                        <option {{ $data[0]->condition=="180 jours après la commande"?'selected':'' }}>180 jours après la commande</option>
                                    </select>
                                    {{--                                    <input type="text" id="condition" required min="0" name="condition"--}}
                                    {{--                                           value="{{ $data[0]->condition }}" class="form-control">--}}
                                </div>
                            </div>
                            <hr class="mt-2">

                            <div class="for-complement  table-responsive" style="max-height: 400px;">
                                <h5 class="float-left my-3">OFFRE COMPLEMENTAIRE</h5>
                                <button type="button" class="btn btn-primary float-right align-self-end my-3"
                                        data-toggle="modal" title="Ajouter les compléments" id="displayComModal"
                                        data-target=".bd-example-modal-lg"><i class="fa fa-plus">&nbsp; Ajouter</i></button>
                                <table class="w-100 table table-striped table-bordered table-active"
                                       id="validated-element-com">
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

                                    @foreach($complements as $item)
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
                                            id="complement-row{{ -$item->complement_id }}">
                                            <td style="width: 270px;">
                                                <input type="hidden" name="complement_id[]" value="{{ $item->complement_id }}">
                                                <input type="text" required name="titre_com[]" class="form-control" value="{{ $item->titre_com }}">
                                            </td>
                                            <td><input type="number" value="{{ $item->quantite }}" min="0"
                                                       name="quantite_com[]"
                                                       onchange="calculeComHT({{ -$item->complement_id }})"
                                                       id="quantite_com{{ -$item->complement_id }}"
                                                       class="form-control quantite_com"
                                                ></td>
                                            <td><input type="number" value="{{ $item->prix }}" min="0" name="prix_com[]"
                                                       onchange="calculeComHT({{ -$item->complement_id }})"
                                                       id="prix_com{{ -$item->complement_id }}"
                                                       class="form-control prix_com"
                                                ></td>
                                            <td>
                                                <textarea name="description_com[]" class="form-control">{{ $item->description_com }}</textarea>
                                            </td>
                                            <td><input type="number" value="{{ $item->remise }}" min="0"
                                                       name="remise_com[]" onchange="calculeComHT(0)" step="any"
                                                       id="remise_com{{ -$item->complement_id }}"
                                                       class="form-control remise_com"></td>
                                            {{--                                            <td><input type="number" value="{{ $item->tva }}" min="0" name="tva_com[]"--}}
                                            {{--                                                       step="any" id="tva_com{{ -$item->complement_id }}"--}}
                                            {{--                                                       onchange="calculeComHT({{ -$item->complement_id }})"--}}
                                            {{--                                                       class="form-control tva_com"></td>--}}
                                            <td><input type="number" min="" readonly name="total_comHT[]"
                                                       value="{{ $HT }}" step="any"
                                                       id="total_comHT{{ -$item->complement_id }}"
                                                       class="form-control total_comHT"></td>
                                            {{--                                            <td><input type="number" min="0" value="{{ $TTC }}" readonly--}}
                                            {{--                                                       name="total_comTTC[]" step="any"--}}
                                            {{--                                                       id="total_comTTC{{ -$item->complement_id }}"--}}
                                            {{--                                                       class="form-control total_comTTC"></td>--}}
                                            <td class="text-center">
                                                <button type="button" onclick="removeComplement({{ $item->complement_id }})"
                                                        class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i>
                                                </button>
                                            </td>
                                        </tr>

                                    @endforeach

                                    </tbody>
                                </table>

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
    {{--@endsection--}}
@stop
@section('script')
    <script>
        //  variabes qui comptes les entrees

        $(document).ready(function () {
            // ici on affiche les informations du client en fonction du client selectionneee
            var idclient = $('#single-select').val();
            $('.infos_client').hide(200);
            //on affiche l'info client correspondant
            $('#infos_client' + idclient).show(250);
            total();
        });


        // cette methode retire un produit depuid la bd
        function removeProduit(id) {

            if ($('#validated-element tbody').find("tr").length > 1) {

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
                            url: "{{ route('devis.remove.produit') }}",
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

        // cette methode retire un complement depuis la bd
        function removeComplement(id) {

            swal.fire({
                title: "Supprimer ce complement?",
                icon: 'question',
                text: "Ce complement sera retiré.",
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
                        url: "{{ route('devis.remove.comp') }}",
                        data: {id: id},
                        dataType: 'json',
                        success: function (res) {
                            if (res) {
                                // swal.fire("Effectué!", "Supprimé avec succès!", "success")
                                toastr.success("Supprimé avec succès!");
                                $('#complement-row' + (-id)).remove()

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


        }
    </script>
@include('divers.common_script')
    <!-- Selet search -->
    <script src="{{asset('template/vendor/select2/js/select2.full.min.js')}}"></script>
    <script src="{{asset('template/js/plugins-init/select2-init.js')}}"></script>
    <script src="{{asset('template/vendor/sweetalert2/dist/sweetalert2.min.js')}}"></script>

@stop

