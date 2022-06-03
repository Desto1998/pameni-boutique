<h5 class="modal-title">Détail de la dévis: {{ $data[0]->reference_devis }}</h5>

<div class="row col-md-12 mt-4">
    <div class="col-md-6">
        <h5 class="">PROFORMA</h5>
        <h6>N° {{ $data[0]->reference_devis }}</h6>
        <h6>Date: {{ $data[0]->date_devis }}</h6>
    </div>
    <div class="col-md-6">
        <h5 class="">COORDONNEES DU CLIENT</h5>
        <h6>{{ $data[0]->nom_client.' '.$data[0]->prenom_client.' '.$data[0]->raison_s_client }}</h6>
        <h6>Tel: {{ $data[0]->phone_1_client }}/{{ $data[0]->phone_2_client }}</h6>
        <h6>BP : {{ $data[0]->postale }}</h6>
    </div>
</div>
<label class="nav-label"><span class="font-weight-bold">Objet: </span>{{ $data[0]->objet }}</label>
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

                <td>{{ $p->reference }}</td>
                <td>
                    <strong>{{ $p->titre_produit }}{{ $p->titre_pocede }}</strong> <br> 
                    <small>{{ $p->description_produit }}{{ $p->description_pocede }}</small>
                </td>
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
                    {{  (new \App\Models\Taxe())->ApplyTVA($montantTVA) }}
                @elseif($data[0]->tva_statut == 2)
                    {{  (new \App\Models\Taxe())->ApplyIS($montantTVA) }}
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
                @elseif($data[0]->tva_statut == 2)
                    {{ number_format(( ($montantTVA * 5.5)/100)+$montantTVA,2,'.','') }}
                @else
                    {{ number_format($montantTVA ,2,'.','') }}
                @endif
            </td>
        </tr>

        </tbody>
    </table>
</div>

<div class="col-md-12 my-3 row">
    <div class="col-md-3 p-3 border">
        <label class="titre font-weight-bold">Validité de l'offre</label><br>
        <label>{{ $data[0]->validite }} semaines</label>
    </div>
    <div class="col-md-3 p-3 border">
        <label class="titre font-weight-bold">Disponibilité</label><br>
        <label>{{ $data[0]->disponibilite }} </label>
    </div>
    <div class="col-md-3 p-3 border">
        <label class="titre font-weight-bold">Garentie</label><br>
        <label>{{ $data[0]->garentie }} mois</label>
    </div>
    <div class="col-md-3 p-3 border">
        <label class="titre font-weight-bold">Conditions financières</label><br>
        <label>{{ $data[0]->condition_financiere }}</label>
    </div>
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

                <td>{{ $p->reference }}</td>
                <td>
                    <strong>{{ $p->titre_produit }}{{ $p->titre_com }}</strong> <br> 
                    <small>{{ $p->description_produit }}{{ $p->description_com }}</small>
                </td>
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
