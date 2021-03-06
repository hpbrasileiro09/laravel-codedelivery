@extends('app')
@section('content')
<div class="container">
	<h3>Editando cliente: {{ $client->name }}</h3>
	@include('errors._check')
	{!! Form::model( $client, ['route' => ['admin.clients.update', $client->id]]) !!}
	@include('admin.clients._form')
	<div class="form-group">
		{!! Form::submit('Salvar cliente',['class' => 'btn btn-primary']) !!}
		&nbsp;<a href="{{ URL::previous() }}"><button type="button" class="btn btn-primary">Voltar</button></a>
	</div>
	{!! Form::close() !!}
</div>
@endsection