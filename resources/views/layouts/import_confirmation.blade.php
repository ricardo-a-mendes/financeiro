@extends('layouts.app')

@section('content')
	<div class="row">
		<div class="page-header">
			<h3>Importação de Arquivo <small>Confirmação</small></h3>
		</div>

		<form action="{{route('import.store')}}" method="post">
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
							<select name="category[{{$improvedTransaction->uniqueId}}]" class="form-control">
								<option value="invalid_option">Selecione</option>
								@foreach($categories as $categoryId => $categoryName)
									<option {{($categoryId == 0)?'selected':''}} value="{{$categoryId}}">{{$categoryName}}</option>
								@endforeach
							</select>
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
@endsection