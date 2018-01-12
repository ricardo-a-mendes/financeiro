@extends('layouts.app')

@section('content')

	<div class="row">
		<div class="page-header">
			<h3>My Account</h3>
		</div>


	</div>

	<div class="row">
		<p>{{trans_choice('app.labels.user', 2)}}</p>
	</div>

@endsection