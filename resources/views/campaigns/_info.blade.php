<h2 class="mt-4 mb-4">
    <span class="text-teal text-bold">{{ count($campaign->defaultMailList->has_subscriber) }}</span>
    {{ trans('messages.' . \App\Library\Tool::getPluralPrase('recipient', count($campaign->defaultMailList->has_subscriber))) }}
</h2>

<div class="row fs-7">
    <div class="col-md-6 campaigns-summary">
        <div class="mb-2">
            <span class="text-bold d-inline-block text-end pe-3" style="width:120px">
                <span class="label bg-light">{{ trans('messages.from') }} <span class="material-icons-outlined">
                    alternate_email
                    </span></span>
            </span>
            @if (is_object($campaign->defaultMailList))
                <a href="{{ action('ListController@overview', $campaign->defaultMailList->uid) }}">
                    {{ $campaign->defaultMailList->name }}
                </a>
            @else
                {{ $campaign->defaultMailList->name }}
            @endif
        </div>
        <div class="mb-2">
            <span class="text-bold d-inline-block text-end pe-3" style="width:120px">
                <span class="label bg-light">{{ trans('messages.subject') }} <span class="material-icons-outlined">
                    subject
                    </span></span></span>
            {{ $campaign->subject }}
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
                <span class="label bg-light">{{ trans('messages.reply_to') }} <span class="material-icons-outlined">
                    alternate_email
                    </span></span></span>
            <a href="mailto:{{ $campaign->reply_to }}">{{ $campaign->reply_to }}</a>
        </div>
        <div class="mb-2">
            <span class="text-bold d-inline-block text-end pe-3" style="width:120px">
                <span class="label bg-light">{{ trans('messages.updated_at') }} <span class="material-icons-outlined">
                    event
                    </span></span></span>
            {{\Illuminate\Support\Carbon::parse($campaign->updated_at)->toDateTimeString()}}
        </div>
        <div class="mb-2">
            <span class="text-bold d-inline-block text-end pe-3" style="width:120px">
                <span class="label bg-light">{{ trans('messages.run_at') }} <span class="material-icons-outlined">
                    event
                    </span></span></span>
            {{ isset($campaign->run_at) ? \Illuminate\Support\Carbon::parse($campaign->run_at)->toDateTimeString() : "" }}
        </div>
        <div class="mb-2">
            <span class="text-bold d-inline-block text-end pe-3" style="width:120px">
                <span class="label bg-light">{{ trans('messages.delivery_at') }} <span class="material-icons-outlined">
                    event
                    </span></span></span>
            {{ isset($campaign->delivery_at) ? \Illuminate\Support\Carbon::parse($campaign->delivery_at)->toDateTimeString() : "" }}
        </div>
    </div>
</div>
