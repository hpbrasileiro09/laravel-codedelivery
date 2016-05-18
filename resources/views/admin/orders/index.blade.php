@extends('app')
@section('content')
<div class="container">
	<h3>Pedidos</h3>
	<a href="{{ route("admin.orders.create") }}" class="btn btn-default">Novo pedido</a>
	<br /><br />
	<table class="table table-bordered">
		<thead>
			<tr>
				<td>ID</td>
				<td>Cliente</td>
				<td>Total</td>
				<td>Dt.Cria&ccedil;&atilde;o</td>
				<td>Status</td>
				<td>A&ccedil;&atilde;o</td>
			</tr>
		</thead>
		<tbody>
			@foreach ($orders as $order)
			<tr>
				<td>{{$order->id}}</td>
				<td>{{$order->nm_client}}</td>
				<td>{{$order->total}}</td>
				<td>{{$order->created_at_br}}</td>
				<td>{{$order->ds_status}}</td>
				<td>
					<a href="{{route('admin.orders.edit',['id' => $order->id])}}" class="btn btn-default btn-sm">Editar</a>
					<a href="{{route('admin.orders.delete',['id' => $order->id])}}" class="btn btn-default btn-sm">Remover</a>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	{!! $orders->render() !!}
</div>
@endsection