@extends('layouts.guest')

@section('content')

    <div class="authincation h-100">
        <div class="container-fluid h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-4">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
                                    <h4 class="text-center mb-4">Recuperer mon compte</h4>
                                    <form method="POST" action="{{ route('password.email') }}">
                                        <div class="form-group">
                                            @csrf
                                            <label><strong>Email</strong></label>
                                            <input id="email" type="email"
                                                   class="form-control @error('email') is-invalid @enderror"
                                                   name="email" value="{{ old('email') }}"
                                                   placeholder="example@gmail.com" required autocomplete="email"
                                                   autofocus>

                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                        </div>


                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary btn-block">Verifier mon email
                                            </button>
                                                <a class="btn btn-link" href="{{ route('login') }}">
                                                    {{ __('Revenir') }}
                                                </a>
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


@endsection
