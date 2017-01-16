@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-7">
            <div class="row">
                <div class="col-md-4">
                    <h3>Resumo&nbsp;
                        <span data-toggle="modal" data-target="#modalNewTransaction">
                            <span data-toggle="tooltip" data-placement="top" title="Novo Lançamento" class="glyphicon glyphicon-plus small" style="cursor: pointer"></span>
                        </span>
                        <span data-toggle="modal" data-target="#modalImportStatement">&nbsp;
                            <span data-toggle="tooltip" data-placement="top" title="Importar Extrato" class="glyphicon glyphicon-import small" style="cursor: pointer"></span>
                        </span>
                    </h3>
                </div>
                <div class="col-md-8">
                    <nav class="navbar navbar-default">
                        <div class="container-fluid">
                            <!-- Collect the nav links, forms, and other content for toggling -->
                            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                <ul class="nav navbar-nav">
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Anterior <span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                            <li><a href="{{route('statement', ['monthToAdd' => -1])}}">{{date('m-Y', strtotime(date('Y-m-d'). '-1 months'))}}</a></li>
                                            <li><a href="{{route('statement', ['monthToAdd' => -2])}}">{{date('m-Y', strtotime(date('Y-m-d'). '-2 months'))}}</a></li>
                                            <li><a href="{{route('statement', ['monthToAdd' => -3])}}">{{date('m-Y', strtotime(date('Y-m-d'). '-3 months'))}}</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="{{route('statement')}}">Mês Atual ({{date('m-Y')}})</a></li>
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Posterior <span class="caret"></span></a>
                                        <ul class="dropdown-menu">
                                            <li><a href="{{route('statement', ['monthToAdd' => 1])}}">{{date('m-Y', strtotime(date('Y-m-d'). '+1 months'))}}</a></li>
                                            <li><a href="{{route('statement', ['monthToAdd' => 2])}}">{{date('m-Y', strtotime(date('Y-m-d'). '+2 months'))}}</a></li>
                                            <li><a href="{{route('statement', ['monthToAdd' => 3])}}">{{date('m-Y', strtotime(date('Y-m-d'). '+3 months'))}}</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div><!-- /.navbar-collapse -->
                        </div><!-- /.container-fluid -->
                    </nav>
                </div>
            </div>

            <div class="row">
                <h4>Período listado: {{$statementDate}}</h4>
                <table class="table table-responsive table-hover">
                    <thead>
                    <tr>
                        <th style="width: 50%">&nbsp;</th>
                        <th style="width: 25%">Provisionado</th>
                        <th style="width: 25%">Efetivado</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th>Saldo</th>
                        <th class="{{($totalCreditGoal-$totalDebitGoal >= 0)?'success text-green':'danger  text-red'}}"><span class="glyphicon glyphicon-thumbs-{{($totalCreditGoal-$totalDebitGoal >= 0)?'up':'down'}}"></span> {{Number::formatCurrency($totalCreditGoal-$totalDebitGoal)}}</th>
                        <th class="{{($totalCredit-$totalDebit >= 0)?'success text-green':'danger text-red'}}"><span class="glyphicon glyphicon-thumbs-{{($totalCredit-$totalDebit >= 0)?'up':'down'}}"></span> {{Number::formatCurrency($totalCredit-$totalDebit)}}</th>
                    </tr>
                    <tr>
                        <td colspan="3"></td>
                    </tr>
                    <tr class="success">
                        <th><span id="credit" class="glyphicon glyphicon-triangle-top" style="cursor: pointer"></span> Creditos</th>
                        <th>{{Number::formatCurrency($totalCreditGoal)}}</th>
                        <th>{{Number::formatCurrency($totalCredit)}}</th>
                    </tr>
                    @foreach($statementCredit as $creditItem)
                        <tr class="credit-rows">
                            <td>
                                 <span data-month_to_add="{{$monthToAdd}}" data-category="{{$creditItem->category}}" data-category_id="{{$creditItem->id}}" data-toggle="modal" data-target="#modalDetails">
                                    <span data-toggle="tooltip" data-placement="left" title="Ver Detalhes" class="glyphicon glyphicon-eye-open" style="cursor:pointer;">&nbsp;</span>
                                </span>
                                <a data-toggle="tooltip" data-placement="right" title="Editar Categoria" href="{{route('category.edit', ['id' => $creditItem->id])}}">{{$creditItem->category}}</a>
                            </td>
                            <td>{{Number::formatCurrency($creditItem->goal_value)}}</td>
                            <td>{{Number::formatCurrency($creditItem->effected_value)}}</td>
                        </tr>
                    @endforeach

                    <tr class="danger">
                        <th><span id="debit" class="glyphicon glyphicon-triangle-top" style="cursor: pointer"></span> Debitos</th>
                        <th>{{Number::formatCurrency($totalDebitGoal)}}</th>
                        <th>{{Number::formatCurrency($totalDebit)}}</th>
                    </tr>
                    @foreach($statementDebit as $debitItem)
                        <tr class="debit-rows">
                            <td>
                                <span data-month_to_add="{{$monthToAdd}}" data-category="{{$debitItem->category}}" data-category_id="{{$debitItem->id}}" data-toggle="modal" data-target="#modalDetails">
                                    <span data-toggle="tooltip" data-placement="left" title="Ver Detalhes" class="glyphicon glyphicon-eye-open" style="cursor:pointer;">&nbsp;</span>
                                </span>
                                <a data-toggle="tooltip" data-placement="right" title="Editar Categoria" href="{{route('category.edit', ['id' => $debitItem->id])}}">{{$debitItem->category}}</a>
                            </td>
                            <td>{{Number::formatCurrency($debitItem->goal_value)}}</td>
                            <td class="{{($debitItem->value > $debitItem->effected_value)?'btn-danger':''}}">{{Number::formatCurrency($debitItem->effected_value)}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        </div>
        <div class="col-md-5">
            <div id="MyChart"></div>
        </div>
    </div>

    <!-- Modal Import Statement Files -->
    <div class="modal fade" id="modalImportStatement" tabindex="-1" role="dialog" aria-labelledby="modalImportStatementLabel">
        <div class="modal-dialog" role="document">
            <form id="import_file_form" method="post" enctype="multipart/form-data" action="{{route('import.upload')}}">
                {{csrf_field()}}
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="modalImportStatementLabel">Importar Arquivo</h4>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label for="description">Selecione o arquivo (OFX ou CSV)</label>
                        <input type="file" class="form-control" name="import_file" id="import_file" placeholder="Arquivo">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="import_file_button">Importar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                </div>
            </div>
            </form>
        </div>
    </div>
    <!-- Modal Category Details -->
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

    <!-- Modal New Transaction -->
    <div class="modal fade" id="modalNewTransaction" tabindex="-1" role="dialog" aria-labelledby="modalNewTransaction">
        <div class="modal-dialog" role="document">
            <form method="post" action="{{route('transaction.store')}}">
                {{ csrf_field() }}
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Novo Lançamento</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description">Descrição</label>
                                    <input type="text" class="form-control" name="description" id="description" placeholder="Descrição">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="transaction_value">Valor</label>
                                    <input type="number" step="0.01" min="0.01" class="form-control" name="transaction_value" id="transaction_value" placeholder="Valor">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="transaction_date">Data</label>
                                    <input type="date" class="form-control" name="transaction_date" id="transaction_date" value="{{date('Y-m-d')}}">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="category">Categoria</label>
                                    <select name="category" class="form-control">
                                        <option value="invalid_option">{{trans('app.labels.select')}}</option>
                                        @foreach($categories as $categoryId => $categoryName)
                                            <option value="{{$categoryId}}">{{$categoryName}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="account">Conta</label>
                                    <select name="account" class="form-control">
                                        <option value="invalid_option">{{trans('app.labels.select')}}</option>
                                        @foreach($accounts as $accountId => $accountName)
                                            <option value="{{$accountId}}">{{$accountName}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="transactionType">Tipo</label>
                                    <select name="transactionType" class="form-control">
                                        <option value="invalid_option">{{trans('app.labels.select')}}</option>
                                        @foreach($transactionTypes as $transactionTypeId => $transactionTypeName)
                                            <option value="{{$transactionTypeId}}">{{$transactionTypeName}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Salvar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('js')

    <script type="text/javascript" src="{{asset('js/bootstrap/modal.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/Highcharts-5.0.6/code/highcharts.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/Highcharts-5.0.6/code/highcharts-3d.js')}}"></script>
    <script type="text/javascript">
        $(function(){
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
                var monthToAdd = span.data('month_to_add') // Extract info from data-* attributes
                var url_details = '{{route('statement.category.details', ['categoryID' => ''])}}';

                var modal = $(this);
                modal.find('.modal-title').text('Detalhes da categoria "' + category + '"');

                $.ajax({
                    url: url_details+'/'+category_id+'/'+monthToAdd,
                    success: function (tableDetails) {
                        modal.find('.modal-body').html(tableDetails);
                    }
                });
            }).modal({'backdrop': 'static', 'show': false});

            $('#modalImportStatement').modal({'backdrop': 'static', 'show': false});

            $('#import_file_button').click(function () {
                $(this).attr('disabled', 'disabled');
                $('#import_file_form').submit();
            });

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
                    text: 'Controle de Caixa {{$statementDate}}'
                },

                xAxis: {
                    categories: ['Provisioned', 'Effected']
                },

                yAxis: {
                    allowDecimals: false,
                    min: 0,
                    title: {
                        text: 'Valores (R$)'
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

                colors: ['#2AB27B', '#BF5329'],

                series: [{
                    name: 'Income',
                    data: [{{$totalCreditGoal}}, {{$totalCredit}}],
                    stack: 'income'
                }, {
                    name: 'Spent',
                    data: [{{$totalDebitGoal}}, {{$totalDebit}}],
                    stack: 'spent'
                }]
            });
        });
    </script>
@endsection