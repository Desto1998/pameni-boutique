@extends('_layouts.app')
@section('title','| CATEGORIES')
@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <span class="float-left h4">Liste des clients</span>

                        <div class="table-responsive mt-3">
                            <table id="example" class="display w-100 text-center">
                                <thead class="bg-primary">
                                <tr>
                                    <th>#</th>
                                    <th>Nom</th>
                                    <th>Prenom</th>
                                    <th>Adresse</th>
                                    <th>Email</th>
                                    <th>Telephone</th>
                                    <th>Ville</th>
                                    <th>Cree le</th>
{{--                                    <th>Action</th>--}}
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data as $key=>$value)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $value->nom }}</td>
                                        <td>{{ $value->prenom }}</td>
                                        <td>{{ $value->adresse }}</td>
                                        <td>{{ $value->email }}</td>
                                        <td>{{ $value->tel }}</td>
                                        <td>{{ $value->date_ajout }}</td>

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

@stop
@section('script')
    <script>
        function deleteFun(id) {
            var table = $('#example').DataTable();

            if (confirm("Supprimer cette categorie?")===true) {
                // if (confirm("Supprmer cette tâches?") == true) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: "{{ route('categories.delete') }}",
                    data: {id: id},
                    dataType: 'json',
                    success: function (res) {
                        if (res) {
                            // alert("Supprimé avec succès!")
                            table.row( $('#deletebtn'+id).parents('tr') )
                                .remove()
                            toastr.success("Supprimé avec succès!");
                        } else {
                            alert( "Erreur lors de la suppression!")
                        }

                    },
                    error: function (resp) {
                        alert("Une erreur s'est produite.");
                    }
                });
            }

            // }
        }
    </script>
@endsection
