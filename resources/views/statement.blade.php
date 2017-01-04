@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <h3>Extrato&nbsp;
                    <span data-toggle="tooltip" data-placement="top" title="Novo Lançamento" class="glyphicon glyphicon-plus small" style="cursor: pointer"></span>
                    &nbsp;
                    <span data-toggle="tooltip" data-placement="top" title="Importar Extrato" class="glyphicon glyphicon-import small" style="cursor: pointer"></span>
                </h3>
                <table class="table table-responsive table-hover">
                    <thead>
                    <tr>
                        <th style="width: 50%">Descrição</th>
                        <th style="width: 25%">Provisionado</th>
                        <th style="width: 25%">Efetivado</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="success">
                        <th><span id="credit" class="glyphicon glyphicon-triangle-top"></span> Creditos</th>
                        <th>{{Number::formatCurrency($totalCreditGoal)}}</th>
                        <th>{{Number::formatCurrency($totalCredit)}}</th>
                    </tr>
                    @foreach($statementCredit as $creditItem)
                        <tr class="credit-rows">
                            <td>{{$creditItem->category}}</td>
                            <td>{{Number::formatCurrency($creditItem->goal_value)}}</td>
                            <td>{{Number::formatCurrency($creditItem->effected_value)}}</td>
                        </tr>
                    @endforeach

                    <tr class="danger">
                        <th><span id="debit" class="glyphicon glyphicon-triangle-top"></span> Debitos</th>
                        <th>{{Number::formatCurrency($totalDebitGoal)}}</th>
                        <th>{{Number::formatCurrency($totalDebit)}}</th>
                    </tr>
                    @foreach($statementDebit as $debitItem)
                        <tr class="debit-rows">
                            <td>
                                <span data-category="{{$debitItem->category}}" data-category_id="{{$debitItem->id}}" data-toggle="modal" data-target="#modalDetails">
                                    <span data-toggle="tooltip" data-placement="left" title="Ver Detalhes" class="glyphicon glyphicon-eye-open" style="cursor:pointer;">&nbsp;</span>
                                </span>
                                {{$debitItem->category}}
                            </td>
                            <td>{{Number::formatCurrency($debitItem->goal_value)}}</td>
                            <td class="{{($debitItem->value > $debitItem->effected_value)?'btn-danger':''}}">{{Number::formatCurrency($debitItem->effected_value)}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-md-5">
                <div id="MyChart"></div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modalDetails" tabindex="-1" role="dialog" aria-labelledby="modalDetailsLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script type="text/javascript" src="{{asset('js/bootstrap/tooltip.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/bootstrap/modal.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/Highcharts-5.0.6/code/highcharts.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/Highcharts-5.0.6/code/highcharts-3d.js')}}"></script>
    <script type="text/javascript">
        $(function(){
            $('[data-toggle="tooltip"]').tooltip();

            $('#credit, #debit').on('click', function (){
                var type = $(this)[0].id;
                if ($(this).attr('class') == 'glyphicon glyphicon-triangle-top') {
                    $('.'+type+'-rows').hide();
                    $(this).removeClass('glyphicon-triangle-top');
                    $(this).addClass('glyphicon-triangle-bottom');
                } else {
                    $('.'+type+'-rows').show();
                    $(this).removeClass('glyphicon-triangle-bottom');
                    $(this).addClass('glyphicon-triangle-top');
                }
            });

            //Modal for Trasaction Details of a selected Category
            $('#modalDetails').on('show.bs.modal', function (event) {
                var span = $(event.relatedTarget) // Span that triggered the modal
                var category = span.data('category') // Extract info from data-* attributes
                var category_id = span.data('category_id') // Extract info from data-* attributes
                var url_details = '{{route('statement.category.details', ['categoryID' => ''])}}';

                var modal = $(this);
                modal.find('.modal-title').text('Detalhes da categoria "' + category + '"');

                $.ajax({
                    url: url_details+'/'+category_id,
                    success: function (tableDetails) {
                        modal.find('.modal-body').html(tableDetails);
                    }
                });
            }).modal({'backdrop': 'static', 'show': false});

            var myChart = Highcharts.chart('MyChart', {
                chart: {
                    type: 'column',
                    options3d: {
                        enabled: true,
                        alpha: 15,
                        beta: 15,
                        viewDistance: 25,
                        depth: 40
                    }
                },

                title: {
                    text: 'Controle de Caixa'
                },

                xAxis: {
                    categories: ['Jan', 'Fev']
                },

                yAxis: {
                    allowDecimals: false,
                    min: 0,
                    title: {
                        text: 'Valores em R$/1.000'
                    }
                },

                tooltip: {
                    headerFormat: '<b>{point.key}</b><br>',
                    pointFormat: '<span style="color:{series.color}">\u25CF</span> {series.name}: {point.y} / {point.stackTotal}'
                },

                plotOptions: {
                    column: {
                        stacking: 'normal',
                        depth: 40
                    }
                },

                colors: ['#2AB27B', '#90ed7d', '#CBB956', '#BF5329'],

                series: [{
                    name: 'Salary',
                    data: [6, 6],
                    stack: 'income'
                }, {
                    name: 'Rent',
                    data: [1, 2],
                    stack: 'income'
                }, {
                    name: 'Provisioned',
                    data: [6, 9],
                    stack: 'provisioned'
                }, {
                    name: 'Spent',
                    data: [5, 8],
                    stack: 'spent'
                }]
            });
        });
    </script>
@endsection