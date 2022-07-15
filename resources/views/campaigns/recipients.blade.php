@extends('layouts.core.backend')

@section('title', trans('messages.campaigns') . " - " . trans('messages.recipients'))

@section('head')
    <script type="text/javascript" src="{{ URL::asset('core/js/group-manager.js') }}"></script>
@endsection

@section('page_header')



    <div class="page-title">
        <ul class="breadcrumb breadcrumb-caret position-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ trans('messages.home') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('campaigns') }}">{{ trans('messages.campaigns') }}</a></li>
        </ul>
        <h1>
            <span class="text-semibold"><span class="material-icons-outlined me-2">
forward_to_inbox
</span> {{ $campaign->name }}</span>
        </h1>

        @include('campaigns._steps', ['current' => 1])
    </div>

@endsection

@section('content')
    <form action="{{ action('CampaignController@recipients', $campaign->id) }}" method="POST" class="form-validate-jqueryz recipients-form">
        {{ csrf_field() }}
        <input type="hidden" name="uid" value="{{$campaign->uid}}">

        <h4 class="mb-20 mt-0">
            {{ trans('messages.choose_lists_segments_for_the_campaign') }}
        </h4>

       {{-- <div class="addable-multiple-form">
--}}{{--
            <div class="addable-multiple-container campaign-list-segments">
                <?php $num = 0
                ?>


                @foreach ($campaign->getListsSegmentsGroups() as $index =>  $lists_segment_group)


                    @include('campaigns._list_segment_form', [
                        'lists_segment_group' => $lists_segment_group,
                        'index' => $num,
                    ])
                    <?php $num++ ?>


                @endforeach
            </div>
--}}{{--
            <br />
            --}}{{-- <a
                sample-url="{{ action('CampaignController@listSegmentForm', $campaign->id) }}"
                href="#add_condition" class="btn btn-secondary add-form">
                <span class="material-icons-outlined">
add
</span> {{ trans('messages.add_list_segment') }}
            </a> --}}{{--
        </div>--}}
        <div class="addable-multiple-form" >
            <div class="addable-multiple-container campaign-list-segments" >
                <div class="condition-line" rel="0" >
                    <div class="row list-segment-container">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Set as default list</label>
                                <div>
                                    <input type="hidden" name="lists_segments[0][is_default]" value="false">
                                    <div class="form-group control-radio">
                                        <div class="radio tooltipstered" data-popup="tooltip">
                                            <label>
                                                <input radio-group="campaign_list_info_defaulf" checked="" type="radio" name="lists_segments[0][is_default]" value="true" class="styled  ">
                                                Default
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 list_select_box" target-box="segments-select-box" segments-url="#">
                            <div class="form-group control-select">
                                <label>
                                    To which list shall we send?
                                </label>

                                <select name="lists_segments[0][mail_list_uid]" class="select " tabindex="-1" aria-hidden="true" required>
                                    <option value="" selected disabled>Choose</option>
                                    @foreach ($show_list as $list )

                                        <option value="{{$list->id}}"  {{($list->id==$campaign->default_mail_list_id)?"selected":""}}>{{$list->name}} ({{$list->has_subscriber_count}})</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                        <div class="col-md-5 segments-select-box multiple"></div>
                        <div class="col-md-1 pt-28 del-col">
                            <a onclick="$(this).parents('.condition-line').remove()" href="#delete" class="btn bg-danger-400"><span class="material-icons-outlined">
delete_outline
</span></a>
                        </div>
                    </div>
                </div>


            </div>

        </div>

        <hr>

        <div class="text-end">
            <button class="btn btn-secondary">{{ trans('messages.save_and_next') }} <span class="material-icons-outlined">
arrow_forward
</span> </button>
        </div>
    <form>

    <script>
        var CampaignsReciepientsSegment = {
			manager: null,

            rowToGroup: function(row) {
                return {
                    listSelect: row.find('.list-select'),
                    url: row.find('.list-select').closest('.list_select_box').attr("segments-url"),
                    segmentSelect: row.find('.segments-select-box'),
                    getVal: function() {
                        return row.find('.list-select').val();
                    },
                    index: row.closest('.condition-line').attr('rel')
                }
            },

            addRow: function(row) {
                group = this.rowToGroup(row);
                this.getManager().add(group);

                this.groupAction(group);
            },

            groupAction: function(group) {
                group.check = function() {
                    if(group.getVal() !== '') {
                        $.ajax({
                            method: "GET",
                            url: group.url,
                            data: {
                                list_uid: group.getVal(),
                                index: group.index
                            }
                        })
                        .done(function( res ) {
                            group.segmentSelect.html(res);

                            initJs(group.segmentSelect);
                        });
                    } else {
                        group.segmentSelect.html('');
                    }
                }

                group.listSelect.on('change', function() {
                    group.check();
                });
            },

			getManager: function() {
				if (this.manager == null) {
					this.manager = new GroupManager();

					$('.condition-line').each(function() {
						var row = $(this);

						CampaignsReciepientsSegment.addRow(row);
					});
				}

				return this.manager;
			},

			check: function() {
				this.getManager().groups.forEach(function(group) {
					group.check();
				});
			}
		}

        $(function() {
            CampaignsReciepientsSegment.getManager();


            $('.recipients-form').submit(function(e) {
                if (!$('[radio-group=campaign_list_info_defaulf]:checked').length) {
                    new Dialog('alert', {
                        message: '{{ trans('messages.recipients.select_default_list.warning') }}',
                    });

                    e.preventDefault();
                    return false;
                }
            });

            // addable multiple form
            $(document).on("click", ".addable-multiple-form .add-form", function(e) {
                var form = $(this).parents('.addable-multiple-form');
                var container = form.find('.addable-multiple-container');
                var status = $(this).attr('automation-status');

                if(status == 'active') {
                    //show disable automation confirm
                    $('#disable_automation_confirm').modal('show');
                    return;
                }

                // ajax update custom sort
                $.ajax({
                    method: "GET",
                    url: $(this).attr('sample-url'),
                })
                .done(function( msg ) {
                    var num = "0";

                    if(container.find('.condition-line').length) {
                        num = parseInt(container.find('.condition-line').last().attr("rel"))+1;
                    }

                    msg = msg.replace(/__index__/g, num);

                    container.append(msg);

                    var new_line = container.find('.condition-line').last();

                    if(new_line.find('.event-campaigns-container').length) {
                        loadAutomationEmail(new_line.find('.event-campaigns-container'));
                    }

                    initJs(new_line);

                    CampaignsReciepientsSegment.addRow(new_line);
                });
            });

            // radio group check
            $(document).on('change', '[radio-group]', function() {
                var checked = $(this).is(':checked');
                var group = $(this).attr('radio-group');

                if(checked) {
                    $('[radio-group="' + group + '"]').prop('checked', false);
                    $(this).prop('checked', true);
                }
            });
        });

        function loadAutomationEmail(container) {
            var url = container.attr('data-url');

            $.ajax({
                method: "GET",
                url: url
            })
            .done(function( data ) {
                container.html(data);
            });
        }
    </script>
@endsection
