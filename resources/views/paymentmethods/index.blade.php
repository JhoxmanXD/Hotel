@extends('layouts.app')

@section('content')

    <div class="card mt-2">
        <div class="card-header">
            <a href="{{ route('paymentmethods.create') }}" class="btn btn-primary float-right" title="Nuevo">
                <i class="fas fa-plus nav-icon"></i>
            </a>
            <h3 class="card-title">Método De Pago</h3>
        </div>
        <!-- /.card-TABLE-->
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th>name</th>
                        <th>description</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($paymentmethods as $paymentmethod)
                        <tr>
                            <td>{{ $paymentmethod->name }}</td>
                            <td>{{ $paymentmethod->description }}</td>
                            <td>
                                @can('paymentmethods.edit')
                                    <a href="{{ route('paymentmethods.edit', $paymentmethod->id) }}"
                                       class="btn btn-info btn-sm" title="Editar">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                @endcan
                                @can('paymentmethods.destroy')
                                    <form class="d-inline delete-form"
                                          action="{{ route('paymentmethods.destroy', $paymentmethod) }}"
                                          method="POST"
                                          onsubmit="return confirm('¿Eliminar método de pago?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-TABLE -->
    </div>

@endsection