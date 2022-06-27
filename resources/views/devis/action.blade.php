<div class="btn-group text-center">
    <ul>
        <li class="d-flex">
            <a href="javascript:void(0);"  class="btn btn-success btn-xs" data-toggle="modal"
               data-target="#devis-view-modal{{ $value->devis_id }}"
               title="Visualiser les details"><i
                    class="fa fa-eye"></i></a>
            <a href="{{ route('devis.print',['id' =>$value->devis_id]) }}" target="_blank" class="btn btn-light btn-xs ml-1"
               title="Imprimer la proformat"><i
                    class="fa fa-file-pdf-o"></i></a>
            @if (Auth::user()->is_admin==1 || $value->statut <=1)
                @if(Auth::user()->is_admin==1 || Auth::user()->id===$value->id)
                    <a href="{{ route('devis.edit',['id' =>$value->devis_id]) }}" class="btn btn-warning btn-xs ml-1"
                       title="Editer le devis"><i
                            class="fa fa-edit"></i></a>
                @endif
            @endif
        </li>
        <li class="d-flex mt-1">
            @if ($value->statut===0 && Auth::user()->is_admin==1)
                <a href="javascript:void(0);" onclick="validerFun({{ $value->devis_id}})"
                   class="btn btn-primary btn-xs"
                   title="Marquer comme validé"><i
                        class="fa fa-check"></i></a>
            @endif
            @if ($value->statut===1 )
                <a href="{{ route('devis.edit',['id' =>$value->devis_id]) }}" data-toggle="modal"
                   data-target="#fature-modal" onclick="getId({{ $value->devis_id }})" class="btn btn-secondary btn-xs"
                   title="Générer la facture."><i
                        class="fa fa-file-archive-o"></i></a>
            @endif
            @if ($value->statut ===1 && Auth::user()->is_admin==1)
                <a href="javascript:void(0);" onclick="bloquerFun({{ $value->devis_id }})"
                   class="btn btn-dark btn-xs ml-1"
                   title="Marquer comme non validé."><i
                        class="fa fa-close"></i></a>
            @endif

            @if (Auth::user()->is_admin==1)
                <button class="btn btn-danger btn-xs ml-1 "
                        title="Supprimer ce devis" id="deletebtn{{ $value->devis_id }}"
                        onclick="deleteFun({{ $value->devis_id }})"><i
                        class="fa fa-trash"></i></button>
            @endif
        </li>
    </ul>


</div>

