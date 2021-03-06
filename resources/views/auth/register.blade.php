@extends('layouts.app')

@section('page-header')
    <div class="page-header page-header-default">
        <div class="page-header-content">
            <div class="page-title">
                <h4><i class="icon-users4 position-left"></i> <span class="text-semibold">Usuarios</span> - Registro
                    <small class="display-block">Al registrarte aceptas las condiciones de la plataforma. Tu cuenta puede estar sujeta a aprobación por parte del equipo administrador.</small>
                </h4>
            </div>
        </div>

        <div class="breadcrumb-line">
            <ul class="breadcrumb">
                <li><a href="/"><i class="icon-home2 position-left"></i> Inicio</a></li>
                <li><a>Usuarios</a></li>
                <li class="active">Registro</li>
            </ul>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-body login-form">
                <div class="text-center">
                    <div class="icon-object border-success text-success"><i class="icon-plus3"></i></div>
                    <h5 class="content-group">{{ __('Crear una cuenta') }}
                        <small class="display-block">{{ __('Todos los campos son obligatorios') }}</small>
                    </h5>
                </div>
                <div class="content-divider text-muted form-group"><span>{{ __('Información de acceso') }}</span></div>
                <form class="form-horizontal" role="form" method="POST" action="{{ route('register') }}">
                    {{ csrf_field() }}
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} has-feedback has-feedback-left">
                        <input id="email" type="email" class="form-control" placeholder="Tu correo electrónico" name="email"
                               value="{{ old('email') }}" required>
                        <div class="form-control-feedback">
                            <i class="icon-mention text-muted"></i>
                        </div>
                        @if ($errors->has('email'))
                            <span class="help-block text-danger"><i
                                        class="icon-cancel-circle2 position-left"></i> {{ $errors->first('email') }}</span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }} has-feedback has-feedback-left">
                        <input id="password" type="password" name="password" class="form-control" placeholder="Crear contraseña" required>
                        <div class="form-control-feedback">
                            <i class="icon-user-lock text-muted"></i>
                        </div>
                        @if ($errors->has('password'))
                            <span class="help-block text-danger"><i
                                        class="icon-cancel-circle2 position-left"></i> {{ $errors->first('password') }}</span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }} has-feedback has-feedback-left">
                        <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" placeholder="Confirmar contraseña"
                               required>
                        <div class="form-control-feedback">
                            <i class="icon-user-lock text-muted"></i>
                        </div>
                        @if ($errors->has('password_confirmation'))
                            <span class="help-block text-danger"><i
                                        class="icon-cancel-circle2 position-left"></i> {{ $errors->first('password_confirmation') }}</span>
                        @endif
                    </div>
                    <div class="content-divider text-muted form-group"><span>Datos personales</span></div>
                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }} has-feedback has-feedback-left">
                        <input id="name" type="text" class="form-control" placeholder="Tu nombre" name="name" value="{{ old('name') }}" required
                               autofocus>
                        <div class="form-control-feedback">
                            <i class="icon-user-check text-muted"></i>
                        </div>
                        @if ($errors->has('name'))
                            <span class="help-block text-danger"><i class="icon-cancel-circle2 position-left"></i> {{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <button type="submit" class="btn bg-teal btn-block btn-lg">{{ __('Crear cuenta') }} <i
                                class="icon-circle-right2 position-right"></i></button>
                </form>

            </div>
        </div>
    </div>
@endsection
