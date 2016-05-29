	<div class="form-group">
		{!! Form::label('Produto', 'Produto:') !!}
		{!! Form::select('product_id', $products, null, ['class' => 'form-control']) !!}
	</div>