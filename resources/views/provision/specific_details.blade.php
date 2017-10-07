<table class="table table-striped">
    <thead>
    <tr>
        <th>{{trans('app.labels.date')}}</th>
        <th>{{trans('app.labels.value')}}</th>
    </tr>
    </thead>
    <tbody>
    @forelse($provisions as $provision)
        <tr>
            <td>{{date('d/m/Y', strtotime($provision->target_date))}}</td>
            <td>{{Number::formatCurrency($provision->value)}}</td>
        </tr>
    @empty
        <tr>
            <td colspan="2">{{trans('app.messages.no_items_found')}}</td>
        </tr>
    @endforelse
    </tbody>
    <tfoot>
    <tr>
        <td>{{trans('app.labels.total')}}</td>
        <td>{{Number::formatCurrency($provisions->count()*$provision->value)}}</td>
    </tr>
    </tfoot>
</table>