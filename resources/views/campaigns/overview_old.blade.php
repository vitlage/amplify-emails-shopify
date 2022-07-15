@extends('layouts.core.backend')
@if($campaign !=null)
@section('title', $campaign->name)
@endif
@section('head')
    <script type="text/javascript" src="{{ URL::asset('core/echarts/echarts.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('core/echarts/dark.js') }}"></script>
@endsection

@section('content')
    <div class="page-title">
        <ul class="breadcrumb breadcrumb-caret position-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ trans('messages.home') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('campaigns') }}">{{ trans('messages.campaigns') }}</a></li>
        </ul>
        @if($campaign !=null)
        <h1 class="d-flex align-items-center">
            <span class="text-semibold mr-3">{{ $campaign->name }}</span>
{{--            <span class="d-flex" title='{{ $campaigns->status == Acelle\Model\Campaign::STATUS_ERROR ? $campaigns->last_error : '' }}' data-popup='tooltip'>--}}
			<span class="label label-flat bg-{{ $campaign->status }}">{{ trans('messages.campaign_status_' . $campaign->status) }}</span>
		</span>
        </h1>
        @endif
    </div>
    @if($campaign !=null)
    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-tabs nav-tabs-top nav-underline">
                <li  class="nav-item" >

                    <a href="#" class="nav-link" data-tab="#overview" data-toggle="tab">
					<span class="material-icons-outlined">auto_graph</span> {{ trans('messages.overview') }}
                    </a>
                </li>
                <li  class="nav-item">
                    <a href="#" class="nav-link" data-tab="#setting"  data-toggle="tab">
					<span class="material-icons-outlined">settings</span> {{ trans('messages.setting') }}
                    </a>
                </li>


            </ul>
        </div>
    </div>
    <div id="myTabContent" class="row">
        <div class="col-md-12 tab-pane fade active show" id="overview">
                <h2 class="mt-4 mb-4">
                <span class="text-teal text-bold">
                    @if(isset($statistics->subscriber_count))
                        {{$statistics->subscriber_count}}
                    @else
                        0
                    @endif
                </span> Recipients
                </h2>
                <div class="row ">
                    <div class="col-md-6 campaigns-summary">
                        <div class="mb-2">
            <span class="text-bold d-inline-block text-end pe-3" style="width:120px">
                <span class="label bg-light">{{ trans('messages.from') }} <span class="material-icons-outlined">
                    alternate_email
                    </span></span>
            </span>
                            {{$campaign->from_name}}

                        </div>
                        <div class="mb-2">
            <span class="text-bold d-inline-block text-end pe-3" style="width:120px">
                <span class="label bg-light">{{ trans('messages.subject') }} <span class="material-icons-outlined">
                    subject
                    </span></span></span>
                            {{ $campaign->default_subject }}
                        </div>
                        <div class="mb-2">
            <span class="text-bold d-inline-block text-end pe-3" style="width:120px">
                <span class="label bg-light">{{ trans('messages.from_email') }} <span class="material-icons-outlined">
                    alternate_email
                    </span></span></span>
                            <a href="mailto:{{ $campaign->from_email }}">{{ $campaign->from_email }}</a>
                        </div>
                        <div class="mb-2">
            <span class="text-bold d-inline-block text-end pe-3" style="width:120px">
                <span class="label bg-light">{{ trans('messages.from_name') }} <span class="material-icons-outlined">
                    subject
                    </span></span></span>
                            {{ $campaign->from_name }}
                        </div>

                    </div>
                    <div class="col-md-6">

                        <div class="mb-2">
            <span class="text-bold d-inline-block text-end pe-3" style="width:120px">
                <span class="label bg-light">{{ trans('messages.updated_at') }} <span class="material-icons-outlined">
                    event
                    </span></span></span>
                            {{ \Illuminate\Support\Carbon::parse( $campaign->updated_at)->toFormattedDateString() }}
                        </div>

                    </div>
                </div>

                <h4 class="mt-4 mb-3"><i class="icon-stats-dots"></i> {{ trans('messages.statistics') }}</h4>
                <p class="mb-3">{!! trans('messages.campaign_table_chart_intro') !!}</p>

                <div class="row">
                    <div class="col-md-12">
                        <div class="">
                            <div class="">
                                <div class="chart-container">
                                    <div id="campaignChart"
                                         class="border shadow-sm rounded"
                                         data-url="#"
                                         style="width:100%; height:350px;"
                                    ></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <script>
                    var CampaignsChart = {
                        chart: $('#campaignChart'),
                        url: $('#campaignChart').attr('data-url'),

                        init: function() {
                            CampaignsChart.showChart();
                        },

                        showChart: function() {
                                <?php  $myArray =[
                                    [
                                        'name' => trans('messages.recipients'),
                                        'value' => isset($statistics->subscriber_count)? $statistics->subscriber_count:0,
                                    ],
                                    [
                                        'name' => trans('messages.Open'),
                                        'value' => isset($statistics->open_count)? $statistics->open_count:0,
                                    ],
                                    [
                                        'name' => trans('messages.Click'),
                                        'value' => isset($statistics->click_count)? $statistics->click_count:0,
                                    ],
                                    [
                                        'name' => trans('messages.Bounce'),
                                        'value' => isset($statistics->bounce_count)? $statistics->bounce_count:0,
                                    ],
                                    [
                                        'name' => trans('messages.report'),
                                        'value' => isset($statistics->abuse_feedback_count)? $statistics->abuse_feedback_count:0,
                                    ],
                                    [
                                        'name' => trans('messages.unsubscribe'),
                                        'value' => isset($statistics->unsubscribe_count)? $statistics->unsubscribe_count:0,
                                    ],
                                ];

                                ?>

                            var codes = $.parseJSON(<?php print json_encode(json_encode($myArray)); ?>);
                            // console.log(codes);

                            CampaignsChart.renderChart( codes );

                        },

                        renderChart: function(data) {
                            // based on prepared DOM, initialize echarts instance
                            var myChart = echarts.init(CampaignsChart.chart[0], ECHARTS_THEME);
                            var colors = [
                                '#555555',
                                '#626eb2',
                                '#81ac8d',
                                '#7d5fb2',
                                '#b26e59',
                                '#5cb2b2',
                                '#b25977',
                                '#aab25a',
                                '#5b7bb2',
                            ];

                            // mapping cols
                            var cols = data.map(function(item) {
                                return item.name;
                            }).reverse();

                            // mapping data
                            var cData = data.map(function(item, index) {
                                return {
                                    name: item.name,
                                    value: item.value,
                                    itemStyle: {
                                        color: colors[index]
                                    }
                                };
                            }).reverse();

                            var option = {
                                grid: {
                                    left: '100px',
                                    right: '100px',
                                    top: '30px',
                                    bottom: '50px'
                                },
                                yAxis: {
                                    type: 'category',
                                    data: cols,
                                },
                                xAxis: {
                                    type: 'value',
                                    name: '{{ trans('messages.subscribers') }}',
                                    scale: true
                                },
                                series: [{
                                    data: cData,
                                    type: 'bar'
                                }]
                                // tooltip: {
                                //     trigger: 'axis',
                                //     axisPointer: {
                                //         type: 'shadow'
                                //     }
                                // },
                                // grid: {
                                //     left: '3%',
                                //     right: '4%',
                                //     bottom: '3%',
                                //     containLabel: true
                                // },
                                // xAxis: {
                                //     type: 'value',
                                //     boundaryGap: [0, 0.01]
                                // },
                                // yAxis: {
                                //     type: 'value'
                                // },
                                // series: [
                                //     {
                                //         type: 'bar',
                                //         data: {
                                //             name: 'Unsubscribe',
                                //             value: 10000
                                //         }
                                //     }
                                // ]
                            };

                            // // specify chart configuration item and data
                            // var option = {
                            //     legend: {
                            //         right: 0,
                            //         top: 5,
                            //         orient: 'vertical',
                            //         icon: 'circle',
                            //     },
                            //     tooltip: {
                            //         trigger: 'item',
                            //         formatter: '{a} <br/>{b} : {c} ({d}%)'
                            //     },
                            //     toolbox: {
                            //         show: false,
                            //         feature: {
                            //             mark: {show: true},
                            //             dataView: {show: true, readOnly: false},
                            //             restore: {show: true},
                            //             saveAsImage: {show: true}
                            //         }
                            //     },
                            //     series: [
                            //         {
                            //             name: 'Activities',
                            //             type: 'bar',
                            //             center: ['45%', '40%'],
                            //             selectedMode: 'single',
                            //             itemStyle: {
                            //                 borderRadius: 0
                            //             },
                            //             label: {
                            //                 position: 'inner',
                            //                 fontSize: 14,
                            //                 formatter: '{d}%',
                            //             },
                            //             data: [
                            //                 {value: 45, name: 'Work', itemStyle: { color: '#6a7796', borderWidth: 1,  borderType: 'solid', borderColor: '#fff' } },
                            //                 {value: 27, name: 'Eat', itemStyle: { color: '#906659', borderWidth: 1,  borderType: 'solid', borderColor: '#fff' }},
                            //                 {value: 11, name: 'Commute', itemStyle: { color: '#a5895d', borderWidth: 1,  borderType: 'solid', borderColor: '#fff' }},
                            //                 {value: 22, name: 'Watch TV', itemStyle: { color: '#476844', borderWidth: 1,  borderType: 'solid', borderColor: '#fff' }},
                            //                 {value: 28, name: 'Sleep', itemStyle: { color: '#5f3763', borderWidth: 1,  borderType: 'solid', borderColor: '#fff' }}
                            //             ],
                            //         }
                            //     ]
                            // };

                            // use configuration item and data specified to show chart
                            myChart.setOption(option);
                        }
                    }
                    CampaignsChart.init();
                </script>

            </div>
        <div class="col-md-12 tab-pane fade active hide" id="setting">

            <p>Pause a running campaign. You can later on run the campaign again to have it resume from where it left off.</p>
            <a href="{{route('campaigns.pause',$campaign->uid)}}" class="btn btn-danger">Pause</a>
        </div>
    </div>
    @else
        <div class="empty-list">
		<span class="material-icons-outlined">
			auto_awesome
			</span>
            <span class="line-1">
			{{ trans('messages.campaign_empty_line_1') }}
		</span>
        </div>
    @endif


    <script>
        $(document).ready(function () {
            $(document).on('click','.nav-link',function() {
                var crnt_tab_id=$(this).data('tab')
                var crnt_tab= $("#myTabContent").find(crnt_tab_id);
                crnt_tab.removeClass('hide')
                crnt_tab.addClass('show')
                crnt_tab.siblings().removeClass('show')
                crnt_tab.siblings().addClass('hide')

            });
        });
    </script>

@endsection
