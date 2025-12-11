@extends('layouts.app')

@section('content')

    <div class="card mt-2">
        <div class="card-header">
            <a href="{{ route('registrations.create') }}" class="btn btn-primary float-right" title="Nuevo">
                <i class="fas fa-plus nav-icon"></i>
            </a>
            <h3 class="card-title">Registros de Hospedaje</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Habitación</th>
                        <th>Empleado</th>
                        <th>Entrada</th>
                        <th>Salida</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($registrations as $reg)
                        <tr>
                            <td>{{ $reg->id }}</td>
                            <td>{{ optional($reg->client)->name }}</td>
                            <td>
                                {{ optional($reg->room)->number }}
                                @if(optional($reg->room->roomType ?? null)->name)
                                    - {{ $reg->room->roomType->name }}
                                @endif
                            </td>
                            <td>{{ optional($reg->employee)->name }}</td>
                            <td>
                                {{-- CORREGIDO: checkindate (sin guion) --}}
                                {{ \Carbon\Carbon::parse($reg->checkindate)->format('Y-m-d') }}
                                {{ $reg->checkintime }}
                            </td>
                            <td>
                                {{-- LÓGICA DE SALIDA --}}
                                {{-- CORREGIDO: checkoutdate (sin guion) --}}
                                @if($reg->checkoutdate)
                                    {{ \Carbon\Carbon::parse($reg->checkoutdate)->format('Y-m-d') }}
                                    {{ $reg->checkouttime }}
                                @else
                                    <span class="badge badge-warning">En curso</span>
                                @endif
                            </td>
                            <td>
                                {{-- 1. BOTÓN DE CHECKOUT (Solo si no tiene fecha de salida) --}}
                                {{-- CORREGIDO: checkoutdate (sin guion) --}}
                                @if(!$reg->checkoutdate)
                                    <form action="{{ route('registrations.checkout', $reg->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-warning btn-sm" title="Finalizar Estancia / Checkout" onclick="return confirm('¿Confirmar salida del cliente? Se calculará el precio final.')">
                                            <i class="fas fa-sign-out-alt"></i>
                                        </button>
                                    </form>
                                @endif

                                {{-- 2. BOTÓN DE EDITAR --}}
                                <a href="{{ route('registrations.edit', $reg) }}" class="btn btn-info btn-sm" title="Editar">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>

                                {{-- 3. BOTÓN DE ELIMINAR --}}
                                <form class="d-inline" action="{{ route('registrations.destroy', $reg) }}" method="POST"
                                      onsubmit="return confirm('¿Eliminar registro?');">
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
