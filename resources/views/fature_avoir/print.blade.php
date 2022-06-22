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

    .for-date{
        width: 200px;
        justify-content: right;
        text-align: center;
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
        width: 445px;
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
        margin: 40px 0;
    }

    .for-garentie tr td  {
        width: 50%;
    }
    .for-garentie tr td div {
        font-size: 12px;
        line-height: 1.6;
        padding: 8px;
        border: #a5a3a3 solid 1px;
        /*height: 50px;*/

    }

    .for-garentie tr td div .titre {
        font-weight: 700;
    }
    .space-for-footer{
        height: 205px;
    }
    footer {
        position: fixed;
        bottom: -70px;
        left: 0px;
        right: 0px;
        height: 200px;
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
        width: 158px;
        background-color: #0c85d0;
        padding: 10px;
        border-radius: 10px;
        color: #ffffff;
        font-size: 9px;
    }
</style>
<body style="margin-left: 7px; margin-right: 5px;">
<header class="forhead">
    <table class="heading-table">
        <tr>
            <td class="for-logo">
                @php
                    $ImagePath = $_SERVER["DOCUMENT_ROOT"] . '/public/images/logo/logo_gssc.png';
                @endphp

                {{--                    <img src="{{ asset('images/logo/logo_gssc.png') }}" class="logo" alt="Logo not found">--}}
                <img src="{{ $ImagePath }}" class="logo" alt="Logo not found">
            </td>
            <td class="for-name">
                <h3>{{ 'GLOBAL SOFT & COMMUNICATION Sarl' }}</h3>
                <p>
                    <strong>GSC:</strong> Rue Castelnau face direction commerciale MTN derrière Akwa Palace, DOUALA CAMEROUN <br>
                    <strong style="padding-top: 8px; text-transform: uppercase">DSP: {{ $data[0]->firstname }} {{ $data[0]->lastname }} {{ $data[0]->phone }} </strong>
                </p>

            </td>
            <td class="for-date">
                <strong>{{ (new DateTime($data[0]->date_avoir))->format('d').' '.$mois.' '.(new DateTime($data[0]->date_avoir))->format('Y') }}</strong>
            </td>
        </tr>
    </table>
</header>

<div class="for-infos">
    <table class="devis-info">
        <tr>
            <td class="devis-info">
                <div class="devis-details">
                    <strong style="text-decoration: underline">FACTURE AVOIR</strong><br>
                    <strong>{{ $data[0]->reference_avoir }}</strong><br>
                    <strong>Contibibuable n°</strong><br>
                    <strong>M06191391224E</strong><br>
                </div>

                <div class="devis-details" style="margin-top: 15px">
                    <strong style="text-decoration: underline">Coordonnée bancaire</strong><br>
                    <strong>CCA-Bank</strong><br>
                    <strong>N° de compte: 00258112901</strong><br>
                    <strong>Code banque: 10039</strong><br>
                    <strong>Code Guichet: 10039</strong><br>
                    <strong>clé: 30</strong><br>

                </div>

            </td>
            <td>
                <div class="client-details">
                    <strong style="text-decoration: underline">COORDONNEES CLIENT</strong><br>
                    <strong style="text-transform: uppercase">{{ $factures[0]->nom_client }} {{ $factures[0]->prenom_client }} {{ $factures[0]->raison_s_client }}</strong><br>
                    <strong>Tel: {{ $factures[0]->phone_1_client }}  {{ isset($factures[0]->phone_2_client)?'/'.$factures[0]->phone_2_client:''  }}</strong><br>
                    <strong>BP: {{ $factures[0]->postale }}  </strong><br>
                    @if ($factures[0]->type_client==1)
                        <strong>{{ $factures[0]->contribuable }}  </strong><br>
                        <strong>NC: {{ $factures[0]->rcm }}  </strong><br>
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
                $montantTVA += $montant;
            @endphp
            <tr class="text-black  produit-input">

                <td>{{ $p->reference }}{{ $p->reference_avoir }}</td>
                <td>
                    <strong>{{ $p->titre_produit }}{{ $p->titre_avoir }}</strong> <br>
                    <small>{{ $p->description_produit }}{{ $p->description_avoir }}</small>
                </td>
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
            @if ($data[0]->tva_statut == 2)
                <td class="total">IS 5.5%</td>
            @else
                <td class="total">TVA 19.25%</td>
            @endif
            <td class="number total">
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
            <td class="total">Net à déduire</td>
            <td class="number total">
                {{ number_format( (new \App\Models\Avoirs())->montantTotal($data[0]->avoir_id),2,'.',' ') }}
            </td>
        </tr>
        </tbody>
    </table>
