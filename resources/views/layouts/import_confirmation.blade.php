@extends('layouts.app')

@section('content')
	<div class="row">
		<div class="page-header">
			<h3>Importação de Arquivo <small>Confirmação</small></h3>
		</div>

		<form class="form-inline" action="{{route('import.store')}}" method="post">
			{{csrf_field()}}

		<table class="table table-striped">
			<thead>
			<tr>
				<th>#</th>
				<th>Data</th>
				<th>Descrição</th>
				<th>Valor</th>
				<th>Categoria</th>
			</tr>
			</thead>
			<tbody>
			@forelse($improvedTransactions as $improvedTransaction)
				<input type="hidden" name="transaction[{{$improvedTransaction->uniqueId}}]" value="{{json_encode($improvedTransaction)}}">
				<tr>
					<td><input type="checkbox" {{($improvedTransaction->existent_transaction)?'':'checked'}} name="import[]" value="{{$improvedTransaction->uniqueId}}"></td>
					<td>{{$improvedTransaction->date->format('d/m/Y')}}</td>

					@if($improvedTransaction->existent_transaction)
						<td class="warning"><span class="glyphicon glyphicon-pushpin" data-toggle="tooltip" title="Transação Existente"></span> {{$improvedTransaction->description}}</td>
					@else
						<td>{{$improvedTransaction->description}}</td>
					@endif

					<td class="{{($improvedTransaction->type == 'credit')?'text-green success':'text-red danger'}}">{{Number::formatCurrency($improvedTransaction->value)}}</td>
					<td>
						@if(is_null($improvedTransaction->category_id))
							<select name="category[{{$improvedTransaction->uniqueId}}]" class="form-control combo_category">
								<option value="invalid_option">Selecione</option>
								@foreach($categories as $categoryId => $categoryName)
									<option {{($categoryId == 0)?'selected':''}} value="{{$categoryId}}">{{$categoryName}}</option>
								@endforeach
							</select>&nbsp;
							<span data-toggle="modal" data-target="#modalNewCategory">
								<span class="glyphicon glyphicon-plus cursor-pointer" data-toggle="tooltip" title="Nova Categoria">
								</span>
							</span>
						@else
							{{$improvedTransaction->category_name}}
						@endif
					</td>
				</tr>
			@empty
				<tr>
					<td colspan="4">Nenhuma transação importada.</td>
				</tr>
			@endforelse
			</tbody>
			<tfoot>
			<tr>
				<td colspan="5">
					<input class="btn btn-success" type="submit" name="save" value="Salvar">
				</td>
			</tr>
			</tfoot>
		</table>
		</form>
	</div>

	<!-- Modal New Category -->
	<div class="modal fade" id="modalNewCategory" tabindex="-1" role="dialog" aria-labelledby="modalNewCategoryLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Nova Categoria</h4>
				</div>
				<div class="modal-body">
					<div id="divMessage"></div>
					<div class="form-group">
						<label for="category">Name da Categoria</label>
						<input type="text" class="form-control" id="category" name="category" placeholder="Categoria">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-success" id="save">Salvar</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
				</div>
			</div>
		</div>
	</div>
@endsection
@section('js')

	<script type="text/javascript" src="{{asset('js/bootstrap/modal.js')}}"></script>
	<script type="text/javascript">
		$(function(){
			//Modal for New Category
			$('#modalNewCategory').on('show.bs.modal', function (event) {
				$('#save').removeAttr('disabled');
				$('#divMessage').html('').removeAttr('class');
				$('#category').val('');
			}).modal({'backdrop': 'static', 'show': false});

			$('#save').click(function(){
				var url_save = '{{route('category.store')}}';
				$.ajax({
					url: url_save,
					method: 'POST',
					data: {
						category: $('#category').val(),
						_token: '{{csrf_token()}}'
					},
					dataType: 'json',
					beforeSend: function () {
						$('#save').attr('disabled', 'disabled');
					},
					success: function (dataReturn) {
						var classAlert = 'alert alert-success';
						if (dataReturn.success == true) {
							$.each($('.combo_category'), function(){
								$(this).append($('<option>', {
									value: dataReturn.category_id,
									text: dataReturn.category_name
								}));
							});
						} else {
							$('#save').removeAttr('disabled');
							classAlert = 'alert alert-info';
						}

						$('#divMessage').attr('class', classAlert).html(dataReturn.message);
					},
					statusCode: {
						422: function(dataError) {
							var errors = dataError.responseJSON;
							$('#divMessage').attr('class', 'alert alert-danger').html(errors.category[0]);
							$('#save').removeAttr('disabled');
						}
					}
				});

			});
		});
	</script>
@endsection