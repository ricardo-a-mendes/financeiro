@extends('layouts.app')

@section('content')

	@if (count($errors) > 0)
		<div class="alert alert-danger">
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif

	<div class="row">
		<form method="post" action="{{$route}}">
			<div class="form-group">
				<label for="exampleInputEmail1">{{trans_choice('category.labels.category', 1)}}</label>
				<input type="text" class="form-control" id="category" name="category" placeholder="{{trans_choice('category.labels.category', 1)}}" value="{{$category->name}}">
				<input type="hidden" name="id" value="{{$category->id}}">
				{{ csrf_field() }}
				{{ method_field($method) }}
			</div>
			<div class=" form-group">
				<button type="submit" name="save" value="save" class="btn btn-success">{{trans('app.labels.save')}}</button>
				<a href="{{route('category.index')}}" class="btn btn-danger">{{trans('app.labels.cancel')}}</a>
			</div>
		</form>
	</div>

@endsection