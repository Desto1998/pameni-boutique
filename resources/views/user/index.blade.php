@extends('layouts.app')
@section('css_before')
    <link href="{{asset('template/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">

@endsection
@section('content')
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Liste des utilisateurs</h4>
                    {{--                    <p class="mb-0">Your business dashboard template</p>--}}
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Users</a></li>
                </ol>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card px-3">
                    <div class="card-body">
                        <a href="{{ route('user.add') }}" title="Ajouter un utilisateur"
                           class="btn btn-primary mb-3 float-right">
                            <i class="fa fa-plus"></i>&nbsp;&nbsp;Nouveau
                        </a>
                        <div class="table-responsive">
                            <table id="example" class="display" style="min-width: 845px">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Email</th>
                                    <th>Téléphone</th>
                                    <th>Role</th>
                                    <th>Statut</th>
                                    <th>Crée le</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $key=> $value)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $value->lastname }}</td>
                                        <td>{{ $value->firstname }}</td>
                                        <td>{{ $value->phone }}</td>
                                        <td>{{ $value->email }}</td>
                                        <td>
                                            @if($value->is_admin>=1)
                                                <span class="p-2 text-info">Administrateur</span>
                                            @endif
                                            @if($value->is_admin==0)
                                                <span class="p-2 text-success">Utilisateur</span>
                                            @endif

                                        </td>
                                        <td>
                                            @if($value->is_active>=1)
                                                <span class="p-2 text-info">Actif</span>
                                            @endif
                                            @if($value->is_active==0)
                                                <span class="p-2 text-danger">Bloqué</span>
                                            @endif

                                        </td>
                                        <td>{{ $value->created_at }}</td>
                                        <td class="d-flex">
                                            <a href="{{ route('user.edit', ['id'=>$value->id]) }}"

                                               @if(Auth::user()->id != $value->id)
                                                   class="btn btn-warning btn-sm" title="Modifier le compte"><i
                                                        class="fa fa-edit"></i></a>
                                                <button class="btn btn-danger btn-sm ml-1 " title="Supprimer"
                                                        onclick="deleteUser({{ $value->id }})"><i
                                                        class="fa fa-trash"></i></button>

                                                @if($value->is_active==1)

                                                    <a type="button" class="btn btn-dark ml-1 btn-sm"
                                                       href="{{ route('block_compte', ['id'=>$value->id]) }}"
                                                       title="Bloquer le compte">
                                                        <i class="fa fa-fw fa-lock"></i>
                                                    </a>

                                                @endif
                                                @if($value->is_active==0)

                                                    <a title="Activer le compte"
                                                       class="btn btn-success btn-sm ml-1"
                                                       href="{{ route('activate_compte', ['id'=>$value->id]) }}"
                                                       id="activate-user">
                                                        <i class="fa fa-fw fa-check"></i>
                                                    </a>

                                                @endif
                                            @endif
                                        </td>
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

@endsection
@section('script')
    <script>
        function deleteUser(id) {
            if (confirm("Supprimer cet utilisateur?") == true) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: "{{ route('user.delete') }}",
                    data: {id: id},
                    dataType: 'json',
                    success: function (res) {
                        if (res) {
                            alert("Supprimé avec succès!");
                            window.location.reload(200);

                        } else {
                            alert("Une erreur s'est produite!");
                        }

                    }
                });
            }
        }
        {{--function blockFunc(id) {--}}
        {{--    $('#success').addClass('hidden');--}}
        {{--    $('#error').addClass('hidden');--}}
        {{--    $.ajaxSetup({--}}
        {{--        headers: {--}}
        {{--            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
        {{--        }--}}
        {{--    });--}}
        {{--    $.ajax({--}}
        {{--        type: "POST",--}}
        {{--        url: "{{ route('block_compte') }}",--}}
        {{--        data: {id: id},--}}
        {{--        dataType: 'json',--}}
        {{--        success: function (res) {--}}
        {{--            if (res) {--}}

        {{--                $('#success').removeClass('hidden');--}}
        {{--                $('#error').addClass('hidden');--}}
        {{--                $('#succesActionModal').show(50);--}}
        {{--                window.location.reload(200);--}}

        {{--            } else {--}}
        {{--                $('#success').addClass('hidden');--}}
        {{--                $('#error').removeClass('hidden');--}}
        {{--            }--}}

        {{--        }--}}
        {{--    });--}}
        {{--}--}}

        {{--function activateFunc(id) {--}}
        {{--    $('#success').addClass('hidden');--}}
        {{--    $('#error').addClass('hidden');--}}
        {{--    $.ajaxSetup({--}}
        {{--        headers: {--}}
        {{--            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
        {{--        }--}}
        {{--    });--}}
        {{--    $.ajax({--}}
        {{--        type: "POST",--}}
        {{--        url: "{{ route('activate_compte') }}",--}}
        {{--        data: {id: id},--}}
        {{--        dataType: 'json',--}}
        {{--        success: function (res) {--}}
        {{--            if (res) {--}}

        {{--                $('#success').removeClass('hidden');--}}
        {{--                $('#error').addClass('hidden');--}}
        {{--                $('#succesActionModal').removeClass('hidden');--}}
        {{--                window.location.reload(200);--}}

        {{--            } else {--}}
        {{--                $('#success').addClass('hidden');--}}
        {{--                $('#error').removeClass('hidden');--}}
        {{--            }--}}

        {{--        }--}}
        {{--    });--}}
        {{--}--}}

    </script>
    <!-- Datatable -->
    <script src="{{asset('template/vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('template/js/plugins-init/datatables.init.js')}}"></script>

@endsection
