<div class="btn-group text-center">
    <a type="button" title="Cliquez pour effectuer une action" class="dropdown" data-toggle="dropdown">
        <strong>... </strong></a>
    <ul class="dropdown-menu justify-content-center text-center" role="menu">
        <li class="text-center">
            <a href="javascript:void(0);" data-toggle="modal"
               data-target="#facture-view-modal{{ $value->avoir_id }}" class="btn btn-success btn-sm ml-1"
               title="Visualiser les details"><i
                    class="fa fa-eye"></i></a>
            <a href="{{ route('avoir.print',['id' =>$value->avoir_id]) }}" target="_blank" class="btn btn-light btn-sm ml-1"
               title="Imprimer la facture"><i
                    class="fa fa-file-pdf-o"></i></a>
            @if (Auth::user()->is_admin==1 || $value->statut <=1)
                @if(Auth::user()->is_admin==1 || Auth::user()->id===$value->id)
                    <a href="{{ route('avoir.edit',['id' =>$value->avoir_id]) }}" class="btn btn-warning btn-sm ml-1"
                       title="Editer la facture"><i
                            class="fa fa-edit"></i></a>
                @endif
            @endif

        </li>

        <li class="text-center mt-2">
{{--            @if ($value->statut ==1)--}}
{{--                @if ((new \App\Models\Factures())->montantTotal($value->avoir_id) - (new \App\Models\Factures())->Payer($value->facture_id)>0)--}}
{{--                    <a href="javascript:void(0);" data-toggle="modal"--}}
{{--                       data-target="#paiement-modal" onclick="getId({{ $value->avoir_id }})" class="btn btn-secondary btn-sm ml-1"--}}
{{--                       title="Ajouter un paiement."><i--}}
{{--                            class="fa fa-money"></i></a>--}}
{{--                @endif--}}
{{--            @endif--}}
            @if(Auth::user()->is_admin==1 || Auth::user()->id===$value->id )
                @if($value->statut ==1)
                    <a href="javascript:void(0);" onclick="recoverFun({{ $value->avoir_id }})" class="btn btn-secondary btn-sm ml-1"
                       title="Recouvrir le montant de la caisse"><i
                            class="fa fa-dollar"></i></a>
                @endif
            @endif
            @if ($value->statut===0 && Auth::user()->is_admin==1)
                <a href="javascript:void(0);" onclick="validerFun({{ $value->avoir_id }})"
                   class="btn btn-primary btn-sm ml-1"
                   title="Marquer comme validé"><i
                        class="fa fa-check"></i></a>
            @endif

            @if ($value->statut ===1 && Auth::user()->is_admin==1)
                <a href="javascript:void(0);" onclick="bloquerFun({{ $value->avoir_id }})"
                   class="btn btn-dark btn-sm ml-1"
                   title="Marquer comme non validé."><i
                        class="fa fa-close"></i></a>
            @endif

            @if (Auth::user()->is_admin==1)
                <button class="btn btn-danger btn-sm ml-1 "
                        title="Supprimer cette facture" id="deletebtn{{ $value->avoir_id }}"
                        onclick="deleteFun({{ $value->avoir_id }})"><i
                        class="fa fa-trash"></i></button>
            @endif
        </li>
    </ul>
</div>

<div class="modal fade bd-example-modal-lg" data-backdrop="static" id="facture-view-modal{{ $value->avoir_id }}" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Détail de la facture: {{ $value->reference_avoir }}</h5>
                <a href="{{ route('avoir.view',['id' =>$value->avoir_id]) }}" class="mx-5 ml-1"
                   title="Plus de details">Voir plus</a>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row col-md-12">
                    <div class="col-md-6">
                        <h5 class="">Facture Avoir</h5>
                        <h6>N° {{ $value->reference_avoir }}</h6>
                        <h6>Date: {{ $value->date_avoir }}</h6>
                        <h6>Facture N: {{ $factures[0]->reference_fact }}</h6>
                    </div>
                    <div class="col-md-6">
                        <h5 class="">COORDONNEES DU CLIENT</h5>
                        <h6>{{ $factures[0]->nom_client.' '.$factures[0]->prenom_client.' '.$factures[0]->raison_s_client }}</h6>
                        <h6>Tel: {{ $factures[0]->phone_1_client }}/{{ $factures[0]->phone_2_client }}</h6>
                        <h6>BP : {{ $factures[0]->postale }}</h6>
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
                            $montantTTC = (new \App\Models\Avoirs())->montantTotal($value->avoir_id);
                            $montantHT = (new \App\Models\Avoirs())->montantHT($value->avoir_id);
                            $montantTVA=0;
                        @endphp


                        @foreach($pocedes as $p)
                            @php
                                $remise = ($p->prix * $p->quantite *$p->remise)/100;
                                $montant = ($p->quantite * $p->prix) - $remise;
                                $HT = $montant;

                                #$montantHT += $montant;
                                $tva = ($montant * $p->tva)/100;
                                $montant = $tva + $montant;
                                $TTC = $montant;
                                //$montantTVA += $montant;
                            @endphp
                            <tr class="text-black  produit-input">

                                <td>{{ $p->reference }}{{ $p->reference_avoir }}</td>
                                <td>{{ $p->titre_produit }}{{ $p->titre_avoir }} &nbsp;&nbsp; <small>{{ $p->description_produit }}{{ $p->description_avoir }}</small></td>
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
                                    {{  (new \App\Models\Taxe())->ApplyTVA($montantHT) }}
                                @elseif($value->tva_statut == 2)
                                    {{  (new \App\Models\Taxe())->ApplyIS($montantHT) }}
                                @else
                                    0
                                @endif

                            </td>

                        </tr>
                        <tr>
                            <td>Montant TTC</td>
                            <td>
                                @if ($value->tva_statut == 1 || $value->tva_statut == 2)
                                    {{ $montantTTC }}
                                @else
                                    {{ $montantHT }}
                                @endif
                            </td>
                        </tr>

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
