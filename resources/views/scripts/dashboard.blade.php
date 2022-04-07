
{{--    list-unstyled--}}
{{--    no-notification--}}
    <script>
        $(document).ready(function (){
            $('.pulse-css').hide();
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
                        $('.list-unstyled').append(res[0]);

                        $('.pulse-css').show().append('<span class="font-weight-bolder fs-6 mb-2">'+res[1]+'</span>')
                        // toastr.warning("Vous pourrez avoir des nofications non lues!",'Alerte');

                        $('#no-notification').hide();
                    } else {
                        toastr.success("Aucune notification!",'Alerte');
                    }
                },
                error: function (resp) {
                    // toastr.warning("Une erreur s'est produite lors du chargement des notifications!");
                    sweetAlert("Désolé!", "Une erreur s'est produite lors du chargement des notifications! Veillez actualiser la page et reconnectez-vous", "error");
                }
            });
        });
    </script>

