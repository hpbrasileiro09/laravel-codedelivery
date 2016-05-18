@extends('app')
@section('content')
<div class="container">
	<h3>Clientes</h3>
	<a href="{{ route("admin.clients.create") }}" class="btn btn-default">Novo cliente</a>
	<br /><br />
	<table class="table table-bordered">
		<thead>
			<tr>
				<td>ID</td>
				<td>Nome</td>
				<td>Cidade</td>
				<td>Estado</td>
				<td>Cep</td>
				<td>A&ccedil;&atilde;o</td>
			</tr>
		</thead>
		<tbody>
			@foreach ($clients as $client)
			<tr>
				<td>{{$client->id}}</td>
				<td>{{$client->user->name}}</td>
				<td>{{$client->city}}</td>
				<td>{{$client->state}}</td>
				<td>{{$client->zipcode}}</td>
				<td>
					<a href="{{route('admin.clients.edit',['id' => $client->id])}}" class="btn btn-default btn-sm">Editar</a>
					<a href="{{route('admin.clients.delete',['id' => $client->id])}}" class="btn btn-default btn-sm">Remover</a>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	{!! $clients->render() !!}
</div>
@endsection