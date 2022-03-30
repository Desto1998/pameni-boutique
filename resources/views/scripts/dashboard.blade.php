
{{--    list-unstyled--}}
{{--    no-notification--}}
    <script>
        $(document).ready(function (){
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
                    if (res) {
                        console.log(res)
                        $('.pulse-css').append('<span class="font-weight-bolder fs-6 mb-2">'+res.length+'</span>')
                        // toastr.warning("Vous pourrez avoir des nofications non lues!",'Alerte');
                        $('.list-unstyled').append(res);
                        $('#no-notification').hide();
                    } else {
                        toastr.success("Aucune notification!",'Alerte');
                    }
                },
                error: function (resp) {
                    toastr.warning("Une erreur s'est produite lors du chargement des notifications!");
                    sweetAlert("Désolé!", "Une erreur s'est produite lors du chargement des notifications!", "error");
                }
            });
        });
    </script>

