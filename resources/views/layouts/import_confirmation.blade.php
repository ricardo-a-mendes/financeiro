@extends('layouts.app')

@section('content')
	<div class="row">
		<div class="page-header">
			<h3>Importação de Arquivo <small>Confirmação</small></h3>
		</div>


		<table class="table table-striped">
			<thead>
			<tr>
				<th>ID</th>
				<th>Data</th>
				<th>Descrição</th>
				<th>Valor</th>
				<th>Categoria</th>
			</tr>
			</thead>
			<tbody>
			@forelse($improvedTransactions as $improvedTransaction)
				<tr>
					<td>{{$improvedTransaction->uniqueId}}</td>
					<td>{{$improvedTransaction->date->format('d/m/Y')}}</td>
					<td>{{$improvedTransaction->description}}</td>
					<td>{{Number::formatCurrency($improvedTransaction->value)}}</td>
					<td>
						@if(is_null($improvedTransaction->category_id))
							<select name="category[{{$improvedTransaction->uniqueId}}]" class="form-control">
								<option value="invalid_option">Selecione</option>
								@foreach($categories as $categoryId => $categoryName)
									<option value="{{$categoryId}}">{{$categoryName}}</option>
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
		</table>

	</div>
@endsection