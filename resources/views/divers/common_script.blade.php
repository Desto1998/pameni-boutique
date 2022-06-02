<script>

    //  variabes qui comptes les entrees
    var totalProduit = 0;
    var totalComplement = 0;
    var typeOperation = 1;
    $('#displayProductModal').click(function (e){
        typeOperation =1;
    });
    $('#displayComModal').click(function (e){
        typeOperation =2;
    });
    $(document).ready(function () {
        // ici on affiche les informations du client en fonction du client selectionneee

        $('#single-select').on('change', function (e) {
            var idclient = $('#single-select').val();
            // on cache d'abord toutes les infos client
            $('.infos_client').hide(200);
            //on affiche l'info client correspondant
            $('#infos_client' + idclient).show(250);
        });

        // cette methode ajoute une nouvelle ligne de produit sur le tableau
    });

    // cette fonction retire une ligne dans le tableau de produit
    function removeLigne(number) {

        if ($('#validated-element tbody').find("tr").length > 1) {
            $('#product-row' + number).remove();
            total();
        } else {
            alert("Vous ne pouvez pas supprimer tous les elements.");
        }
    }

    // fontion qui charge le prix d'un produit
    function setPrix(number) {
        var productId = $('#select-pro' + number).val();
        var defaultPrice = $('#data_p_prix' + productId).val();
        $('#prix' + number).val(defaultPrice);
        $('#quantite' + number).val(0);
        $('#totalHT' + number).val(0);
        $('#remise' + number).val(0);
        total();
    }


    // fonction qui calcule le montant HT  par produit
    function calculeHT(number) {

        var remise = 0;
        var qte = 0;
        var prix = 0;
        var tva = 0;

        if ($('#remise' + number).val() != '') {
            remise = $('#remise' + number).val()
        }
        if ($('#quantite' + number).val() != '') {
            prix = $('#quantite' + number).val()
        }
        if ($('#prix' + number).val() != '') {
            qte = $('#prix' + number).val()
        }
        if ($('select[name="tva_statut"]').val() == 1) {
            tva = 19.25;
        }
        if ($('select[name="tva_statut"]').val() == 2) {
            tva = 5.5;
        }
        // if ($('#tva'+number).val()!=''){
        //     tva = $('#tva'+number).val()
        // }

        var montant = (qte * prix) - (qte * prix * remise) / 100;

        var ttc = (montant * tva) / 100 + montant;
        ttc = Number(ttc).toFixed(2);
        montant = Number(montant).toFixed(2)
        $('#totalHT' + number).val(montant);
        // $('#totalTTC'+number).val(ttc);
        total();

    }

    $('select[name="tva_statut"]').on('change', function (e) {
        // if ($('select[name="tva_statut"]').val()==1){
        total();
        // }
    });

    // fonction qui calcule les totaux HT et TTC
    function total() {
        var totalht = 0;
        var totalttc = 0;
        var tva = 0;
        $('input[name="totalHT[]"]').each(function () {
            totalht += Number($(this).val());
        });
        // $('input[name="totalTTC[]"]').each(function (){
        //    totalttc +=Number( $(this).val());
        // });
        if ($('select[name="tva_statut"]').val() == 1) {
            tva = 19.25;
        }
        if ($('select[name="tva_statut"]').val() == 2) {
            tva = 5.5;
        }
        var mtva = (totalht * tva) / 100;
        mtva = Number(mtva).toFixed(2)
        $('#mtva').val(mtva);
        $('#ht').val(Number(totalht).toFixed(2));
        var mttc = parseFloat(totalht) + parseFloat(mtva);
        $('#ttc').val(mttc);
    }


    // fontions pour la partie des complements


    // cette methode ajoute une nouvelle ligne de produit sur le tableau des complements


    // cette fonction retire une ligne dans le tableau de produit
    function removeComLigne(number) {
        $('#complement-row' + number).remove();
        // if ($('#table-complement tbody').find("tr").length > 1) {
        //
        //     // total();
        // } else {
        //     alert("Vous ne pouvez pas supprimer tous les elements.");
        // }
    }

    // fontion qui charge le prix d'un produit
    function setComPrix(number) {
        var productId = $('#select-com' + number).val();
        var defaultPrice = $('#data_p_prix' + productId).val();
        $('#prix_com' + number).val(defaultPrice);
    }

    function calculeComHT(number) {

        var remise = 0;
        var qte = 0;
        var prix = 0;
        var tva = 0;
        if ($('#select-com' + number).val()) {
            if ($('#remise_com' + number).val() != '') {
                remise = $('#remise_com' + number).val()
            }
            if ($('#quantite_com' + number).val() != '') {
                prix = $('#quantite_com' + number).val()
            }
            if ($('#prix_com' + number).val() != '') {
                qte = $('#prix_com' + number).val()
            }

            // if ($('#tva_com'+number).val()!=''){
            //     tva = $('#tva_com'+number).val()
            // }

            var montant = (qte * prix) - (qte * prix * remise) / 100;

            var ttc = (montant * tva) / 100 + montant;
            ttc = Number(ttc).toFixed(2);
            montant = Number(montant).toFixed(2)
            $('#total_comHT' + number).val(montant);
            // $('#total_comTTC'+number).val(ttc);
            total();
        }
    }

    // fonction qui calcule les totaux HT et TTC
    // function totalComp(){
    //     var totalht = 0;
    //     var totalttc = 0;
    //         $('input[name="total_comHT[]"]').each(function (){
    //            totalht += Number($(this).val());
    //         });
    //         $('input[name="total_comTTC[]"]').each(function (){
    //            totalttc +=Number( $(this).val());
    //         });
    //         // $('input[name="prix[]"]').each(function (){
    //         //    prix += $(this).val();
    //         // });
    //     $('#comht').val(Number(totalht).toFixed(2));
    //     $('#comttc').val(Number(totalttc).toFixed(2));
    // }

    // function d'ajout du client

    function filterFormInput() {
        var type = $('#type_client').val();
        if (type == 1) {
            $('.enterprisehide').show(200)
            $('.clienthide').hide(200)
            $('#nom_client').prop('required', false)
            $('#raison_s_client').prop('required', true)
            $('#raison_s_client').attr('disabled', false)
            $('#nom_client').attr('disabled', true)
            // $('#rcm').prop('required',true)
            $('#rcm').attr('disabled', false)
            $('#contribuabe').attr('disabled', false)
        } else {
            $('#raison_s_client').prop('required', false)
            $('#raison_s_client').attr('disabled', true)
            $('.enterprisehide').hide(200)
            $('.clienthide').show(200)
            $('#nom_client').prop('required', true)
            $('#nom_client').attr('disabled', false)
            $('#rcm').attr('disabled', true)
            $('#contribuabe').attr('disabled', true)
        }

    }

    $("#client-form").on("submit", function (event) {
        event.preventDefault();

        $('#client-form .btn-primary').attr("disabled", true).html("En cours...")
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var data = $('#client-form').serialize()

        $.ajax({
            type: "POST",
            url: "{{ route('client.store') }}",
            data: data,
            dataType: 'json',
            success: function (res) {
                console.log(res);
                if (res) {

                    toastr.success("Enregistré avec succès!");
                    $('.infos_client').hide(200);
                    var option = ' <option selected value="' + res.client_id + '">' + res.nom_client + ' ' + res.prenom_client + ' ' + res.raison_s_client + '</option>'
                    $('#single-select').append(option).select2();
                    // $('#single-select').select2();
                    var data = '<div class="hidden infos_client pl-3" id="infos_client' + res.client_id + '">';
                    data += '<label class="h5 font-weight-bold mt-1">' + res.nom_client + ' ' + res.prenom_client + ' ' + res.raison_s_client + '</label><br>'
                    data += '<label class="h5 font-weight-bold mt-1">Tel: ' + res.phone_1_client + ' / ' + res.phone_2_client + '</label><br>'
                    data += '  <label class="h5 font-weight-bold mt-1">Bp:' + res.postale + '</label><br>'
                    data += '</div>';
                    $('#client-block').append(data);
                    $('#infos_client' + res.client_id).show(100);
                    // on reinitialise le formulaire
                    $('#client-form .btn-primary').attr("disabled", false).html("Enregistrer")
                    $('#client-form')[0].reset()
                    $('#clientsModal').modal('hide');

                } else {
                    sweetAlert("Désolé!", "Erreur lors de l'enregistrement!", "error")
                    $('#client-form .btn-primary').attr("disabled", false).html("Enregistrer")
                }

            },
            error: function (resp) {
                sweetAlert("Désolé!", "Une erreur s'est produite.", "error");
                $('#client-form .btn-primary').attr("disabled", false).html("Enregistrer")
            }
        });
    });

    // variable qui compte le nombre de produit entree sur le formulair | ne pas toucher
    var totalInputs = 0;

    $('#addFields').on('click', function (event) {

        event.preventDefault();
        // if ($('#product-form-value').serialize() == null || $('#product-form-value').serialize() == undefined) {
        //     return false
        // }

        var titre = $('#titre_produit').val();
        var prix = $('#prix_produit').val();
        var qte = $('#quantite_produit').val()
        var desc = $('#description_produit').val()
        var remp = $('#remp').val()

        var cattext = $('#single-select option:selected').text();


        var categorie = $('#single-select').val()
        if (titre == '' || prix == '' || qte == '') {
            toastr.warning("Veillez remplir tous les champs obligatoires!");
            return "";
        } else {
            // totalProduit
            // totalComplement
            totalInputs++;


            $('#product-form')[0].reset();
            if (typeOperation===1){
                var id = 'addedBlock' + totalInputs;
                var block = '';
                var table = '<tr style="color: black" class="text-center" id="' + id + '">';

                table += '<td style="border:1px solid #eaeaea; width: 200px"><input type="text" required name="titre[]" class="form-control" value="' + titre + '"></td>'
                table += '<td style="border:1px solid #eaeaea; width: 60px"><input type="number" required name="quantite[]" class="form-control quantite " value="' + qte + '" onchange="calculeHT(' + totalInputs + ')" id="quantite' + totalInputs + '"></td>'
                table += '<td style="border:1px solid #eaeaea;"><input type="number" name="prix[]" required class="form-control prix" value="' + prix + '" onchange="calculeHT(' + totalInputs + ')" id="prix' + totalInputs + '"></td>'
                table += '<td style="border:1px solid #eaeaea; width: 100px"><input type="number" step="any" name="remise[]" class="form-control remise" value="' + remp + '" onchange="calculeHT(' + totalInputs + ')" id="remise' + totalInputs + '"></td>'
                table += '<td style="border:1px solid #eaeaea; width: 200px"><textarea name="description[]" class="form-control">' + desc + '</textarea></td>'
                table += '<td style="border:1px solid #eaeaea;"><input type="number" disabled name="totalHT[]" class="form-control totalHT" value="' + prix * qte + '" id="totalHT' + totalInputs + '"></td>'
                table += '<td style="border:1px solid #eaeaea; width: 50px"><button type="button" class="btn btn-sm btn-danger" onclick="removeElelement(' + totalInputs + ')"><i class="fa fa-trash-o"></i></button></td>'
                table += '</tr>';
                $('#validated-element>tbody').append(table);
                calculeHT(totalInputs);
                total();
            }
            if (typeOperation===2){
                var id = 'addedBlock-com' + totalInputs;
                var block = '';
                var table = '<tr style="color: black" class="text-center" id="' + id + '">';

                table += '<td style="border:1px solid #eaeaea; width: 200px"><input type="text" required name="titre_com[]" class="form-control" value="' + titre + '"></td>'
                table += '<td style="border:1px solid #eaeaea; width: 60px"><input type="number" required name="quantite_com[]" class="form-control quantite " value="' + qte + '" onchange="calculeComHT(' + totalInputs + ')" id="quantite_com' + totalInputs + '"></td>'
                table += '<td style="border:1px solid #eaeaea;"><input type="number" name="prix_com[]" required class="form-control prix_com" value="' + prix + '" onchange="calculeComHT(' + totalInputs + ')" id="prix_com' + totalInputs + '"></td>'
                table += '<td style="border:1px solid #eaeaea; width: 100px"><input type="number" step="any" name="remise_com[]" class="form-control remise_com" value="' + remp + '" onchange="calculeComHT(' + totalInputs + ')" id="remise_com' + totalInputs + '"></td>'
                table += '<td style="border:1px solid #eaeaea; width: 200px"><textarea name="description_com[]" class="form-control">' + desc + '</textarea></td>'
                table += '<td style="border:1px solid #eaeaea;"><input type="number" disabled name="total_comHT[]" class="form-control total_comHT" value="' + prix * qte + '" id="total_comHT' + totalInputs + '"></td>'
                table += '<td style="border:1px solid #eaeaea; width: 50px"><button type="button" class="btn btn-sm btn-danger" onclick="removeElelementCom(' + totalInputs + ')"><i class="fa fa-trash-o"></i></button></td>'
                table += '</tr>';

                $('#validated-element-com>tbody').append(table);
                calculeComHT(totalInputs);
                // total();
            }

        }
    });
    // Enlever toutes entrees  crees
    $('#removeFields').click(function (e) {

        if (confirm("Supprimer toutes entrées?") === true) {
            $('#validated-element tbody').find("tr").remove();
            $('#product-form-value')[0].reset();
            totalInputs = 0;
            total();
        }

    })

    // retirer un produit du tableau de produit sur la modal d'enregistrement des produits
    function removeElelement(nombre) {

        if (confirm("Supprimer cette ligne?") === true) {
            $('#validated-element tbody').find("#addedBlock" + nombre).remove();
            $('.addedBlock' + nombre).remove();
            totalInputs--;
            total();
        }
    }
    function removeElelementCom(nombre) {
        if (confirm("Supprimer cette ligne?") === true) {
            $('#validated-element-com tbody').find("#addedBlock-com" + nombre).remove();
            $('.addedBlock-com' + nombre).remove();
            totalInputs--;
        }
    }

    $('#devis-form').on('submit',function (e){

        if ($('#validated-element tbody').find("tr").length < 1) {
            alert("Assurez-vous de remplir au moins un produit. Merci!");
            // e.preventCancel;
            // e.preventAbort;
            // e.preventClose;

            return false;
        }
    });
</script>
