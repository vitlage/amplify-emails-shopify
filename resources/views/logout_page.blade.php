@extends('layouts.core.demo')

@section('content')
<center>
    <div class="text-center login-header" style="width: 500px;">
        <a class="main-logo-big" href="#">
{{--            <img src="{{ URL::asset('images/logo_big.svg') }}" alt="">--}}
            <img src="{{ URL::asset('images/amplify_logo.png') }}" alt="">

        </a>
        <form class="card " method="get" action="{{ route('home') }}" autocomplete="off">
            {{--            @csrf--}}
            <div class="card-body">
                <h2 class="card-title text-center mb-4">Enter your shop domain to Login or Install this app.</h2>
                <div class="mb-3">
                    <input id="shop" type="text" class="form-control @error('shop') is-invalid @enderror" name="shop" value="{{ old('shop') }}"
                           placeholder="example.myshopify.com"    required  autofocus>

                    @error('shop')
                    {{ $message }}
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>

                <div class="form-footer">
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </div>
            </div>

        </form>
    </div>

</center>
@endsection
