@extends('layouts.app')

@section('content')

    <div class="card mt-2">
        <div class="card-header">
            <a href="{{ route('invoices.create') }}" class="btn btn-primary float-right" title="Nuevo">
                <i class="fas fa-plus nav-icon"></i>
            </a>
            <h3 class="card-title">Facturas</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Registro</th>
                        <th>Cliente</th>
                        <th>Habitación</th>
                        <th>Método Pago</th>
                        <th>Fecha</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoices as $inv)
                        <tr>
                            <td>{{ $inv->id }}</td>
                            <td>#{{ $inv->registration_id }}</td>
                            <td>{{ optional($inv->registration->client)->name }}</td>
                            <td>{{ optional($inv->registration->room)->number }}</td>
                            <td>{{ optional($inv->paymentMethod)->name }}</td>
                            <td>{{ optional($inv->date)->format('Y-m-d') }}</td>
                            <td>{{ number_format($inv->total, 2) }}</td>
                            <td>
                                <span class="badge badge-{{ $inv->state ? 'success' : 'secondary' }}">
                                    {{ $inv->state ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('invoices.edit', $inv) }}" class="btn btn-info btn-sm" title="Editar">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <form class="d-inline" action="{{ route('invoices.destroy', $inv) }}" method="POST"
                                      onsubmit="return confirm('¿Eliminar factura?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection