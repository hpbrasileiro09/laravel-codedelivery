@extends('app')
@section('content')
<div class="container">
	<h3>Cupons</h3>
	<a href="{{ route("admin.cupoms.create") }}" class="btn btn-default">Novo cupom</a>
	<br /><br />
	<table class="table table-bordered">
		<thead>
			<tr>
				<td>ID</td>
				<td>Código</td>
				<td>Valor</td>
				<td>A&ccedil;&atilde;o</td>
			</tr>
		</thead>
		<tbody>
			@foreach ($cupoms as $cupom)
			<tr>
				<td>{{$cupom->id}}</td>
				<td>{{$cupom->code}}</td>
				<td>{{$cupom->value}}</td>
				<td>
					<a href="{{route('admin.cupoms.edit',['id' => $cupom->id])}}" class="btn btn-default btn-sm">Editar</a>
					<a href="{{route('admin.cupoms.delete',['id' => $cupom->id])}}" class="btn btn-default btn-sm">Remover</a>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	{!! $cupoms->render() !!}
</div>
@endsection