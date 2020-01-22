@extends('layouts.app')

@section('content')
    <div class="container col-md-8" xmlns:v-on="http://www.w3.org/1999/xhtml">
        @if($message = Session::get('success'))
            <div class="alert alert-success alert-dismissible fade show" id="alert">
                <p><b>{{ $message }}</b></p>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="table-responsive-md table-responsive-sm py-3">
            <table class="table table-hover table-borderless">
                <thead class="bg-dark text-white">
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Tipo</th>
                    <th>Creado</th>
                    <th>Opciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <th>{{ $user->id }}</th>
                        <th>{{ $user->name }}</th>
                        <th>{{ $user->email }}</th>
                        <th><span class="badge badge-warning">{{ $user->type }}</span></th>
                        <th>{{ $user->created_at }}</th>
                        <th class="d-flex justify-content-center">
                            <div class="dropdown">
                                <button class="btn btn-sm rounded-circle" type="button" id="dropdownOptions" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-ellipsis-v"></i>
                                    <div class="dropdown-menu" aria-labelledby="dropdownOptions">
                                        <a class="dropdown-item"><i class="fas fa-edit" @click="modal('edit')"></i> Editar</a>
                                        <a class="dropdown-item" @click="modal('delete','{{$user->id}}');">
                                            <i class="fas fa-trash-alt"></i> Eliminar
                                        </a>
                                    </div>
                                </button>
                            </div>
                        </th>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <!-- Modal Eliminar -->
            <div class="modal fade"  id="modaleliminar" tabindex="-1" role="dialog" aria-labelledby="modalEliminar" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="container d-flex justify-content-center py-3">
                                <p class="font-weight-bold">¿Desea eliminar el registro seleccionado?</p>
                            </div>
                            <div class="container py-2 d-flex justify-content-end">
                                <button type="submit"  class="btn btn-sm btn-danger mr-3" v-on:click="eliminar();">Eliminar</button>
                                <button class="btn btn-sm btn-primary mr-3" v-on:click="cerrarModal('delete');">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-center">
            {{ $users->links() }}
        </div>
    </div>

@endsection
