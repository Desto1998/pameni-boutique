@extends('_layouts.site_layout')
@section('title','| ACCEUIL')
@section('content')
    <div class="container d-flex justify-content-center mt-3">
        @include('_partial._flash-message')
        <div class="card col-md-12">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <label>MTN MOMO</label>
                        <div class="row mb-4">
{{--                            <img src="" alt="Image introuvable">--}}
                        </div>
                        <form action="">
                            <div class="form-group">
                                <label class="form-label">Numero <span class="text-danger">*</span></label>
                                <input type="number" name="numero" min="9" maxlength="9"
                                       class="form-control form-control-sm" placeholder="Numero">

                            </div>
                            <button type="submit" name="btn" class="btn w-100 btn-primary btn-block btn-sm mt-3">Valider
                            </button>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div id="paypal-payment-button"></div>

                        </div>
                    </div>
                </div>
                <a href="{{ route('site.boutique') }}">Retourner au site</a>

                <div class="row">
                </div>
            </div>
        </div>

    </div>
@endsection
@section('script')
    <script
        src="https://www.paypal.com/sdk/js?client-id=AaQXD4PtqVKT39q5UHiUZ4G_M_t6-gTnxzGN0AVT8FN1DIybtDtQM08cXeqZwE6xve71QCnM1kQG0zqR&currency=EUR"></script>
    {{--    <script src="https://www.paypal.com/sdk/js?client-id=TON_CLIENT_ID&currency=EUR"></script>--}}
    {{--    <script src="paypal.js"></script>--}}
    <script>
        paypal.Buttons({
            style: {
                color: 'blue'
            },
            createOrder: function (data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '0.10'
                        }
                    }]
                })
            },
            onApprove: function (data, actions) {
                // This function captures the funds from the transaction.
                return actions.order.capture().then(function (details) {
                    console.log(details)
                    window.location.replace("success.html")
                })
            }
        }).render('#paypal-payment-button');
    </script>
@endsection
