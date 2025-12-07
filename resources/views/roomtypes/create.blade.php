@extends ('layouts.app')

@section ('content')
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
                            <h3>Crear Tipo de Habitación</h3>
                        </div>
                        <form method="POST" action="{{ route('roomtypes.store') }}">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Nombre <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                           value="{{ old('name') }}" required autocomplete="off">
                                    @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="form-group">
                                    <label>Descripción <span class="text-danger">*</span></label>
                                    <input type="text" name="description" class="form-control @error('description') is-invalid @enderror"
                                           value="{{ old('description') }}" required autocomplete="off">
                                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Registrar</button>
                                <a href="{{ route('roomtypes.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                            </div>
                        </form>
                    </div> <!-- card -->
                </div>
            </div>
        </div>
    </section>
</div>
@endsection