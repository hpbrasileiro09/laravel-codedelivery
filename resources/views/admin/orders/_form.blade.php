	<div class="form-group">
		{!! Form::label('Client', 'Cliente:') !!}
		{!! Form::select('client_id', $clients, null, ['class' => 'form-control']) !!}
	</div>
	<div class="form-group">
		{!! Form::label('Status', 'Status:') !!}
		{!! Form::select('status', $status, null, ['class' => 'form-control']) !!}
	</div>
	{!! Form::hidden('total', null, ['class' => 'form-control', 'id' => 'total']) !!}
