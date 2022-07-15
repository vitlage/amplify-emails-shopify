@extends('layouts.core.install')

@section('title', trans('messages.finish'))

@section('content')

    @if (Session::has('error'))
        <div class="alert alert-danger alert-noborder">
            <p class="text-semibold">
                {{ Session::get('error') }}
            </p>
        </div>
    @endif

        <h4 class="text-primary fw-600 mb-3"><span class="material-icons-outlined me-2">
task_alt
</span> Congratulations, you've successfully installed Acelle Email Marketing Application (AcelleMail)</h4>

        <br /><br />
        Now, you can go to your Admin Panel at <a class="text-semibold" href="{{ route('home') }}">{{ route('home') }}</a>
        <br /><br />

        Thank you for chosing AcelleMail.
        <div class="clearfix"><!-- --></div>
<br />

@endsection
