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
                        <div class="card-header bg-warning">
                            <h3>Editar Registro de Hospedaje #{{ $registration->id }}</h3>
                        </div>
                        
                        {{-- FORMULARIO DE EDICIÓN --}}
                        <form method="POST" action="{{ route('registrations.update', $registration) }}">
                            @csrf
                            @method('PUT') {{-- NECESARIO para indicar que es una actualización --}}
                            
                            <div class="card-body">
                                
                                {{-- CLIENTE Y HABITACIÓN --}}
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Cliente <span class="text-danger">*</span></label>
                                            <select name="client_id" class="form-control @error('client_id') is-invalid @enderror" required>
                                                <option value="">-- Seleccione Cliente --</option>
                                                @foreach($clients as $client)
                                                    <option value="{{ $client->id }}" 
                                                        {{ old('client_id', $registration->client_id) == $client->id ? 'selected' : '' }}>
                                                        {{ $client->name }}
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
                                                <option value="">-- Seleccione Habitación --</option>
                                                @foreach($rooms as $room)
                                                    <option value="{{ $room->id }}" 
                                                        {{ old('room_id', $registration->room_id) == $room->id ? 'selected' : '' }}>
                                                        #{{ $room->number }} - {{ optional($room->roomType)->name }}
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
                                                <option value="">-- Seleccione Empleado --</option>
                                                @foreach($employees as $employee)
                                                    <option value="{{ $employee->id }}" 
                                                        {{ old('employee_id', $registration->employee_id) == $employee->id ? 'selected' : '' }}>
                                                        {{ $employee->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('employee_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                {{-- FECHAS --}}
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Fecha Entrada <span class="text-danger">*</span></label>
                                            <input type="date" name="checkindate" class="form-control @error('checkindate') is-invalid @enderror"
                                                   value="{{ old('checkindate', \Carbon\Carbon::parse($registration->checkindate)->format('Y-m-d')) }}" required>
                                            @error('checkindate') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Hora Entrada <span class="text-danger">*</span></label>
                                            <input type="time" name="checkintime" class="form-control @error('checkintime') is-invalid @enderror"
                                                   value="{{ old('checkintime', $registration->checkintime) }}" required>
                                            @error('checkintime') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Fecha Salida</label>
                                            <input type="date" name="checkoutdate" class="form-control @error('checkoutdate') is-invalid @enderror"
                                                   value="{{ old('checkoutdate', optional($registration->checkoutdate)->format('Y-m-d')) }}">
                                            @error('checkoutdate') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Hora Salida</label>
                                            <input type="time" name="checkouttime" class="form-control @error('checkouttime') is-invalid @enderror"
                                                   value="{{ old('checkouttime', $registration->checkouttime) }}">
                                            @error('checkouttime') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-warning">Actualizar</button>
                                <a href="{{ route('registrations.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                            </div>
                        </form>
                    </div> 
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
