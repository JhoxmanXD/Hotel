@extends('layouts.app')

@section('content')

    <div class="card mt-2">
        <div class="card-header">
            <a href="{{ route('rooms.create') }}" class="btn btn-primary float-right" title="Nuevo">
                <i class="fas fa-plus nav-icon"></i>
            </a>
            <h3 class="card-title">Habitaciones</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>Número</th>
                        <th>Tipo</th>
                        <th>Piso</th>
                        <th>Tarifa</th>
                        <th>Capacidad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rooms as $room)
                        <tr>
                            <td>{{ $room->number }}</td>
                            <td>{{ optional($room->roomType)->name }}</td>
                            <td>{{ $room->floor }}</td>
                            <td>{{ number_format($room->value, 2) }}</td>
                            <td>{{ $room->numpeople }}</td>
                            <td>
                                <a href="{{ route('rooms.edit', $room) }}" class="btn btn-info btn-sm" title="Editar">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <form class="d-inline" action="{{ route('rooms.destroy', $room) }}" method="POST"
                                      onsubmit="return confirm('¿Eliminar habitación?');">
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