<div class="modal fade bd-example-modal-lg" id="devis-view-modal{{ $value->devis_id }}" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Détail de le dévis: {{ $value->reference_devis }}</h5>
                <a href="{{ route('devis.view',['id' =>$value->devis_id]) }}" class="mx-5  ml-1"
                   title="Plus de details">Voir plus</a>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row col-md-12">
                    <div class="col-md-6">
                        <h5 class="">PROFORMA</h5>
                        <h6>N° {{ $value->reference_devis }}</h6>
                        <h6>Date: {{ $value->date_devis }}</h6>
                    </div>
                    <div class="col-md-6">
                        <h5 class="">COORDONNEES DU CLIENT</h5>
                        <h6>{{ $value->nom_client.' '.$value->prenom_client.' '.$value->raison_s_client }}</h6>
                        <h6>Tel: {{ $value->phone_1_client }}/{{ $value->phone_2_client }}</h6>
                        <h6>BP : {{ $value->postale }}</h6>
                    </div>
                </div>
                <label class="nav-label"><span class="font-weight-bold">Objet: </span>{{ $value->objet }}</label>
                <div class="for-produit table-responsive" style="max-height: 400px;">
                    <label class="nav-label h3 text-uppercase">Produits</label>
                    <table class="w-100 table table-bordered">
                        <thead class="bg-primary text-white text-center">
                        <tr class="text-white" style="color: #ffffff!important;">
                            <th>Réf.</th>
                            <th>Désignation</th>
                            <th>Qté</th>
                            <th>P.U.HT.</th>
                            <th>Remise</th>
{{--                            <th>TVA</th>--}}
                            <th>M. HT</th>
                            <th>M. TTC</th>
{{--                            <th><i class="fa fa-trash"></i></th>--}}
                        </tr>

                        </thead>
                        <tbody style="color: #000000!important;">
                        @php
                            $montantTTC = 0;
                            $montantHT=0;
                            $montantTVA=0;
                        @endphp


                            @foreach($pocedes as $p)
                                @php
                                    $remise = ($p->prix * $p->quantite *$p->remise)/100;
                                    $montant = ($p->quantite * $p->prix) - $remise;
                                    $HT = $montant;

                                    $montantHT += $montant;
                                    $tva = ($montant * $p->tva)/100;
                                    $montant = $tva + $montant;
                                    $TTC = $montant;
                                    $montantTVA += $montant;
                                @endphp
                                <tr class="text-black  produit-input">

                                <td>{{ $p->reference }}{{ $p->reference_pocede }}</td>
                                <td>
                                    <strong>{{ $p->titre_produit }}{{ $p->titre_pocede }}</strong> <br>
                                    <small>{{ $p->description_produit }}{{ $p->description_pocede }}</small></td>
                                <td>{{ $p->quantite }}</td>
                                <td>{{ $p->prix }}</td>
                                <td>{{ $p->remise }}%</td>
{{--                                <td>{{ $p->tva }}%</td>--}}
                                <td>
                                    {{ number_format($HT,2, '.', '') }}
                                </td>
                                <td>
                                    {{  number_format($TTC, 2, '.', '')  }}
                                </td>

                        </tr>
                            @endforeach


                        <tr>
                            <th colspan="5" rowspan="3"></th>
                            <td>Total HT</td>
                            <td>{{ number_format($montantHT,2,'.','') }}</td>

                        </tr>

                        <tr>
                            @if ($value->tva_statut == 2)
                                <td class="total">IS 5.5%</td>
                            @else
                                <td class="total">TVA 19.25%</td>
                            @endif
                            <td>
                                @if ($value->tva_statut == 1)
                                    {{  (new \App\Models\Taxe())->ApplyTVA($montantTVA) }}
                                @elseif($value->tva_statut == 2)
                                    {{  (new \App\Models\Taxe())->ApplyIS($montantTVA) }}
                                @else
                                    0
                                @endif

                            </td>

                        </tr>
                        <tr>
                            <td>Montant TTC</td>
                            <td>
                                @if ($value->tva_statut == 1)
                                    {{ number_format(( ($montantTVA * 19.25)/100)+$montantTVA,2,'.','') }}
                                @elseif($value->tva_statut == 2)
                                    {{ number_format(( ($montantTVA * 5.5)/100)+$montantTVA,2,'.','') }}
                                @else
                                    {{ number_format($montantTVA ,2,'.','') }}
                                @endif
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>
                <hr class="mt-2">
                <div class="for-produit table-responsive" style="max-height: 400px;">
                    <label class="nav-label h3">OFFRE COMPLEMENTAIRE</label>
                    <table class="w-100 table  table-bordered">
                        <thead class="bg-primary text-white text-center">
                        <tr>
                            <th>Réf.</th>
                            <th>Désignation</th>
                            <th>Qté</th>
                            <th>P.U.HT.</th>
                            <th>Remise</th>
{{--                            <th>TVA</th>--}}
                            <th>M. HT</th>
                            <th>M. TTC</th>
                        </tr>

                        </thead>
                        <tbody style="color: #000000!important;">
                        @php
                            $montantTTC = 0;
                           $montantHT=0;
                           $montantTVA = 0;
                        @endphp
                        @php
                            $remise = ($p->prix * $p->quantite *$p->remise)/100;
                            $montant = ($p->quantite * $p->prix) - $remise;
                            $HT = $montant;

                            $montantHT += $montant;
                            $tva = ($montant * $p->tva)/100;
                            $montant = $tva + $montant;
                            $TTC = $montant;
                            $montantTVA += $montant;
                        @endphp
                            @foreach($complements as $p)
                                <tr class="text-black  produit-input">

                                <td>{{ $p->reference }}{{ $p->reference_com }}</td>
                                <td>
                                    <strong>{{ $p->titre_produit }}{{ $p->titre_com }}</strong> <br>
                                    <small>{{ $p->description_produit }}{{ $p->description_com }}</td>
                                <td>{{ $p->quantite }}</td>
                                <td>{{ $p->prix }}</td>
                                <td>{{ $p->remise }}%</td>
{{--                                <td>{{ $p->tva }}%</td>--}}
                                <td>
                                    {{ number_format($HT,2, '.', '') }}
                                </td>
                                <td>
                                    {{  number_format($TTC, 2, '.', '')  }}
                                </td>

                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                {{--                        <button type="submit" class="btn btn-primary">Enregistrer</button>--}}
            </div>
        </div>
    </div>
</div>
