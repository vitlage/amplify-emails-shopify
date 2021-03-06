<nav class="navbar navbar-expand-xl navbar-dark fixed-top navbar-main py-0 navbar-backend">
    <div class="container-fluid ms-0">
        <a class="navbar-brand d-flex align-items-center me-2" href="/">
            {{--@if (\Acelle\Model\Setting::get('site_logo_small'))
                <img class="logo" src="{{ action('SettingController@file', \Acelle\Model\Setting::get('site_logo_small')) }}" alt="">
            @else--}}
				{{--<span class="default-app-logo">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 389.3 60.1"><g id="Layer_2" data-name="Layer 2"><g id="Layer_1-2" data-name="Layer 1"><g id="Layer_2-2" data-name="Layer 2"><g id="Layer_1-2-2" data-name="Layer 1-2"><path d="M38.5,56.4,36.7,43.8H16.9l-7,12.6H0L29.6,6h9.8l8,50.4ZM33.1,16V13.6h-.2a18,18,0,0,1-1.6,3.8L20.6,36.7H35.7l-2.4-19A9.9,9.9,0,0,1,33.1,16Z" style="fill:#fff"/><path d="M82.7,28.9A13.5,13.5,0,0,0,79.4,27a13.2,13.2,0,0,0-4.4-.8,10.4,10.4,0,0,0-6.1,2,14.7,14.7,0,0,0-4.5,5.7,17.5,17.5,0,0,0-1.8,7.8c0,2.9.7,5.1,2,6.6a7,7,0,0,0,5.6,2.3,12.2,12.2,0,0,0,4.6-.9,22.6,22.6,0,0,0,4.4-2.2l-1.5,7.2a22.4,22.4,0,0,1-9.9,2.6c-4.3,0-7.6-1.3-10.1-3.9s-3.6-6.3-3.6-10.9a26,26,0,0,1,2.7-11.6,19.9,19.9,0,0,1,7.6-8.4,20.2,20.2,0,0,1,10.9-3,22.2,22.2,0,0,1,5.1.6,19.7,19.7,0,0,1,4,1.6Z" style="fill:#fff"/><path d="M118.6,29.3a10,10,0,0,1-6,9.5c-4.1,2.1-10.2,3.2-18.4,3.3v1.1a7.4,7.4,0,0,0,2.2,5.6,8.6,8.6,0,0,0,6.1,2.1,22,22,0,0,0,5.7-1,39.9,39.9,0,0,0,5.6-2.5l-1.4,7a25,25,0,0,1-11.7,2.9c-4.7,0-8.3-1.3-10.9-3.9s-4-6.3-4-11a25.6,25.6,0,0,1,2.7-11.5A20.7,20.7,0,0,1,96,22.6a18.4,18.4,0,0,1,10.4-3.1q5.7,0,9,2.7A8.8,8.8,0,0,1,118.6,29.3Zm-8.2.2a3.7,3.7,0,0,0-1.3-2.8,4.9,4.9,0,0,0-3.5-1.1,9.8,9.8,0,0,0-6.8,3.1,15.7,15.7,0,0,0-4,7.5c10.4,0,15.6-2.2,15.6-6.7Z" style="fill:#fff"/><path d="M130.6,57c-2.6,0-4.6-.6-6-1.9a7.5,7.5,0,0,1-2-5.5,60.1,60.1,0,0,1,1.3-8.5c.9-4.1,3.6-16.8,8.1-38h8.6l-8.5,40a35.4,35.4,0,0,0-.8,4.5c0,1.8,1,2.7,3.1,2.7a8.7,8.7,0,0,0,3.2-.6l-1.3,6.5A22.4,22.4,0,0,1,130.6,57Z" style="fill:#fff"/><path d="M151.3,57c-2.6,0-4.6-.6-5.9-1.9a7.1,7.1,0,0,1-2-5.5,48.5,48.5,0,0,1,1.3-8.5c.9-4.1,3.6-16.8,8.1-38h8.5l-8.5,40a23.4,23.4,0,0,0-.7,4.5q0,2.7,3,2.7a8.7,8.7,0,0,0,3.2-.6L157,56.2A22.4,22.4,0,0,1,151.3,57Z" style="fill:#fff"/><path d="M196.3,29.3a10,10,0,0,1-6,9.5c-4,2.1-10.2,3.2-18.4,3.3v1.1a7.3,7.3,0,0,0,2.1,5.6,8.6,8.6,0,0,0,6.1,2.1,22,22,0,0,0,5.7-1,28.1,28.1,0,0,0,5.6-2.5l-1.4,7a25,25,0,0,1-11.7,2.9c-4.7,0-8.3-1.3-10.9-3.9s-3.9-6.3-3.9-11a26.9,26.9,0,0,1,2.6-11.5,20.7,20.7,0,0,1,7.5-8.3,18.7,18.7,0,0,1,10.5-3.1c3.7,0,6.7.9,8.9,2.7A8.5,8.5,0,0,1,196.3,29.3Zm-8.2.2a3.2,3.2,0,0,0-1.3-2.8,4.9,4.9,0,0,0-3.5-1.1,9.8,9.8,0,0,0-6.8,3.1,14.7,14.7,0,0,0-3.9,7.5C182.9,36.2,188.1,34,188.1,29.5Z" style="fill:#fff"/><path d="M339.6,59.2h-8.7a17.3,17.3,0,0,1,.3-3.2,22,22,0,0,1,.4-3.6h-.2a28.9,28.9,0,0,1-3.8,4.7,12.4,12.4,0,0,1-3.4,2.2,12.6,12.6,0,0,1-4.3.8,9.1,9.1,0,0,1-7.9-3.7c-1.9-2.4-2.9-5.7-2.9-10A25.6,25.6,0,0,1,312.2,34a19.9,19.9,0,0,1,8.2-8.8,23.9,23.9,0,0,1,12-2.9A68.3,68.3,0,0,1,345.9,24l-5,23.5c-.3,1.6-.6,3.7-.9,6.1A52.7,52.7,0,0,0,339.6,59.2Zm-3.3-30a15.7,15.7,0,0,0-4.8-.5,12.8,12.8,0,0,0-7.1,2.1,14.4,14.4,0,0,0-4.9,6.3,22.5,22.5,0,0,0-1.8,8.9,9.2,9.2,0,0,0,1.3,5.4,4.5,4.5,0,0,0,4,1.9c2.5,0,4.8-1.3,6.8-3.9a26.4,26.4,0,0,0,4.4-10.5Z" style="fill:#fff"/><path d="M358.6,59.8a8.3,8.3,0,0,1-5.9-2,7.1,7.1,0,0,1-2-5.5,14.7,14.7,0,0,1,.4-3.6l5.2-25.5h8.5l-4.7,22.7a35.4,35.4,0,0,0-.8,4.5c0,1.8,1,2.7,3.1,2.7a8.7,8.7,0,0,0,3.2-.6L364.2,59A21,21,0,0,1,358.6,59.8ZM368.1,11a4.7,4.7,0,0,1-1.5,3.5,5.5,5.5,0,0,1-3.7,1.4,4.5,4.5,0,0,1-3.5-1.3,3.9,3.9,0,0,1-1.5-3.3,3.9,3.9,0,0,1,1.6-3.5,5,5,0,0,1,3.7-1.3,5.5,5.5,0,0,1,3.5,1.2A4.7,4.7,0,0,1,368.1,11Z" style="fill:#fff"/><path d="M379.3,59.8a8.3,8.3,0,0,1-5.9-2,6.9,6.9,0,0,1-2.1-5.4,48.6,48.6,0,0,1,1.4-8.5c.9-4.1,3.6-16.8,8.1-38h8.5l-8.5,40a23.4,23.4,0,0,0-.7,4.5q0,2.7,3,2.7a8.7,8.7,0,0,0,3.2-.6L385,59A22.4,22.4,0,0,1,379.3,59.8Z" style="fill:#fff"/><path d="M307.4.1,310,3.3c-.1.4-.1.7-.2,1.1l-.2.6L297.9,59.1H284.5l10.4-44L266.1,44.8l-4.2-.6L246.7,16.9c-3.6,14-7.1,28-10.7,42.1l-11.6.2,14-54.8c.3-1.5.7-2.9,1.5-3.4h10.2c-.3-.8-.2-.6-.1-.4s1.3,2.5,1.9,3.8l.4.6c4.5,8.9,9.1,17.7,13.7,26.5L291.7,5l.6-.6L296.5.1Z" style="fill:#fff"/><path d="M310,3.5a2.9,2.9,0,0,0-.2.9H238.4l.4-1.8A3.4,3.4,0,0,1,242.1,0h65.1a2.9,2.9,0,0,1,2.9,2.9C310.1,3.1,310,3.3,310,3.5Z" style="fill:#fff"/><path d="M228.9,14.7H203.3a2.5,2.5,0,0,1,0-5h25.6a2.5,2.5,0,0,1,0,5Z" style="fill:#fff"/><path d="M225.3,28.7H213.5a2.5,2.5,0,0,1,0-5h11.8a2.5,2.5,0,0,1,0,5Z" style="fill:#fff"/><path d="M221.9,42.7h-3.1a2.5,2.5,0,0,1,0-5h3.1a2.5,2.5,0,0,1,0,5Z" style="fill:#fff"/></g></g></g></g></svg>
				</span>--}}
            <img class="logo" src="{{ URL::asset('images/amplify_logo.png') }}" alt="">
            {{--            @endif--}}
        </a>
        <button class="navbar-toggler" role="button" data-bs-toggle="collapse" data-bs-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

		<span class="leftbar-hide-menu middle-bar-element">
            <svg class="SideBurgerIcon-image" viewBox="0 0 50 32"><path d="M49,4H19c-0.6,0-1-0.4-1-1s0.4-1,1-1h30c0.6,0,1,0.4,1,1S49.6,4,49,4z"></path><path d="M49,16H19c-0.6,0-1-0.4-1-1s0.4-1,1-1h30c0.6,0,1,0.4,1,1S49.6,16,49,16z"></path><path d="M49,28H19c-0.6,0-1-0.4-1-1s0.4-1,1-1h30c0.6,0,1,0.4,1,1S49.6,28,49,28z"></path><path d="M8.1,22.8c-0.3,0-0.5-0.1-0.7-0.3L0.7,15l6.7-7.8c0.4-0.4,1-0.5,1.4-0.1c0.4,0.4,0.5,1,0.1,1.4L3.3,15l5.5,6.2   c0.4,0.4,0.3,1-0.1,1.4C8.6,22.7,8.4,22.8,8.1,22.8z"></path></svg>
        </span>

        <div class="collapse navbar-collapse" id="navbarsExample04">
            <ul class="navbar-nav me-auto mb-md-0 main-menu">
                <li class="nav-item" rel0="HomeController">
					<a href="{{route('home')}}" class="nav-link lvl-1 d-flex align-items-center @if (request()->is('/')) active @endif">
						<i class="navbar-icon">
							<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 92.1 86.1"><g id="Layer_2" data-name="Layer 2"><g id="Layer_1-2" data-name="Layer 1"><g id="Layer_2-2" data-name="Layer 2"><g id="Layer_1-2-2" data-name="Layer 1-2"><path d="M51.8,86.1H41.9a8.5,8.5,0,0,1-8.5-8.5V60.2a8.5,8.5,0,0,1,8.5-8.5h9.9a8.5,8.5,0,0,1,8.5,8.5V77.6A8.5,8.5,0,0,1,51.8,86.1ZM41.9,58.7a1.5,1.5,0,0,0-1.5,1.5V77.6a1.5,1.5,0,0,0,1.5,1.5h9.9a1.5,1.5,0,0,0,1.5-1.5V60.2a1.5,1.5,0,0,0-1.5-1.5Z" style="fill:aqua"/><path d="M60.4,86.1H31.7A20.6,20.6,0,0,1,11.2,65.7V24.6h7V65.7A13.5,13.5,0,0,0,31.7,79.1H60.4A13.5,13.5,0,0,0,73.9,65.7V25.3h7V65.7A20.6,20.6,0,0,1,60.4,86.1Z" style="fill:#f2f2f2"/><path d="M88.6,36.5a3.6,3.6,0,0,1-2-.6L45.7,7.7,5.5,35.1a3.5,3.5,0,1,1-4-5.8L43.7.6a3.6,3.6,0,0,1,4,0L90.6,30.1a3.5,3.5,0,0,1-2,6.4Z" style="fill:#f2f2f2"/></g></g></g></g></svg>
						</i>
						<span>{{ trans('messages.dashboard') }}</span>
					</a>
				</li>
                <li class="nav-item active" rel0="CampaignController">
                    <a title="Campaigns" href="{{route('campaigns')}}" class="leftbar-tooltip nav-link d-flex align-items-center py-3 lvl-1 @if (request()->is('campaigns')) active @endif">
                        <i class="navbar-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 106.1 92.1"><g id="Layer_2" data-name="Layer 2"><g id="Layer_1-2" data-name="Layer 1"><g id="Layer_2-2" data-name="Layer 2"><g id="Layer_1-2-2" data-name="Layer 1-2"><path d="M40.8,92.1h-.1a5.2,5.2,0,0,1-5.1-4.8c-1.4-4.5-2.7-9-4-13.4S29,65.3,27.8,61L3.2,50.4a.1.1,0,0,0-.1-.1A5.7,5.7,0,0,1,.5,47.8a5.6,5.6,0,0,1,2.6-7.4.1.1,0,0,0,.1-.1c16-6.8,31.7-13.2,46.9-19.3S82.2,8,98.9.8a4.5,4.5,0,0,1,5.7.4,4.6,4.6,0,0,1,1.5,4.1l-5.4,38.1C99,56.1,97.2,68.8,95.4,81.6a5.5,5.5,0,0,1-2,3.7,5.6,5.6,0,0,1-4.1,1.4l-1.4-.3h-.2L52.1,71.2c-2.2,6-4.2,11.3-6,16.4A5.4,5.4,0,0,1,40.8,92.1ZM9.3,45.4,31.6,55a4.8,4.8,0,0,1,2.6,3c1.3,4.6,2.7,9.2,4.1,13.9L41,81q2.7-7.2,5.7-15.6l.2-.3.2-.4c.1-.2.2-.5.4-.6L89.2,12.6C76.8,17.8,64.6,22.7,52.7,27.5,38.6,33.2,24.1,39.1,9.3,45.4ZM55.6,65.2,88.7,79.1l5.1-36.6L98,12.8ZM27.5,59.9h0Z" style="fill:#f2f2f2"></path><path d="M40.1,54.6a3.6,3.6,0,0,1-2.2-6.3l2-1.6a3.6,3.6,0,0,1,5,.6,3.5,3.5,0,0,1-.6,4.9l-2,1.6A3.5,3.5,0,0,1,40.1,54.6Z" style="fill:#ff0"></path><path d="M52.4,45.2a3.5,3.5,0,0,1-2.7-1.4,3.4,3.4,0,0,1,.6-4.9L63.4,28.6a3.5,3.5,0,0,1,4.3,5.5L54.6,44.4A3.7,3.7,0,0,1,52.4,45.2Z" style="fill:aqua"></path></g></g></g></g></svg>
                        </i>
                        <span>Campaigns</span>
                    </a>
                </li>
                <li class="nav-item active" rel0="MailListController">
                    <a href="{{route('lists')}}" title="Lists" class="leftbar-tooltip nav-link d-flex align-items-center py-3 lvl-1 @if (request()->is('lists')) active @endif">
                        <i class="navbar-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 86.3 87.8"><g id="Layer_2" data-name="Layer 2"><g id="Layer_1-2" data-name="Layer 1"><g id="Layer_2-2" data-name="Layer 2"><g id="Layer_1-2-2" data-name="Layer 1-2"><g id="Layer_2-2-2" data-name="Layer 2-2"><g id="Layer_1-2-2-2" data-name="Layer 1-2-2"><g id="Layer_2-2-2-2" data-name="Layer 2-2-2"><g id="Layer_1-2-2-2-2" data-name="Layer 1-2-2-2"><path d="M62.5,49.5A13.1,13.1,0,1,1,75.6,36.4,13.1,13.1,0,0,1,62.5,49.5Zm0-18.8a5.8,5.8,0,1,0,5.8,5.7A5.8,5.8,0,0,0,62.5,30.7Z" style="fill:#f2f2f2"></path><path d="M42.6,87.5h-.1a3.5,3.5,0,0,1-3.4-3.6c.4-10.4,4.5-20,10.8-25.6a18.4,18.4,0,0,1,14.2-4.9C76.6,54.5,85.5,66.8,86,83.9a3.3,3.3,0,0,1-3.3,3.6A3.5,3.5,0,0,1,79,84.2c-.4-13.3-6.8-23.1-15.6-23.9a12.1,12.1,0,0,0-8.9,3.3c-4.9,4.3-8,12-8.4,20.6A3.4,3.4,0,0,1,42.6,87.5Z" style="fill:#f2f2f2"></path><path d="M82.5,87.5H42.6A3.5,3.5,0,0,1,39.1,84a3.5,3.5,0,0,1,3.5-3.5H82.5A3.5,3.5,0,0,1,86,84,3.4,3.4,0,0,1,82.5,87.5Z" style="fill:#f2f2f2"></path><path d="M28.9,87.8H15.6C7,87.8,0,81.9,0,74.6V13.1C0,5.9,7,0,15.6,0h55c8.7,0,15.7,5.9,15.7,13.1V24.6a3.8,3.8,0,1,1-7.5,0V13.1c0-3-3.7-5.6-8.2-5.6h-55c-4.3,0-8.1,2.6-8.1,5.6V74.6c0,3.1,3.8,5.7,8.1,5.7H28.9a3.8,3.8,0,1,1,0,7.5Z" style="fill:#f2f2f2"></path><path d="M44.2,30.5H23.4A3.5,3.5,0,0,1,19.9,27a3.5,3.5,0,0,1,3.5-3.5H44.2A3.5,3.5,0,0,1,47.7,27,3.4,3.4,0,0,1,44.2,30.5Z" style="fill:#f2f2f2"></path><path d="M28.9,47.8H23.4a3.5,3.5,0,0,1-3.5-3.5,3.5,3.5,0,0,1,3.5-3.5h5.5a3.5,3.5,0,0,1,3.5,3.5A3.4,3.4,0,0,1,28.9,47.8Z" style="fill:#ff0"></path><path d="M27.7,65.1H23.4a3.5,3.5,0,0,1-3.5-3.5,3.5,3.5,0,0,1,3.5-3.5h4.3a3.5,3.5,0,0,1,3.5,3.5A3.4,3.4,0,0,1,27.7,65.1Z" style="fill:#f2f2f2"></path><polygon points="43.7 55.8 40.3 54.5 37.2 56.6 37.4 52.9 34.4 50.7 38 49.7 39.2 46.2 41.2 49.3 44.9 49.3 42.6 52.3 43.7 55.8" style="fill:lime"></polygon><path d="M37.2,57.1H37a.5.5,0,0,1-.3-.5l.2-3.4-2.8-2.1c-.1-.1-.2-.3-.1-.4s.1-.4.3-.4l3.4-1,1.1-3.2c0-.2.2-.3.4-.4a.5.5,0,0,1,.5.3l1.8,2.8h3.4a.9.9,0,0,1,.5.3c.1.2.1.4-.1.5l-2.1,2.8,1,3.3a.4.4,0,0,1-.1.5c-.2.1-.4.2-.5.1l-3.2-1.2-2.9,2Zm-1.6-6.2,2.1,1.6a.4.4,0,0,1,.2.5v2.7l2.3-1.6a.3.3,0,0,1,.4,0L43,55l-.8-2.5a.5.5,0,0,1,0-.5l1.7-2.2H41.2a.4.4,0,0,1-.4-.2l-1.4-2.2-.9,2.5a.3.3,0,0,1-.3.3Z" style="fill:lime"></path></g></g></g></g></g></g></g></g></svg>
                        </i>
                        <span>Lists</span>
                    </a>
                </li>


                <li class="nav-item active" rel0="MailListController">
                    <a href="{{route('templates')}}" title="Templates" class="leftbar-tooltip nav-link d-flex align-items-center py-3 lvl-1 @if (request()->is('templates')) active @endif">
                        <i class="navbar-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 86.3 87.8"><g id="Layer_2" data-name="Layer 2"><g id="Layer_1-2" data-name="Layer 1"><g id="Layer_2-2" data-name="Layer 2"><g id="Layer_1-2-2" data-name="Layer 1-2"><g id="Layer_2-2-2" data-name="Layer 2-2"><g id="Layer_1-2-2-2" data-name="Layer 1-2-2"><g id="Layer_2-2-2-2" data-name="Layer 2-2-2"><g id="Layer_1-2-2-2-2" data-name="Layer 1-2-2-2"><path d="M62.5,49.5A13.1,13.1,0,1,1,75.6,36.4,13.1,13.1,0,0,1,62.5,49.5Zm0-18.8a5.8,5.8,0,1,0,5.8,5.7A5.8,5.8,0,0,0,62.5,30.7Z" style="fill:#f2f2f2"></path><path d="M42.6,87.5h-.1a3.5,3.5,0,0,1-3.4-3.6c.4-10.4,4.5-20,10.8-25.6a18.4,18.4,0,0,1,14.2-4.9C76.6,54.5,85.5,66.8,86,83.9a3.3,3.3,0,0,1-3.3,3.6A3.5,3.5,0,0,1,79,84.2c-.4-13.3-6.8-23.1-15.6-23.9a12.1,12.1,0,0,0-8.9,3.3c-4.9,4.3-8,12-8.4,20.6A3.4,3.4,0,0,1,42.6,87.5Z" style="fill:#f2f2f2"></path><path d="M82.5,87.5H42.6A3.5,3.5,0,0,1,39.1,84a3.5,3.5,0,0,1,3.5-3.5H82.5A3.5,3.5,0,0,1,86,84,3.4,3.4,0,0,1,82.5,87.5Z" style="fill:#f2f2f2"></path><path d="M28.9,87.8H15.6C7,87.8,0,81.9,0,74.6V13.1C0,5.9,7,0,15.6,0h55c8.7,0,15.7,5.9,15.7,13.1V24.6a3.8,3.8,0,1,1-7.5,0V13.1c0-3-3.7-5.6-8.2-5.6h-55c-4.3,0-8.1,2.6-8.1,5.6V74.6c0,3.1,3.8,5.7,8.1,5.7H28.9a3.8,3.8,0,1,1,0,7.5Z" style="fill:#f2f2f2"></path><path d="M44.2,30.5H23.4A3.5,3.5,0,0,1,19.9,27a3.5,3.5,0,0,1,3.5-3.5H44.2A3.5,3.5,0,0,1,47.7,27,3.4,3.4,0,0,1,44.2,30.5Z" style="fill:#f2f2f2"></path><path d="M28.9,47.8H23.4a3.5,3.5,0,0,1-3.5-3.5,3.5,3.5,0,0,1,3.5-3.5h5.5a3.5,3.5,0,0,1,3.5,3.5A3.4,3.4,0,0,1,28.9,47.8Z" style="fill:#ff0"></path><path d="M27.7,65.1H23.4a3.5,3.5,0,0,1-3.5-3.5,3.5,3.5,0,0,1,3.5-3.5h4.3a3.5,3.5,0,0,1,3.5,3.5A3.4,3.4,0,0,1,27.7,65.1Z" style="fill:#f2f2f2"></path><polygon points="43.7 55.8 40.3 54.5 37.2 56.6 37.4 52.9 34.4 50.7 38 49.7 39.2 46.2 41.2 49.3 44.9 49.3 42.6 52.3 43.7 55.8" style="fill:lime"></polygon><path d="M37.2,57.1H37a.5.5,0,0,1-.3-.5l.2-3.4-2.8-2.1c-.1-.1-.2-.3-.1-.4s.1-.4.3-.4l3.4-1,1.1-3.2c0-.2.2-.3.4-.4a.5.5,0,0,1,.5.3l1.8,2.8h3.4a.9.9,0,0,1,.5.3c.1.2.1.4-.1.5l-2.1,2.8,1,3.3a.4.4,0,0,1-.1.5c-.2.1-.4.2-.5.1l-3.2-1.2-2.9,2Zm-1.6-6.2,2.1,1.6a.4.4,0,0,1,.2.5v2.7l2.3-1.6a.3.3,0,0,1,.4,0L43,55l-.8-2.5a.5.5,0,0,1,0-.5l1.7-2.2H41.2a.4.4,0,0,1-.4-.2l-1.4-2.2-.9,2.5a.3.3,0,0,1-.3.3Z" style="fill:lime"></path></g></g></g></g></g></g></g></g></svg>
                        </i>
                        <span>Template</span>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a href="" title="Content" class="leftbar-tooltip nav-link d-flex align-items-center py-3 lvl-1 dropdown-toggle" id="content-menu" data-bs-toggle="dropdown" aria-expanded="false" >
                        <i class="navbar-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 744.6 736.4"><g id="Layer_2" data-name="Layer 2"><g id="Layer_1-2" data-name="Layer 1"><g id="Layer_2-2" data-name="Layer 2"><g id="Layer_1-2-2" data-name="Layer 1-2"><path d="M633.8,736.4h-523A110.9,110.9,0,0,1,0,625.6V110.8A110.9,110.9,0,0,1,110.8,0H369.7a74,74,0,0,1,73.9,73.9v54a18.9,18.9,0,0,0,18.9,18.9H670.7a74.1,74.1,0,0,1,73.9,73.9h0V625.6A110.9,110.9,0,0,1,633.8,736.4ZM110.8,55A55.8,55.8,0,0,0,55,110.8V625.6a55.8,55.8,0,0,0,55.8,55.8h523a55.9,55.9,0,0,0,55.8-55.8V220.7a18.9,18.9,0,0,0-18.9-18.9H462.5a74,74,0,0,1-73.9-73.9v-54A18.9,18.9,0,0,0,369.7,55Z" style="fill:#f2f2f2"></path><path d="M572.2,405.9H172.3a27.5,27.5,0,0,1,0-55H572.2a27.5,27.5,0,0,1,0,55Z" style="fill:#f2f2f2"></path><path d="M572.2,582.1H172.3a27.5,27.5,0,0,1,0-55H572.2a27.5,27.5,0,0,1,0,55Z" style="fill:#f2f2f2"></path><path d="M286.2,251.6H151.7a27.5,27.5,0,1,1,0-55H286.2a27.5,27.5,0,0,1,0,55Z" style="fill:#f0bdad"></path></g></g></g></g></svg>
                        </i>
                        <span>Content</span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="content-menu">
                        <li class="nav-item" rel0="ProductController">
                            <a class="dropdown-item d-flex align-items-center" href="{{route('products')}}" @if (request()->is('products')) active @endif>
                                <i class="navbar-icon" style="">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 88.3 71.5" style="enable-background:new 0 0 88.3 71.5;" xml:space="preserve"> <style type="text/css"> .st0{fill:#93A8C1;}.st1{fill:#414042;}</style> <g id="Layer_2_1_"> <g id="Layer_1-2"> <rect x="18.4" y="48" class="st0" width="52.5" height="10.1"></rect> <rect x="18.4" y="30.8" class="st0" width="52.5" height="10.1"></rect> <path class="st1" d="M71.3,71.5C71.3,71.5,71.3,71.5,71.3,71.5L17.7,71c-0.6,0-1.2-0.3-1.7-0.7s-0.7-1.1-0.7-1.7l0.9-38l-4.4,2.7 c-0.6,0.4-1.3,0.5-1.9,0.3c-0.6-0.2-1.2-0.6-1.5-1.2c-2.7-5.5-5.4-11-8.2-16.5c-0.4-0.9-0.3-1.9,0.3-2.6c4.4-5.1,10-9.1,16.3-11.4 c4.7-1.6,7.7-1.5,13.6-1.3c3,0.1,6.8,0.2,12.2,0.2c6.2-0.1,10.4-0.3,13.5-0.5c5.3-0.3,8-0.5,12.5,0.8c7.3,2.2,13.8,6.3,19,11.9 c0.6,0.7,0.8,1.7,0.4,2.6L80.6,32c-0.3,0.6-0.8,1.1-1.4,1.3c-0.6,0.2-1.3,0.1-1.9-0.2l-4.7-2.7l1.1,38.7c0,0.6-0.2,1.3-0.7,1.7 C72.6,71.2,72,71.5,71.3,71.5z M20.1,66.2l48.7,0.5l-1.2-40.5c0-0.9,0.4-1.7,1.2-2.1c0.7-0.4,1.7-0.5,2.4,0l6.1,3.5L83,15 c-4.4-4.4-9.8-7.6-15.7-9.4C63.6,4.6,61.5,4.7,56.4,5C53.3,5.2,49,5.4,42.7,5.5c-5.5,0-9.3-0.1-12.4-0.2c-5.8-0.2-8-0.3-11.8,1.1 c-5,1.8-9.6,4.9-13.3,8.8c2.1,4.2,4.2,8.5,6.3,12.7l5.9-3.7c0.7-0.5,1.7-0.5,2.4,0c0.8,0.4,1.2,1.3,1.2,2.1L20.1,66.2z"></path> <path class="st1" d="M44.4,18c-3.5,0-6.9-1.6-10-4.8c-2.6-2.8-4.2-6.3-4.5-10c-0.1-1.3,0.8-2.5,2.1-2.6c1.3-0.1,2.5,0.8,2.6,2.1 c0.3,2.6,1.4,5.2,3.2,7.1c0.9,0.9,3.5,3.6,7,3.3c3.9-0.3,6.4-3.9,7.5-6.1c0.8-1.5,1.3-3.2,1.6-4.9c0.2-1.3,1.4-2.2,2.7-2 c1.3,0.2,2.2,1.4,2,2.7c-0.3,2.2-1,4.3-2.1,6.3c-2.7,5.3-6.8,8.4-11.4,8.7C44.9,18,44.7,18,44.4,18z"></path> </g> </g> </svg>
                                </i>
                                <span>Products</span>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
            <div class="navbar-right">
                <ul class="navbar-nav me-auto mb-md-0">
{{--                    @include('layouts.core._top_notifications')--}}

                    @include('layouts.core._menu_backend_user')
                </ul>
            </div>
        </div>
    </div>
</nav>

<script>

    $(function() {
        //
        $('.leftbar .leftbar-hide-menu').on('click', function(e) {
            if (!$('.leftbar').hasClass('leftbar-closed')) {
                $('.leftbar').addClass('leftbar-closed');

                // MenuFrontend.saveLeftbarState('closed');
            } else {
                $('.leftbar').removeClass('leftbar-closed');

                // MenuFrontend.saveLeftbarState('open');
            }
        });
    });
</script>
