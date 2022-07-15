@extends('layouts.core.backend')

@section('title', trans('messages.campaigns') . " - " . trans('messages.setup'))

@section('head')
    <script type="text/javascript" src="{{ URL::asset('core/js/group-manager.js') }}"></script>
@endsection

@section('page_header')

	<div class="page-title">
		<ul class="breadcrumb breadcrumb-caret position-right">
			<li class="breadcrumb-item"><a href="{{ route('home') }}">{{ trans('messages.home') }}</a></li>
			<li class="breadcrumb-item"><a href="{{ action("CampaignController@index") }}">{{ trans('messages.campaigns') }}</a></li>
		</ul>
		<h1>
			<span class="text-semibold"><span class="material-icons-outlined me-2 me-2">
forward_to_inbox
</span> {{ $campaign->name }}</span>
		</h1>

		@include('campaigns._steps', ['current' => 2])
	</div>

@endsection

@section('content')
	<form action="{{ action('CampaignController@setup', $campaign->uid) }}" method="POST" class="form-validate-jqueryz">
		{{ csrf_field() }}
        <input id="uid" value="{{$campaign->uid}}" type="hidden" name="uid" class="form-control required">

        <div class="row">
            <div class="col-md-6 list_select_box" target-box="segments-select-box" segments-url="https://demo.acellemail.com/segments/select_box">
                <div class="form-group control-text">
                    <label>
                        Name your campaign
                        <span class="text-danger">*</span>
                    </label>


                    <input id="name" placeholder="" value="{{$campaign->name}}" type="text" name="name" class="form-control required" required>



                    <div class="help alert alert-info">
                        Give your campaign a name
                    </div>


                </div>

                <div class="form-group control-text">
                    <label>
                        Email subject
                        <span class="text-danger">*</span>
                    </label>


                    <input id="subject" placeholder="" value="{{$campaign->subject}}" type="text" name="subject" class="form-control required  " required>



                    <div class="help alert alert-info">
                        When it comes to email marketing, the best subject lines tell what's inside instead of sell what's inside.
                    </div>


                </div>

                <div class="form-group control-text">
                    <label>
                        From name
                        <span class="text-danger">*</span>
                    </label>


                    <input id="from_name" placeholder="" value="{{$campaign->from_name}}" type="text" name="from_name" class="form-control required  " required>



                    <div class="help alert alert-info">
                        Use something subscribers will instantly recognize, like your company name.
                    </div>


                </div>

                <div class="hiddable-box" data-control="[name=use_default_sending_server_from_email]" data-hide-value="1">
                    <div class="form-group control-autofill">
                        <label>
                            From email
                            <span class="text-danger">*</span>
                        </label>


                        <div id="sender_from_input">
                            <input id="from_email" placeholder="" value="{{$campaign->from_email}}" type="text" name="from_email" class="form-control required email  " required>
{{--                            <div class="autofill-dropbox-container autofill-dropbox-container-_5nuf6eoz7 hide"><h5 class="header text-warning">No identity matches your FROM email address</h5><ul class="autofill-dropbox autofill-dropbox-_5nuf6eoz7"><li class=""><a class="autofill-item-empty text-center" href="javascript:;"><label>(empty)</label></a></li></ul></div><div class="helper-block autofill-error alert alert-warning">The email address you entered is not verified yet. Please choose one that matches the suggested list or click <a href="https://demo.acellemail.com/senders" target="blank"><strong>here</strong></a> to verify.</div></div>--}}



                        {{--<div class="help alert alert-info">
                            FROM header of your email, also the identity of the sender. Use an email address that does match one of your verified domains to make it more likely that your email reaches recipient's INBOX
                        </div>--}}
                        </div>

                    </div>
                </div>

                {{--<div class="form-group control-checkbox2">


                    <input type="hidden" name="use_default_sending_server_from_email" value="0">

                    <div class="checkbox inline text-semibold  ">
                        <label>
        <span class="d-flex align-items-center">
            <input name="use_default_sending_server_from_email" value="1" class="styled me-2   " type="checkbox">
            <span style="padding-top: 3px" class="ms-2">Use sending server's default value</span>
        </span>
                        </label>
                    </div>
                </div>--}}

                <div class="form-group control-autofill">
                    <label>
                        Reply to
                        <span class="text-danger">*</span>
                    </label>


                    <div id="sender_reply_to_input">
                        <input id="reply_to" placeholder="" value="{{$campaign->reply_to}}" type="text" name="reply_to" class="form-control required email" required>
{{--                        <div class="autofill-dropbox-container autofill-dropbox-container-_2pyg307wg hide"><h5 class="header text-warning">No identity matches your REPLY TO email address</h5><ul class="autofill-dropbox autofill-dropbox-_2pyg307wg"><li class=""><a class="autofill-item-empty text-center" href="javascript:;"><label>(empty)</label></a></li></ul></div><div class="helper-block autofill-error alert alert-warning">The email address you entered is not verified yet.</div></div>--}}
                </div>

            </div>
            {{--<div class="col-md-6 segments-select-box">
                <div class="form-group checkbox-right-switch">
                    <!-- value="" will result in value="", so it is safe to set it to 0 in case of false -->
                    <input type="hidden" name="track_open" value="0">
                    <div class="d-flex">

                        <div style="width:100%"><label>

                                Track opens


                                <span class="checkbox-description">
						Discover who opens your campaigns by tracking the number of times an invisible web beacon embedded in the campaign is downloaded.
					</span>

                            </label></div>

                        <div class="d-flex align-items-top">
                            <label><input checked="" type="checkbox" name="track_open" value="1" class="switchery  " data-on-text="On" data-off-text="Off" data-on-color="success" data-off-color="default"><span class="check-symbol"></span></label>
                        </div>
                    </div>




                    <!-- value="" will result in value="", so it is safe to set it to 0 in case of false -->
                    <input type="hidden" name="track_click" value="0">
                    <div class="d-flex">

                        <div style="width:100%"><label>

                                Track clicks


                                <span class="checkbox-description">
						Discover which campaign links were clicked, how many times they were clicked, and who did the clicking.
					</span>

                            </label></div>

                        <div class="d-flex align-items-top">
                            <label><input checked="" type="checkbox" name="track_click" value="1" class="switchery  " data-on-text="On" data-off-text="Off" data-on-color="success" data-off-color="default"><span class="check-symbol"></span></label>
                        </div>
                    </div>




                    <!-- value="" will result in value="", so it is safe to set it to 0 in case of false -->
                    <input type="hidden" name="sign_dkim" value="0">
                    <div class="d-flex">

                        <div style="width:100%"><label>

                                Add DKIM signature


                                <span class="checkbox-description">
						Sign your email with your sending domain (if any), telling receiving email servers that your email is actually coming from you. This is to help establish the authenticity of your email, improving delivery rate.
					</span>

                            </label></div>

                        <div class="d-flex align-items-top">
                            <label><input checked="" type="checkbox" name="sign_dkim" value="1" class="switchery  " data-on-text="On" data-off-text="Off" data-on-color="success" data-off-color="default"><span class="check-symbol"></span></label>
                        </div>
                    </div>



                    <!-- value="" will result in value="", so it is safe to set it to 0 in case of false -->
                    <input type="hidden" name="custom_tracking_domain" value="0">
                    <div class="d-flex">

                        <div style="width:100%"><label>

                                Custom Tracking Domain


                                <span class="checkbox-description">
						Using a tracking domain causes all the links and URLs in your emails to be overwritten as if they come from your own brand's domain (rather than from this application hostname), making your email more authentic and more likely to reach recipients INBOX.
					</span>

                            </label></div>

                        <div class="d-flex align-items-top">
                            <label><input type="checkbox" name="custom_tracking_domain" value="1" class="switchery  " data-on-text="On" data-off-text="Off" data-on-color="success" data-off-color="default"><span class="check-symbol"></span></label>
                        </div>
                    </div>




                    <div class="select-tracking-domain" style="display: none;">
                        <div class="form-group control-select">


                            <select name="tracking_domain_uid" class="select select-search select2-hidden-accessible" data-select2-id="1" tabindex="-1" aria-hidden="true">
                                <option value="" data-select2-id="3">Select tracking domain</option>
                            </select><span class="select2 select2-container select2-container--default" dir="ltr" data-select2-id="2" style="width: 180px;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-disabled="false" aria-labelledby="select2-tracking_domain_uid-42-container"><span class="select2-selection__rendered" id="select2-tracking_domain_uid-42-container" role="textbox" aria-readonly="true" title="Select tracking domain">Select tracking domain</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>



                            <div class="help alert alert-info">
                                Rewrite all tracking links to use the domain you choose
                            </div>


                        </div>
                    </div>

                </div>
            </div>--}}
        </div>
		<hr>
		<div class="text-end  unverified_next_but">
			<button class="btn btn-secondary">{{ trans('messages.save_and_next') }} <span class="material-icons-outlined">
