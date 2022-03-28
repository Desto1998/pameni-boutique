@extends('layouts.app')
@section('title','| USER-ADD')
@section('css_before')

@stop
@section('content')
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Créer un utilisateur</h4>
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

{{--                        <h4 class="card-title">{{ __('Créer un utilisateur') }}</h4>--}}
                        <form method="POST" action="{{ route('user.add.store') }}" id="registerForm">
                            @csrf

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="lastname" class="">{{ __('Nom') }}&nbsp;<span
                                            class="text-danger">*</span></label>

                                    <input id="lastname" type="text"
                                           class="form-control @error('name') is-invalid @enderror" name="name"
                                           value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror

                                </div>
                                <div class="form-group col-md-6">
                                    <label for="firstname" class="">{{ __('Prenom') }}</label>

                                    <input id="firstname" type="text"
                                           class="form-control @error('name') is-invalid @enderror" name="firstname"
                                           value="{{ old('firstname') }}" autocomplete="firstname" autofocus>

                                    @error('firstname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="email" class="">{{ __('Email') }}&nbsp;<span
                                            class="text-danger">*</span></label>


                                    <input id="email" type="email"
                                           class="form-control @error('email') is-invalid @enderror" name="email"
                                           value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror

                                </div>


                                <div class="form-group col-md-6">
                                    <label for="cf-phone">{{ __('Téléphone') }} &nbsp;<span
                                            class="text-danger">*</span></label>

                                    <input id="cf-phone" name="phone" type="tel"
                                           class="form-control @error('phone') is-invalid @enderror" minlength="8"
                                           maxlength="14" required>
                                    @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="role">Role <span class="text-danger">*</span></label>
                                    <select name="role" class="form-control" id="role">
                                        <option value="2">Utilisateur</option>
                                        <option value="1">Administrateur</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="password" class="">{{ __('Mot de passe') }}&nbsp;<span
                                            class="text-danger">*</span></label>
                                    <input id="password" type="password"
                                           class="form-control @error('password') is-invalid @enderror" name="password"
                                           required autocomplete="new-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror

                                </div>
                            </div>
{{--                            <div class="row">--}}
{{--                                --}}

{{--                                <div class="form-group col-md-6">--}}
{{--                                    <label for="password-confirm"--}}
{{--                                           class="">{{ __('Confirmer le mot de passe') }}&nbsp;<span--}}
{{--                                            class="text-danger">*</span></label>--}}

{{--                                    <input id="password-confirm" type="password" class="form-control"--}}
{{--                                           onblur="checkConfirmPassword()"--}}
{{--                                           name="password_confirmation" required autocomplete="new-password">--}}
{{--                                    <div id="invalid-passconf" hidden><span class="text-danger">Le mot de passe confirmé est different !</span>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}

                            <div class="form-group row mb-0 text-centers justify-content-center">
                                <div class="col-md-6 ">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        {{ __('Enregistrer') }}
                                    </button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
@section('script')

@endsection
