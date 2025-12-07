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
                            <h3>Crear Factura</h3>
                        </div>
                        <form method="POST" action="{{ route('invoices.store') }}">
                            @csrf
                            <div class="card-body">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Registro (Reserva) <span class="text-danger">*</span></label>
                                            <select name="registration_id" class="form-control @error('registration_id') is-invalid @enderror" required>
                                                <option value="">-- Seleccione --</option>
                                                @foreach($registrations as $reg)
                                                    <option value="{{ $reg->id }}" {{ old('registration_id') == $reg->id ? 'selected' : '' }}>
                                                        #{{ $reg->id }} - {{ optional($reg->client)->name }}
                                                        @if(optional($reg->room)->number)
                                                            (Hab: {{ $reg->room->number }})
                                                        @endif
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('registration_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Método de Pago <span class="text-danger">*</span></label>
                                            <select name="payment_method_id" class="form-control @error('payment_method_id') is-invalid @enderror" required>
                                                <option value="">-- Seleccione --</option>
                                                @foreach($paymentmethods as $pm)
                                                    <option value="{{ $pm->id }}" {{ old('payment_method_id') == $pm->id ? 'selected' : '' }}>
                                                        {{ $pm->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('payment_method_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Fecha <span class="text-danger">*</span></label>
                                            <input type="date" name="date" class="form-control @error('date') is-invalid @enderror"
                                                   value="{{ old('date', now()->format('Y-m-d')) }}" required>
                                            @error('date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Total <span class="text-danger">*</span></label>
                                            <input type="number" step="0.01" min="0" name="total"
                                                   class="form-control @error('total') is-invalid @enderror"
                                                   value="{{ old('total') }}" required autocomplete="off">
                                            @error('total') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Estado <span class="text-danger">*</span></label>
                                            <select name="state" class="form-control @error('state') is-invalid @enderror" required>
                                                <option value="1" {{ old('state') == '1' ? 'selected' : '' }}>Activo</option>
                                                <option value="0" {{ old('state') === '0' ? 'selected' : '' }}>Inactivo</option>
                                            </select>
                                            @error('state') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Registrar</button>
                                <a href="{{ route('invoices.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                            </div>
                        </form>
                    </div> <!-- card -->
                </div>
            </div>
        </div>
    </section>
</div>
@endsection