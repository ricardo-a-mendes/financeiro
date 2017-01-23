<table class="table table-striped">
    <thead>
    <tr>
        <th>{{trans('app.labels.date')}}</th>
        <th>{{trans('app.labels.value')}}</th>
    </tr>
    </thead>
    <tbody>
    @forelse($provisions as $provision)
        @foreach($provision->provisionDates as $provisionDate)
        <tr>
            <td>{{$provisionDate->ProvisionDateBR}}</td>
            <td>{{Number::formatCurrency($provision->value)}}</td>
        </tr>
        @endforeach
    @empty
        <tr>
            <td colspan="2">{{trans('app.messages.no_items_found')}}</td>
        </tr>
    @endforelse
    </tbody>
    <tfoot>
    <tr>
        <td>{{trans('app.labels.total')}}</td>
        <td>{{Number::formatCurrency($total)}}</td>
    </tr>
    </tfoot>
</table>