
{{--<h5 class="modal-title">Détail de la commande: {{ $data[0]->reference_commande }}</h5>--}}
{{--<button type="button" class="close" data-dismiss="modal"><span>&times;</span>--}}
{{--</button>--}}
<div class="row col-md-12 mt-0">
    <div class="col-md-6">
        <h5 class="">Bon de commande</h5>
        <h6>N° {{ $data[0]->reference_commande }}</h6>
        <h6>Date: {{ $data[0]->date_commande }}</h6>
        <h6>Devis/Proformat: @isset($piece[0]->ref){{ $piece[0]->ref }} @endisset</h6>
        <h6>Du: @isset($piece[0]->ref){{ $piece[0]->date_piece }} @endisset</h6>
    </div>
    <div class="col-md-6">
        <h5 class="">COORDONNEES DU FOURNISSEUR</h5>
        <h6>{{ $data[0]->nom_fr.' '.$data[0]->prenom_fr.' '.$data[0]->raison_s_fr }}</h6>
        <h6>Tel: {{ $data[0]->phone_1_fr }}/{{ $data[0]->phone_2_fr }}</h6>
        <h6>BP : {{ $data[0]->postale }}</h6>
    </div>
</div>
<label class="nav-label"><span class="font-weight-bold">Objet: </span>{{ $data[0]->objet }}</label>
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
                @if ($data[0]->tva_statut == 1)
                    {{ number_format(($montantTVA * 19.25)/100,2,'.','') }}
                @else
                    0
                @endif

            </td>

        </tr>
        <tr>
            <td>Montant TTC</td>
            <td>
                @if ($data[0]->tva_statut == 1)
                    {{ number_format(( ($montantTVA * 19.25)/100)+$montantTVA,2,'.','') }}
                @else
                    {{ number_format($montantTVA ,2,'.','') }}
                @endif
            </td>
        </tr>

        </tbody>
    </table>

</div>
<div class="my-3 d-inline-flex">
    <div class="col-md-3 p-3 border">
        <label class="w-100 font-weight-bold">Observation</label>
        <small class="mt-1">{{ $data[0]->observation }}</small>
    </div>
    <div class="col-md-3 p-3 ml-1 border">
        <label class="w-100 font-weight-bold">Mode de paiement</label>
        <small class="mt-1">{{ $data[0]->mode_paiement }}</small>
    </div>
    <div class="col-md-3 p-3 ml-1 border">
        <label class="w-100 font-weight-bold">Condition de paiement</label>
        <small class="mt-1">{{ $data[0]->condition_paiement }}</small>
    </div>
    <div class="col-md-3 p-3 ml-1 border">
        <label class="w-100 font-weight-bold">Delai de livraison</label>
        <small class="mt-1">{{ $data[0]->delai_liv }}</small>
    </div>

</div>
<div class="col-md-3 p-3 my-2 border">
    <label class="w-100 font-weight-bold">Lieu de livraison</label>
    <small class="mt-1">{{ $data[0]->lieu_liv }}</small>
</div>
@if (isset($piece[0]))
    <div class="row mt-4">
        <label class="nav-label w-100">Informations du devis/proformat</label>
        <div class="col-md-4">

            <label class="my-2">Reference: <span class="font-weight-bold">{{ $piece[0]->ref }}</span></label><br>
            <label class="my-2">Date: <span class="font-weight-bold">{{ $piece[0]->date_piece }}</span></label>
        </div>
        <div class="col-md-8 d-flex justify-content-center">
            @if ($piece[0]->chemin)
                <a href="{{ asset('images/piece/'.$piece[0]->chemin) }}" target="_blank" class="">
                    <img ref="{{ asset('images/piece/'.$piece[0]->chemin) }}" style="max-width: 500px; max-height: 400px"
                         src="{{ asset('images/piece/'.$piece[0]->chemin) }}" alt="Aucune image pour l'instant">
                </a>
            @else
                <p class="font-weight-bold text-danger">Aucune image entregistree pour l'instant.</p>
            @endif

        </div>
    </div>
@endif
