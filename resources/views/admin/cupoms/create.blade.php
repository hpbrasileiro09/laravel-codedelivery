@extends('app')
@section('content')
<div class="container">
	<h3>Novo cupom</h3>
	@include('errors._check')
	{!! Form::open(['route' => 'admin.cupoms.store']) !!}
	@include('admin.cupoms._form')
	<div class="form-group">
		{!! Form::submit('Criar cupom',['class' => 'btn btn-primary']) !!}
		&nbsp;<a href="{{ URL::previous() }}"><button type="button" class="btn btn-primary">Voltar</button></a>
	</div>
	{!! Form::close() !!}
</div>
@endsection