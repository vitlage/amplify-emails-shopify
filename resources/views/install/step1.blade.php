
@extends('layouts.core.install')

@section('title', trans('messages.database'))

@section('content')

    <h3 class="text-primary"><span class="material-icons-outlined">
settings
</span> Amplify configuration</h3>
    @if (Session::has('error'))
        <div class="alert alert-danger alert-noborder">
            <p class="text-semibold">
                {{ Session::get('error') }}
            </p>
        </div>
    @endif
    @if (isset($connect_error))
        <div class="alert alert-danger alert-noborder">
            <p class="text-semibold">
                {{ $connect_error }}
            </p>
        </div>
    @endif

    <form action="{{route('step_1.save')}}" method="post" class="">
        @csrf

        <div class="row mb-3">
            <label for="example-text-input" class="col-sm-2 col-form-label">Api Endpoint</label>
            <div class="col-sm-10">
                <input class="form-control" name="api_end_point"  value="{{$api_end_point}}" type="text" placeholder="Enter api endpoint..." id="example-text-input" >
            </div>
        </div>
        <div class="row mb-3">
            <label for="example-text-input" class="col-sm-2 col-form-label">Api Token</label>
            <div class="col-sm-10">
                <input class="form-control" name="api_token" value="{{$api_token}}" type="text" placeholder="Enter api token..." id="example-text-input" >
            </div>
        </div>
        <hr >
        <div class="text-end">
            <button type="submit" class="btn btn-primary">{!! trans('messages.save') !!} <span class="material-icons-round">
east
</span></button>
        </div>
    </form>
@endsection
