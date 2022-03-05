<!DOCTYPE html>
<html>
<head>
    <title>Presentation facture</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
</head>
<style>
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
</style>
<body>
<div class="forhead" style="background: #EEEEEE">
    <table style="background: #EEEEEE; padding: 5px">
        <tr>
            <td>
                <div class="for-infomation">
                    <h2>RAPPORT DES CHARGES</h2>

                </div>
            </td>
            <td>
                <div class="for-factname">

                </div>
            </td>
            <td>

                <div class="for-logo">

                    @php
                        $ImagePath = $_SERVER["DOCUMENT_ROOT"] . '/images/logo/logo_gssc.png';

                    @endphp

                    {{--                    <img src="{{ asset('images/logo/logo_gssc.png') }}" class="logo" alt="Logo not found">--}}
                    <img src="{{ $ImagePath }}" class="logo" alt="Logo not found">

                </div>
            </td>
        </tr>
    </table>
</div>
<h3 style="text-align: center; margin: 20px;">{{ $titre }}</h3>
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

</body>
</html>
