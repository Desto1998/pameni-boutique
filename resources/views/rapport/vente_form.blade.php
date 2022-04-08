@extends('layouts.app')
@section('title','| RAPPORT| VENTE')
@section('css_before')
    <link href="{{asset('template/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{asset('template/vendor/sweetalert2/dist/sweetalert2.min.css')}}" rel="stylesheet">

@stop
@section('content')
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Rapport des charges</h4>
                    {{--                    <p class="mb-0">Your business dashboard template</p>--}}
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Rapport</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Charge</a></li>
                </ol>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card px-3">
                    <div class="card-body">
                        <div class="alert alert-outline-warning alert-dismissible fade show">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                            </button>
                            <strong>Pour le rapport d'un jour, veillez renseigner uniquement la date de début et laisser vide la date de fin.</strong>
                        </div>
                        <!-- Button trigger modal -->
                        <h4 class="w-50">Créer le rapport de vente</h4>
                        <form action="{{ route('rapport.vente.print') }}" method="get">
                            @csrf
                            <div class="form-group">
                                <label for="titre">Titre</label>
                                <input type="text" name="titre" id="titre" class="form-control">
                            </div>
                            <label class="nav-item text-uppercase">Période</label>

                            <div class="form-group">
                                <label for="debut">Date de début <span class="text-danger">*</span></label>
                                <input type="date" name="debut" required id="debut" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="fin">Date de fin</label>
                                <input type="date" name="fin" id="fin" class="form-control">
                            </div>

                            <div class="form-group row mb-0 text-centers justify-content-center">
                                <div class="col-md-6 ">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        {{ __('Effectuer') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
@section('script')
    <script>
    </script>
@endsection
