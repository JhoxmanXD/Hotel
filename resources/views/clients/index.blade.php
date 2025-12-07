@extends('layouts.app')

@section('content')

<div class="card mt-2">
    <div class="card-header">
        <a href="{{ route('clients.create') }}" class="btn btn-primary float-right" title="Nuevo"><i class="fas fa-plus nav-icon"></i></a>
    <h3 class="card-title">clientes</h3>
    </div>
    <!-- /.card-TABLE-->
    <div class="card-body">
    <table id="example1" class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>name</th>
                <th>documentNumber</th>
                <th>address</th>
                <th>phone</th>
                <th>email</th>
                <th>state</th>
                <th>registeredBy</th>
            </tr>
        </thead>
        <tbody>
        
        @foreach($clients as $client)
        <tr>
            <td>{{$client->id}}</td>
            <td>{{$client->name}}</td>
            <td>{{$client->documentNumber}}</td>
            <td>{{$client->address}}</td>
            <td>{{$client->phone}}</td>
            <td>{{$client->email}}</td>
            <td>
            <input data-type="client" data-id="{{$client->id}}" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" 
            data-toggle="toggle" data-on="Activo" data-off="Inactivo" {{ $client->estado ? 'checked':'' }}>
            </td>
            <td>{{$client->registeredBy}}</td>
            <td>
                <form class="d-inline delete-form" action="{{ route('clients.destroy', $client) }}"  method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" title="Eliminar"><i class="fas fa-trash-alt"></i></button>
                </form>
            </td>
        </tr>
        @endforeach
        </tbody>
        
    </table>
    </div>
    <!-- /.card-TABLE -->
</div>

@endsection
