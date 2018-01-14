@extends('layouts.app')

@section('content')
	<div class="row">
		<div class="page-header">
			<h3>{{trans_choice('provision.labels.provision', 2)}} <small><a href="{{route('provision.create')}}" data-toggle="tooltip" data-placement="top" title="{{trans('provision.labels.new')}}" class="deco-none glyphicon glyphicon-plus cursor-pointer"></a></small></h3>
		</div>

		<table class="table table-striped">
			<thead>
			<tr>
				<th>ID</th>
				<th>{{trans_choice('category.labels.category', 1)}}</th>
				<th>{{trans_choice('provision.labels.provision', 1)}}</th>
				<th>{{trans('app.labels.specific')}}</th>
				<th>{{trans('app.labels.type')}}</th>
				<th>{{trans('app.labels.actions')}}</th>
			</tr>
			</thead>
			<tbody>
			@forelse($provisions as $provision)
			<tr>
				<td>{{$provision->id}}</td>
				<td><a data-toggle="tooltip" title="{{trans('category.labels.edit')}}" href="{{route('category.edit', ['id' => $provision->category->id])}}">{{$provision->category->name}}</a></td>
				<td>
                    @if($provision->provisionDates->count() > 0)
                        {{Number::formatCurrency($provision->provisionDates->count()*$provision->value)}}
                    @else
                        {{Number::formatCurrency($provision->value)}}
                    @endif
				</td>
				<td>
					@if($provision->provisionDates->count() > 0)
						<span data-modal_title="{{trans('provision.labels.specific_of', ['categoryName' => $provision->category->name])}}"  data-provision_id="{{$provision->id}}" data-loading="{{trans('app.labels.loading')}}" data-toggle="modal" data-target="#modalDetails">
							<span class="glyphicon glyphicon-calendar cursor-pointer" data-toggle="tooltip" data-placement="right" title="{{trans('app.labels.view')}}"></span>
						</span>
					@else
						&nbsp;
					@endif
				</td>
				<td class="{{($provision->transactionType->unique_name === 'credit')?'text-green':'text-red'}}">{{$provision->transactionType->name}}</td>
				<td>
					<a href="{{route('provision.edit', ['id' => $provision->id])}}" data-toggle="tooltip" data-placement="top" title="{{trans('app.labels.edit')}}" class="deco-none glyphicon glyphicon-pencil"></a>
					&nbsp;|&nbsp;
					<span class="cursor-pointer" data-category="{{$provision->category->name}}" data-category_id="{{$provision->id}}" data-toggle="modal" data-target="#deleteProvision">
						<span data-toggle="tooltip" data-placement="top" title="{{trans('app.labels.delete')}}" class="glyphicon glyphicon-trash"></span>
					</span>
				</td>
			</tr>
			@empty
			<tr>
				<td colspan="4">{{trans('app.messages.no_items_found')}}</td>
			</tr>
			@endforelse
			</tbody>
		</table>

	</div>

	<!-- Modal Specific Provision Details -->
	<div class="modal fade" id="modalDetails" tabindex="-1" role="dialog" aria-labelledby="modalDetailsLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Modal title</h4>
				</div>
				<div class="modal-body">
					<p>{{trans('app.labels.loading')}}...</p>
					<div class="progress">
						<div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%">
							<span class="sr-only">50% Complete</span>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
				</div>
			</div>
		</div>
	</div>
@endsection
@section('js')

	<script type="text/javascript" src="{{asset('js/bootstrap/modal.js')}}"></script>
	<script type="text/javascript">
		$(function(){
			//Modal for Specific Provision Details
			$('#modalDetails').on('show.bs.modal', function (event) {
				var span = $(event.relatedTarget); // Span that triggered the modal
				var category = span.data('category'); // Extract info from data-* attributes
				var provision_id = span.data('provision_id'); // Extract info from data-* attributes
				var modal_title = span.data('modal_title'); // Extract info from data-* attributes
				var loading = span.data('loading');

				var url_details = '{{route('provision.specific.details', ['provisionID' => ''])}}';

				var loadingHTML = '<p>'+loading+'...</p>';
                loadingHTML = loadingHTML + '<div class="progress">';
                loadingHTML = loadingHTML + '<div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%">';
                loadingHTML = loadingHTML + '<span class="sr-only">50% Complete</span>';
                loadingHTML = loadingHTML + '</div>';
                loadingHTML = loadingHTML + '</div>';

				var modal = $(this);
				modal.find('.modal-title').text(modal_title+'.');
                modal.find('.modal-body').html(loadingHTML);

				$.ajax({
					url: url_details+'/'+provision_id,
					success: function (tableDetails) {
						modal.find('.modal-body').html(tableDetails);
					}
				});
			}).modal({'backdrop': 'static', 'show': false});
		});
	</script>
@endsection