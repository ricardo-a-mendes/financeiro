@extends('layouts.app')

@section('content')

	<form method="post" action="{{route('reference.update', ['id' => $transactionReference->id])}}" class="form-inline">
		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<label for="category">{{trans_choice('reference.labels.reference', 1)}}</label>
					<p>{{$transactionReference->description}}</p>
					{{ csrf_field() }}
					{{ method_field('PUT') }}
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
					<label for="category">{{trans_choice('category.labels.category', 1)}}</label>
					<select name="category" class="form-control combo_category">
						<option value="invalid_option">{{trans('app.labels.select')}}</option>
						@foreach($categories as $categoryId => $categoryName)
							<option {{($categoryId == old('category', $transactionReference->category->id))?'selected':''}} value="{{$categoryId}}">{{$categoryName}}</option>
						@endforeach
					</select>
					<span data-toggle="modal" data-target="#modalNewCategory">
						<span class="glyphicon glyphicon-plus cursor-pointer" data-toggle="tooltip" title="{{trans('category.labels.new_category')}}">
						</span>
					</span>
				</div>
			</div>

		</div>

		<div class="row">
			<div class="col-md-12">
				<div class=" form-group">
					<button type="submit" name="save" value="save" class="btn btn-success">{{trans('app.labels.save')}}</button>
					<a href="{{route('reference.index')}}" class="btn btn-danger">{{trans('app.labels.cancel')}}</a>
				</div>
			</div>
		</div>
	</form>

	@include('layouts.modal_new_category');

@endsection
