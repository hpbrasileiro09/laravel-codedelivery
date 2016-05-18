	<!-- Modal -->
	<div class="modal fade" id="myModal" role="dialog">
		<div class="modal-dialog">
		  <!-- Modal content-->
		  <div class="modal-content">
		    <div class="modal-header">
		      <button type="button" class="close" id="btn_close">&times;</button>
		      <h4 class="modal-title">Novo item</h4>
		    </div>
		    <div class="modal-body">
		      	<div class="form-group">
					<label for="Product">Produto:</label>
					<select class="form-control" name="product_id" id="product_id">
						@foreach ($products as $product)
						<option value="{{$product->id}}">{{$product->name}}&nbsp;-&nbsp;R$&nbsp;{{$product->price}}</option>
						@endforeach						
					</select>
				</div>	
		      	<div class="form-group">
					<label for="Status">Quantidade:</label>
					<input class="form-control" name="quantity" id="quantity" value="1" type="number">					      		
				</div>	
		    </div>
		    <div class="modal-footer">
		      <input type="hidden" name="count" id="count" value="0" />
		      <input type="hidden" name="item" id="item" value="0" />
		      <input type="hidden" name="action" id="action" value="add" />
		      <button id="btn_new_item" type="button" class="btn btn-default" data-dismiss="modal">Salvar</button>
		    </div>
		  </div>
		</div>
	</div>