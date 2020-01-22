@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-primary">
                <div class="card-header bg-primary text-white">{{ __('Inicio de Sesión') }}</div>

                <div class="card-body">
                    <login></login>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
