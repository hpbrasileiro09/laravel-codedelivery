@extends('app')
@section('content')

<script src="http://192.168.56.142/laravel-codedelivery/public/js/codedelivery.js"></script>

<div class="container">
	<h3>Novo pedido</h3>
	@include('errors._check')
	{!! Form::open(['route' => 'admin.orders.store','id' => 'forder']) !!}

	@include('admin.orders._form')

	<!-- Trigger the modal with a button -->
	<button type="button" class="btn btn-default btn_add" id="btn_add">Novo item</button>
	<br /><br />

	<table id="tb_items" class="table table-striped table-bordered table-hover">
		<tfoot>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td><span id="sgeral">0.00</span><input type="hidden" id="geral" name="geral" value="0.0" /></td>
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
	</table>

	<input type="hidden" id="_icont" name="_icont" value="{{$icont}}" />

	<input type="hidden" id="destroy" name="destroy" />

	<div class="form-group">
		{!! Form::submit('Criar pedido',['class' => 'btn btn-primary']) !!}
	</div>
	{!! Form::close() !!}

	@include('admin.orders._modal')

</div>
@endsection