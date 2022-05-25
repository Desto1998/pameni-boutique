<h5 class="modal-title">Détail de la facture avoir: {{ $data[0]->reference_avoir }}</h5>
{{--<button type="button" class="close" data-dismiss="modal"><span>&times;</span>--}}
{{--</button>--}}
<div class="row col-md-12">
    <div class="col-md-6">
        <h5 class="">Facture Avoir</h5>
        <h6>N° {{ $data[0]->reference_avoir }}</h6>
        <h6>Date: {{ $data[0]->date_avoir }}</h6>
        <h6>Facture N: {{ $factures[0]->reference_fact }}</h6>
    </div>
    <div class="col-md-6">
        <h5 class="">COORDONNEES DU CLIENT</h5>
        <h6>{{ $factures[0]->nom_client.' '.$factures[0]->prenom_client.' '.$factures[0]->raison_s_client }}</h6>
        <h6>Tel: {{ $factures[0]->phone_1_client }}/{{ $factures[0]->phone_2_client }}</h6>
        <h6>BP : {{ $factures[0]->postale }}</h6>
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
            $montantTTC = (new \App\Models\Avoirs())->montantTotal($data[0]->avoir_id);
            $montantHT = (new \App\Models\Avoirs())->montantHT($data[0]->avoir_id);
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
                #$montantTVA += $montant;
            @endphp
            <tr class="text-black  produit-input">

                <td>{{ $p->reference }}</td>
                <td>{{ $p->titre_produit }} &nbsp;&nbsp; <small>{{ $p->description_produit }}</small></td>
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
            @if ($data[0]->tva_statut == 2)
                <td class="total">IS 5.5%</td>
            @else
                <td class="total">TVA 19.25%</td>
            @endif
            <td>
                @if ($data[0]->tva_statut == 1)
                    {{  (new \App\Models\Taxe())->ApplyTVA($montantHT) }}
                @elseif($data[0]->tva_statut == 2)
                    {{  (new \App\Models\Taxe())->ApplyIS($montantHT) }}
                @else
                    0
                @endif

            </td>

        </tr>
        <tr>
            <td>Net à déduire</td>
            <td>
                @if ($data[0]->tva_statut == 1 || $data[0]->tva_statut == 2)
                    {{ $montantTTC }}
                @else
                    {{ $montantHT }}
                @endif
            </td>
        </tr>

        </tbody>
    </table>
</div>
