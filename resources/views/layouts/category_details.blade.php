<table class="table table-striped">
    <thead>
    <tr>
        <th>{{trans('app.labels.date')}}</th>
        <th>{{trans('app.labels.description')}}</th>
        <th>{{trans('app.labels.value')}}</th>
    </tr>
    </thead>
    <tbody>
    @forelse($details as $detail)
    <tr>
        <td>{{$detail->TransactionDateBR}}</td>
        <td>{{$detail->description}}</td>
        <td>{{Number::formatCurrency($detail->value)}}</td>
    </tr>
    @empty
        <tr>
            <td colspan="3">{{trans('app.messages.no_items_found')}}</td>
        </tr>
    @endforelse
    </tbody>
    <tfoot>
    <tr>
        <td colspan="2">{{trans('app.labels.total')}}</td>
        <td>{{Number::formatCurrency($total)}}</td>
    </tr>
    </tfoot>
</table>