<!DOCTYPE html>
<html>
<head>
    <title>Presentation facture</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
</head>
<style>
    * {
        font-family: "Roboto", sans-serif;
    }

    table {
        border-collapse: collapse;
    }

    header table tr td {
        padding-right: 30px;
    }

    header table .for-logo img {
        width: 100px;
    }

    header table .for-name {
        text-align: center;
    }

    header table .for-name p {
        font-size: 12px;
    }

    header table .for-name h3 {
        font-family: "Arial Black";
        color: #0c85d0;
    }

    .for-infos table {
        min-width: 100%;
        font-size: 13px;
    }

    .client-details, .devis-details {
        padding: 10px;
        line-height: 1.4;
    }

    .client-details {
        border: 1px solid #2A2C32;
        border-radius: 10px;
        padding: 5px;
        width: 200px;
    }

    td.devis-info {
        width: 480px;
    }

    .for-objet, .for-complement label {
        margin: 15px 0;
    }

    .for-produit table, .for-complement table {
        width: 100%;
        font-size: 12px;
    }

    .for-produit table thead tr th, .for-produit table tbody tr td {
        border: #000000 1px solid;
        padding: 5px;
    }

    .for-complement {
        margin: 20px 0
    }

    .for-complement table thead tr th, .for-complement table tbody tr td {
        border: #000000 1px solid;
        padding: 5px;
    }

    .bg-primary {
        background-color: #0c85d0;
        padding: 2em;
        text-align: center;
        color: #ffffff;
    }

    .number {
        text-align: right;
    }

    .total {
        font-weight: 700;
    }

    .for-garentie {
        width: 100%;
        margin-top: 20px;
    }

    .for-garentie tr td div {
        font-size: 12px;
        line-height: 1.6;
        padding: 8px;
        border: #EEEEEE solid 1px;
        height: 50px;
        width: 155px;
    }

    .for-garentie tr td div .titre {
        font-weight: 700;
    }

    footer {
        position: fixed;
        bottom: -70px;
        left: 0px;
        right: 0px;
        height: 120px;
        text-align: center;
        line-height: 1;
        font-size: 12px;
    }

    footer table {
        width: 100%;
    }

    footer table tr td {
        width: 33%;
    }

    footer table tr div {
        width: 200px;
        background-color: #0c85d0;
        padding: 10px;
        border-radius: 10px;
        color: #ffffff;
    }
</style>
<body>
<header class="forhead">
    <table class="heading-table">
        <tr>
            <td class="for-logo">
                @php
                    $ImagePath = $_SERVER["DOCUMENT_ROOT"] . '/images/logo/logo_gssc.png';
                @endphp

                {{--                    <img src="{{ asset('images/logo/logo_gssc.png') }}" class="logo" alt="Logo not found">--}}
                <img src="{{ $ImagePath }}" class="logo" alt="Logo not found">
            </td>
            <td class="for-name">
                <h3>{{ 'GLOBAL SOFT & COMMUNICATION Sarl' }}</h3>
                <p>
                    <strong>GSC:</strong> Rue foch face direction Orange, DOUALA CAMEROUN <br><br>
                    <strong>DSP: {{ $data[0]->firstname }} {{ $data[0]->lastname }} {{ $data[0]->phone }} </strong>
                </p>

            </td>
            <td class="for-date">

                <strong>{{ (new DateTime($data[0]->date_devis))->format('d').' '.$mois.' '.(new DateTime($data[0]->date_devis))->format('Y') }}</strong>
            </td>
        </tr>
    </table>
</header>

<div class="for-infos">
    <table class="devis-info">
        <tr>
            <td class="devis-info">
                <div class="devis-details">
                    <strong style="text-decoration: underline">PROFORMAT</strong><br>
                    <strong>{{ $data[0]->reference_devis }}</strong><br>
                    <strong>Contibibuable n°</strong><br>
                    <strong>M06191391224E</strong><br>
                </div>

            </td>
            <td>
                <div class="client-details">
                    <strong style="text-decoration: underline">COORDONNEES CLIENT</strong><br>
                    <strong>{{ $data[0]->nom_client }} {{ $data[0]->prenom_client }} {{ $data[0]->raison_s_client }}</strong><br>
                    <strong>Tel: {{ $data[0]->phone_1_client }}  {{ isset($data[0]->phone_2_client)?'/'.$data[0]->phone_2_client:''  }}</strong><br>
                    <strong>BP: {{ $data[0]->postale }}  </strong><br>
                    @if ($data[0]->type_client==1)
                        <strong>{{ $data[0]->contribuable }}  </strong><br>
                        <strong>NC: {{ $data[0]->rcm }}  </strong><br>
                    @endif
                </div>
            </td>
        </tr>
    </table>
