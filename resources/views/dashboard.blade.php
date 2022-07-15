@extends('layouts.core.backend')

@section('title', trans('messages.dashboard'))

@section('head')
    <script type="text/javascript" src="{{ URL::asset('core/echarts/echarts.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('core/echarts/dark.js') }}"></script>
@endsection

@section('content')
    <h1 class="mb-2 mt-4">{{ trans('messages.backend_dashboard_hello', ['name' => 'Admin']) }}</h1>
    <p>{{ trans('messages.backend_dashboard_welcome') }}</p>

{{--    @include('admin.notifications._top', ['notifications' => $notifications])--}}

    <div class="row ">
        <h3 class="mt-5 mb-3">
    <span class="material-icons-outlined me-2">
        history_toggle_off
        </span>
            {{ trans('messages.recently_sent_campaigns') }}
        </h3>
        @if (count($campaigns) == 0)
            <div class="empty-list">
        <span class="material-icons-outlined">
            auto_awesome
        </span>
                <span class="line-1">
            {{ trans('messages.no_sent_campaigns') }}
        </span>
            </div>
        @else
            <div class="row">
                <div class="col-md-6">
                    <select name="campaign_id" class="dashboard-campaign-select form-select" >
                        @foreach($campaigns as $campaign)
                            <option value="{{$campaign->uid}}">{{$campaign->name}}</option>
                        @endforeach
                    </select>

                </div>
            </div>
            <div id="campaign-quickview-container" data-url="{{ action("CampaignController@quickView") }}"></div>
        @endif

        <script>
            var DashboardCampaigns = {
                container: $('#campaign-quickview-container'),
                campaignSelect: $('.dashboard-campaign-select'),
                url: $('#campaign-quickview-container').attr('data-url'),

                getCampaignId: function() {
                    return DashboardCampaigns.campaignSelect.val();
                },

                loadChart: function() {
                    $.ajax({
                        method: "GET",
                        url: DashboardCampaigns.url,
                        data: {
                            uid: DashboardCampaigns.getCampaignId()
                        }
                    })
                        .done(function( response ) {
                            DashboardCampaigns.container.html(response);
                        });
                },
                init: function() {
                    DashboardCampaigns.campaignSelect.on('change', function() {
                        DashboardCampaigns.loadChart();
                    });

                    DashboardCampaigns.loadChart();
                }
            }

            DashboardCampaigns.init();
        </script>

        <h3 class=" mt-5"><i class="icon-address-book2"></i> {{ trans('messages.list_growth') }}</h3>
        @if (count($lists) == 0)
            <div class="empty-list">
                <span class="material-icons-outlined">
            auto_awesome
        </span>
                <span class="line-1">
            {{ trans('messages.no_saved_lists') }}
        </span>
            </div>
        @else
            <div class="row">
                <div class="col-md-6">
                    <select name="list_id" class="dashboard-list-select form-select" >
                        @foreach($lists as $list)
                            <option value="{{$list->uid}}">{{$list->name}}</option>
                        @endforeach
                    </select>

                </div>
            </div>
            <div id="list-quickview-container" data-url="{{ action("ListController@quickView") }}"></div>
        @endif

        <script>
            var DashboardListGrowth = {
                url: $('#list-quickview-container').attr('data-url'),

                getContainer: function() {
                    return $('#list-quickview-container');
                },

                loadChart: function() {
                    $.ajax({
                        method: "GET",
                        url: DashboardListGrowth.url,
                        data: {
                            uid: $('.dashboard-list-select').val(),
                        }
                    })
                        .done(function( response ) {
                            DashboardListGrowth.getContainer().html(response);
                        });
                }
            }

            $('.dashboard-list-select').on('change', function() {
                DashboardListGrowth.loadChart();
            });

            DashboardListGrowth.loadChart();
        </script>

    </div>
@endsection
