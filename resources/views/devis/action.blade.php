<div class="btn-group text-center">
    <a type="button" title="Cliquez pour effectuer une action" class="dropdown" data-toggle="dropdown">
        <strong>... </strong></a>
    <ul class="dropdown-menu justify-content-center text-center" role="menu">
        <li class="text-center">
            <a href="javascript:void(0);" data-toggle="modal"
               data-target="#devis-view-modal{{ $value->devis_id }}" class="btn btn-success btn-sm ml-1"
               title="Visualiser les details"><i
                    class="fa fa-eye"></i></a>
            <a href="{{ route('devis.view',['id' =>$value->devis_id]) }}" class="btn btn-light btn-sm ml-1"
               title="Imprimer la proformat"><i
                    class="fa fa-file-pdf-o"></i></a>
            @if (Auth::user()->is_admin==1 || Auth::user()->id===$value->id && $value->statut <=1)
                <a href="{{ route('devis.edit',['id' =>$value->devis_id]) }}" class="btn btn-warning btn-sm ml-1"
                   title="Editer le devis"><i
                        class="fa fa-edit"></i></a>
            @endif
        </li>

        <li class="text-center mt-2">
            @if ($value->statut===0 && Auth::user()->is_admin==1)
                <a href="javascript:void(0);" onclick="validerFun({{ $value->devis_id}})"
                   class="btn btn-primary btn-sm ml-1"
                   title="Marquer comme validé"><i
                        class="fa fa-check"></i></a>
            @endif
            @if ($value->statut===1 )
                <a href="{{ route('devis.edit',['id' =>$value->devis_id]) }}" class="btn btn-secondary btn-sm ml-1"
                   title="Générer la facture."><i
                        class="fa fa-file-archive-o"></i></a>
            @endif
            @if ($value->statut ===1 && Auth::user()->is_admin==1)
                <a href="javascript:void(0);" onclick="bloquerFun({{ $value->devis_id }})"
                   class="btn btn-dark btn-sm ml-1"
                   title="Marquer comme non validé."><i
                        class="fa fa-close"></i></a>
            @endif

            @if (Auth::user()->is_admin==1)
                <button class="btn btn-danger btn-sm ml-1 "
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
                <h5 class="modal-title">Détail de la dévis: {{ $value->reference_devis }}</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row col-md-12">
                    <div class="col-md-6">
                        <h3 class="">PROFORMA</h3>
                        <h4>N° {{ $value->reference_devis }}</h4>
                        <h4>Date: {{ $value->date_devis }}</h4>
                    </div>
                    <div class="col-md-6">
                        <h3 class="">COORDONNEES DU CLIENT</h3>
                        <h4>{{ $value->nom_client.' '.$value->prenom_client.' '.$value->raison_s_client }}</h4>
                        <h4>Tel: {{ $value->phone_1_client }}/{{ $value->phone_2_client }}</h4>
                        <h4>BP : {{ $value->postale }}</h4>
                    </div>
                </div>
                <label class="nav-label"><span class="font-weight-bold">Objet: </span>{{ $value->objet }}</label>
                <div class="for-produit table-responsive" style="max-height: 300px; overflow: auto">
                    <label class="nav-label h3 text-uppercase">Produits</label>
                    <table class="w-100 table table-bordered">
                        <thead class="bg-primary text-white text-center">
                        <tr class="text-white" style="color: #ffffff!important;">
                            <th>Réf.</th>
                            <th>Désignation</th>
                            <th>Qté</th>
                            <th>P.U.HT.</th>
                            <th>Remise</th>
                            <th>TVA</th>
                            <th>M. HT</th>
                            <th>M. TTC</th>
{{--                            <th><i class="fa fa-trash"></i></th>--}}
                        </tr>

                        </thead>
                        <tbody style="color: #000000!important;">
                        @php
                            $montantTTC = 0;
                        @endphp


                            @foreach($pocedes as $p)
                                <tr class="text-black  produit-input">
                                @php
                                 $montantTTC = 0;
                                $montantHT=0;
                                $montantTVA = 0;
                                @endphp
                                <td>{{ $p->reference }}</td>
                                <td>{{ $p->titre_produit }}</td>
                                <td>{{ $p->quantite }}</td>
                                <td>{{ $p->prix }}</td>
                                <td>{{ $p->remise }}%</td>
                                <td>{{ $p->tva }}%</td>
                                <td>
                                    {{ number_format((($p->prix*$p->quantite)-($p->remise*$p->prix*$p->quantite)/100),2, '.', '') }}
                                </td>
                                <td>
                                    {{  number_format((($p->prix*$p->quantite)-($p->remise*$p->prix*$p->quantite)/100) + (($p->prix*$p->quantite)-($p->remise*$p->prix*$p->quantite*$p->tva)/100), 2, '.', '')  }}
                                </td>
                                @php
                                    $remise = ($p->prix * $p->quantite *$p->remise)/100;
                                    $montant = ($p->quantite * $p->prix) - $remise;
                                    $montantHT += $montant;
                                    $tva = ($montant * $p->tva)/100;
                                    $montant = $tva + $montant;
            //                        $montant += (($montant * 19.25)/100)+$montant;
                                    $montantTVA += $montant;
                                @endphp
                        </tr>
                            @endforeach


                        <tr>
                            <th colspan="6" rowspan="3"></th>
                            <td>Total HT</td>
                            <td>{{ number_format($montantHT,2,'.','') }}</td>

                        </tr>

                        <tr>
                            <td>TVA 19.25%</td>
                            <td>{{ number_format(($montantTVA * 19.25)/100,2,'.','') }}</td>

                        </tr>
                        <tr>
                            <td>Montant TTC</td>
                            <td>{{ number_format(( ($montantTVA * 19.25)/100)+$montantTVA,2,'.','') }}</td>
                        </tr>

                        </tbody>
                    </table>
                </div>
                <hr class="mt-2">
                <div class="for-produit table-responsive" style="max-height: 300px; overflow: auto">
                    <label class="nav-label h3">OFFRE COMPLEMENTAIRE</label>
                    <table class="w-100 table  table-bordered">
                        <thead class="bg-primary text-white text-center">
                        <tr>
                            <th>Réf.</th>
                            <th>Désignation</th>
                            <th>Qté</th>
                            <th>P.U.HT.</th>
                            <th>Remise</th>
                            <th>TVA</th>
                            <th>M. HT</th>
                            <th>M. TTC</th>
{{--                            <th><i class="fa fa-trash"></i></th>--}}
                        </tr>

                        </thead>
                        <tbody style="color: #000000!important;">
                        @php

                            $montantTTC = 0;
                        @endphp


                            @foreach($complements as $p)
                                <tr class="text-black  produit-input">
                                @php
                                    $montantTTC = 0;
                                   $montantHT=0;
                                   $montantTVA = 0;
                                @endphp
                                <td>{{ $p->reference }}</td>
                                <td>{{ $p->titre_produit }}</td>
                                <td>{{ $p->quantite }}</td>
                                <td>{{ $p->prix }}</td>
                                <td>{{ $p->remise }}%</td>
                                <td>{{ $p->tva }}%</td>
                                <td>
                                    {{ number_format((($p->prix*$p->quantite)-($p->remise*$p->prix*$p->quantite)/100),2, '.', '') }}
                                </td>
                                <td>
                                    {{  number_format((($p->prix*$p->quantite)-($p->remise*$p->prix*$p->quantite)/100) + (($p->prix*$p->quantite)-($p->remise*$p->prix*$p->quantite*$p->tva)/100), 2, '.', '')  }}
                                </td>
                                @php
                                    $remise = ($p->prix * $p->quantite *$p->remise)/100;
                                    $montant = ($p->quantite * $p->prix) - $remise;
                                    $montantHT += $montant;
                                    $tva = ($montant * $p->tva)/100;
                                    $montant = $tva + $montant;
            //                        $montant += (($montant * 19.25)/100)+$montant;
                                    $montantTVA += $montant;
                                @endphp
                                </tr>
                            @endforeach


{{--                        <tr>--}}
{{--                            <td colspan="6"></td>--}}
{{--                            <td>Total HT</td>--}}
{{--                            <td>{{ number_format($montantHT,2,'.','') }}</td>--}}
{{--                        </tr>--}}
{{--                        <tr>--}}
{{--                            <td colspan="6"></td>--}}
{{--                            <td>TVA 19.25%</td>--}}
{{--                            <td>{{ number_format(($montantTVA * 19.25)/100,2,'.','') }}</td>--}}
{{--                        </tr>--}}
{{--                        <tr>--}}
{{--                            <td colspan="6"></td>--}}
{{--                            <td>Montant TTC</td>--}}
{{--                            <td>{{ number_format(( ($montantTVA * 19.25)/100)+$montantTVA,2,'.','') }}</td>--}}
{{--                        </tr>--}}

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
