@extends('layouts.app')

@section('content')

	<form method="post" action="{{$route}}">
		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label for="exampleInputEmail1">Meta</label>
					<div class="input-group">
						<span class="input-group-addon">$</span>
						<input type="number" step="0.01" min="0.01" class="form-control" id="meta" name="value" placeholder="Valor" value="{{old('value', $goal->value)}}">
					</div>
					<input type="hidden" name="id" value="{{$goal->id}}">
					{{ csrf_field() }}
					{{ method_field($method) }}
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label for="category">Categoria</label>
					<select name="category" class="form-control">
						<option value="invalid_option">{{trans('app.labels.select')}}</option>
						@foreach($categories as $categoryId => $categoryName)
							<option {{($categoryId == old('category', $goal->category->id))?'selected':''}} value="{{$categoryId}}">{{$categoryName}}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label for="transactionType">Tipo de Transação</label>
					<select name="transactionType" class="form-control">
						<option value="invalid_option">{{trans('app.labels.select')}}</option>
						@foreach($transactionTypes as $transactionTypeId => $transactionTypeName)
							<option {{($transactionTypeId == old('transactionType', $goal->transactionType->id))?'selected':''}} value="{{$transactionTypeId}}">{{trans('transaction.'.$transactionTypeName)}}</option>
						@endforeach
					</select>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4">
				<div class="checkbox">
					<label>
						<input type="checkbox" name="specific_goal_option" id="specific" value="yes" {{(old('specific_goal_option', $hasSpecificGoal)=='yes')? 'checked="checked"' : ''}}>
						Cadastrar Meta para uma data específica
					</label>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group" id="specific_date">
					<label for="specific_date">Data</label>
					<div class="input-group">
						<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
						<input type="date" min="{{date('Y-m-d')}}" class="form-control" name="specific_date" placeholder="Valor" value="{{$goal->specificDate}}">
					</div>
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
@section('js')
	<script type="text/javascript">
		$(function () {

			var toggle_checkbox = function(){
				if ($('#specific').is(':checked'))
					$('#specific_date').show();
				else
					$('#specific_date').hide();
			};

			//for initial state (even when repopulating after validation)
			toggle_checkbox();

			$('#specific').on('click', function () {
				toggle_checkbox();
			});
		});
	</script>
@endsection