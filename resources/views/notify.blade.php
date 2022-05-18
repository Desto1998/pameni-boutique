@extends('layouts.app')
@section('title','| NOTIFICATIONS')
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
                    <h4>Notifications</h4>
                    {{--                    <p class="mb-0">Your business dashboard template</p>--}}
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Notifications</a></li>
                </ol>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card px-3">
                    <div class="card-body">
                        <!-- Button trigger modal -->
                        <div class="NOTIFY text-black"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('script')

    <script>
        $(document).ready(function (){
            // $('.pulse-css').hide();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "GET",
                url: "{{ route('notify.load') }}",
                // data: {id: id},
                dataType: 'json',
                success: function (res) {
                    if (res[0]) {
                        $('.NOTIFY').append(res[0]);

                        $('.pulse-css').show().append('<span class="font-weight-bolder fs-6 mb-2">'+res[1]+'</span>')
                        // toastr.warning("Vous pourrez avoir des nofications non lues!",'Alerte');

                        $('#no-notification').hide();
                    }
                    // else {
                    //     toastr.success("Aucune notification!",'Alerte');
                    // }
                },
                error: function (resp) {
                    // toastr.warning("Une erreur s'est produite lors du chargement des notifications! Veillez actuliser la page. Merci!");
                    sweetAlert("Désolé!", "Une erreur s'est produite lors du chargement des notifications! Veillez actualiser la page et reconnectez-vous", "error");
                }
            });
        });
    </script>
    <!-- Datatable -->
    <script src="{{asset('template/vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('template/js/plugins-init/datatables.init.js')}}"></script>
    <script src="{{asset('template/vendor/sweetalert2/dist/sweetalert2.min.js')}}"></script>
@endsection
