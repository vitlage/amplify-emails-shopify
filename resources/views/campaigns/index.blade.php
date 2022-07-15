@extends('layouts.core.backend')

@section('title', trans('messages.campaigns'))

@section('head')
    <script type="text/javascript" src="{{ URL::asset('core/echarts/echarts.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('core/echarts/dark.js') }}"></script>
@endsection

@section('content')
    <div class="page-title">
        <ul class="breadcrumb breadcrumb-caret position-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ trans('messages.home') }}</a></li>
        </ul>
        <h1>
            <span class="material-icons-round">
                format_list_bulleted
                </span> {{ trans('messages.campaigns') }}</span>
        </h1>
    </div>
    <div id="CampaignsIndexContainer" class="listing-form top-sticky"
         data-url="{{ action('CampaignController@listing') }}"
         per-page="10"
    >
        <div class="d-flex top-list-controls top-sticky-content">
            <div class="me-auto">
                    <div class="filter-box-1">
                        <span class="text-nowrap">
                            <input type="text" name="keyword" class="form-control search  search-item" placeholder="{{ trans('messages.type_to_search') }}" />
                            <span class="material-icons-round">search</span>
                        </span>
                    </div>
            </div>

            <div class="text-end">
                <a href="{{url('campaigns/select-type')}}" role="button" class="btn btn-secondary">
                    <span class="material-icons-round">
add
</span> Create campaign
                </a>
            </div>

        
        </div>

        <div id="CampaignsIndexContent" class="pml-table-container">



        </div>
    </div>
    <script>
        var CampaignsIndex = {
            getList: function() {
                return makeList({
                    url: '{{ action('CampaignController@listing') }}',
                    container: $('#CampaignsIndexContainer'),
                    content: $('#CampaignsIndexContent')
                });
            }
        };

        $(document).ready(function() {
            CampaignsIndex.getList().load();

        });

    </script>
@endsection
