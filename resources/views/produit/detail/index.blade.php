@extends('layouts.app')
@section('title','| FOURNISSEUR-DETAILS')
@section('css_before')
    <link href="{{asset('template/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{asset('template/vendor/sweetalert2/dist/sweetalert2.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('template/vendor/select2/css/select2.min.css')}}">
    <style>
        table thead tr th{
            color: white!important;
        }
    </style>
@stop
@section('content')
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>DETAILS PRODUIT "{{ $data[0]->reference }}"</h4>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Produits</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Details</a></li>
                </ol>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card px-3">
                    <div class="card-body">
                        <div class="default-tab">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#infos">Infos</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#commandes">Commandes({{ count($commandes) }})</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#factures">Factures({{ count($factures) }})</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#devis">Devis({{ count($devis) }})</a>
                                </li>

                                {{--                                <li class="nav-item">--}}
                                {{--                                    <a class="nav-link" data-toggle="tab" href="#paiement">Paiements({{ count($paiements) }})</a>--}}
                                {{--                                </li>--}}
                                {{--                                <li class="nav-item">--}}
                                {{--                                    <a class="nav-link" data-toggle="tab" href="#message">Factures</a>--}}
                                {{--                                </li>--}}
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade fade show active" id="infos">

                                    <div class="pt-4">
                                        <div class="col-md-12 text-center mb-2">
                                            <label class="h4">Informations du produits</label>
                                        </div>
                                        <div class="table-responsive-md table-responsive-sm">
                                            <table class="table text-black fs-4 font-weight-bold table-bordered table-hover">
                                                <tr>
                                                    <td>
                                                        Reférence
                                                    </td>
                                                    <td>
                                                        {{ $data[0]->reference }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Désignation</td>
                                                    <td>{{ $data[0]->titre_produit }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Catégorie</td>
                                                    <td>{{ $data[0]->titre_cat }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Prix unitaire</td>
                                                    <td>{{ $data[0]->prix_produit }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Description</td>
                                                    <td>{{ $data[0]->description_produit }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Quantité deja aprovisionné</td>
                                                    <td>{{ $data[0]->quantite_produit }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Quantité en stock</td>
                                                    <td>{{ $etatStock }}</td>
                                                </tr>
                                                    <tr>
                                                        <td>Dernière date de modification</td>
                                                        <td>{{ $data[0]->updated_at }}</td>
                                                    </tr>
                                                <tr>
                                                    <td>Date création</td>
                                                    <td>{{ $data[0]->created_at }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Créé par</td>
                                                    <td>
                                                        {{ $data[0]->firstname }} {{ $data[0]->lastname }}
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="commandes" role="tabpanel">
                                    <div class="pt-4">
                                        <div class="col-md-12 text-center mb-2">
                                            <label class="h4">Liste des commandes</label>
                                        </div>
                                        <div class="table-responsive">
                                            <table id="example" class="table w-100 display text-center">
                                                <thead class="bg-primary">
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Réference</th>
                                                    <th>Objet</th>
                                                    <th>Qte</th>
                                                    <th>P.U</th>
                                                    <th>Remise</th>
                                                    <th>Total</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($commandes as $key=>$item)
                                                    <tr>
                                                        <td>{{ $item->created_at }}</td>
                                                        <td>
                                                            <a title="Cliquez pour voir les details de la commande" href="{{ route('commandes.view',['id'=>$item->commande_id]) }}" target="_blank" class="link">
                                                                {{ $item->reference_commande }}
                                                            </a>
                                                        </td>
                                                        <td>{{ $item->objet }}</td>
                                                        <td>{{ $item->quantite }}</td>
                                                        <td>{{ $item->prix }}</td>
                                                        <td> {{ number_format(($item->prix * $item->quantite *$item->remise)/100 ,2,'.','') }}</td>
                                                        <td>{{ number_format(($item->prix * $item->quantite)-($item->prix * $item->quantite *$item->remise)/100 ,2,'.','')  }}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="factures" role="tabpanel">
                                    <div class="pt-4">
                                        <div class="col-md-12 text-center mb-2">
                                            <label class="h4">Liste des factures</label>
                                        </div>
                                        <div class="table-responsive">
                                            <table id="example" class="table w-100 display text-center">
                                                <thead class="bg-primary">
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Réference</th>
                                                    <th>Objet</th>
                                                    <th>Qte</th>
                                                    <th>P.U</th>
                                                    <th>Remise</th>
                                                    <th>Total</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($factures as $key=>$item)
                                                    <tr>
                                                        <td>{{ $item->created_at }}</td>
                                                        <td>
                                                            <a title="Cliquez pour voir les details de la facture" href="{{ route('factures.view',['id'=>$item->facture_id]) }}" target="_blank" class="link">
                                                                {{ $item->reference_fact }}
                                                            </a>
                                                        </td>
                                                        <td>{{ $item->objet }}</td>
                                                        <td>{{ $item->quantite }}</td>
                                                        <td>{{ $item->prix }}</td>
                                                        <td> {{ number_format(($item->prix * $item->quantite *$item->remise)/100 ,2,'.','') }}</td>
                                                        <td>{{ number_format(($item->prix * $item->quantite)-($item->prix * $item->quantite *$item->remise)/100 ,2,'.','')  }}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="devis" role="tabpanel">
                                    <div class="pt-4">
                                        <div class="col-md-12 text-center mb-2">
                                            <label class="h4">Liste des devis</label>
                                        </div>
                                        <div class="table-responsive">
                                            <table id="example" class="table w-100 display text-center">
                                                <thead class="bg-primary">
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Réference</th>
                                                    <th>Objet</th>
                                                    <th>Qte</th>
                                                    <th>P.U</th>
                                                    <th>Remise</th>
                                                    <th>Total</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($devis as $key=>$item)
                                                    <tr>
                                                        <td>{{ $item->created_at }}</td>
                                                        <td>
                                                            <a title="Cliquez pour voir les details de la proformat" href="{{ route('devis.view',['id'=>$item->devis_id]) }}" target="_blank" class="link">
                                                                {{ $item->reference_devis }}
                                                            </a>
                                                        </td>
                                                        <td>{{ $item->objet }}</td>
                                                        <td>{{ $item->quantite }}</td>
                                                        <td>{{ $item->prix }}</td>
                                                        <td> {{ number_format(($item->prix * $item->quantite *$item->remise)/100 ,2,'.','') }}</td>
                                                        <td>{{ number_format(($item->prix * $item->quantite)-($item->prix * $item->quantite *$item->remise)/100 ,2,'.','')  }}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>

    </script>
    <!-- Datatable -->
    <script src="{{asset('template/vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('template/js/plugins-init/datatables.init.js')}}"></script>
    <script src="{{asset('template/vendor/sweetalert2/dist/sweetalert2.min.js')}}"></script>
    <!-- Selet search -->
    <script src="{{asset('template/vendor/select2/js/select2.full.min.js')}}"></script>
    <script src="{{asset('template/js/plugins-init/select2-init.js')}}"></script>

@endsection

