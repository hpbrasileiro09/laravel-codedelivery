$(document).ready(function() {

	var _icont = 0;

	var contador = function() {
	  return _icont += 1;
	}

	var inicia = function() {
		_icont = parseInt($('#_icont').val());
		return _icont;
	}

	inicia(); // Inicializa Contador

	var roundTo2Decimals = function(numberToRound) {
		var _resp = Math.round(numberToRound * 100) / 100;
		return _resp;
	}

	var round2Fixed = function(value) {
	  value = +value;
	  if (isNaN(value))
	    return NaN;
	  value = value.toString().split('e');
	  value = Math.round(+(value[0] + 'e' + (value[1] ? (+value[1] + 2) : 2)));
	  value = value.toString().split('e');
	  return (+(value[0] + 'e' + (value[1] ? (+value[1] - 2) : -2))).toFixed(2);
	}

	var padDigits = function(number, digits) {
	    return Array(Math.max(digits - String(number).length + 1, 0)).join(0) + number;
	}

	var trataValor = function(_valor) {
		var _local = round2Fixed(_valor);
		if (typeof _local !== 'string') {
			return String(_local);
		}
		return _local.replace(',','.');
	}

	var getRootUrl = function() {
	  var defaultPorts = {"http:":80,"https:":443};
	  return window.location.protocol + "//" + window.location.hostname
	   + (((window.location.port)
	    && (window.location.port != defaultPorts[window.location.protocol]))
	    ? (":"+window.location.port) : "");
	}

	var trataGeral = function(_total) {
		var _geral = parseFloat($('#geral').val());
		console.log('0_total='+_total);
		console.log('0_geral='+_geral);
		console.log('0_calc='+(_geral + _total));
		$('#geral').val(_geral + _total); 
		$('#sgeral').text(trataValor(_geral + _total)); 
	};

	var removeGeral = function(_total) {
		var _geral = parseFloat($('#geral').val());
		console.log('1_total='+_total);
		console.log('1_geral='+_geral);
		console.log('1_calc='+(_geral - _total));
		$('#geral').val(_geral - _total); 
		$('#sgeral').text(trataValor(_geral - _total)); 
	};

	var add_item = function(
		_item_id,
		_product_id, 
		_product_name, 
		_item_quantity, 
		_product_price, 
		_item_total
	) {

	  var _acao = '';
	  var _html = '';
	  var _hidden = '';
	  var _icont = contador();

	  _acao += '<button type="button" class="btn btn-default btn-sm btn_remove" id="btn_remove_'+_icont+'">Remover</button>';
	  _acao += '&nbsp;';
	  _acao += '<button type="button" class="btn btn-default btn-sm btn_edit" id="'+_icont+'">Editar</button>';

	  _hidden += '<input type="hidden" name="item_'+_icont+'" id="item_'+_icont+'" value="'+_item_id+'"/>';
	  _hidden += '<input type="hidden" name="count_'+_icont+'" id="count_'+_icont+'" value="'+_icont+'"/>';
	  _hidden += '<input type="hidden" name="product_id_'+_icont+'" id="product_id_'+_icont+'" value="'+_product_id+'"/>';
	  _hidden += '<input type="hidden" name="quantity_'+_icont+'" id="quantity_'+_icont+'" value="'+_item_quantity+'"/>';
	  _hidden += '<input type="hidden" name="price_'+_icont+'" id="price_'+_icont+'" value="'+_product_price+'"/>';
	  _hidden += '<input type="hidden" name="total_'+_icont+'" id="total_'+_icont+'" value="'+_item_total+'"/>';

	  var _price = round2Fixed(_product_price);
	  var _total = round2Fixed(_item_total);

	  _html += '<tr id="tr_item_'+_icont+'">';
	  _html += '<td><span id="item_product_id_'+_icont+'">'+_product_id+'</span></td>';
	  _html += '<td><span id="item_product_name_'+_icont+'">'+_product_name+'</span></td>';
	  _html += '<td><span id="item_quantity_'+_icont+'">'+_item_quantity+'</span></td>';
	  _html += '<td><span id="item_product_price_'+_icont+'">'+_price.replace(',','.')+'</span></td>';
	  _html += '<td><span id="item_total_'+_icont+'">'+_total.replace(',','.')+'</span></td>';
	  _html += '<td>'+_acao+_hidden+'</td>';
	  _html += '</tr>';

	  $('#_icont').val(_icont);

	  $('#tb_items tr:last').after(_html);

	  trataGeral(_item_quantity * _product_price);

	}

	$('#myModal').bind('hidden.bs.modal', function () {
		if ($('#action').val() == 'add') {
			$.getJSON( getRootUrl() + '/laravel-codedelivery/public/admin/products/json/' + $('#product_id').val(), function( data ) {
				var _quantity = $('#quantity').val(); 
				if (_quantity <= 0) _quantity = 1;
				var total = _quantity * data.price;
				add_item(0,$('#product_id').val(),data.name, $('#quantity').val(), data.price, total);
			});
		}
		if ($('#action').val() == 'edit') {
			$.getJSON( getRootUrl() + '/laravel-codedelivery/public/admin/products/json/' + $('#product_id').val(), function( data ) {
				var _icont = parseInt($('#count').val());
				$('#product_id_'+_icont).val($('#product_id').val());
				$('#quantity_'+_icont).val($('#quantity').val());
				var _quantity = $('#quantity').val(); 
				if (_quantity <= 0) _quantity = 1;
				var total = parseInt(_quantity) * parseFloat(data.price);
				var _price = round2Fixed(data.price);
				var _total = round2Fixed(total);
				$('#item_product_id_'+_icont).text($('#product_id').val());
				$('#item_product_name_'+_icont).text(data.name);
				$('#item_quantity_'+_icont).text($('#quantity').val());
				$('#item_product_price_'+_icont).text(_price.replace(',','.'));
				$('#item_total_'+_icont).text(_total.replace(',','.'));
				var antes = parseFloat($('#total_'+_icont).val());
				console.log('antes='+antes);
				removeGeral(antes);
				$('#total_'+_icont).val(total);
				console.log('total='+total);
				trataGeral(total);
			});
		}
	});

	$(document).on( 'click', '.btn_remove', function() {
		var _ponteiro = $(this).attr('id');
		var _icont = _ponteiro.split('_')[2];
	  	var _item = $('#item_'+_icont).val();
	  	var _quantity = $('#quantity_'+_icont).val();
	  	var _price = $('#price_'+_icont).val();
		$(this).parents("tr").remove();
		var _virgula = '|';
		var _destroy = $('#destroy').val();
		if (_destroy.length <= 0) _virgula = '';
		$('#destroy').val(_destroy + _virgula + _item);
		removeGeral(_quantity * _price);
	});

	$(document).on( 'click', '.btn_edit', function() {
		var _icont = $(this).attr('id');
		$('#count').val($('#count_'+_icont).val());
		$('#product_id').val($('#product_id_'+_icont).val());
		$('#quantity').val($('#quantity_'+_icont).val());
		$('#item').val($('#item_'+_icont).val());
		$('#action').val('edit');
		$('#myModal').modal({show:true});
	});

	$(document).on( 'click', '.btn_add', function() {
		$('#count').val(0);
		$('#quantity').val(1);
		$('#item').val(0);
		$('#action').val('add');
		$('#myModal').modal({show:true});
	});

	$('#btn_close').click( function() {
		$('#action').val('close');
		$('#myModal').modal('hide');
	});

});