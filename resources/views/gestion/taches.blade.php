@extends('layouts.app')
@section('css_before')
    <link href="{{asset('template/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{asset('template/vendor/sweetalert2/dist/sweetalert2.min.css')}}" rel="stylesheet">
    <link href="{{asset('template/vendor/sweetalert2/dist/sweetalert2.min.css')}}" rel="stylesheet">

@endsection
@section('content')
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Tâches</h4>
                    {{--                    <p class="mb-0">Your business dashboard template</p>--}}
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Gestion</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">taches</a></li>
                </ol>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card px-3">
                    <div class="card-body">
                        <!-- Button trigger modal -->
                        <h4 class="w-50">Liste des tâches</h4>
                        <button type="button" class="btn btn-primary float-right mb-3" data-toggle="modal"
                                data-target="#tachesModal"><i class="fa fa-plus">&nbsp; Ajouter</i></button>

                        <div class="table-responsive">
                            <table id="example" class="display" style="min-width: 845px">
                                <thead>
                                <tr>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Raison</th>
                                    <th>Charge</th>
                                    <th>Quantité</th>
                                    <th>Prix.U</th>
                                    <th>Total</th>
                                    {{--                                    <th>Statut</th>--}}
                                    {{--                                    <th>Créer le</th>--}}
                                    <th>Crée Par</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($taches as $key=> $value)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $value->date_debut }}</td>
                                        <td>{{ $value->raison }}</td>
                                        <td>{{ $value->titre }}</td>
                                        <td>{{ $value->nombre }}</td>
                                        <td>{{ $value->prix }} FCFA</td>
                                        <td>{{ $value->prix*$value->nombre }} FCFA</td>
                                        {{--                                        <td>--}}
                                        {{--                                            @if ($value->date_debut<=date('Y-m-d'))--}}
                                        {{--                                                <span class="text-danger">Effectué</span>--}}
                                        {{--                                            @else--}}
                                        {{--                                                <span class="text-success">En attente</span>--}}
                                        {{--                                            @endif--}}
                                        {{--                                        </td>--}}
                                        {{--                                        <td>{{ $value->date_ajout }}</td>--}}
                                        <td>{{ $value->firstname }}</td>
                                        <td class="d-flex">
                                            <a href="javascript:void(0);" class="btn btn-warning btn-sm" title="Modifier la tâches"
                                               data-toggle="modal" data-target="#tachesModal{{ $value->tache_id }}"><i
                                                    class="fa fa-edit"></i></a>
                                            @if (Auth::user()->is_admin==1)
                                                <button class="btn btn-danger btn-sm ml-1 "
                                                        title="Supprimer cette tâches"
                                                        onclick="deleteFun({{ $value->tache_id }})"><i
                                                        class="fa fa-trash"></i></button>
                                                {{--                                            Auth::user()->id--}}
                                            @endif
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="tachesModal{{ $value->tache_id }}">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Modifier une tâche</h5>

                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('gestion.taches.add') }}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="tache_id"
                                                               value="{{ $value->tache_id }}">

                                                        <div class="form-group">
                                                            <label for="raison{{ $value->tache_id }}">Raison<span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text" name="raison"
                                                                   id="raison{{ $value->tache_id }}"
                                                                   value="{{ $value->raison }}" placeholder="Raison"
                                                                   class="form-control">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="nombre{{ $value->tache_id }}">Quantité <span
                                                                    class="text-danger">*</span></label>
                                                            <input type="number" name="nombre"
                                                                   value="{{ $value->nombre }}" min="1"
                                                                   id="nombre{{ $value->tache_id }}"
                                                                   class="form-control" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="prix{{ $value->tache_id }}">Prix <span
                                                                    class="text-danger">*</span></label>
                                                            <input type="number" name="prix" min="0"
                                                                   value="{{ $value->prix }}" step="any"
                                                                   id="prix{{ $value->tache_id }}" class="form-control"
                                                                   required>
                                                        </div>


                                                        <div class="form-group">
                                                            <label for="charge{{ $value->tache_id }}">Charges <span
                                                                    class="text-danger">*</span></label>
                                                            <select class="form-control" required name="idcharge"
                                                                    id="charge{{ $value->tache_id }}">
                                                                <option disabled="disabled" selected>Sélectionner une
                                                                    charge
                                                                </option>
                                                                @foreach($charges as $item)
                                                                    <option
                                                                        {{ $item->charge_id==$value->idcharge?'selected':'' }} value="{{ $item->charge_id }}">{{ $item->titre }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="date_debut{{ $value->tache_id }}">Date <span
                                                                    class="text-danger">*</span></label>
                                                            <input type="date" name="date_debut"
                                                                   id="date_debut{{ $value->tache_id }}" required
                                                                   value="{{ $value->date_debut }}"
                                                                   class="form-control">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Annuler
                                                            </button>
                                                            <button type="submit" class="btn btn-primary">Enregistrer
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                </tbody>

                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- Modal -->
    <div class="modal fade" id="tachesModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter une tâche</h5>

                </div>
                <div class="modal-body">
                    <form action="{{ route('gestion.taches.add') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="raison">Raison<span class="text-danger">*</span></label>
                            <input type="text" name="raison" id="raison" placeholder="Raison" class="form-control"
                                   required>
                        </div>

                        <div class="form-group">
                            <label for="nombre">Quantité <span class="text-danger">*</span></label>
                            <input type="number" name="nombre" min="1" id="nombre" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="prix">Prix <span class="text-danger">*</span></label>
                            <input type="number" name="prix" min="0" step="any" id="prix" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="charge">Charges <span class="text-danger">*</span></label>
                            <select class="form-control" required name="idcharge" id="single-select">
                                <option disabled="disabled" selected>Sélectionner une charge</option>
                                @foreach($charges as $item)
                                    <option value="{{ $item->charge_id }}">{{ $item->titre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="date_debut">Date <span class="text-danger">*</span></label>
                            <input type="date" name="date_debut" required id="date_debut" class="form-control">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

@endsection
@section('script')
    <script>
        // delete funtion
        function deleteFun(id) {
            swal.fire({
                title: "Supprimer cette tâches?",
                icon: 'question',
                text: "Cette tâches sera supprimé de façon définitive.",
                type: "warning",
                showCancelButton: !0,
                confirmButtonText: "Oui, supprimer!",
                cancelButtonText: "Non, annuler !",
                reverseButtons: !0
            }).then(function (e) {
                if (e.value === true) {
                    // if (confirm("Supprimer cette tâches?") == true) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "POST",
                        url: "{{ route('gestion.taches.delete') }}",
                        data: {id: id},
                        dataType: 'json',
                        success: function (res) {
                            if (res) {
                                swal.fire("Effectué!", "Supprimé avec succès!", "success")
                                window.location.reload(200);

                            } else {
                                sweetAlert("Désolé!", "Erreur lors de la suppression!", "error")
                            }

                        },
                        error: function (resp) {
                            sweetAlert("Désolé!", "Une erreur s'est produite.", "error");
                        }
                    });
                } else {
                    e.dismiss;
                }
            }, function (dismiss) {
                return false;
            })
            // }
        }

    </script>
    <!-- Datatable -->
    <script src="{{asset('template/vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('template/js/plugins-init/datatables.init.js')}}"></script>
    <script src="{{asset('template/vendor/sweetalert2/dist/sweetalert2.min.js')}}"></script>
    <!-- Selet search -->
    <script src="{{asset('template/vendor/select2/js/select2.full.min.js')}}"></script>
    <script src="{{asset('template/js/plugins-init/select2-init.js')}}"></script>
@endsection
