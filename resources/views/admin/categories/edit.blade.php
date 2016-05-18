@extends('app')
@section('content')
<div class="container">
	<h3>Editando categoria: {{ $category->name }}</h3>
	@include('errors._check')
	{!! Form::model( $category, ['route' => ['admin.categories.update', $category->id]]) !!}
	@include('admin.categories._form')
	<div class="form-group">
		{!! Form::submit('Salvar categoria',['class' => 'btn btn-primary']) !!}
		&nbsp;<a href="{{ URL::previous() }}"><button type="button" class="btn btn-primary">Voltar</button></a>
	</div>
	{!! Form::close() !!}
</div>
@endsection