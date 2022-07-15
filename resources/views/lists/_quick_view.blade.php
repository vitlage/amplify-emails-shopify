<div class="row" >
    <h2 class="text-primary my-4">{{ trans('messages.list_performance') }}</h2>
    <div class="row">
        <div class="col-md-6">
            <div class="content-group-sm">
                <div class="d-flex">
                    <h5 class="text-semibold me-auto">{{ trans('messages.average_open_rate') }}</h5>
                    <div class="pull-right progress-right-info text-primary">{{ number_to_percentage(isset($statistics->open_uniq_rate)? $statistics->open_uniq_rate:0)}}</div>
                </div>
                <div class="progress progress-sm">
                    <div class="progress-bar progress-bar-striped bg-info" style="width: {{ number_to_percentage(isset($statistics->open_uniq_rate)? $statistics->open_uniq_rate:0)}}">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="content-group-sm">
                <div class="d-flex">
                    <h5 class="text-semibold me-auto">{{ trans('messages.average_click_rate') }}</h5>
                    <div class="pull-right progress-right-info text-primary">{{ number_to_percentage(isset($statistics->click_rate)? $statistics->click_rate:0) }}</div>
                </div>
                <div class="progress progress-sm">
                    <div class="progress-bar progress-bar-striped bg-info" style="width: {{ number_to_percentage(isset($statistics->click_rate)? $statistics->click_rate:0) }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br />
    <div class="row mt-4 mb-4">
        <div class="col-md-3">
            <div class="bg-secondary p-3 shadow rounded-3 text-white">
                <div class="text-center">
                    <h2 class="text-semibold mb-1 mt-0">{{ number_to_percentage(isset($statistics->subscribe_rate)? $statistics->subscribe_rate:0) }}</h2>
                    <div class="text-muted2 text-white">{{ trans('messages.avg_subscribe_rate') }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="bg-secondary p-3 shadow rounded-3 text-white">
                <div class="text-center">
                    <h2 class="text-semibold mb-1 mt-0">{{ number_to_percentage(isset($statistics->unsubscribe_rate)? $statistics->unsubscribe_rate:0) }}</h2>
                    <div class="text-muted2 text-white">{{ trans('messages.avg_unsubscribe_rate') }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="bg-secondary p-3 shadow rounded-3 text-white">
                <div class="text-center">
                    <h2 class="text-semibold mb-1 mt-0">{{ number_with_delimiter(isset($statistics->unsubscribe_count)? $statistics->unsubscribe_count:0) }}</h2>
                    <div class="text-muted2 text-white">{{ trans('messages.total_unsubscribers') }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="bg-secondary p-3 shadow rounded-3 text-white">
                <div class="text-center">
                    <h2 class="text-semibold mb-1 mt-0">{{ number_with_delimiter(isset($statistics->unconfirmed_count)? $statistics->unconfirmed_count:0 )}}</h2>
                    <div class="text-muted2 text-white">{{ trans('messages.total_unconfirmed') }}</div>
                </div>
            </div>
        </div>
    </div>
    <br />
    <h3 class="text-semibold text-primary">{{ trans('messages.list_growth') }}</h3>
    <div class="row">

        <div class="col-md-12">
        @if (isset($statistics->subscriber_count))
            <!-- Basic column chart -->
                <div class="border p-3 shadow-sm rounded">
                    <div class="">
                        <div class="chart-container">
                            <div id="ListsGrowthChart2"
                                 class="chart has-fixed-height"
                                 style="width: 100%;height:450px;"
                            ></div>
                        </div>
                    </div>
                </div>
                <!-- /basic column chart -->

                <script>
                    var ListsGrowthChart2 = {
                        {{--                                url: '{{ action('MailListController@statisticsChart', $list->uid) }}',--}}
                        getChart: function() {
                            return $('#ListsGrowthChart2');
                        },

                        showChart: function() {
                                <?php  $myArray =[
                                    [
                                        'value' => isset($statistics->subscriber_count)? $statistics->subscriber_count:0,
                                        'name' => trans('messages.subscribed'),
                                    ],
                                    [
                                        'value' => isset($statistics->unsubscribe_count)? $statistics->unsubscribe_count:0,
                                        'name' => trans('messages.unsubscribed'),
                                    ],
                                    [
                                        'value' => isset($statistics->unconfirmed_count)? $statistics->unconfirmed_count:0,
                                        'name' => trans('messages.unconfirmed'),
                                    ]
                                ];

                                ?>

                            var codes = $.parseJSON(<?php print json_encode(json_encode($myArray)); ?>);
                            console.log(codes);
                            ListsGrowthChart2.renderChart( codes );

                        },

                        renderChart: function(data) {
                            // based on prepared DOM, initialize echarts instance
                            var growthChart2 = echarts.init(ListsGrowthChart2.getChart()[0], ECHARTS_THEME);

                            var colors = [
                                '#5cb2b2',
                                '#b25977',
                                '#aab25a',
                                '#5b7bb2',
                                '#555555',
                                '#626eb2',
                                '#81ac8d',
                                '#7d5fb2',
                                '#b26e59'
                            ];

                            var cData = data.map(function(item, index) {
                                return {
                                    name: item.name,
                                    value: item.value,
                                    itemStyle: {
                                        color: colors[index],
                                        borderWidth: 1,  borderType: 'solid', borderColor: '#fff'
                                    }
                                };
                            });

                            var option = {
                                title: {
                                    text: '{{ trans('messages.subscribers') }}',
                                    // subtext: '{{ trans('messages.statistics_chart') }}',
                                    left: 'center'
                                },
                                tooltip: {
                                    trigger: 'item',
                                    formatter: '{b}: {c} ({d}%)'
                                },
                                legend: {
                                    orient: 'vertical',
                                    left: 'right',
                                },
                                series: [
                                    {
                                        selectedMode: 'single',
                                        type: 'pie',
                                        radius: '70%',
                                        data: cData,
                                        emphasis: {
                                            itemStyle: {
                                                shadowBlur: 10,
                                                shadowOffsetX: 0,
                                                shadowColor: 'rgba(0, 0, 0, 0.5)'
                                            }
                                        },
                                        label: {
                                            // position: 'inner',
                                            fontSize: 12,
                                            color: ECHARTS_THEME == 'dark' ? '#fff' : null,
                                            formatter: '{b}\n{d}% ({c})',
                                        },
                                    }
                                ]
                            };

                            // use configuration item and data specified to show chart
                            growthChart2.setOption(option);
                        }
                    }

                    ListsGrowthChart2.showChart();
                </script>
            @else
                <div class="empty-chart-pie">
                    <div class="empty-list">
                    <span class="material-icons-outlined">
auto_awesome
</span>
                        <span class="line-1">
                        {{ trans('messages.log_empty_line_1') }}
                    </span>
                    </div>
                </div>
            @endif

        </div>
    </div>


</div>
