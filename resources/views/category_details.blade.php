<table class="table table-striped">
    <thead>
    <tr>
        <th>Data</th>
        <th>Descrição</th>
        <th>Valor</th>
    </tr>
    </thead>
    <tbody>
    @forelse($details as $detail)
    <tr>
        <td>{{$detail->transaction_date}}</td>
        <td>{{$detail->description}}</td>
        <td>{{Number::formatCurrency($detail->value)}}</td>
    </tr>
    @empty
        <tr>
            <td colspan="3">Nenhuma Transação para esta categoria!</td>
        </tr>
    @endforelse
    </tbody>
    <tfoot>
    <tr>
        <td colspan="2">Total</td>
        <td>{{Number::formatCurrency($total)}}</td>
    </tr>
    </tfoot>
</table>