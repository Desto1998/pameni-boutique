@extends('layouts.app')
@section('title','| PROFILE')
@section('content')
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Mon profil</h4>
                    <p class="mb-0"></p>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Profile</a></li>
                </ol>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card px-3">
                    <div class="card-header">{{ __('Modifier vos informations') }}</div>
                    <div class="card-body">
                        <ul class="nav nav-pills mb-4">
                            <li class=" nav-item">
                                <a href="#navpills-1" class="nav-link active" data-toggle="tab" aria-expanded="false">A propos de moi</a>
                            </li>


                            <li class="nav-item">
                                <a href="#navpills-2" class="nav-link" data-toggle="tab" aria-expanded="false">Photo de profil</a>
                            </li>
                            <li class="nav-item">
                                <a href="#navpills-3" class="nav-link" data-toggle="tab" aria-expanded="true">Mettre à jour mon mot de passe</a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div id="navpills-1" class="tab-pane active">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="p-t-15">
                                            <label class="h4">Mes informations</label>
                                            <button type="button" style="float: right;" class="btn btn-light" id="edit-btn" title="Modifier mes informations">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                        </div>

                                        <form method="POST" action="{{ route('user.edit.infos') }}"
                                              id="registerForm">
                                            @csrf
                                            <input type="hidden" name="userid" value="{{ $user->id }}">

                                            <div class="form-group">
                                                <label for="lastname" class="">{{ __('Nom') }}&nbsp;<span
                                                        class="text-danger">*</span></label>
                                                <input id="lastname" type="text"
                                                       class="form-control edit-info @error('name') is-invalid @enderror"
                                                       name="name" disabled
                                                       value="{{ $user->lastname }}" required
                                                       autocomplete="name" autofocus>

                                                @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror

                                            </div>
                                            <div class="form-group">
                                                <label for="firstname" class="">{{ __('Prenom') }}</label>

                                                <input id="firstname" type="text" disabled
                                                       class="form-control edit-info @error('name') is-invalid @enderror"
                                                       name="firstname"
                                                       value="{{ $user->firstname }}" required
                                                       autocomplete="firstname" autofocus>

                                                @error('firstname')
                                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label for="email" class="">{{ __('Email') }}
                                                    &nbsp;<span
                                                        class="text-danger">*</span></label>


                                                <input id="email" type="email"
                                                       class="form-control edit-info @error('email') is-invalid @enderror"
                                                       name="email" disabled
                                                       value="{{ $user->email }}" required
                                                       autocomplete="email">

                                                @error('email')
                                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                @enderror


                                                <div class="form-group">
                                                    <label for="cf-phone">{{ __('Téléphone') }}
                                                        &nbsp;<span
                                                            class="text-danger">*</span></label>

                                                    <input id="cf-phone" name="phone" type="tel"
                                                           class="form-control edit-info @error('phone') is-invalid @enderror"
                                                           minlength="8" disabled
                                                           maxlength="14" value="{{ $user->phone }}"
                                                           required>
                                                    @error('phone')
                                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                    @enderror
                                                </div>

                                            </div>
{{--                                            <div class="form-group">--}}
{{--                                                <label for="adresse">{{ __('Adresse') }}</label>--}}
{{--                                                <input type="text" class="form-control edit-info"--}}
{{--                                                       name="adresse" value="{{ $user->adresse }}"--}}
{{--                                                       id="adresse" disabled>--}}
{{--                                            </div>--}}
                                            <div class="form-group row mb-0 text-centers justify-content-center">
                                                <div class="col-md-6 ">
                                                    <button type="submit" disabled
                                                            class="btn btn-primary btn-block edit-info">
                                                        {{ __('Enregistrer') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div id="navpills-2" class="tab-pane">
                                <div class="row">
                                    <div class="col-md-12 d-flex justify-content-center">
                                        <div class="col-md-5">
                                            <form action="{{ route('user.profil.image') }}" method="post" enctype="multipart/form-data">
                                                <div class="row mt-2 mb-3">
{{--                                                    <label class="mb-2"> Votre image de profil</label>--}}
                                                </div>
                                                <input type="hidden" name="userid" value="{{ $user->id }}">
                                                @csrf
                                                <div class="text-center align-content-xxl-center">
                                                    <div class="row mb-3 ml-2" title="Cliquer pour selectioner une image">
                                                        <img id="logo-zone" style="width: 300px; height: 300px; min-height: 200px; min-width: 200px" src="{{ !empty($user->profile_photo_path)?asset('images/profil/'.$user->profile_photo_path):asset('images/logo-thumbnail.png') }}" alt="Ouopps! Auncune image disponible">
                                                    </div>
                                                    <div class="kv-avatar">
                                                        <div class="file-loading">
                                                            <input type="file" id="logo-upload" class="form-control" name="logo"  required>
                                                        </div>
                                                    </div>
                                                    <div class="kv-avatar-hint">
                                                        <small>Sélectionner un fichier< 1500 KB</small>
                                                    </div>
                                                </div>
                                                <div class="form-group mt-2">
                                                    <hr>
                                                    <div class="text-right">
                                                        <button type="submit" name="saveImage" class="btn btn-primary btn-block">Enregistrer</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="navpills-3" class="tab-pane">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="p-t-15">
                                            <label class="h4">Réinitialiser mon mot de passe</label>

                                        </div>
                                        <form method="POST" action="{{ route('user.edit.password') }}"
                                              id="registerForm">
                                            @csrf
                                            <input type="hidden" name="userid" value="{{ $user->id }}">

                                            <div class="form-group">
                                                <label for="password"
                                                       class="">{{ __('Ancien mot de passe') }}
                                                    &nbsp;<span
                                                        class="text-danger">*</span></label>
                                                <input id="oldpassword" type="password"
                                                       class="form-control reset-password @error('password') is-invalid @enderror"
                                                       name="oldpassword"
                                                       required autocomplete="old-password">

                                                @error('oldpassword')
                                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                @enderror

                                            </div>
                                            <div class="form-group">
                                                <label for="password"
                                                       class="">{{ __('Nouveau mot de passe') }}&nbsp;<span
                                                        class="text-danger">*</span></label>
                                                <input id="password" type="password"
                                                       class="form-control reset-password @error('password') is-invalid @enderror"
                                                       name="password"
                                                       required autocomplete="new-password">

                                                @error('password')
                                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                                @enderror

                                            </div>

                                            <div class="form-group">
                                                <label for="password-confirm"
                                                       class="">{{ __('Confirmer le mot de passe') }}
                                                    &nbsp;<span
                                                        class="text-danger">*</span></label>

                                                <input id="password-confirm" type="password"
                                                       class="form-control reset-password"
                                                       onblur="checkConfirmPassword()"
                                                       name="password_confirmation" required
                                                       autocomplete="new-password">
                                                <div id="invalid-passconf" hidden><span
                                                        class="text-danger">Le mot de passe confirmé est different !</span>
                                                </div>
                                            </div>

                                            <div
                                                class="form-group row mb-0 text-centers justify-content-center">
                                                <div class="col-md-6 ">
                                                    <button type="submit"
                                                            class="btn btn-primary btn-block reset-password">
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
                </div>
            </div>
        </div>

    </div>

@stop
@section('script')

    <script>

        function checkForm() {
            var adress = $('#website').val();
            if (!/^(http(s)?\/\/:)?(www\.)?[a-zA-Z\-]{3,}(\.(com|net|org))?$/.test(adress)) {
                $('#invalid-website').removeAttr('hidden');
                $('#registerForm').preventDefault();
            }
            // else {
            //     $('#invalid-website').addAttr('hidden');
            // }
            var password = $('#password').val();
            var confirmpass = $('#password-confirm').val();
            if (password !== confirmpass) {
                $('#invalid-passconf').removeAttr('hidden');
                $('#registerForm').preventDefault();
            }
        }

        function checkConfirmPassword() {
            var password = $('#password').val();
            var confirmpass = $('#password-confirm').val();
            if (password != confirmpass) {
                $('#invalid-passconf').removeAttr('hidden');
                $('#invalid-passconf').show();

            } else {
                // $('#invalid-passconf').attr('hidden');
                $('#invalid-passconf').hide();
            }
        }
        $('#edit-btn').click(function (e){
            $('.edit-info').removeAttr('disabled');
            // $('.btn-primary').removeAttr('disabled');
        });
        $("#logo-zone").click(function(e) {
            $("#logo-upload").click();
        });
        function fasterPreview( uploader ) {
            if ( uploader.files && uploader.files[0] ){
                $('#logo-zone').attr('src',
                    window.URL.createObjectURL(uploader.files[0]) );
            }
        }
        $("#logo-upload").change(function(){
            fasterPreview( this );
        });
        $('#edit-btn').click(function (e){
            $('.form-control').removeAttr('disabled');
            $('.btn-primary').removeAttr('disabled');
        });
    </script>
@endsection
