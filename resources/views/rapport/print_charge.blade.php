<!DOCTYPE html>
<html>
<head>
    <title>Presentation facture</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
</head>
<style>
    *{
      font-family: "Roboto", sans-serif;
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

    .forhead {
        display: flex;
        justify-content: center;
        height: 140px;
        margin-top: 0;
        padding-top: 10px;
        background: #EEEEEE;
    }

    .for-logo {
        min-width: 270px;
        max-width: 250px;
    }

    .logo {
        width: 160px;
    }

    .for-factname {
        text-align: center;
        width: 206px;
        display: flex;
        justify-content: center;
        margin-top: 70px;
    }

    .for-infomation {
        font-size: 16px;
        color: #707070;
        /*border: #707070 3px dashed;*/
        height: 90px;
        padding: 10px;
        width: 530px;
    }

    .fact-title {
        margin: 0 0 0 0;
        text-align: center;
    }


    table {
        min-width: 1030px;
        border-collapse: collapse;
    }
    .for-product{
        margin-top: 30px;
    }
    .for-product > .product-table > table > thead > tr > th {
        border: 1px solid #000000;
    }

    .for-product > .product-table > table > tbody > tr > td {
        border: 1px solid #000000;
        /*padding-left: 10px;*/
        /*padding-top: 5px;*/
        padding: 5px;
    }

    .for-paiement > .paiement-table > table > thead > tr > th {
        border: 2px solid #EEEEEE;
        padding-left: 10px;
    }

    .for-paiement > .paiement-table > table > tbody > tr > td {
        border: 2px solid #EEEEEE;
        padding-left: 10px;
        padding-top: 5px;
    }


    .resume-info > td {
        padding-top: 20px;
    }
    .end{
        text-align: right;
    }
    .center{
        text-align: center;
    }
    .bold{
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
<div class="forhead" style="background: #EEEEEE">
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
</div>
<h3 style="text-align: center; margin: 20px;text-transform: capitalize">{{ $titre }}</h3>
<label><i>Période:</i> <strong>{{ $debut }}</strong> au <strong>{{ $fin }}</strong></label><br>
<label><i>Date d'émission:</i> <strong>
        <?= date('d F, Y');?></strong></label>
<div class="for-product">
    <div class="product-table">
        <table>
            <thead>
            <tr>
                <th>Date</th>
                <th>Charges</th>
                <th>Raison</th>
                <th>Qte</th>
                <th>Prix_u</th>
                <th>Total</th>
            </tr>

            </thead>
            <tbody>
            @php
                $total=0;
            @endphp
            @foreach($data as $key=>$value)
                <tr>
                    @php
                        $total +=$value->prix * $value->nombre;
                    @endphp
                    <td class="bold">{{ $value->date_ajout }}</td>
                    <td class="">{{ $value->titre }}</td>
                    <td class="">{{ $value->raison }}</td>
                    <td class="center bold">{{ $value->nombre }}</td>
                    <td class="end bold">{{ $value->prix }} FCFA</td>
                    <td class="end bold">{{ $value->prix * $value->nombre }} FCFA</td>
                </tr>
            @endforeach

            </tbody>
        </table>
    </div>
    <h2>Total: {{ $total }} FCFA</h2>
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
