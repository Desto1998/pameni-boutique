<div class="btn-group text-center">
    <a type="button" title="Cliquez pour effectuer une action" class="dropdown" data-toggle="dropdown">
        <strong>... </strong></a>
    <ul class="dropdown-menu justify-content-center text-center" role="menu">
        <li class="text-center">
            <a href="javascript:void(0);" data-toggle="modal"
               data-target="#facture-view-modal{{ $value->commande_id }}" class="btn btn-success btn-sm ml-1"
               title="Visualiser les details"><i
                    class="fa fa-eye"></i></a>
            <a href="{{ route('commandes.print',['id' =>$value->commande_id]) }}" target="_blank" class="btn btn-light btn-sm ml-1"
               title="Imprimer la facture"><i
                    class="fa fa-file-pdf-o"></i></a>
            @if (Auth::user()->is_admin==1 || Auth::user()->id===$value->id && $value->statut <=1)
                <a href="{{ route('factures.edit',['id' =>$value->commande_id]) }}" class="btn btn-warning btn-sm ml-1"
                   title="Editer la commande"><i
                        class="fa fa-edit"></i></a>
            @endif
        </li>

        <li class="text-center mt-2">

            <a href="javascript:void(0);" data-toggle="modal"
               data-target="#paiement-modal" onclick="getId({{ $value->commande_id }})" class="btn btn-secondary btn-sm ml-1"
               title="Ajouter un paiement."><i
                    class="fa fa-money"></i></a>

            @if ($value->statut===0 && Auth::user()->is_admin==1)
                <a href="javascript:void(0);" onclick="validerFun({{ $value->commande_id}})"
                   class="btn btn-primary btn-sm ml-1"
                   title="Marquer comme validé"><i
                        class="fa fa-check"></i></a>
            @endif

            @if ($value->statut ===1 && Auth::user()->is_admin==1)
                <a href="javascript:void(0);" onclick="bloquerFun({{ $value->commande_id }})"
                   class="btn btn-dark btn-sm ml-1"
                   title="Marquer comme non validé."><i
                        class="fa fa-close"></i></a>
            @endif

            @if (Auth::user()->is_admin==1)
                <button class="btn btn-danger btn-sm ml-1 "
                        title="Supprimer cette facture" id="deletebtn{{ $value->commande_id }}"
                        onclick="deleteFun({{ $value->commande_id }})"><i
                        class="fa fa-trash"></i></button>
            @endif
        </li>
    </ul>
</div>

<div class="modal fade bd-example-modal-lg" id="facture-view-modal{{ $value->commande_id }}" tabindex="-1" role="dialog"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Détail de la commande: {{ $value->reference_commande }}</h5>
                <a href="{{ route('commandes.view',['id' =>$value->commande_id]) }}" class="mx-5 ml-1"
                   title="Plus de details">Voir plus</a>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row col-md-12">
                    <div class="col-md-6">
                        <h5 class="">Bon de commande</h5>
                        <h6>N° {{ $value->reference_comamnde }}</h6>
                        <h6>Date: {{ $value->date_fact }}</h6>
                    </div>
                    <div class="col-md-6">
                        <h5 class="">COORDONNEES DU CLIENT</h5>
                        <h6>{{ $value->nom_fr.' '.$value->prenom_fr.' '.$value->raison_s_fr }}</h6>
                        <h6>Tel: {{ $value->phone_1_fr }}/{{ $value->phone_2_fr }}</h6>
                        <h6>BP : {{ $value->postale }}</h6>
                    </div>
                </div>
                <label class="nav-label"><span class="font-weight-bold">Objet: </span>{{ $value->observation }}</label>
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

                                <td>{{ $p->reference }}</td>
                                <td>{{ $p->titre_produit }}</td>
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
                            <td>TVA 19.25%</td>
                            <td>
                                @if ($value->tva_statut == 1)
                                    {{ number_format(($montantTVA * 19.25)/100,2,'.','') }}
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
                                @else
                                    {{ number_format($montantTVA ,2,'.','') }}
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
