@extends('app')
@section('content')
<div class="container">
	<h3>Pedidos</h3>
	<table class="table table-bordered">
		<thead>
			<tr>
				<td>ID</td>
				<td>Cliente</td>
				<td>Total</td>
				<td>Dt.Cria&ccedil;&atilde;o</td>
				<td>Itens</td>
				<td>Entregador</td>
				<td>Status</td>
				<td>A&ccedil;&atilde;o</td>
			</tr>
		</thead>
		<tbody>
			@foreach ($orders as $order)
			<tr>
				<td>{{$order->id}}</td>
				<td>{{$order->client->user->name}}</td>
				<td>{{$order->total}}</td>
				<td>{{$order->created_at}}</td>
				<td>
					@foreach($order->items as $item)
						<li>{{ $item->product->name }}</li>
					@endforeach
				</td>
				<td>
					@if ($order->deliveryman)
						{{$order->deliveryman->name}}
					@else
						--
					@endif
				</td>
				<td>{{$order->status}}</td>
				<td>
					<a href="{{route('admin.orders.edit',['id' => $order->id])}}" class="btn btn-default btn-sm">Editar</a>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	{!! $orders->render() !!}
</div>
@endsection