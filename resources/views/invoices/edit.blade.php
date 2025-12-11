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
                            <h3>Editar Factura #{{ $invoice->id }}</h3>
                        </div>
                        
                        {{-- FORMULARIO DE EDICIÓN --}}
                        <form method="POST" action="{{ route('invoices.update', $invoice) }}">
                            @csrf
                            @method('PUT') {{-- Importante para actualizar --}}
                            
                            <div class="card-body">

                                <div class="row">
                                    {{-- Registro / Reserva --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Registro (Reserva) <span class="text-danger">*</span></label>
                                            {{-- ID "registration_id" es vital para el AJAX --}}
                                            <select name="registration_id" id="registration_id" class="form-control @error('registration_id') is-invalid @enderror" required>
                                                <option value="">-- Seleccione --</option>
                                                @foreach($registrations as $reg)
                                                    <option value="{{ $reg->id }}" 
                                                        {{ old('registration_id', $invoice->registration_id) == $reg->id ? 'selected' : '' }}>
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

                                    {{-- Método de Pago --}}
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Método de Pago <span class="text-danger">*</span></label>
                                            <select name="payment_method_id" class="form-control @error('payment_method_id') is-invalid @enderror" required>
                                                <option value="">-- Seleccione --</option>
                                                @foreach($paymentmethods as $pm)
                                                    <option value="{{ $pm->id }}" 
                                                        {{ old('payment_method_id', $invoice->payment_method_id) == $pm->id ? 'selected' : '' }}>
                                                        {{ $pm->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('payment_method_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    {{-- Fecha --}}
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Fecha <span class="text-danger">*</span></label>
                                            <input type="date" name="date" class="form-control @error('date') is-invalid @enderror"
                                                   value="{{ old('date', \Carbon\Carbon::parse($invoice->date)->format('Y-m-d')) }}" required>
                                            @error('date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>

                                    {{-- Total (Calculado automáticamente) --}}
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Total <span class="text-danger">*</span></label>
                                            <input type="number" step="0.01" min="0" name="total" id="total"
                                                   class="form-control @error('total') is-invalid @enderror"
                                                   value="{{ old('total', $invoice->total) }}" required autocomplete="off" readonly>
                                            @error('total') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>

                                    {{-- Estado --}}
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Estado <span class="text-danger">*</span></label>
                                            <select name="state" class="form-control @error('state') is-invalid @enderror" required>
                                                <option value="1" {{ old('state', $invoice->state) == '1' ? 'selected' : '' }}>Activo</option>
                                                <option value="0" {{ old('state', $invoice->state) === '0' ? 'selected' : '' }}>Inactivo</option>
                                            </select>
                                            @error('state') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-warning">Actualizar</button>
                                <a href="{{ route('invoices.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                            </div>
                        </form>
                    </div> 
                </div>
            </div>
        </div>
    </section>
</div>

{{-- SCRIPT PARA RECALCULAR TOTAL SI CAMBIAN LA RESERVA --}}
@push('scripts')
<script>
    $(document).ready(function() {
        // Cuando cambian la Reserva seleccionada en la edición
        $('#registration_id').change(function() {
            var registrationId = $(this).val();
            
            if(registrationId) {
                // Aviso visual
                $('#total').attr('placeholder', 'Recalculando...');

                $.ajax({
                    url: '/registration/' + registrationId + '/calculate',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        // Actualizar el total con el nuevo cálculo
                        $('#total').val(data.total);
                    },
                    error: function() {
                        alert('Error al recalcular el precio.');
                    }
                });
            } else {
                $('#total').val('');
            }
        });
    });
</script>
@endpush

@endsection
