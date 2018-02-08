@extends('layouts.app')
@section('css')
    {{-- http://seiyria.com/bootstrap-slider/ --}}
    <link href="{{ asset('/css/bootstrap-slider.min.css') }}" rel="stylesheet">
    <style type="text/css">
        .slider.slider-horizontal {
            width: 800px;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div id="MyChart"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <form method="post" id="formMonthsToAdd" action="{{route('statement.yearly.filter')}}">
                    {{csrf_field()}}
                    <input name="monthsToAdd" style="background: #BABABA" id="ex1" data-slider-id='ex1Slider' type="text"
                           data-slider-min="1"
                           data-slider-max="12"
                           data-slider-step="1"
                           data-slider-value="{{$sliderPosition}}"
                           data-slider-ticks="[1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]"
                           data-slider-ticks-labels="[1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]"
                    />
                </form>
            </div>
            <div class="row">
                <table class="table table-responsive table-hover">
                    <tbody>
                    <tr>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        @foreach($yearMonths as $yearMonth => $yearMonthDescription)
                            <th>{{$yearMonthDescription}}</th>
                        @endforeach
                    </tr>
                    <tr>
                        <th>{{trans('app.labels.balance')}}</th>
                        <th>&nbsp;</th>
                        @foreach($yearMonths as $yearMonth => $yearMonthDescription)
                            <th class="{{($totalCredit[$yearMonth]-$totalDebit[$yearMonth] >= 0)?'success text-green':'danger  text-red'}}"><span class="glyphicon glyphicon-thumbs-{{($totalCredit[$yearMonth]-$totalDebit[$yearMonth] >= 0)?'up':'down'}}"></span> {{Number::formatCurrency($totalCredit[$yearMonth]-$totalDebit[$yearMonth])}}</th>
                        @endforeach
                    </tr>
                    <tr>
                        <td colspan="{{count($yearMonths)+2}}"></td>
                    </tr>
                    <tr class="success">
                        <th><span id="credit" class="glyphicon glyphicon-triangle-bottom cursor-pointer">&nbsp;</span>{{trans('transaction.credit')}}</th>
                        <th>&nbsp;</th>
                        @foreach($yearMonths as $yearMonth => $yearMonthDescription)
                            <th>{{Number::formatCurrency($totalCredit[$yearMonth])}}</th>
                        @endforeach
                    </tr>

                    @foreach($creditStatements as $catId => $statements)
                        <tr class="credit-rows">
                            <td rowspan="2">{{$categories[$catId]}}</td>
                            <td>Posted</td>
                            @foreach($yearMonths as $yearMonth => $yearMonthDescription)
                                @if(is_null($statements[$yearMonth]->category_id))
                                    <td>0.00</td>
                                @else
                                    <td><span class="cursor-pointer" data-month_to_add="0" data-category="{{$statements[$yearMonth]->category}}" data-category_id="{{$statements[$yearMonth]->category_id}}" data-toggle="modal" data-target="#modalDetails">{{Number::formatCurrency($statements[$yearMonth]->posted_value)}}</span></td>
                                @endif
                            @endforeach
                        </tr>
                        <tr class="credit-rows">
                            <td>Provision</td>
                            @foreach($yearMonths as $yearMonth => $yearMonthDescription)
                                @if(is_null($statements[$yearMonth]->category_id))
                                    <td>0.00</td>
                                @else
                                    <td><span class="cursor-pointer" data-month_to_add="0" data-category="{{$statements[$yearMonth]->category}}" data-category_id="{{$statements[$yearMonth]->category_id}}" data-toggle="modal" data-target="#modalDetails">{{Number::formatCurrency($statements[$yearMonth]->provision_value)}}</span></td>
                                @endif
                            @endforeach
                        </tr>
                    @endforeach

                    <tr class="danger">
                        <th><span id="debit" class="glyphicon glyphicon-triangle-bottom cursor-pointer">&nbsp;</span>{{trans('transaction.debit')}}</th>
                        <th>&nbsp;</th>
                        @foreach($yearMonths as $yearMonth => $yearMonthDescription)
                            <th>{{Number::formatCurrency($totalDebit[$yearMonth])}}</th>
                        @endforeach
                    </tr>
                    @foreach($debitStatements as $catId => $statements)
                        <tr class="debit-rows">
                            <td rowspan="2">
                                {{$categories[$catId]}}
                            </td>
                            <td>Posted</td>
                            @foreach($yearMonths as $yearMonth => $yearMonthDescription)
                                @if(is_null($statements[$yearMonth]->category_id))
                                    <td>$ 0.00</td>
                                @else
                                    <td><span class="cursor-pointer" data-month_to_add="0" data-category="{{$statements[$yearMonth]->category}}" data-category_id="{{$statements[$yearMonth]->category_id}}" data-toggle="modal" data-target="#modalDetails">{{Number::formatCurrency($statements[$yearMonth]->posted_value)}}</span></td>
                                @endif
                            @endforeach
                        </tr>
                        <tr class="debit-rows">
                            <td>Provision</td>
                            @foreach($yearMonths as $yearMonth => $yearMonthDescription)
                                @if(is_null($statements[$yearMonth]->category_id))
                                    <td>$ 0.00</td>
                                @else
                                    <td><span class="cursor-pointer" data-month_to_add="0" data-category="{{$statements[$yearMonth]->category}}" data-category_id="{{$statements[$yearMonth]->category_id}}" data-toggle="modal" data-target="#modalDetails">{{Number::formatCurrency($statements[$yearMonth]->provision_value)}}</span></td>
                                @endif
                            @endforeach
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
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
    <script type="text/javascript" src="{{asset('js/Highcharts-5.0.6/code/highcharts.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/Highcharts-5.0.6/code/highcharts-3d.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/bootstrap-slider.min.js')}}"></script>
    <script type="text/javascript">
        $(function(){

            $('#ex1').slider({
                formatter: function(value) {
                    return 'Current value: ' + value;
                }
            }).on('slideStop', function (slider) {
                console.log(slider.value);
                $('#formMonthsToAdd').submit();
            });

            $('.debit-rows').hide();
            $('.credit-rows').hide();

            //Show/Hide details
            $('#credit, #debit').on('click', function (){
                var type = $(this)[0].id;

                if ($(this).attr('class') == 'glyphicon cursor-pointer glyphicon-triangle-top') {
                    $('.'+type+'-rows').hide();
                    $(this).removeClass('glyphicon-triangle-top');
                    $(this).addClass('glyphicon-triangle-bottom');
                } else {
                    $('.'+type+'-rows').show();
                    $(this).removeClass('glyphicon-triangle-bottom');
                    $(this).addClass('glyphicon-triangle-top');
                }
            });

            //Modal for Transaction Details of a selected Category
            $('#modalDetails').on('show.bs.modal', function (event) {
                var span = $(event.relatedTarget); // Span that triggered the modal
                var category = span.data('category'); // Extract info from data-* attributes
                var category_id = span.data('category_id'); // Extract info from data-* attributes
                var monthToAdd = span.data('month_to_add'); // Extract info from data-* attributes
                var url_details = '{{route('statement.category.details', ['categoryID' => ''])}}';

                var modal = $(this);
                modal.find('.modal-title').text('{{trans('category.labels.details_of')}} "' + category + '"');

                $.ajax({
                    url: url_details+'/'+category_id+'/'+monthToAdd,
                    success: function (tableDetails) {
                        modal.find('.modal-body').html(tableDetails);
                    }
                });
            }).modal({'backdrop': 'static', 'show': false});

            var incomeData = @json($totalsCreditGraph);

            var expansesData = @json($totalsDebitGraph);

            var provisionData = [
                ['Oct', 2100],
                ['Nov', 2100],
                ['Dec', 2200],
                ['Jan', 1300],
                ['Feb', 3000],
                ['Mar', 2539]
            ];

            Highcharts.chart('MyChart', {
                chart: {
                    type: 'spline'
                },
                title: {
                    text: 'General vision over the time'
                },
                subtitle: {
                    text: 'Credit X Debit X Provision'
                },
                xAxis: {
                    title: {
                        text: 'Date'
                    }
                },
                yAxis: {
                    title: {
                        text: 'Amount ({{trans('app.labels.currency_symbol')}})'
                    }
                },
                tooltip: {
                    headerFormat: '<b>{series.name}</b><br>',
                    pointFormat: '{point.x:%e. %b}: {point.y:.2f} m'
                },

                plotOptions: {
                    spline: {
                        marker: {
                            enabled: true
                        }
                    }
                },

                series: [{
                    name: '{{trans('app.labels.income')}}',
                    color: 'green',
                    data: incomeData
                }, {
                    name: '{{trans('app.labels.expenses')}}',
                    color: 'red',
                    data: expansesData
                }, {
                    name: '{{trans('provision.labels.provisioned')}}',
                    color: 'orange',
                    data: provisionData
                }]
            });

            $('.highcharts-credits').hide();
        });
    </script>
@endsection