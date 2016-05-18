@extends('app')
@section('content')
<div class="container">
	<h3>Nova categoria</h3>
	@include('errors._check')
	{!! Form::open(['route' => 'admin.categories.store']) !!}
	@include('admin.categories._form')
	<div class="form-group">
		{!! Form::submit('Criar categoria',['class' => 'btn btn-primary']) !!}
		&nbsp;<a href="{{ URL::previous() }}"><button type="button" class="btn btn-primary">Voltar</button></a>
	</div>
	{!! Form::close() !!}
</div>
@endsection