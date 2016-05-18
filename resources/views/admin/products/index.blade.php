@extends('app')
@section('content')
<div class="container">
	<h3>Produtos</h3>
	<a href="{{ route("admin.products.create") }}" class="btn btn-default">Novo produto</a>
	<br /><br />
	<table class="table table-bordered">
		<thead>
			<tr>
				<td>ID</td>
				<td>Nome</td>
				<td>Categoria</td>
				<td>Pre&ccedil;o</td>
				<td>A&ccedil;&atilde;o</td>
			</tr>
		</thead>
		<tbody>
			@foreach ($products as $product)
			<tr>
				<td>{{$product->id}}</td>
				<td>{{$product->name}}</td>
				<td>{{$product->category->name}}</td>
				<td>{{$product->price}}</td>
				<td>
					<a href="{{route('admin.products.edit',['id' => $product->id])}}" class="btn btn-default btn-sm">Editar</a>
					<a href="{{route('admin.products.delete',['id' => $product->id])}}" class="btn btn-default btn-sm">Remover</a>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	{!! $products->render() !!}
</div>
@endsection