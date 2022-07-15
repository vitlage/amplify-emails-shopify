@extends('layouts.core.backend')

@section('title', $campaign->name)

@section('head')
    <script type="text/javascript" src="{{ URL::asset('core/echarts/echarts.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('core/echarts/dark.js') }}"></script>
@endsection

@section('page_header')

    @include("campaigns._header")

@endsection

@section('content')

    @include("campaigns._menu")

    @include("campaigns._info")

    <br />

    @include("campaigns._chart")



{{--    @include("campaigns._open_click_rate")--}}

{{--    @include("campaigns._count_boxes")--}}

    <br />

{{--    @include("campaigns._24h_chart")--}}


    <br />

{{--    @include("campaigns._top_link")--}}

    <br />


@endsection
