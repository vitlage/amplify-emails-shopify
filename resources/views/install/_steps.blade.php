<style>
    .disabled {
        pointer-events:none;
    }
</style>
                <ul class="nav nav-pills campaign-steps install-steps">
                    <li class="{{ $current == 1 ? "active" : "" }} {{ $step <= 2 ? "enabled text-white" : "disabled" }}">
						<a href="{{ action("AdminController@step1") }}"
							class="rounded-top rounded-3-top"
						>
							<span class="material-icons-outlined">
                    settings
                    </span> Step 1
						</a>
					</li>
                    <li class="{{ $current == 2 ? "active" : "" }} {{ $step == 2 ? "enabled text-white" : "disabled" }}">
						<a href="{{ action("AdminController@step2") }}"
							class="rounded-top rounded-3-top"
						>
							<span class="material-icons-outlined">
                    dns
                    </span> Step 2
						</a>
					</li>


					<li class="{{ $current == 3 ? "active" : "" }} {{ $step == 3 ? "enabled" : "disabled" }}"
						class="rounded-top rounded-3-top"
					>
						<a href="{{ action("AdminController@finish") }}">
							<span class="material-icons-outlined">
                            task_alt
                            </span> {{ trans('messages.finish') }}
						</a>
					</li>
				</ul>
