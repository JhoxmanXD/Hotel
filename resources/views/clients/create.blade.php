@extends('layouts.app')

@section('title','Registrar Cliente')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid"></div>
    </section>
    @include('layouts.partials.msg')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-10">
                    <div class="card">
                        <div class="card-header bg-secondary">
                            <h3>@yield('title')</h3>
                        </div>
                        <form method="POST" action="{{ route('clients.store') }}">
                            @csrf
                            <div class="card-body">

                                <div class="form-group">
                                    <label>Nombre <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                           value="{{ old('name') }}" required autocomplete="off">
                                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="form-group">
                                    <label>Número de Documento <span class="text-danger">*</span></label>
                                    <input type="text" name="documentNumber" class="form-control @error('documentNumber') is-invalid @enderror"
                                           value="{{ old('documentNumber') }}" required autocomplete="off">
                                    @error('documentNumber') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                                   value="{{ old('email') }}" autocomplete="off">
                                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Teléfono</label>
                                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                                   value="{{ old('phone') }}" autocomplete="off">
                                            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Dirección</label>
                                            <input type="text" name="address" class="form-control @error('address') is-invalid @enderror"
                                                   value="{{ old('address') }}" autocomplete="off">
                                            @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>

                                <input type="hidden" name="state" value="1">

                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-lg-2 col-xs-4 mb-2">
                                        <button type="submit" class="btn btn-primary btn-block">Registrar</button>
                                    </div>
                                    <div class="col-lg-2 col-xs-4">
                                        <a href="{{ route('clients.index') }}" class="btn btn-outline-secondary btn-block">Cancelar</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div> <!-- card -->
                </div>
            </div>
        </div>
    </section>
</div>
@endsection