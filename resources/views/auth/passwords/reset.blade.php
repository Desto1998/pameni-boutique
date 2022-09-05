@extends('_layouts.guest')

@section('content')
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth px-0">
                <div class="row w-100 mx-0">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                            @if ($is_validToken==0)
                                <div class="alert alert-danger alert-dismissible fade show">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                                    </button>
                                    <strong>Votre delais d'attente a expiré. Veillez recommenecer!</strong>
                                </div>
                            @endif
                            <h4 class="text-center mb-4">Recuperer mon compte</h4>
                            @include('_partial._flash-message')
                            <form  method="POST" action="{{ route('password.update') }}">
                                <div class="form-group">
                                    @csrf
                                    <input type="hidden" name="token" value="{{ $token }}">
                                    <label><strong>Email</strong></label>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="example@gmail.com" required autocomplete="email" autofocus>

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                <div class="form-group">

                                    <label><strong>Nouveau mot de passe</strong></label>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>

                                <div class="form-group">

                                    <label><strong>Confirmez le mot de passe</strong></label>
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">

                                </div>


                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary btn-block">Valider</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
