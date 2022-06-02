@extends('layouts.app')
@section('title','| FACTURES-AVOIR-EDIT')
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
                    <h4>Editer la facture "{{ $data->reference_avoir }}"</h4>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Factures A</a></li>
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
                        <form action="{{ route('avoir.edit.update') }}" method="post" id="devis-form" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" value="{{ $data->avoir_id }}" name="avoir_id">
                            <div class="row">
                                <div class="col-md-5 float-left d-flex">
                                    <div class="form-group col-md-6">
                                        <label for="date">Date de la facture <span class="text-danger">*</span> </label>
                                        <input type="date" value="{{ $data->date_avoir }}" name="date" id="date" class="form-control" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="statut_tva">Inclure la TVA/IS?  <span class="text-danger">*</span>  </label>
                                        <select class="form-control" name="tva_statut" disabled>
                                            <option {{ $data->tva_statut==0?"selected":"" }} value="0">Aucun</option>
                                            <option {{ $data->tva_statut==1?"selected":"" }} value="1">TVA</option>
                                            <option {{ $data->tva_statut==2?"selected":"" }} value="2">IS</option>
{{--                                            <option {{ $data->tva_statut==0?"selected":"" }} value="0">Non</option>--}}
{{--                                            <option {{ $data->tva_statut==1?"selected":"" }} value="1">Oui</option>--}}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-7 float-right d-flex">
                                    <div class="form-group col-md-3">
                                        <label>Facture N_0</label>
                                        <input type="text" value="{{ $factures[0]->reference_fact }}" class="form-control" readonly>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Du</label>
                                        <input type="text" value="{{ $factures[0]->date_fact }}" class="form-control" readonly>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="text-center pl-3">Coordonnées du client</label>
                                            <div class=" pl-3" id="infos_client{{ $factures[0]->client_id }}">
                                                <label
                                                    class="h5 font-weight-bold mt-1">{{ $factures[0]->nom_client }} {{ $factures[0]->prenom_client }}{{ $factures[0]->raison_s_client }}</label><br>
                                                <label
                                                    class="h5 font-weight-bold mt-1">Tel: {{ $factures[0]->phone_1_client }}  {{ $factures[0]->phone_client }}</label><br>
                                                <label
                                                    class="h5 font-weight-bold mt-1">Bp: {{ $factures[0]->postale }}</label><br>
                                                {{--                                                <label class="h5 font-weight-bold mt-1"> {{ $cl->rcm }}</label><br>--}}
                                                {{--                                                <label class="h5 font-weight-bold mt-1">NC: {{ $cl->contribuabe }}</label><br>--}}
                                            </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="objet">Objet <span class="text-danger"></span>: </label>
                                <input type="text" name="objet" id="objet" value="{{ $data->objet }}"
                                       class="form-control" required>
                            </div>
                            <div class="for-produit table-responsive" style="max-height: 400px;">
                                <label class="nav-label">Produits</label>
                                <table class="w-100 table table-striped table-bordered table-active" id="table-produit">
                                    <thead class="bg-primary text-white text-center">
                                    <tr>
                                        <th>Désignation</th>
                                        <th>Qté</th>
                                        <th>P.U.HT.</th>
                                        <th>Remise(%)</th>
                                        {{--                                        <th>TVA</th>--}}
                                        <th>M. HT(FCFA)</th>
                                        {{--                                        <th>M. TTC</th>--}}
                                        <th><i class="fa fa-trash"></i></th>
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
                                            id="product-row{{ -$item->produitavoir_id }}">

                                            <td style="width: 270px;">
                                                <input type="hidden" name="produitavoir_id[]" value="{{ $item->produitavoir_id }}">
                                                <select name="idproduit[]" class="dropdown-groups form-control"
                                                        id="select-pro{{ -$item->produitavoir_id }}" readonly="Lecture seule"
                                                        onchange="setPrix({{ -$item->produitavoir_id }})"
                                                        style="color: #000000">
                                                    <option selected="selected" disabled>Sélectionez un produit</option>
                                                    @foreach($categories as $cat)
                                                        <optgroup class="" label="{{ $cat->titre_cat }}">
                                                            @foreach($produits as $p)
                                                                @if ($p->idcategorie===$cat->categorie_id)
                                                                    <option
                                                                        {{ $item->idproduit==$p->produit_id?'selected':'' }}
                                                                        value="{{ $p->produit_id }}">{{ $p->titre_produit }}</option>
                                                                @endif
                                                            @endforeach
                                                        </optgroup>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td><input type="number" min="1" value="{{ $item->quantite }}"
                                                       name="quantite[]" onchange="calculeHT({{ -$item->produitavoir_id }})"
                                                       id="quantite{{ -$item->produitavoir_id }}" max="{{ $TMAX[$item->idproduit] }}"
                                                       class="form-control quantite"
                                                       required></td>
                                            <td><input type="number" min="0" value="{{ $item->prix }}" name="prix[]"
                                                       onchange="calculeHT({{ -$item->produitavoir_id }})" disabled
                                                       id="prix{{ -$item->produitavoir_id }}" class="form-control prix"
                                                       required></td>
                                            <td><input type="number" min="0" value="{{ $item->remise }}" disabled name="remise[]"
                                                       onchange="calculeHT({{ -$item->produitavoir_id }})" step="any"
                                                       id="remise{{ -$item->produitavoir_id }}"
                                                       class="form-control remise" required></td>
                                            {{--                                            <td><input type="number" min="0" value="{{ $item->tva }}" name="tva[]"--}}
                                            {{--                                                       step="any" id="tva{{ -$item->produit_f_id }}"--}}
                                            {{--                                                       onchange="calculeHT({{ -$item->produit_f_id }})"--}}
                                            {{--                                                       class="form-control tva" required></td>--}}
                                            <td><input type="number" min="0" readonly name="totalHT[]" value="{{ $HT }}"
                                                       step="any" id="totalHT{{ -$item->produitavoir_id }}"
                                                       class="form-control totalHT"></td>
                                            {{--                                            <td><input type="number" min="0" value="{{ $TTC }}" readonly--}}
                                            {{--                                                       name="totalTTC[]" step="any" id="totalTTC{{ -$item->produit_f_id }}"--}}
                                            {{--                                                       class="form-control totalTTC"></td>--}}

                                            <td class="text-center">
                                                <button type="button" onclick="removeProduit({{ $item->produitavoir_id }})"
                                                        class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
{{--                                    @if (count($pocedes)===0)--}}
{{--                                        <tr class="text-black  produit-input font-weight-bold" id="product-row0">--}}
{{--                                            <td style="width: 270px;">--}}
{{--                                                <select name="idproduit[]" class="dropdown-groups form-control" id="select-pro0" onchange="setPrix(0)" style="color: #000000">--}}
{{--                                                    <option selected="selected" disabled>Sélectionez un produit</option>--}}
{{--                                                    @foreach($categories as $cat)--}}
{{--                                                        <optgroup class="" label="{{ $cat->titre_cat }}">--}}
{{--                                                            @foreach($produits as $p)--}}
{{--                                                                @if ($p->idcategorie===$cat->categorie_id)--}}
{{--                                                                    <option--}}
{{--                                                                        value="{{ $p->produit_id }}">{{ $p->titre_produit }}</option>--}}
{{--                                                                @endif--}}
{{--                                                            @endforeach--}}
{{--                                                        </optgroup>--}}
{{--                                                    @endforeach--}}
{{--                                                </select>--}}
{{--                                            </td>--}}
{{--                                            <td><input type="number" min="0" value="0" name="quantite[]" onchange="calculeHT(0)" id="quantite0" class="form-control quantite"--}}
{{--                                                       required></td>--}}
{{--                                            <td><input type="number" min="0" value="0" name="prix[]" onchange="calculeHT(0)" id="prix0" class="form-control prix"--}}
{{--                                                       required></td>--}}
{{--                                            <td><input type="number" min="0" value="0" name="remise[]" onchange="calculeHT(0)" step="any" id="remise0"--}}
{{--                                                       class="form-control remise" required></td>--}}
{{--                                            --}}{{--                                        <td><input type="number" min="0" value="0" name="tva[]" step="any" id="tva0" onchange="calculeHT(0)"--}}
{{--                                            --}}{{--                                                   class="form-control tva" required></td>--}}
{{--                                            <td><input type="number" min="0" readonly  name="totalHT[]" value="0" step="any" id="totalHT0"--}}
{{--                                                       class="form-control totalHT"></td>--}}
{{--                                            --}}{{--                                        <td><input type="number" min="0" value="0" readonly name="totalTTC[]" step="any" id="totalTTC0"--}}
{{--                                            --}}{{--                                                   class="form-control totalTTC"></td>--}}
{{--                                            <td class="text-center">--}}
{{--                                                <button type="button" onclick="removeLigne(0)"--}}
{{--                                                        class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></button>--}}
{{--                                            </td>--}}
{{--                                        </tr>--}}
{{--                                    @endif--}}
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-12 d-flex">
                                <div class="col-md-9 d-flex">
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

    {{--    ici on garde les donnees des produit pour ne pas attaquer le serveur a chaque fois--}}
    @foreach($produits as $p)

        <input type="hidden" name="produit_idproduit" value="{{ $p->produit_id }}" id="data_p_idproduit{{ $p->produit_id }}">
        <input type="hidden" name="produit_reference" value="{{ $p->reference }}" id="data_p_reference{{ $p->produit_id }}">
        <input type="hidden" name="produit_prix" value="{{ $p->prix_produit }}" id="data_p_prix{{ $p->produit_id }}">
        <input type="hidden" name="produit_quantite" value="{{ $p->quantite_produit }}" id="data_p_quantite{{ $p->produit_id }}">
        <input type="hidden" name="produit_categorie" value="{{ $p->idcategorie }}" id="data_p_categorie{{ $p->idcategorie }}">

    @endforeach
