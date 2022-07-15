@if (count($campaigns) > 0)
    <table id="myTableData" class="table table-box pml-table mt-2"
           current-page="{{ empty(request()->page) ? 1 : empty(request()->page) }}"
    >
        @foreach ($campaigns as $key => $campaign)
{{--            @dd($campaigns->uid)--}}
            <tr>
                {{--<td width="1%">
                    <div class="text-nowrap">
                        <div class="checkbox inline">
                            <label>
                                <input type="checkbox" class="node styled"
                                       name="uids[]"
                                       value="{{ $campaigns->uid }}"
                                />
                            </label>
                        </div>
                    </div>
                </td>--}}
                <td>
                    <h5 class="text-bold mb-1">
                        <a class="kq_search" href="{{ route('campaigns.overview', $campaign->uid) }}">
                            {{ $campaign->name }}
                        </a>
                    </h5>
                    <span class="text-muted">{{ trans('messages.' . $campaign->type   ) }}</span>
                    <span class="text-muted2 d-block">{{ trans('messages.updated_at') }}: {{ \Illuminate\Support\Carbon::parse( $campaign->updated_at)->toFormattedDateString() }}</span>
                </td>
                {{--<td>{{ $campaigns->from_name }}</td>
                <td>{{ $campaigns->from_email }}</td>--}}
                <td width="15%" class="text-center">
					<span class="text-muted2 list-status pull-left" title='' data-popup='tooltip'>
{{--						<span class="label label-flat bg-{{ $campaign->status }}">{{ trans('messages.campaign_status_' . $campaign->status) }}</span>--}}
						<span class="label label-flat bg-{{ $campaign->status }}">{{ ucwords($campaign->status) }}</span>
                    </span>

                </td>
                <td class="text-end text-nowrap">

                    <div class="d-flex align-items-center text-nowrap justify-content-end">
                        @if ($campaign->status=='new')
                            <a href="{{ action('CampaignController@edit', $campaign->uid) }}" role="button"
                               class="btn btn-secondary btn-icon ms-1"> <span class="material-icons-outlined">
                        edit
                        </span> {{ trans('messages.edit') }}</a>
                        @else
                            <a href="{{ route('campaigns.overview', $campaign->uid) }}" data-popup="tooltip"
                               title="{{ trans('messages.overview') }}" role="button"
                               class="btn btn-primary btn-icon ms-1"
                            >
                                <i class="icon-stats-growth"></i> {{ trans('messages.campaigns.overview_statistics') }}</a>
                        @endif
                    </div>
                </td>
            </tr>
        @endforeach
    </table>
{{--    @include('elements/_per_page_select', ["items" => $campaigns])--}}


    <script>
        var CampaignsList = {
            copyPopup: null,

            getCopyPopup: function() {
                if (this.copyPopup === null) {
                    this.copyPopup = new Popup();
                }

                return this.copyPopup;
            }
        }

        var CampaignsResendPopup = {
            popup: null,

            load: function(url) {
                if (this.popup == null) {
                    this.popup = new Popup({
                        url: url
                    });
                }
                this.popup.load({
                    url: url
                });
            }
        }

        var CampaignsSendTestEmailPopup = {
            popup: null,

            load: function(url) {
                if (this.popup == null) {
                    this.popup = new Popup({
                        url: url
                    });
                }
                this.popup.load({
                    url: url
                });
            }
        }

        $('.resend-campaigns').click(function(e) {
            e.preventDefault();

            var url = $(this).attr('href');

            CampaignsResendPopup.load(url);
        });

        $('.copy-campaigns-button').on('click', function(e) {
            e.preventDefault();
            var url = $(this).attr('href');

            CampaignsList.getCopyPopup().load({
                url: url
            });
        });

        $('.send-a-test-email-link').on('click', function(e) {
            e.preventDefault();
            var url = $(this).attr('href');

            CampaignsSendTestEmailPopup.load(url);
        });
    </script>



@elseif (!empty(request()->keyword))
    <div class="empty-list">
		<span class="material-icons-outlined">
			auto_awesome
			</span>
        <span class="line-1">
			{{ trans('messages.no_search_result') }}
		</span>
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
