@extends('layouts.main')
@section('page-title')
    {{__('Manage Purchase')}}
@endsection
@section('page-breadcrumb')
    {{ __('Report') }},
    {{ __('Daily Purchase Report') }}
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/plugins/apexcharts.min.js') }}"></script>
    <script src="{{ asset('js/html2pdf.bundle.min.js') }}"></script>
    <script>
        var filename = $('#filename').val();
        function saveAsPDF() {
            var element = document.getElementById('printableArea');
            var opt = {
                margin: 0.3,
                filename: filename,
                image: {type: 'jpeg', quality: 1},
                html2canvas: {scale: 4, dpi: 72, letterRendering: true},
                jsPDF: {unit: 'in', format: 'A2'}
            };
            html2pdf().set(opt).from(element).save();
        }
    </script>
    <script>
        (function () {
            var chartBarOptions = {
                series: [
                    {
                        name: '{{ __("Purchase") }}',
                        data:   {!! json_encode($data) !!},
                    },
                ],

                chart: {
                    height: 300,
                    type: 'area',
                    dropShadow: {
                        enabled: true,
                        color: '#000',
                        top: 18,
                        left: 7,
                        blur: 10,
                        opacity: 0.2
                    },
                    toolbar: {
                        show: false
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: 2,
                    curve: 'smooth'
                },
                title: {
                    text: '',
                    align: 'left'
                },
                xaxis: {
                    categories: {!! json_encode($arrDuration) !!},
                    title: {
                        text: '{{ __("Days") }}'
                    }
                },
                colors: ['#6fd944', '#6fd944'],

                grid: {
                    strokeDashArray: 4,
                },
                legend: {
                    show: false,
                },
                yaxis: {
                    title: {
                        text: '{{ __("Amount") }}'
                    },

                }

            };
            var arChart = new ApexCharts(document.querySelector("#daily-purchase"), chartBarOptions);
            arChart.render();
        })();
    </script>
@endpush
@section('page-action')
    <div>
        <a  class="btn btn-sm btn-primary" onclick="saveAsPDF()"  data-bs-toggle="tooltip"  data-bs-original-title="{{ __('Download') }}">
            <i class="ti ti-download"></i>
        </a>
    </div>
@endsection
 
@section('content')
    <ul class="nav nav-pills my-3" id="pills-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" href="#daily-chart" role="tab"
               aria-controls="pills-home" aria-selected="true">{{ __('Daily') }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
               href="{{ route('reports.monthly.purchase') }}"
               onclick="window.location.href = '{{ route('reports.monthly.purchase') }}'" role="tab"
               aria-controls="pills-profile" aria-selected="false">{{ __('Monthly') }}</a>
        </li>
    </ul>

    <div class="row">
        <div class="col-sm-12">
            <div class=" multi-collapse mt-2 " id="multiCollapseExample1">
                <div class="card">
                    <div class="card-body">
                        {{ Form::open(['route' => ['reports.daily.purchase'], 'method' => 'GET', 'id' => 'daily_purchase_report_submit']) }}
                        <div class="row d-flex align-items-center justify-content-end">
                            <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 col-12">
                                <div class="btn-box">
                                    {{ Form::label('start_date', __('Start Date'),['class'=>'form-label'])}}
                                    {{ Form::date('start_date', isset($_GET['start_date'])?$_GET['start_date']:'', array('class' => 'form-control month-btn')) }}
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-6 col-sm-12 col-12 mr-2">
                                <div class="btn-box">
                                    {{ Form::label('end_date', __('End Date'),['class'=>'form-label'])}}
                                    {{ Form::date('end_date', isset($_GET['end_date'])?$_GET['end_date']:'', array('class' => 'form-control month-btn')) }}

                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mr-2">
                                <div class="btn-box">
                                    {{ Form::label('warehouse', __('Warehouse'),['class'=>'form-label'])}}
                                    {{ Form::select('warehouse',$warehouse,isset($_GET['warehouse'])?$_GET['warehouse']:'', array('class' => 'form-control select')) }}
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 mr-2">
                                <div class="btn-box">
                                    {{ Form::label('vendor', __('Vendor'),['class'=>'form-label'])}}
                                    {{ Form::select('vendor',$vendor,isset($_GET['vendor'])?$_GET['vendor']:'', array('class' => 'form-control select')) }}
                                </div>
                            </div>

                            <div class="col-auto float-end ms-2 mt-4">
                                <a href="#" class="btn btn-sm btn-primary me-1"
                                   onclick="document.getElementById('daily_purchase_report_submit').submit(); return false;" data-toggle="tooltip" data-original-title="{{ __('apply') }}" title="{{ __('Apply') }}">
                                    <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                                </a>
                                <a href="{{ route('reports.daily.purchase') }}" class="btn btn-sm btn-danger" data-toggle="tooltip"      data-original-title="{{ __('Reset') }}">
                                <span class="btn-inner--icon"><i class="ti ti-trash-off text-white-off"></i></span>
                                </a>
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="printableArea">
        <div class="row">
            <div class="col">
                <input type="hidden" value="{{$filter['warehouse'].' '.__('Daily Purchase').' '.'Report of'.' '.$filter['startDate'].' to '.$filter['endDate']}}" id="filename">
                <div class="card p-4 mb-4">
                    <h7 class="report-text gray-text mb-0">{{__('Report')}} :</h7>
                    <h6 class="report-text mb-0">{{__('Daily Purchase Report')}}</h6>
                </div>
            </div>
            @if(!empty($filter['warehouse']))
                <div class="col">
                    <div class="card p-4 mb-4">
                        <h7 class="report-text gray-text mb-0">{{__('Warehouse')}} :</h7>
                        <h6 class="report-text mb-0">{{$filter['warehouse']}}</h6>
                    </div>
                </div>
            @endif
            @if(!empty($filter['vendor']))
                <div class="col">
                    <div class="card p-4 mb-4">
                        <h7 class="report-text gray-text mb-0">{{__('Vendor')}} :</h7>
                        <h6 class="report-text mb-0">{{$filter['vendor']}}</h6>
                    </div>
                </div>
            @endif
            <div class="col">
                <div class="card p-4 mb-4">
                    <h7 class="report-text gray-text mb-0">{{__('Duration')}} :</h7>
                    <h6 class="report-text mb-0">{{$filter['startDate'].' to '.$filter['endDate']}}</h6>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="setting-tab">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="daily-chart" role="tabpanel">
                                <div class="col-lg-12">
                                    <div class="card-header">
                                        <div class="row ">
                                            <div class="col-6">
                                                <h6>{{ __('Daily Report') }}</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div id="daily-purchase"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection



