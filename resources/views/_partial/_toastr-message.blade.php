<script>

    @if ($message = Session::get('primary'))
        toastr.options =
        {
            "closeButton": true,
            "progressBar": true
        }
    toastr.success("{{ $message }}");
    @endif
        @if ($message = Session::get('success'))
        toastr.options =
        {
            "closeButton": true,
            "progressBar": true
        }
    toastr.success("{{ $message }}");
    @endif

        @if ($message = Session::get('error'))
        toastr.options =
        {
            "closeButton": true,
            "progressBar": true
        }
    toastr.error("{{ $message }}");
    @endif


        @if ($message = Session::get('warning'))
        toastr.options =
        {
            "closeButton": true,
            "progressBar": true
        }
    toastr.warning("{{$message }}");
    @endif


        @if ($message = Session::get('info'))
        toastr.options =
        {
            "closeButton": true,
            "progressBar": true
        }
    toastr.info("{{ $message }}");
    @endif

        @if ($message = Session::get('danger'))
        toastr.options =
        {
            "closeButton": true,
            "progressBar": true
        }
    toastr.error("{{ $message }}");
    @endif


        @if ($errors->any())
        toastr.options =
        {
            "closeButton": true,
            "progressBar": true
        }
    toastr.error("Veuillez vérifier le formulaire ci-dessous pour les erreurs!");
    @endif

</script>
