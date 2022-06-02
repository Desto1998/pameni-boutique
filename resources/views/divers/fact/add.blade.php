@extends('layouts.app')
@section('title','| DIVERS|FACTURE-CREER')
@section('css_before')
    <link href="{{asset('template/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{asset('template/vendor/sweetalert2/dist/sweetalert2.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('template/vendor/select2/css/select2.min.css')}}">
    <style>
        table thead tr th {
            color: white !important;
        }

        .hidden {
            display: none;
        }
        .enterprisehide {
            display: none;
        }
    </style>
@stop
@section('content')
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>CREER UNE FACTURE</h4>
                    {{--                    <p class="mb-0">Your business dashboard template</p>--}}
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Divers</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Proformat</a></li>
                </ol>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card px-3">
                    <div class="card-body">
                        <!-- Button trigger modal -->
                        <span class="float-left h4"></span>
                        <form action="{{ route('divers.factures.store') }}" method="post" id="devis-form">
                            @csrf
                            <div class="row">
                                <div class="col-md-5 float-left d-flex">
                                    <div class="form-group col-md-6">
                                        <label for="date">Date de la profomat <span
                                                class="text-danger"> *</span></label>
                                        <input type="date" name="date" id="date" class="form-control" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="statut_tva">Inclure la TVA/IS? <span
                                                class="text-danger"> *</span></label>
                                        <select class="form-control" name="tva_statut">
                                            <option value="0">Aucun</option>
                                            <option value="1">TVA</option>
                                            <option value="2">IS</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-7 float-right d-flex" id="client-block">
                                    <div class="form-group col-md-6">
                                        <label for="echeance">Client <span class="text-danger"> *</span> </label>
                                        <select name="idclient" id="single-select" class="form-control" required>
                                            <option selected="selected" disabled>Sélectionez un client</option>
                                            @foreach($clients as $cl)
                                                <option
                                                    value="{{ $cl->client_id }}">{{ $cl->nom_client }} {{ $cl->prenom_client }}{{ $cl->raison_s_client }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group" id="client-block">
                                        <label class="text-center pl-3">Coordonnées du client
                                            &nbsp;&nbsp;
                                            <button type="button" class="btn btn-primary btn-sm float-right"
                                                    data-toggle="modal"
                                                    title="Ajouter un client"
                                                    data-target="#clientsModal"><i class="fa fa-plus">&nbsp;</i>
                                            </button>
                                        </label>
                                        @foreach($clients as $cl)
                                            <div class="hidden infos_client pl-3" id="infos_client{{ $cl->client_id }}">
                                                <label
                                                    class="h5 font-weight-bold mt-1">{{ $cl->nom_client }} {{ $cl->prenom_client }}{{ $cl->raison_s_client }}</label><br>
                                                <label
                                                    class="h5 font-weight-bold mt-1">Tel: {{ $cl->phone_1_client }}  {{ $cl->phone_client }}</label><br>
                                                <label
                                                    class="h5 font-weight-bold mt-1">Bp: {{ $cl->postale }}</label><br>
                                                {{--                                                <label class="h5 font-weight-bold mt-1"> {{ $cl->rcm }}</label><br>--}}
                                                {{--                                                <label class="h5 font-weight-bold mt-1">NC: {{ $cl->contribuabe }}</label><br>--}}
                                            </div>

                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label for="objet">Objet <span class="text-danger"> *</span> </label>
                                <input type="text" name="objet" id="objet" class="form-control" required>
                            </div>
                            {{--                            <div class="d-flex row w-100">--}}
                            <h4 class="float-left align-self-start text-uppercase mb-3">Produits</h4>
                            <button type="button" class="btn btn-primary float-right align-self-end mb-3"
                                    data-toggle="modal" title="Ajouter des produit" id="displayProductModal"
                                    data-target=".bd-example-modal-lg"><i class="fa fa-plus">&nbsp; Ajouter</i></button>
                            {{--                            </div>--}}
                            <div class="created-element  table-responsive" style="max-height: 400px;">
                                <table id="validated-element" style="border-collapse: collapse"
                                       class="table w-100 table-striped">
                                    <thead class="bg-primary">
                                    <tr class="text-center">
                                        <th style="border:1px solid #eaeaea;">Titre</th>
                                        <th style="border:1px solid #eaeaea;">Quantité</th>
                                        <th style="border:1px solid #eaeaea;">P.U.HT.</th>
                                        <th style="border:1px solid #eaeaea;">Remise</th>
                                        <th style="border:1px solid #eaeaea;">Description</th>
                                        <th style="border:1px solid #eaeaea;">M. HT(FCFA)</th>
                                        <th style="border:1px solid #eaeaea; width: 30px" title="Supprimer la ligne"><i
                                                class="fa fa-trash-o"></i></th>
                                    </tr>
                                    </thead>
                                    <tbody id="content-item">

                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-12 d-flex pt-2 mt-3">

                                <div class="col-md-12 d-flex">
                                    <div class="d-flex form-group col-md-4">
                                        <label class="text-center">Montant HT &nbsp;&nbsp;</label>
                                        <input type="number" readonly name="ht" value="0" id="ht" class="form-control">
                                    </div>
                                    <div class="d-flex form-group col-md-4">
                                        <label class="text-center">Montant TVA/IS &nbsp;&nbsp;</label>
                                        <input type="number" readonly name="mtva" id="mtva" value="0"
                                               class="form-control">
                                    </div>
                                    <div class="d-flex form-group col-md-4">
                                        <label class="text-center">Montant TTC &nbsp;&nbsp;</label>
                                        <input type="number" readonly name="ttc" id="ttc" value="0"
                                               class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 mt-3 row">
                                <div class="col-md-6">
                                    <label class="nav-label text-center">Informations du bon de commande</label>
                                    <div class="form-group">
                                        <label for="ref_bon">Reference du bon de commande</label>
                                        <input type="text" name="ref_bon" id="ref_bon" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>date du bon de commande</label>
                                        <input type="date"  name="date_bon" id="ref_bon" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="logo-upload">Joindre un fichier</label>
                                        <input type="file" name="logo" id="logo-upload" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row mb-3 ml-5" title="Cliquer pour selectioner une image">
                                        <img id="logo-zone" style="width: 300px; height: 300px; min-height: 200px; min-width: 200px" src="{{ asset('images/logo-thumbnail.png') }}" alt="Ouopps! Auncune image disponible">
                                    </div>
                                    {{--                                    <div class="kv-avatar-hint">--}}
                                    {{--                                        <small>Sélectionner un fichier< 1500 KB</small>--}}
                                    {{--                                    </div>--}}
                                </div>
                            </div>

                            <div class="modal-footer mt-3">
                                <button type="reset" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                <button type="submit" class="btn btn-primary">Enregistrer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('divers.proformat.modal')
    @include('client.modal')
@stop
@section('script')
    @include('divers.common_script')

    <!-- Datatable -->
    <script src="{{asset('template/vendor/sweetalert2/dist/sweetalert2.min.js')}}"></script>
    <!-- Selet search -->
    <script src="{{asset('template/vendor/select2/js/select2.full.min.js')}}"></script>
    <script src="{{asset('template/js/plugins-init/select2-init.js')}}"></script>

@stop
