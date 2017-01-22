@extends('layouts.app')

@section('content')

	<form method="post" action="{{$route}}">
		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label for="exampleInputEmail1">{{trans_choice('provision.labels.provision', 1)}}</label>
					<div class="input-group">
						<span class="input-group-addon">$</span>
						<input type="number" step="0.01" min="0.01" class="form-control" id="meta" name="value" placeholder="{{trans('app.labels.value')}}" value="{{old('value', $goal->value)}}">
					</div>
					<input type="hidden" name="id" value="{{$goal->id}}">
					{{ csrf_field() }}
					{{ method_field($method) }}
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label for="category">{{trans_choice('category.labels.category',1)}}</label>
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
					<label for="transactionType">{{trans('transaction.labels.type')}}</label>
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
						{{trans('provision.labels.new_specific_provision')}}
					</label>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group" id="specific_date">
					<label for="specific_date">{{trans('app.labels.date')}}</label>
					<div class="input-group">
						<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
						<input type="date" min="{{date('Y-m-d')}}" class="form-control" name="specific_date" value="{{$goal->specificDate}}">
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class=" form-group">
					<button type="submit" name="save" value="save" class="btn btn-success">{{trans('app.labels.save')}}</button>
					<a href="{{route('goal.index')}}" class="btn btn-danger">{{trans('app.labels.cancel')}}</a>
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