</div>
<div class="for-prix">


    {{--        {{ (new \App\Models\ChiffreLettre())->Conversion(number_format(( ($montantTVA * 19.25)/100)+$montantTVA,0,'.','')) }}--}}
    <strong>
        Montant  net à déduire:<br>
        {{--        {{ (new \App\Models\ChiffreLettre())->Conversion(number_format(( ($montantTVA * 19.25)/100)+$montantTVA,0,'.','')) }}--}}
        @php

            if ($data[0]->tva_statut == 1){
                     $montantTVA = (($montantTVA * 19.25)/100)+ $montantTVA;
                     //ucfirst((new \App\Models\ChiffreLettre())->Conversion(number_format($montantTVA ,2,'.','')))
                }elseif ($data[0]->tva_statut == 2){
                    $montantTVA = (($montantTVA * 5.5)/100)+ $montantTVA;
            }
             $intpart = number_format($montantTVA ,2,'.','');
             $intpart = floor($intpart);
             $fraction = number_format($montantTVA ,2,'.','') - $intpart;
             $chaine = "$fraction"."000";
             $chaine2 = $chaine[2];
             $chaine2 .= $chaine[3];
             $chaineIntPart = (new \App\Models\ChiffreLettre())->Conversion($intpart);
             $chaineDecimalPart = (new \App\Models\ChiffreLettre())->Conversion((int)($chaine2));

        @endphp
        @if ((int)$chaine2==0)
            {{ ucfirst($chaineIntPart) }}
        @else
            {{ ucfirst($chaineIntPart) }} {{ "virgule" }} {{ $chaineDecimalPart }}
        @endif
        francs CFA
    </strong>

</div>

<table class="for-garentie" style="text-align: justify">
    <tr>
        <td>
            <div>
                <label class="titre">CONDITION DE GARANTIE:</label><br>
                <small>
                    La garantie est valable dans le cas de défauts d'usine et ainsi que les pannes dues aux
                    défauts de fabrication.<br>
                    Les équipements électroniques livrés par nos soins doivent être sous protection électrique recommandée par le constructeur.
                </small>
            </div>
        </td>

        <td>
            <div>
                <label class="titre">Note: </label><br>
                <small>Toutes les fournitures restent la propriété exclusive

                    de Global Soft and Communication Sarl jusqu'au règlement intégral de la facture par le client.

                    Nos Tarifs sont confidentiels ne sont utilisables et adressés qu'à nos clients,

                    la diffusion de cette facture et son contenu sont strictement interdits.

                </small>
            </div>
        </td>
    </tr>
</table>
{{-- <div class="space-for-footer"></div> --}}
<footer class="for-footer">
    @php
        $ImagePath = $_SERVER["DOCUMENT_ROOT"] . '/public/images/logo/logo-partenaire-gsc.png';
    @endphp
       <img style="width: 100%;" src="{{ $ImagePath }}" alt="Logo Partenaire non trouvable">
    {{--     <img  src="{{ asset('images/logo/logo-partenaire-gsc.png') }}" alt="logo Partenaire non trouvable">--}}
    <table class="table-footer">
        <tr>
            <td>
                <div>
                    <strong>Douala</strong>-
                    AKWA rue Castelneau face direction commerciale MTN derrière Akwa Palace,  DOUALA CAMEROUN<br>
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
            <td>
                <div>
                    <strong>Ndjamena, Tchad</strong> - avenue Ngarterie Mathias axe<br>
                    gsctchad@gsc-technology.com
                </div>
            </td>
        </tr>
    </table>
</footer>
</body>
</html>
