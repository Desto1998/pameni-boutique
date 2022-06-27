@extends('layouts.app')
@section('title','| PRODUITS')
@section('css_before')
    <link href="{{asset('template/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{asset('template/vendor/sweetalert2/dist/sweetalert2.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('template/vendor/select2/css/select2.min.css')}}">
{{--    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"/>--}}
{{--    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">--}}
{{--    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">--}}
 <!-- datatable css -->
{{--    <link href="{{ asset('datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">--}}
{{--    <link href="{{ asset('datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">--}}
@stop
@section('content')
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Produits</h4>
                    {{--                    <p class="mb-0">Your business dashboard template</p>--}}
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Produit</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Index</a></li>
                </ol>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card px-3">
                    <div class="card-body">
                        <!-- Button trigger modal -->
                        <h4 class="float-left h4">Liste des produits</h4>
                        <button type="button" class="btn btn-primary float-right align-self-end mb-3"
                                data-toggle="modal"
                                data-target=".bd-example-modal-lg"><i class="fa fa-plus">&nbsp; Ajouter</i></button>


                        <div class="table-responsive mt-4">
                            <table id="example" class="display text-center w-100" >
                                <thead class="bg-primary">
                                <tr>
                                    <th>#</th>
                                    <th>Ref.</th>
                                    <th>Désignation</th>
                                    <th>Catégorie</th>
                                    <th>Qté</th>
                                    <th>P.U</th>
                                    <th>Stock</th>
                                    <th>Description</th>
                                    <th style="width: 120px">Crée Par</th>
                                    <th>Action</th>
                                </tr>
                                </thead>

                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- Modal add produts -->

    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter des produits</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="#" method="post" id="product-form">
                        @csrf
                        <div class="form-content" id="form-content">
                            <div class="form-group">
                                <label for="titre_produit">Désignation du produit<span
                                        class="text-danger">*</span></label>
                                <input type="text" name="titre_produit" placeholder="Désignation" id="titre_produit"
                                       class="form-control"
                                       required>
                            </div>
                            <div class="row col-md-12">
                                <div class="form-group col-md-6">
                                    <label class="" for="categorie">Catégorie <span class="text-danger">*</span></label>
                                    <select class="form-control" required name="idcategorie" id="single-select">
                                        <option disabled="disabled" selected>Sélectionner une catégorie</option>
                                        @foreach($categories as $item)

                                            <option value="{{ $item->categorie_id }}">{{ $item->titre_cat }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="quantite_produit">Quantité<span
                                            class="text-danger">*</span></label>
                                    <input type="number" name="quantite_produit"
                                           value="" required min="1" id="quantite_produit"
                                           class="form-control">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="prix_produit">Prix
                                        unitaire<span
                                            class="text-danger">*</span></label>
                                    <input type="number" id="prix_produit" name="prix_produit"
                                           required step="any"
                                           value="" min="0"
                                           class="form-control">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description_produit">Description du produit </label>
                                <textarea name="description_produit" id="description_produit" placeholder="Description"
                                          class="form-control"></textarea>
                            </div>

                        </div>
                        <div class="row col-md-12 d-flex justify-content-end mb-3">
                            <button type="submit" class="btn btn-sm btn-success float-right" id="addFields"
                                    title="Cliquez pour ajouter une nouvelle section!">
                                <i class="fa fa-plus"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-light float-right ml-2" id="removeFields"
                                    title="Supprimer tous!">
                                <i class="fa fa-trash-o"></i>
                            </button>
                        </div>
                    </form>
                    <form method="post" action="{{ route('produit.store') }}" id="product-form-value">

                        <div class="created-element table-responsive" style="max-height: 400px;">
                            <table id="validated-element" style="width: 100%; border-collapse: collapse"
                                   class="table col-md-12 table-striped table-responsive">
                                <thead class="bg-primary">
                                <tr class="text-center">
                                    <th style="border:1px solid #eaeaea; width: 250px">Titre</th>
                                    <th style="border:1px solid #eaeaea; width: 100px">Quantité</th>
                                    <th style="border:1px solid #eaeaea; width: 100px">Prix</th>
                                    <th style="border:1px solid #eaeaea; width: 200px">Categorie</th>
                                    <th style="border:1px solid #eaeaea; width: 250px">Description</th>
                                    <th style="border:1px solid #eaeaea; width: 20px"></th>
                                </tr>
                                </thead>
                                <tbody id="content-item">

                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="reset" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

{{--@include('produit.produit_modal')--}}
@endsection
@section('script')
    <script>
        // delete function

        function deleteFun(id) {
            // alert(id)

            var table = $('#example').DataTable();

            swal.fire({
                title: "Supprimer ce produit?",
                icon: 'question',
                text: "Ce produit sera supprimé de façon définitive.",
                type: "warning",
                showCancelButton: !0,
                confirmButtonText: "Oui, supprimer!",
                cancelButtonText: "Non, annuler !",
                reverseButtons: !0
            }).then(function (e) {
                if (e.value === true) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "POST",
                        url: "{{ route('produit.delete') }}",
                        data: {id: id},
                        dataType: 'json',
                        success: function (res) {
                            if (res) {
                                swal.fire("Effectué!", "Supprimé avec succès!", "success")
                                // loadProducts()

                                table.row( $('#deletebtn'+id).parents('tr') )
                                    .remove()
                                    .draw();
                            }else {
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
        // variable qui compte le nombre de produit entree sur le formulair | ne pas toucher
        var totalInputs = 0;
        $('#product-form').on("submit", function (event) {
            event.preventDefault();
            if ($('#product-form-value').serialize() == null || $('#product-form-value').serialize() == undefined) {
                return false
            }

            var titre = $('#titre_produit').val();
            var prix = $('#prix_produit').val();
            var qte = $('#quantite_produit').val()
            var desc = $('#description_produit').val()

            var cattext = $('#single-select option:selected').text();


            var categorie = $('#single-select').val()
            if (titre == '' || prix == '' || qte == '' || categorie == '' || categorie == null) {
                toastr.warning("Veillez remplir tous les champs obligatoires!");
                return "";
            } else {
                totalInputs++;
                var id = 'addedBlock' + totalInputs;
                var block = '';
                var table = '<tr style="color: black" class="text-center" id="' + id + '">';
                block += '<input type="hidden" class="' + id + '" value="' + prix + '" name="prix_produit[]">'
                block += '<input type="hidden" class="' + id + '" value="' + qte + '" name="quantite_produit[]">'
                block += '<input type="hidden" class="' + id + '" value="' + titre + '" name="titre_produit[]">'
                block += '<input type="hidden" class="' + id + '" value="' + desc + '" name="description_produit[]">'
                block += '<input type="hidden" class="' + id + '" value="' + categorie + '" name="idcategorie[]">'

                table += '<td style="border:1px solid #eaeaea; width: 250px">' + titre + '</td>'
                table += '<td style="border:1px solid #eaeaea; width: 100px">' + qte + '</td>'
                table += '<td style="border:1px solid #eaeaea; width: 100px">' + prix + '</td>'
                table += '<td style="border:1px solid #eaeaea; width: 250px">' + cattext + '</td>'
                table += '<td style="border:1px solid #eaeaea; width: 250px">' + desc + '</td>'
                table += '<td style="border:1px solid #eaeaea; width: 50px"><button type="button" class="btn btn-sm btn-danger" onclick="removeElelement(' + totalInputs + ')"><i class="fa fa-trash-o"></i></button></td>'
                table += '</tr>';

                $('#product-form')[0].reset();
                $('#single-select').val(null).trigger('change');
                $('#product-form-value').append(block);
                $('#validated-element>tbody').append(table);
            }


        });
        // Enlever toutes entrees  crees
        $('#removeFields').click(function (e) {

            if (confirm("Supprimer toutes entrées?") === true) {
                $('#validated-element tbody').find("tr").remove();
                $('#product-form-value')[0].reset();
                totalInputs = 0;
            }

        })

        // retirer un produit du tableau de produit sur la modal d'enregistrement des produits
        function removeElelement(nombre) {
            if (confirm("Supprimer cette ligne?") === true) {
                $('#validated-element tbody').find("#addedBlock" + nombre).remove();
                $('.addedBlock' + nombre).remove();
                totalInputs--;
            }
        }

        // Sauvegarder l'ensembre des produits crees dans la bd
        $("#product-form-value").on("submit", function (event) {
            event.preventDefault();

            if (totalInputs == 0) {
                toastr.warning("Veillez ajouter au moins un produit!");
                return false;
            }
            $('#product-form-value .btn-primary').attr("disabled", true).html("En cours...")
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var data = $('#product-form-value').serialize()

            $.ajax({
                type: "POST",
                url: "{{ route('produit.store') }}",
                data: data,
                dataType: 'json',
                success: function (res) {
                    if (res) {
                        // swal.fire("Effectué!", "Enregistré avec succès!", "success")
                        // on recharge le tableau de produit
                        toastr.success("Enregistré avec succès!");

                        loadProducts();
                        // on reinitialise le formulaire qui contient les produits
                        $('#product-form-value .btn-primary').attr("disabled", false).html("Enregistrer")
                        $('#validated-element tbody tr').remove()
                        $('#product-form-value')[0].reset()

                        $('#product-form-value input').remove()
                        totalInputs =0;
                        $('.bd-example-modal-lg').modal('hide');
                    } else {
                        sweetAlert("Désolé!", "Erreur lors de l'enregistrement!", "error")
                        $('#product-form-value .btn-primary').attr("disabled", false).html("Enregistrer")
                    }

                },
                error: function (resp) {
                    sweetAlert("Désolé!", "Une erreur s'est produite.", "error");
                    $('#product-form-value .btn-primary').attr("disabled", false).html("Enregistrer")
                }
            });
        });
        // fonction qui charge les produits : les elements du tableau
        function loadProducts() {
            $('#example').dataTable().fnClearTable();
            $('#example').dataTable().fnDestroy();
            // $("#example").DataTable.destroy();
            $("#example").DataTable({
                Processing: true,
                searching: true,
                serverSide: true,
                LengthChange: true, // desactive le module liste deroulante(d'affichage du nombre de resultats par page)
                iDisplayLength: 10, // Configure le nombre de resultats a afficher par page a 10
                bRetrieve: false,
                stateSave: false,
                ajaxSetup:{
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                },
                ajax:{
                    url: "{{ route('produit.load') }}",
                },

                columns: [
                    {data: 'DT_RowIndex',name:'produit_id', orderable: true, searchable: true},
                    {data: 'reference',name:'reference'},
                    {data: 'titre_produit',name:'titre_produit'},
                    {data: 'titre_cat',name:'categories.titre_cat', orderable: true, searchable: true},
                    {data: 'quantite_produit',name:'quantite_produit'},
                    {data: 'prix_produit',name:'prix_produit'},
                    {data: 'stock',name:'stock', orderable: true, searchable: false},
                    {data: 'description',name:'description_produit'},
                    {data: 'firstname',name:'users.firstname', orderable: true, searchable: false},
                    {data: 'action', name: 'action', orderable: false, searchable: false},

                ],
                order: ['0','desc']
            })

        }

        $(document).ready(function () {
            loadProducts()
        });

        // edit product
        function  editFun(id){
                $('#edit-product-form'+id +' .btn-primary').attr("disabled", true).html("En cours...")
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var data = $('#edit-product-form'+id).serialize()

                $.ajax({
                    type: "POST",
                    url: "{{ route('produit.update') }}",
                    data: data,
                    dataType: 'json',
                    success: function (res) {
                        if (res) {
                            // swal.fire("Effectué!", "Enregistré avec succès!", "success")
                            // on recharge le tableau de produit
                            toastr.success("Enregistré avec succès!");

                            $('#produitsModal'+id).modal('hide');
                            $('#edit-product-form'+id +' .btn-primary').attr("disabled", false).html("Enregistrer")
                            loadProducts();
                        } else {
                            sweetAlert("Désolé!", "Erreur lors de l'enregistrement!", "error")
                            $('#edit-product-form'+id +' .btn-primary').attr("disabled", false).html("Enregistrer")
                        }

                    },
                    error: function (resp) {
                        sweetAlert("Désolé!", "Une erreur s'est produite.", "error");
                        $('#product-form-value .btn-primary').attr("disabled", false).html("Enregistrer")
                    }
                });

        }


    </script>
    <script src="{{asset('template/vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
{{--    <script src="{{asset('template/js/plugins-init/datatables.init.js')}}"></script>--}}

    <script src="{{asset('template/vendor/sweetalert2/dist/sweetalert2.min.js')}}"></script>
    <!-- Selet search -->
    <script src="{{asset('template/vendor/select2/js/select2.full.min.js')}}"></script>
    <script src="{{asset('template/js/plugins-init/select2-init.js')}}"></script>

    <!-- Datatable -->
{{--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>--}}
{{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>--}}

    {{--    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>--}}
{{--    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>--}}
{{--    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>--}}

    <script src="{{ asset('datatable/js/jquery.dataTables.min.js') }}"></script>
{{--    <script src="{{ asset('datatable/js/bootstrap.min.js') }}"></script>--}}
{{--    <script src="{{ asset('datatable/js/dataTables.bootstrap4.min.js') }}"></script>--}}

@endsection