arrow_forward
</span> </button>
		</div>

	<form>

	<script>
		var CampaignsSetupNextButton = {
			manager: null,

			getManager: function() {
				if (this.manager == null) {
					this.manager = new GroupManager();
					this.manager.add({
						isError: function() {
							return $('.autofill-error:visible').length;
						},
						nextButton: $('.unverified_next_but'),
						inputs: $('[name=reply_to], [name=from_email]')
					});

					this.manager.bind(function(group) {
						group.check = function() {
							if (!group.isError()) {
								group.nextButton.removeClass('pointer-events-none');
								group.nextButton.removeClass('disabled');
							} else {
								group.nextButton.addClass('pointer-events-none');
								group.nextButton.addClass('disabled');
							}
						}

						group.check();

						group.inputs.on('change keyup', function() {
							group.check();
						});
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
			CampaignsSetupNextButton.check();





			// @Legacy
			// auto fill
			var box = $('#sender_from_input').autofill({
				messages: {
					header_found: '{{ trans('messages.sending_identity') }}',
					header_not_found: '{{ trans('messages.sending_identity.not_found.header') }}'
				},
				callback: function() {
					CampaignsSetupNextButton.check();
				}
			});
			box.loadDropbox(function() {
				$('#sender_from_input').focusout();
				box.updateErrorMessage();
			})

			// auto fill 2
			var box2 = $('#sender_reply_to_input').autofill({
				messages: {
					header_found: '{{ trans('messages.sending_identity') }}',
					header_not_found: '{{ trans('messages.sending_identity.reply.not_found.header') }}'
				},
				callback: function() {
					CampaignsSetupNextButton.check();
				}
			});
			box2.loadDropbox(function() {
				$('#sender_reply_to_input').focusout();
				box2.updateErrorMessage();
			})

			$('[name="from_email"]').blur(function() {
				$('[name="reply_to"]').val($(this).val()).change();
			});
			$('[name="from_email"]').change(function() {
				$('[name="reply_to"]').val($(this).val()).change();
			});

			// select custom tracking domain
			$('[name=custom_tracking_domain]').change(function() {
				var value = $('[name=custom_tracking_domain]:checked').val();

				if (value) {
					$('.select-tracking-domain').show();
				} else {
					$('.select-tracking-domain').hide();
				}
			});
			$('[name=custom_tracking_domain]').change();

			// legacy
			$('.hiddable-box').each(function() {
				var box = $(this);
				var control = $(box.attr('data-control'));
				var hide_value = box.attr('data-hide-value');

				control.change(function() {
					var val;

					control.each(function() {
						if ($(this).is(':checked')) {
							val = $(this).val();
						}
					});

					if(hide_value == val) {
						box.addClass('hide');
					} else {
						box.removeClass('hide');
					}
				});

				control.change();
			});
		})
	</script>

@endsection
