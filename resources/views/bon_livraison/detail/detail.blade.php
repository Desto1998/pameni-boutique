<div class="row col-md-12">
    <div class="col-md-6">
        <h5 class="">Bon de livraison</h5>
        <h6>N° {{ $data[0]->reference_bl }}</h6>
        <h6>Date: {{ $data[0]->date_bl }}</h6>
    </div>
    <div class="col-md-6">
        <h5 class="">COORDONNEES DU CLIENT</h5>
        <h6>{{ $devis[0]->nom_client.' '.$devis[0]->prenom_client.' '.$devis[0]->raison_s_client }}</h6>
        <h6>Tel: {{ $devis[0]->phone_1_client }}/{{ $devis[0]->phone_2_client }}</h6>
        <h6>BP : {{ $devis[0]->postale }}</h6>
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
                {{--                                <td>{{ $p->prix }}</td>--}}
                {{--                                <td>{{ $p->remise }}%</td>--}}
                {{--                                --}}{{--                                <td>{{ $p->tva }}%</td>--}}
                {{--                                <td>--}}
                {{--                                    {{ number_format($HT,2, '.', '') }}--}}
                {{--                                </td>--}}
                {{--                                <td>--}}
                {{--                                    {{  number_format($TTC, 2, '.', '')  }}--}}
                {{--                                </td>--}}

            </tr>
        @endforeach

        </tbody>
    </table>
</div>
