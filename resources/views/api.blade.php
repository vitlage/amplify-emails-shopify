@extends('layouts.core.backend')

@section('title', trans('messages.api_token'))



@section('content')
    <div class="page-title">
        <ul class="breadcrumb breadcrumb-caret position-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ trans('messages.home') }}</a></li>
            <li class="breadcrumb-item active">{{ trans('messages.api_token') }}</li>

        </ul>
        <h1>
            <span class="material-icons-round">
                vpn_key
                </span> {{ trans('messages.api') }}</span>
        </h1>
    </div>
    <div class="row">
        @if (isset($connect_error))
            <div class="alert alert-danger">
                {{ $connect_error }}
            </div>
        @endif

        <form action="{{route('api.update')}}" method="post" class="">
            @csrf

            <div class="row mb-3">
                <label for="example-text-input" class="col-sm-2 col-form-label">Api Endpoint</label>
                <div class="col-sm-10">
                    <input class="form-control" name="api_end_point" type="text" placeholder="Enter api endpoint..." id="example-text-input"
                    value="{{$setting->api_end_point}}">
                </div>
            </div>
            <div class="row mb-3">
                <label for="example-text-input" class="col-sm-2 col-form-label">Api Token</label>
                <div class="col-sm-10">
                    <input class="form-control" name="api_token" type="text" placeholder="Enter api token..." id="example-text-input"
                           value="{{$setting->api_token}}">
                </div>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-primary">{!! trans('messages.update') !!} </button>
            </div>
        </form>
    </div>

@endsection
