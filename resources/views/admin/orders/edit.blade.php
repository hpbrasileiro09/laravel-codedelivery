@extends('app')
@section('content')

<script type="text/javascript">
	var _url_base = "{{$url->to('/')}}";
</script>

<script src="{{$url->to('/')}}/js/codedelivery.js"></script>

<div class="container">
	<h3>Editando pedido: {{ $order->id }}</h3>
	@include('errors._check')
	{!! Form::model( $order, ['route' => ['admin.orders.update', $order->id], 'id' => 'forder']) !!}

	@include('admin.orders._form')

	<div class="form-group">
		{!! Form::label('Deliveryman', 'Entregador:') !!}
		{!! Form::select('user_deliveryman_id', $deliveryman, null, ['class' => 'form-control']) !!}
	</div>

	<!-- Trigger the modal with a button -->
	<button type="button" class="btn btn-default btn_add" id="btn_add">Novo item</button>
	<br /><br />

	<table id="tb_items" class="table table-striped table-bordered table-hover">
		<?php $total = 0; ?>
		@foreach($order->items as $item)
			<?php $total += ($item->qtd * $item->price); ?>
		@endforeach
		<tfoot>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>
				<span id="sgeral">{{number_format($total, 2, '.', '.')}}</span>
				<input type="hidden" id="geral" name="geral" value="{{ $total }}" />
				</td>
				<td>&nbsp;</td>
			</tr>
		</tfoot>
		<thead>
			<tr>
				<td>ID</td>
				<td>Nome</td>
				<td>Quantidade</td>
				<td>Pre&ccedil;o</td>
				<td>Total</td>
				<td>A&ccedil;&atilde;o</td>
			</tr>
		</thead>
		<tbody>
		@foreach($order->items as $item)
			<?php $icont++; ?>
			<tr>
				<td><span id="item_product_id_{{$icont}}">{{$item->id}}</span></td>
				<td><span id="item_product_name_{{$icont}}">{{$item->product->name}}</span></td>
				<td><span id="item_quantity_{{$icont}}">{{$item->qtd}}</span></td>
				<td><span id="item_product_price_{{$icont}}">{{$item->price}}</span></td>
				<td><span id="item_total_{{$icont}}">{{number_format($item->qtd * $item->price, 2, '.', '.')}}</span></td>
				<td>
				<button type="button" class="btn btn-default btn-sm btn_remove" id="btn_remove_{{$icont}}">Remover</button>&nbsp;
				<button type="button" class="btn btn-default btn-sm btn_edit" id="{{$icont}}">Editar</button>
				<input type="hidden" name="item_{{$icont}}" id="item_{{$icont}}" value="{{$item->id}}"/>
				<input type="hidden" name="count_{{$icont}}" id="count_{{$icont}}" value="{{$icont}}"/>
				<input type="hidden" name="product_id_{{$icont}}" id="product_id_{{$icont}}" value="{{$item->product_id}}"/>
				<input type="hidden" name="quantity_{{$icont}}" id="quantity_{{$icont}}" value="{{$item->qtd}}"/>
				<input type="hidden" name="price_{{$icont}}" id="price_{{$icont}}" value="{{$item->product->price}}"/>
				<input type="hidden" name="total_{{$icont}}" id="total_{{$icont}}" value="{{$item->qtd * $item->product->price}}"/>
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>

	<input type="hidden" id="_icont" name="_icont" value="{{$icont}}" />

	<input type="hidden" id="destroy" name="destroy" />

	<div class="form-group">
		{!! Form::submit('Salvar pedido',['class' => 'btn btn-primary']) !!}
		&nbsp;<a href="{{ URL::previous() }}"><button type="button" class="btn btn-primary">Voltar</button></a>
	</div>
	{!! Form::close() !!}

	@include('admin.orders._modal')

</div>
@endsection