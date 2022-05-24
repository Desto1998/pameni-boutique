<h5 class="modal-title">Détail de la facture: {{ $data[0]->reference_fact }}</h5>
{{--<button type="button" class="close" data-dismiss="modal"><span>&times;</span>--}}
{{--</button>--}}
<div class="row col-md-12 mt-4">
    <div class="col-md-6">
        <h5 class="">Facture</h5>
        <h6>N° {{ $data[0]->reference_fact }}</h6>
        <h6>Date: {{ $data[0]->date_fact }}</h6>
    </div>
    <div class="col-md-6 align-content-end justify-content-end">
        <h5 class="">COORDONNEES DU CLIENT</h5>
        <h6>{{ $data[0]->nom_client.' '.$data[0]->prenom_client.' '.$data[0]->raison_s_client }}</h6>
        <h6>Tel: {{ $data[0]->phone_1_client }}/{{ $data[0]->phone_2_client }}</h6>
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
            $montantTTC = (new \App\Models\Factures())->montantTotal($data[0]->facture_id);
            $montantHT=(new \App\Models\Factures())->montantHT($data[0]->facture_id);
            $montantTVA=0;
        @endphp


        @foreach($pocedes as $p)
            @php
                $remise = ($p->prix * $p->quantite *$p->remise)/100;
                $montant = ($p->quantite * $p->prix) - $remise;
                $HT = $montant;

                $tva = ($montant * $p->tva)/100;
                $montant = $tva + $montant;
                $TTC = $montant;
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
            <td>{{ $montantHT }}</td>

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
            <td>Montant TTC</td>
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
@if (isset($piece[0]))
    <div class="row mt-4">
        <label class="nav-label w-100">Informations du bon de commade</label>
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
                <p class="font-weight-bold text-danger">Aucune image entregistrée pour l'instant.</p>
            @endif

        </div>
    </div>
@endif
