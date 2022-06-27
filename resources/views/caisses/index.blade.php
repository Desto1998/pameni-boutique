@extends('layouts.app')
@section('title','| CHARGES')
@section('css_before')
    <link href="{{asset('template/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{asset('template/vendor/sweetalert2/dist/sweetalert2.min.css')}}" rel="stylesheet">
    <style>
        .hide{
            display: none;
        }
    </style>
@stop
@section('content')
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Caisses</h4> solde: <span class="{{ $solde<=0? 'text-danger':'text-primary' }}">{{ $solde }} F CFA</span>
                    {{--                    <p class="mb-0">Your business dashboard template</p>--}}
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Gestion</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Caisses</a></li>
                </ol>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card px-3">
                    <div class="card-body">
                        <!-- Button trigger modal -->
                        <span class="float-left h4 text-center">Liste des operations de caisse</span>
{{--                        <button type="button" class="btn btn-primary float-right mb-3" data-toggle="modal"--}}
{{--                                data-target="#chargesModal"><i class="fa fa-plus">&nbsp; Ajouter</i></button>--}}

                        <div class="table-responsive">
                            <table id="example" class="display text-center w-100">
                                <thead class="bg-primary">
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Raison</th>
                                    <th>Montant</th>
                                    <th>Description</th>
                                    <th>Type</th>
                                    <th>Crée par</th>
{{--                                    <th>Action</th>--}}
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>


@endsection
@section('script')
    <script>

        function loadCaisses(){
            $('#example').dataTable().fnClearTable();
            $('#example').dataTable().fnDestroy();
            $("#example").DataTable({
                Processing: true,
                searching: true,
                LengthChange: true, // desactive le module liste deroulante(d'affichage du nombre de resultats par page)
                iDisplayLength: 10, // Configure le nombre de resultats a afficher par page a 10
                bRetrieve: true,
                stateSave: false,
                serverSide:true,
                ajaxSetup:{
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                ajax:{
                    url: "{{ route('gestion.load.caisse') }}",

                },

                columns: [
                    {data: 'DT_RowIndex',name:'caisse_id'},
                    {data: 'date_depot',name:'date_depot'},
                    {data: 'raison',name:'raison'},
                    {data: 'montant',name:'montant'},
                    {data: 'description',name:'description'},
                    {data: 'type',name:'type'},
                    {data: 'firstname',name:'users.firstname'},
                    // {data: 'action', name: 'action', orderable: false, searchable: false},

                ],
                order: ['0','desc']
            })
        }
        // load table on page load
        $(document).ready(function () {
            loadCaisses()

        });


    </script>
    <!-- Datatable -->
    <script src="{{asset('template/vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('template/js/plugins-init/datatables.init.js')}}"></script>
    <script src="{{asset('template/vendor/sweetalert2/dist/sweetalert2.min.js')}}"></script>
@endsection
