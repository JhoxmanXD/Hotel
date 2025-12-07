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
                            <h3>Crear Habitación</h3>
                        </div>
                        <form method="POST" action="{{ route('rooms.store') }}">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Tipo de Habitación <span class="text-danger">*</span></label>
                                            <select name="room_type_id" class="form-control @error('room_type_id') is-invalid @enderror" required>
                                                <option value="">-- Seleccione --</option>
                                                @foreach($roomtypes as $rt)
                                                    <option value="{{ $rt->id }}" {{ old('room_type_id') == $rt->id ? 'selected' : '' }}>
                                                        {{ $rt->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('room_type_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Número <span class="text-danger">*</span></label>
                                            <input type="text" name="number" class="form-control @error('number') is-invalid @enderror"
                                                   value="{{ old('number') }}" required autocomplete="off">
                                            @error('number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Piso <span class="text-danger">*</span></label>
                                            <input type="number" name="floor" class="form-control @error('floor') is-invalid @enderror"
                                                   value="{{ old('floor') }}" required min="0" step="1">
                                            @error('floor') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Tarifa <span class="text-danger">*</span></label>
                                            <input type="number" name="value" class="form-control @error('value') is-invalid @enderror"
                                                   value="{{ old('value') }}" required min="0" step="0.01">
                                            @error('value') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Capacidad (personas) <span class="text-danger">*</span></label>
                                            <input type="number" name="numpeople" class="form-control @error('numpeople') is-invalid @enderror"
                                                   value="{{ old('numpeople') }}" required min="1" step="1">
                                            @error('numpeople') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Registrar</button>
                                <a href="{{ route('rooms.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                            </div>
                        </form>
                    </div> <!-- card -->
                </div>
            </div>
        </div>
    </section>
</div>
@endsection