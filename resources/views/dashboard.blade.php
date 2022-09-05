@extends('_layouts.app')
@section('title','| HOME')
@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4>Tableau de bord</h4>
                        <div class="col-md-12 grid-margin transparent">
                            <div class="row">
                                <div class="col-md-6 mb-4 stretch-card transparent">
                                    <div class="card card-tale">
                                        <div class="card-body">
                                            <p class="mb-4">Clients</p>
                                            <p class="fs-30 mb-2">{{ count($clients) }}</p>
{{--                                            <p>10.00% (30 days)</p>--}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4 stretch-card transparent">
                                    <div class="card card-dark-blue">
                                        <div class="card-body">
                                            <p class="mb-4">Commandes en attente</p>
                                            <p class="fs-30 mb-2">{{ count($comET) }}</p>
{{--                                            <p>22.00% (30 days)</p>--}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
                                    <div class="card card-light-blue">
                                        <div   class="card-body">
                                            <p class="mb-4">Commande en cours</p>
                                            <p class="fs-30 mb-2">{{ count($comEC) }}</p>
{{--                                            <p>2.00% (30 days)</p>--}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 stretch-card transparent">
                                    <div class="card card-light-danger">
                                        <div class="card-body">
                                            <p class="mb-4">Traité</p>
                                            <p class="fs-30 mb-2">{{ count($comT) }}</p>
{{--                                            <p>0.22% (30 days)</p>--}}
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
@stop
@section('script')

@endsection