</div>
<div class="for-objet"><strong>Objet:</strong> {{ $data[0]->objet }}</div>
<div class="for-produit">
    <table class="table-produit">
        <thead class="bg-primary text-white text-center">
        <tr class="text-white">
            <th>Réf.</th>
            <th>Désignation</th>
            <th>Qté</th>
            <th>P.U.HT.</th>
            <th>Remise</th>
{{--            <th>TVA</th>--}}
            <th>M. HT(FCFA)</th>
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
                <td class="number">{{ $p->quantite }}</td>
                <td class="number">{{ $p->prix }}</td>
                <td class="number">{{ $p->remise }}%</td>
{{--                <td class="number">{{ $p->tva }}%</td>--}}
                <td class="number">
                    {{ number_format($HT,2, '.', '') }}
                </td>
                <td class="number">
                    {{  number_format( $TTC, 2, '.', '')  }}
                </td>

            </tr>
        @endforeach

        <tr>
            <th colspan="5" rowspan="3"></th>
            <td class="total">Total HT</td>
            <td class="number total">{{ number_format($montantHT,2,'.','') }}</td>

        </tr>

        <tr>
            <td class="total">TVA 19.25%</td>
            <td class="number total">
                @if ($data[0]->tva_statut == 1)
                    {{ number_format(($montantTVA * 19.25)/100,2,'.','') }}
                @else
                    0
                @endif
            </td>

        </tr>
        <tr>
            <td class="total">Montant TTC</td>
            <td class="number total">
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
<div class="for-prix">
    <strong>
{{--        {{ (new \App\Models\ChiffreLettre())->Conversion(number_format(( ($montantTVA * 19.25)/100)+$montantTVA,0,'.','')) }}--}}
        @if ($data[0]->tva_statut == 1)
            {{ ucfirst((new \App\Models\ChiffreLettre())->Conversion(number_format(( ($montantTVA * 19.25)/100)+$montantTVA,0,'.',''))) }}
        @else
            {{ ucfirst((new \App\Models\ChiffreLettre())->Conversion(number_format($montantTVA ,2,'.',''))) }}
        @endif francs CFA
    </strong>
</div>

<table class="for-garentie">
    <tr>
        <td>
            <div>
                <label class="titre">Validité de l'offre</label><br>
                <label>{{ $data[0]->validite }} semaines</label>
            </div>
        </td>
        <td>
            <div>
                <label class="titre">Disponibilité</label><br>
                <label>{{ $data[0]->disponibilite }} </label>
            </div>
        </td>
        <td>
            <div>
                <label class="titre">Garentie</label><br>
                <label>{{ $data[0]->garentie }}</label>
            </div>
        </td>
        <td>
            <div>
                <label class="titre">Conditions financières</label><br>
                <label>{{ $data[0]->condition }} semaines</label>
            </div>
        </td>
    </tr>
</table>
<div class="for-complement">
    <div style="margin-bottom: 10px">
        <strong style="text-decoration: underline;">OFFRE COMPLEMENTAIRE</strong><br>
    </div>
    <table class="table-complement">
        <thead class="bg-primary text-white text-center">
        <tr>
            <th>Réf.</th>
            <th>Désignation</th>
            <th>Qté</th>
            <th>P.U.HT.</th>
            <th>Remise</th>
{{--            <th>TVA</th>--}}
            <th>M. HT(FCFA)</th>
            <th>M. TTC</th>
        </tr>
        </thead>
        <tbody style="color: #000000!important;">

        @php
            $montantTTC = 0;
           $montantHT=0;
           $montantTVA = 0;
        @endphp
        @foreach($complements as $p)
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
                <td class="number">{{ $p->quantite }}</td>
                <td class="number">{{ $p->prix }}</td>
                <td class="number">{{ $p->remise }}%</td>
{{--                <td class="number">{{ $p->tva }}%</td>--}}
                <td class="number">
                    {{ number_format($HT,2, '.', '') }}
                </td>
                <td class="number">
                    {{  number_format($TTC, 2, '.', '')  }}
                </td>

            </tr>
        @endforeach
        @if (count($complements)===0)
            <td colspan="3"></td>
            <td colspan="3"></td>
            <td colspan="3"></td>
            <td colspan="3"></td>
            <td colspan="3"></td>
            <td colspan="3"></td>
            <td colspan="3"></td>
            <td colspan="3"></td>
        @endif
        </tbody>
    </table>
</div>
<footer class="for-footer">
    <table class="table-footer">
        <tr>
            <td>
                <div>
                    <strong>Douala</strong>-
                    Akwa boulevard de la libertee face Direction Orange Akwa Douala<br>
                    gscdla@gsc-technology.com
                </div>
            </td>
            <td>
                <div>
                    <strong>Yaounde</strong>, Rond pointNlongkak immeuble Pharmacie Lumiere
                    <br>
                    gscyde@gsc-technology.com
                </div>
            </td>
            <td>
                <div>
                    <strong>Garoua</strong>, centre Commercial face Direction PMUC<br>
                    gscgaroua@gsc-technology.com
                </div>
            </td>
        </tr>
    </table>
</footer>
</body>
</html>