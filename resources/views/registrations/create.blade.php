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
                <div class="col-md-11">
                    <div class="card">
                        <div class="card-header bg-secondary">
                            <h3>Crear Registro de Hospedaje</h3>
                        </div>
                        <form method="POST" action="{{ route('registrations.store') }}">
                            @csrf
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Cliente <span class="text-danger">*</span></label>
                                            <select name="client_id" class="form-control @error('client_id') is-invalid @enderror" required>
                                                <option value="">-- Seleccione --</option>
                                                @foreach($clients as $c)
                                                    <option value="{{ $c->id }}" {{ old('client_id') == $c->id ? 'selected' : '' }}>
                                                        {{ $c->name }} @if($c->documentNumber) ({{ $c->documentNumber }}) @endif
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('client_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Habitación <span class="text-danger">*</span></label>
                                            <select name="room_id" class="form-control @error('room_id') is-invalid @enderror" required>
                                                <option value="">-- Seleccione --</option>
                                                @foreach($rooms as $r)
                                                    <option value="{{ $r->id }}" {{ old('room_id') == $r->id ? 'selected' : '' }}>
                                                        {{ $r->number }} @if(optional($r->roomType)->name) - {{ $r->roomType->name }} @endif
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('room_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Empleado <span class="text-danger">*</span></label>
                                            <select name="employee_id" class="form-control @error('employee_id') is-invalid @enderror" required>
                                                <option value="">-- Seleccione --</option>
                                                @foreach($employees as $e)
                                                    <option value="{{ $e->id }}" {{ old('employee_id') == $e->id ? 'selected' : '' }}>
                                                        {{ $e->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('employee_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Fecha Entrada <span class="text-danger">*</span></label>
                                            <input type="date" name="checkindate" value="{{ old('checkindate') }}"
                                                   class="form-control @error('checkindate') is-invalid @enderror" required>
                                            @error('checkindate') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Hora Entrada <span class="text-danger">*</span></label>
                                            <input type="time" name="checkintime" value="{{ old('checkintime') }}"
                                                   class="form-control @error('checkintime') is-invalid @enderror" required>
                                            @error('checkintime') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Fecha Salida</label>
                                            <input type="date" name="checkoutdate" value="{{ old('checkoutdate') }}"
                                                   class="form-control @error('checkoutdate') is-invalid @enderror">
                                            @error('checkoutdate') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Hora Salida</label>
                                            <input type="time" name="checkouttime" value="{{ old('checkouttime') }}"
                                                   class="form-control @error('checkouttime') is-invalid @enderror">
                                            @error('checkouttime') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            <small class="form-text text-muted">Requerida si seleccionas Fecha Salida.</small>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Registrar</button>
                                <a href="{{ route('registrations.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                            </div>
                        </form>
                    </div> <!-- card -->
                </div>
            </div>
        </div>
    </section>
</div>
@endsection