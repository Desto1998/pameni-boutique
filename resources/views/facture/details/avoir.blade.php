<div class="col-md-12 mb-3">
    <label class="float-left h4">Liste des factures avoirs pour cette facture</label>

</div>
<div class="table-responsive mt-5">
    <table id="example" class="text-center w-100 table">
        <thead class="bg-primary">
        <tr>
            <th>#</th>
            <th>Date</th>
            <th>Reference</th>
            <th>Objet</th>
            <th>Montant</th>
            <th>Par</th>
            <th>Créé le</th>
        </tr>
        </thead>
        <tbody>
        @php
            $total =0;
        @endphp
        @foreach($avoirs as $k =>$item)
            @php
                $total += (new \App\Models\Avoirs())->montantTotal($item->avoir_id);
            @endphp
            <tr>
                <td>{{ $k+1 }}</td>
                <td>{{ $item->date_avoir }}</td>
                <td>
                    <a href="{{ route('avoir.view',['id'=>$item->avoir_id]) }}" title="Cliquez pour visualise les détails de la facture." target="_blank" class="text-primary">
                        {{ $item->reference_avoir }}
                    </a>
                </td>
                <td>{{ $item->objet }}</td>
                <td>{{ (new \App\Models\Avoirs())->montantTotal($item->avoir_id) }}</td>
                <td>{{ $item->firstname }}</td>
                <td>{{ $item->date_created }}</td>

            </tr>
        @endforeach

        </tbody>
    </table>
</div>
<div class="col-md-12 mt-3">
    <label>Total: <span class="text-warning">{{ $total }} FCFA</span></label><br>
</div>


