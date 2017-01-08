@extends('layouts.app')

@section('content')

	<form method="post" action="{{$route}}">
		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label for="exampleInputEmail1">Meta</label>
					<input type="text" class="form-control" id="meta" name="value" placeholder="Valor" value="{{$goal->value}}">
					<input type="hidden" name="id" value="{{$goal->id}}">
					{{ csrf_field() }}
					{{ method_field($method) }}
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label for="category">Categoria</label>
					<select name="category" class="form-control">
						<option value="invalid_option">Selecione</option>
						@foreach($categories as $categoryId => $categoryName)
							<option {{($categoryId == $goal->category->id)?'selected':''}} value="{{$categoryId}}">{{$categoryName}}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label for="transactionType">Tipo de Transação</label>
					<select name="transactionType" class="form-control">
						<option value="invalid_option">Selecione</option>
						@foreach($transactionTypes as $transactionTypeId => $transactionTypeName)
							<option {{($transactionTypeId == $goal->transactionType->id)?'selected':''}} value="{{$transactionTypeId}}">{{$transactionTypeName}}</option>
						@endforeach
					</select>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class=" form-group">
					<button type="submit" name="save" value="save" class="btn btn-success">Salvar</button>
					<a href="{{route('goal.index')}}" class="btn btn-danger">Cancelar</a>
				</div>
			</div>
		</div>
	</form>

@endsection