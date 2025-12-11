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
                        <div class="card-header bg-warning">
                            <h3>Editar Empleado: {{ $employee->name }}</h3>
                        </div>
                        
                        {{-- FORMULARIO DE EDICIÓN --}}
                        <form method="POST" action="{{ route('employees.update', $employee) }}">
                            @csrf
                            @method('PUT') {{-- Indica a Laravel que es una actualización --}}
                            
                            <div class="card-body">
                                <div class="row">
                                    {{-- Nombre --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nombre <span class="text-danger">*</span></label>
                                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                                   value="{{ old('name', $employee->name) }}" required autocomplete="off">
                                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>

                                    {{-- Documento --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Número de Documento <span class="text-danger">*</span></label>
                                            <input type="text" name="documentNumber" class="form-control @error('documentNumber') is-invalid @enderror"
                                                   value="{{ old('documentNumber', $employee->documentNumber) }}" required autocomplete="off">
                                            @error('documentNumber') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    {{-- Dirección --}}
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Dirección</label>
                                            <input type="text" name="address" class="form-control @error('address') is-invalid @enderror"
                                                   value="{{ old('address', $employee->address) }}" autocomplete="off">
                                            @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>

                                    {{-- Teléfono --}}
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Teléfono</label>
                                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                                   value="{{ old('phone', $employee->phone) }}" autocomplete="off">
                                            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>

                                    {{-- Email --}}
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                                   value="{{ old('email', $employee->email) }}" autocomplete="off">
                                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>

                                {{-- Password (Opcional si usas Laravel Breeze/Jetstream para usuarios) --}}
                                {{-- <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Contraseña (Dejar vacío para no cambiar)</label>
                                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div> --}}
                                
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-warning">Actualizar</button>
                                <a href="{{ route('employees.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                            </div>
                        </form>
                    </div> 
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