@stop
@section('script')
    <script>
        //  variabes qui comptes les entrees
        var totalProduit = 0;
        var totalComplement = 0;
        $(document).ready(function () {
            total();
        });

        // fontion qui charge le prix d'un produit
        function setPrix(number) {
            var productId =  $('#select-pro'+number).val();
            var defaultPrice = $('#data_p_prix'+productId).val();
            $('#prix'+number).val(defaultPrice);
        }


        // fonction qui calcule le montant HT  par produit
        function calculeHT(number){

            var remise =0;
            var qte =0;
            var prix =0;
            var tva = 0;
            if ($('#select-pro'+number).val()){
                if ($('#remise'+number).val()!=''){
                    remise = $('#remise'+number).val()
                }
                if ($('#quantite'+number).val()!=''){
                    prix = $('#quantite'+number).val()
                }
                if ($('#prix'+number).val()!=''){
                    qte = $('#prix'+number).val()
                }
                if ($('select[name="tva_statut"]').val()==1){
                    tva = 19.25;
                }
                // if ($('#tva'+number).val()!=''){
                //     tva = $('#tva'+number).val()
                // }

                var montant = (qte*prix) - (qte*prix*remise)/100 ;

                var ttc = (montant * tva )/100 + montant;
                ttc = Number(ttc).toFixed(2) ;
                montant =Number(montant).toFixed(2)
                $('#totalHT'+number).val(montant);
                // $('#totalTTC'+number).val(ttc);
                total();
            }
        }


        $('select[name="tva_statut"]').on('change',function (e){
            // if ($('select[name="tva_statut"]').val()==1){
            total();
            // }
        });

        // fonction qui calcule les totaux HT et TTC
        function total(){
            var totalht = 0;
            var totalttc = 0;
            var tva = 0;
            $('input[name="totalHT[]"]').each(function (){
                totalht += Number($(this).val());
            });
            // $('input[name="totalTTC[]"]').each(function (){
            //     totalttc +=Number( $(this).val());
            // });
            if ($('select[name="tva_statut"]').val()==1){
                tva = 19.25;
            }
            var mtva = (totalht * tva )/100;
            mtva = Number(mtva).toFixed(2)
            $('#mtva').val(mtva);
            $('#ht').val(Number(totalht).toFixed(2));
            // $('#ttc').val(Number(totalht+mtva).toFixed(2));
            var mttc = parseFloat(totalht) + parseFloat(mtva);
            $('#ttc').val(mttc);
        }

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
                            url: "{{ route('avoir.retirerProduit') }}",
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

    <!-- Selet search -->
    <script src="{{asset('template/vendor/select2/js/select2.full.min.js')}}"></script>
    <script src="{{asset('template/js/plugins-init/select2-init.js')}}"></script>
    <script src="{{asset('template/vendor/sweetalert2/dist/sweetalert2.min.js')}}"></script>

@stop

