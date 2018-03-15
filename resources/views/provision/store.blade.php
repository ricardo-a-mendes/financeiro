@extends('layouts.app')

@section('content')

	<form method="post" action="{{$route}}">
		<div class="row">
			<div class="col-md-3">
				<div class="form-group">
					<label for="category">{{trans_choice('category.labels.category',1)}}</label>
					<select name="category" class="form-control">
						<option value="invalid_option">{{trans('app.labels.select')}}</option>
						@foreach($categories as $categoryId => $categoryName)
							<option {{($categoryId == old('category', $provision->category->id))?'selected':''}} value="{{$categoryId}}">{{$categoryName}}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group">
					<label for="exampleInputEmail1">{{trans_choice('provision.labels.provision', 1)}}</label>
					<div class="input-group">
						<span class="input-group-addon">$</span>
						<input type="number" step="0.01" min="0.01" class="form-control" id="meta" name="value" placeholder="{{trans('app.labels.value')}}" value="{{old('value', $provision->value)}}">
					</div>
					<input type="hidden" name="id" value="{{$provision->id}}">
					{{ csrf_field() }}
					{{ method_field($method) }}
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group">
					<label for="transactionType">{{trans('transaction.labels.type')}}</label>
					<select name="transactionType" class="form-control">
						<option value="invalid_option">{{trans('app.labels.select')}}</option>
						@foreach($transactionTypes as $transactionTypeId => $transactionTypeName)
							<option {{($transactionTypeId == old('transactionType', $provision->transactionType->id))?'selected':''}} value="{{$transactionTypeId}}">{{trans('transaction.'.$transactionTypeName)}}</option>
						@endforeach
					</select>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				<div class="form-group">
					<label for="transactionPeriod">{{trans('provision.labels.start_at')}}</label>
					<div class="input-group">
						<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
						<input type="month" class="form-control" id="start_at" name="start_at" placeholder="{{trans('app.labels.value')}}" value="{{old('start_at', date('Y-m', strtotime($provision->start_at)))}}">
					</div>
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group">
					<label for="transactionPeriod">{{trans('provision.labels.valid_until')}}</label>
					<div class="input-group">
						<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
						<input type="month" class="form-control" id="valid_until" name="valid_until" placeholder="{{trans('app.labels.value')}}" value="{{old('valid_until', date('Y-m', strtotime($provision->valid_until)))}}">
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class=" form-group">
					<button type="submit" name="save" value="save" class="btn btn-success">{{trans('app.labels.save')}}</button>
					<a href="{{route('provision.index')}}" class="btn btn-danger">{{trans('app.labels.cancel')}}</a>
				</div>
			</div>
		</div>
	</form>

@endsection