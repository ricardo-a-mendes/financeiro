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
				<!-- TODO: Add checkbox to select/deselect all -->
				<th>#</th>
				<th>Data</th>
				<th>Descrição</th>
				<th>Valor</th>
				<th>Categoria</th>
			</tr>
			</thead>
			<tbody>
			@forelse($enhancedTransactions as $enhancedTransaction)
				<input type="hidden" name="transaction[{{$enhancedTransaction->uniqueId}}]" value="{{json_encode($enhancedTransaction)}}">
				<tr>
					<td><input type="checkbox" {{($enhancedTransaction->existent_transaction)?'':'checked'}} name="import[]" value="{{$enhancedTransaction->uniqueId}}"></td>
					<td>{{$enhancedTransaction->date->format('d/m/Y')}}</td>

					@if($enhancedTransaction->existent_transaction)
						<td class="warning"><span class="glyphicon glyphicon-pushpin" data-toggle="tooltip" title="Transação Existente"></span> {{$enhancedTransaction->description}}</td>
					@else
						<td>{{$enhancedTransaction->description}}</td>
					@endif

					<td class="{{($enhancedTransaction->type == 'credit')?'text-green success':'text-red danger'}}">{{Number::formatCurrency($enhancedTransaction->value)}}</td>
					<td>
						@if(is_null($enhancedTransaction->category_id) || $enhancedTransaction->category_id == 0)
							<select name="category[{{$enhancedTransaction->uniqueId}}]" class="form-control combo_category">
								<option value="invalid_option">{{trans('app.labels.select')}}</option>
								@foreach($categories as $categoryId => $categoryName)
									<option {{($categoryId == 0)?'selected':''}} value="{{$categoryId}}">{{$categoryName}}</option>
								@endforeach
							</select>&nbsp;
							<span data-toggle="modal" data-target="#modalNewCategory">
								<span class="glyphicon glyphicon-plus cursor-pointer" data-toggle="tooltip" title="Nova Categoria">
								</span>
							</span>
						@else
							{{$enhancedTransaction->category_name}}
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
					@if (count($enhancedTransactions))
						<input class="btn btn-success" type="submit" name="save" value="Salvar">
						<a href="{{route('statement')}}" class="btn btn-danger">Cancelar</a>
					@else
						<a href="{{route('statement')}}" class="btn btn-danger">Voltar</a>
					@endif
				</td>
			</tr>
			</tfoot>
		</table>
		</form>
	</div>

	@include('layouts.modal_new_category')
@endsection
