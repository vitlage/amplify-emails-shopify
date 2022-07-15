@extends('layouts.core.backend')
@if($list !=null)
@section('title', $list->name)
@endif

@section('head')
    <script type="text/javascript" src="{{ URL::asset('core/echarts/echarts.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('core/echarts/dark.js') }}"></script>
@endsection

@section('content')
    <div class="page-title">
        <ul class="breadcrumb breadcrumb-caret position-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ trans('messages.home') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('lists') }}">{{ trans('messages.lists') }}</a></li>
        </ul>
        @if($list !=null)

        <h1 class="d-flex align-items-center">
            <span class="text-semibold mr-3">{{ $list->name }}</span>
		</span>
        </h1>
        <span class="badge badge-info bg-info-800 badge-big">
            @if(isset($statistics->subscriber_count))
                {{$statistics->subscriber_count}}
            @else
                0
            @endif
        </span> {{ trans('messages.subscribers') }}
        @endif
    </div>
    @if($list !=null)
    <div class="row">
        <div class="col-md-12">
            <ul class="nav nav-tabs nav-tabs-top nav-underline">
                <li  class="nav-item" >
                    <a href="#" class="nav-link" data-tab="#overview" data-toggle="tab">
					<span class="material-icons-outlined">auto_graph</span> {{ trans('messages.overview') }}
                    </a>
                </li>
                <li  class="nav-item" >
                    <a href="#" class="nav-link" data-tab="#subscribers" data-toggle="tab">
					<span class="material-icons-outlined">people</span> {{ trans("messages.subscribers") }}
                    </a>
                </li>
                <li  class="nav-item">
                    <a href="#" class="nav-link" data-tab="#setting"  data-toggle="tab">
					<span class="material-icons-outlined">settings</span> {{ trans('messages.setting') }}
                    </a>
                </li>


            </ul>
        </div>
    </div>

    <div id="myTabContent" class="row">
        <div class="col-md-12 tab-pane fade active show" id="overview">
            <h2 class="text-primary my-4">{{ trans('messages.list_performance') }}</h2>
            <div class="row">
                <div class="col-md-6">
                    <div class="content-group-sm">
                        <div class="d-flex">
                            <h5 class="text-semibold me-auto">{{ trans('messages.average_open_rate') }}</h5>
                            <div class="pull-right progress-right-info text-primary">{{ number_to_percentage(isset($statistics->open_uniq_rate)? $statistics->open_uniq_rate:0)}}</div>
                        </div>
                        <div class="progress progress-sm">
                            <div class="progress-bar progress-bar-striped bg-info" style="width: {{ number_to_percentage(isset($statistics->open_uniq_rate)? $statistics->open_uniq_rate:0)}}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="content-group-sm">
                        <div class="d-flex">
                            <h5 class="text-semibold me-auto">{{ trans('messages.average_click_rate') }}</h5>
                            <div class="pull-right progress-right-info text-primary">{{ number_to_percentage(isset($statistics->click_rate)? $statistics->click_rate:0) }}</div>
                        </div>
                        <div class="progress progress-sm">
                            <div class="progress-bar progress-bar-striped bg-info" style="width: {{ number_to_percentage(isset($statistics->click_rate)? $statistics->click_rate:0) }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br />
            <div class="row mt-4 mb-4">
                <div class="col-md-3">
                    <div class="bg-secondary p-3 shadow rounded-3 text-white">
                        <div class="text-center">
                            <h2 class="text-semibold mb-1 mt-0">{{ number_to_percentage(isset($statistics->subscribe_rate)? $statistics->subscribe_rate:0) }}</h2>
                            <div class="text-muted2 text-white">{{ trans('messages.avg_subscribe_rate') }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="bg-secondary p-3 shadow rounded-3 text-white">
                        <div class="text-center">
                            <h2 class="text-semibold mb-1 mt-0">{{ number_to_percentage(isset($statistics->unsubscribe_rate)? $statistics->unsubscribe_rate:0) }}</h2>
                            <div class="text-muted2 text-white">{{ trans('messages.avg_unsubscribe_rate') }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="bg-secondary p-3 shadow rounded-3 text-white">
                        <div class="text-center">
                            <h2 class="text-semibold mb-1 mt-0">{{ number_with_delimiter(isset($statistics->unsubscribe_count)? $statistics->unsubscribe_count:0) }}</h2>
                            <div class="text-muted2 text-white">{{ trans('messages.total_unsubscribers') }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="bg-secondary p-3 shadow rounded-3 text-white">
                        <div class="text-center">
                            <h2 class="text-semibold mb-1 mt-0">{{ number_with_delimiter(isset($statistics->unconfirmed_count)? $statistics->unconfirmed_count:0 )}}</h2>
                            <div class="text-muted2 text-white">{{ trans('messages.total_unconfirmed') }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <br />
            <h3 class="text-semibold text-primary">{{ trans('messages.list_growth') }}</h3>
            <div class="row">

                <div class="col-md-12">
                @if (isset($statistics->subscriber_count))
                    <!-- Basic column chart -->
                        <div class="border p-3 shadow-sm rounded">
                            <div class="">
                                <div class="chart-container">
                                    <div id="ListsGrowthChart2"
                                         class="chart has-fixed-height"
                                         style="width: 100%;height:450px;"
                                    ></div>
                                </div>
                            </div>
                        </div>
                        <!-- /basic column chart -->

                        <script>
                            var ListsGrowthChart2 = {
{{--                                url: '{{ action('MailListController@statisticsChart', $list->uid) }}',--}}
                                getChart: function() {
                                    return $('#ListsGrowthChart2');
                                },

                                showChart: function() {
                                        <?php  $myArray =[
                                            [
                                                'value' => isset($statistics->subscriber_count)? $statistics->subscriber_count:0,
                                                'name' => trans('messages.subscribed'),
                                            ],
                                            [
                                                'value' => isset($statistics->unsubscribe_count)? $statistics->unsubscribe_count:0,
                                                'name' => trans('messages.unsubscribed'),
                                            ],
                                            [
                                                'value' => isset($statistics->unconfirmed_count)? $statistics->unconfirmed_count:0,
                                                'name' => trans('messages.unconfirmed'),
                                            ]
                                        ];

                                        ?>

                                    var codes = $.parseJSON(<?php print json_encode(json_encode($myArray)); ?>);
                                    console.log(codes);
                                    ListsGrowthChart2.renderChart( codes );

                                },

                                renderChart: function(data) {
                                    // based on prepared DOM, initialize echarts instance
                                    var growthChart2 = echarts.init(ListsGrowthChart2.getChart()[0], ECHARTS_THEME);

                                    var colors = [
                                        '#5cb2b2',
                                        '#b25977',
                                        '#aab25a',
                                        '#5b7bb2',
                                        '#555555',
                                        '#626eb2',
                                        '#81ac8d',
                                        '#7d5fb2',
                                        '#b26e59'
                                    ];

                                    var cData = data.map(function(item, index) {
                                        return {
                                            name: item.name,
                                            value: item.value,
                                            itemStyle: {
                                                color: colors[index],
                                                borderWidth: 1,  borderType: 'solid', borderColor: '#fff'
                                            }
                                        };
                                    });

                                    var option = {
                                        title: {
                                            text: '{{ trans('messages.subscribers') }}',
                                            // subtext: '{{ trans('messages.statistics_chart') }}',
                                            left: 'center'
                                        },
                                        tooltip: {
                                            trigger: 'item',
                                            formatter: '{b}: {c} ({d}%)'
                                        },
                                        legend: {
                                            orient: 'vertical',
                                            left: 'right',
                                        },
                                        series: [
                                            {
                                                selectedMode: 'single',
                                                type: 'pie',
                                                radius: '70%',
                                                data: cData,
                                                emphasis: {
                                                    itemStyle: {
                                                        shadowBlur: 10,
                                                        shadowOffsetX: 0,
                                                        shadowColor: 'rgba(0, 0, 0, 0.5)'
                                                    }
                                                },
                                                label: {
                                                    // position: 'inner',
                                                    fontSize: 12,
                                                    color: ECHARTS_THEME == 'dark' ? '#fff' : null,
                                                    formatter: '{b}\n{d}% ({c})',
                                                },
                                            }
                                        ]
                                    };

                                    // use configuration item and data specified to show chart
                                    growthChart2.setOption(option);
                                }
                            }

                            ListsGrowthChart2.showChart();
                        </script>
                    @else
                        <div class="empty-chart-pie">
                            <div class="empty-list">
                    <span class="material-icons-outlined">
auto_awesome
</span>
                                <span class="line-1">
                        {{ trans('messages.log_empty_line_1') }}
                    </span>
                            </div>
                        </div>
                    @endif

                </div>
            </div>


        </div>
        <div class="col-md-12 tab-pane fade active hide" id="subscribers">
            @if ($subscribers !=null || count($subscribers)>0)
                <h2 class="text-primary me-auto"><span class="material-icons-outlined">
			people
			</span> {{ trans('messages.subscribers') }}</h2>
                <div class="listing-form subscribers-list">
                    <div class="d-flex top-list-controls top-sticky-content">
                        <div class="me-auto">
                            <div class="filter-box-1">
                        <span class="text-nowrap">
                            <input type="text" name="keyword" class="form-control search  search-item" placeholder="{{ trans('messages.type_to_search') }}" />
                            <span class="material-icons-round">search</span>
                        </span>
                            </div>
                        </div>
                    </div>
                    <div id="SubscribersIndexContent" class="pml-table-container">
                        <table id="myTableData" class="table table-box pml-table table-sub"
                               current-page=""
                        >
                            @foreach ($subscribers as $key => $item)
                                <tr>
{{--                                    @dump($item)--}}

                                    <td>
                                        <div class="d-flex">
                                            <div class="subscriber-avatar">
                                                <a href="#">
                                                    <img src="{{asset('/images/user_demo.png')}}" />
                                                </a>
                                            </div>
                                            <div class="no-margin text-bold">
                                                <a class="kq_search" href="#">
                                                    {{ $item->email }}
                                                </a>
                                                <br />
                                                <span class="label label-flat bg-{{ $item->status }}">{{ trans('messages.' . $item->status) }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="no-margin stat-num kq_search">
                                            @if(isset($item->FIRST_NAME))
                                                @if($item->FIRST_NAME!=""){{$item->FIRST_NAME }}@else{{'--'}}@endif
                                            @elseif(isset($item->first_name))
                                                @if($item->first_name!=""){{$item->first_name }}@else{{'--'}}@endif
                                            @else{{'--'}}
                                            @endif
                                        </span>
                                        <br>
                                        <span class="text-muted2">First name</span>
                                    </td>
                                    <td>
                                        <span class="no-margin stat-num kq_search">
                                            @if(isset($item->LAST_NAME))
                                                @if($item->LAST_NAME!=""){{$item->LAST_NAME }} @else{{'--'}} @endif
                                            @elseif(isset($item->last_name))
                                                @if($item->last_name!=""){{$item->last_name }}@else{{'--'}}@endif
                                            @else{{'--'}}
                                            @endif
                                        </span>
                                        <br>
                                        <span class="text-muted2">Last name</span>
                                    </td>
                                    <td>
                                        <span class="no-margin stat-num kq_search">
                                            @if(isset($item->ADDRESS))
                                                @if($item->ADDRESS!=""){{$item->ADDRESS }} @else{{'--'}} @endif
                                            @elseif(isset($item->address))
                                                @if($item->address!=""){{$item->address }}@else{{'--'}}@endif
                                            @else{{'--'}}
                                            @endif</span>
                                        <br>
                                        <span class="text-muted2">Address</span>
                                    </td>

                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>


            @else
                <div class="empty-list">
		            <span class="material-icons-outlined">
                    people
                    </span>
                    <span class="line-1">   {{ trans('messages.subscriber_empty_line_1') }}</span>
                </div>
            @endif
        </div>
        <div class="col-md-12 tab-pane fade active hide" id="setting">
            <form action="#" method="post" class="">
{{--                @csrf--}}
                <h3 class="text-semibold">Identity</h3>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="example-text-input" class=" col-form-label">Name <span class="text-danger">*</span></label>
                        <input class="form-control" name="name" type="text" placeholder="" id="example-text-input" required
                        value="{{isset($list->name)? $list->name:""}}"
                        >
                    </div>
                    <div class="col-md-6">
                        <label for="example-text-input" class=" col-form-label">Email <span class="text-danger">*</span></label>
                        <input class="form-control" name="email" type="email" placeholder="" id="example-text-input" required
                               value="{{isset($list->from_email)? $list->from_email:""}}"
                        >

                    </div>
                    <div class="col-md-6">
                        <label for="example-text-input" class=" col-form-label">Default From name <span class="text-danger">*</span></label>
                        <input class="form-control" name="from_name" type="text" placeholder="" id="example-text-input" required
                               value="{{isset($list->from_name)? $list->from_name:""}}">
                    </div>
                    <div class="col-md-6">
                        <label for="example-text-input" class=" col-form-label">Default email subject <span class="text-danger">*</span></label>
                        <input class="form-control" name="email_subject" type="text" placeholder="" id="example-text-input" required
                               value="{{isset($list->default_subject)? $list->default_subject:""}}">

                    </div>
                </div>
                <h3 class="text-semibold">Contact information</h3>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="example-text-input" class=" col-form-label">Company / Organization <span class="text-danger">*</span></label>
                        <input class="form-control" name="company" type="text" placeholder="" id="example-text-input" required
                        value="{{isset($contact->company)? $contact->company:""}}">
                    </div>
                    <div class="col-md-6">
                        <label for="example-text-input" class=" col-form-label">State / Province / Region <span class="text-danger">*</span></label>
                        <input class="form-control" name="state" type="text" placeholder="" id="example-text-input" required
                        value="{{isset($contact->state)? $contact->state:""}}">
                    </div>
                    <div class="col-md-6">
                        <label for="example-text-input" class=" col-form-label">Address 1 <span class="text-danger">*</span></label>
                        <input class="form-control" name="address" type="text" placeholder="" id="example-text-input" required
                        value="{{isset($contact->address_1)? $contact->address_1:""}}">
                    </div>
                    <div class="col-md-6">
                        <label for="example-text-input" class=" col-form-label">City  <span class="text-danger">*</span></label>
                        <input class="form-control" name="city" type="text" placeholder="" id="example-text-input" required
                        value="{{isset($contact->city)? $contact->city:""}}">
                    </div>
                    <div class="col-md-6">
                        <label for="example-text-input" class=" col-form-label">Address 2 </label>
                        <input class="form-control" name="address2" type="text" placeholder="" id="example-text-input"
                        value="{{isset($contact->address_2)? $contact->address_2:""}}">
                    </div>
                    <div class="col-md-6">
                        <label for="example-text-input" class=" col-form-label">Zip / Postal code  <span class="text-danger">*</span></label>
                        <input class="form-control" name="zip_code" type="text" placeholder="" id="example-text-input" required
                        value="{{isset($contact->zip)? $contact->zip:""}}">
                    </div>
                    <div class="col-md-6">
                        <label for="example-text-input" class=" col-form-label">Country<span class="text-danger">*</span></label>
                        <select name="country" class="form-select" required>
                            <option value="">{{isset($contact->country)? $contact->country:""}}</option>
                            {{--<option value="">Choose</option>
                            <option value="1">Afghanistan</option>
                            <option value="2">Albania</option>
                            <option value="3">Algeria</option>
                            <option value="4">American Samoa</option>
                            <option value="5">Andorra</option>
                            <option value="6">Angola</option>
                            <option value="7">Anguilla</option>
                            <option value="8">Antigua</option>
                            <option value="9">Argentina</option>
                            <option value="10">Armenia</option>
                            <option value="11">Aruba</option>
                            <option value="12">Australia</option>
                            <option value="13">Austria</option>
                            <option value="14">Azerbaijan</option>
                            <option value="15">Bahrain</option>
                            <option value="16">Bangladesh</option>
                            <option value="17">Barbados</option>
                            <option value="18">Belarus</option>
                            <option value="19">Belgium</option>
                            <option value="20">Belize</option>
                            <option value="21">Benin</option>
                            <option value="22">Bermuda</option>
                            <option value="23">Bhutan</option>
                            <option value="24">Bolivia</option>
                            <option value="25">Bosnia and Herzegovina</option>
                            <option value="26">Botswana</option>
                            <option value="27">Brazil</option>
                            <option value="28">British Indian Ocean Territory</option>
                            <option value="29">British Virgin Islands</option>
                            <option value="30">Brunei</option>
                            <option value="31">Bulgaria</option>
                            <option value="32">Burkina Faso</option>
                            <option value="33">Burma Myanmar</option>
                            <option value="34">Burundi</option>
                            <option value="35">Cambodia</option>
                            <option value="36">Cameroon</option>
                            <option value="37">Canada</option>
                            <option value="38">Cape Verde</option>
                            <option value="39">Cayman Islands</option>
                            <option value="40">Central African Republic</option>
                            <option value="41">Chad</option>
                            <option value="42">Chile</option>
                            <option value="43">China</option>
                            <option value="44">Colombia</option>
                            <option value="45">Comoros</option>
                            <option value="46">Cook Islands</option>
                            <option value="47">Costa Rica</option>
                            <option value="48">CÃ´te d'Ivoire</option>
                            <option value="49">Croatia</option>
                            <option value="50">Cuba</option>
                            <option value="51">Cyprus</option>
                            <option value="52">Czech Republic</option>
                            <option value="53">Democratic Republic of Congo</option>
                            <option value="54">Denmark</option>
                            <option value="55">Djibouti</option>
                            <option value="56">Dominica</option>
                            <option value="57">Dominican Republic</option>
                            <option value="58">Ecuador</option>
                            <option value="59">Egypt</option>
                            <option value="60">El Salvador</option>
                            <option value="61">Equatorial Guinea</option>
                            <option value="62">Eritrea</option>
                            <option value="63">Estonia</option>
                            <option value="64">Ethiopia</option>
                            <option value="65">Falkland Islands</option>
                            <option value="66">Faroe Islands</option>
                            <option value="67">Federated States of Micronesia</option>
                            <option value="68">Fiji</option>
                            <option value="69">Finland</option>
                            <option value="70">France</option>
                            <option value="71">French Guiana</option>
                            <option value="72">French Polynesia</option>
                            <option value="73">Gabon</option>
                            <option value="74">Georgia</option>
                            <option value="75">Germany</option>
                            <option value="76">Ghana</option>
                            <option value="77">Gibraltar</option>
                            <option value="78">Greece</option>
                            <option value="79">Greenland</option>
                            <option value="80">Grenada</option>
                            <option value="81">Guadeloupe</option>
                            <option value="82">Guam</option>
                            <option value="83">Guatemala</option>
                            <option value="84">Guinea</option>
                            <option value="85">Guinea-Bissau</option>
                            <option value="86">Guyana</option>
                            <option value="87">Haiti</option>
                            <option value="88">Honduras</option>
                            <option value="89">Hong Kong</option>
                            <option value="90">Hungary</option>
                            <option value="91">Iceland</option>
                            <option value="92">India</option>
                            <option value="93">Indonesia</option>
                            <option value="94">Iran</option>
                            <option value="95">Iraq</option>
                            <option value="96">Ireland</option>
                            <option value="97">Israel</option>
                            <option value="98">Italy</option>
                            <option value="99">Jamaica</option>
                            <option value="100">Japan</option>
                            <option value="101">Jordan</option>
                            <option value="102">Kazakhstan</option>
                            <option value="103">Kenya</option>
                            <option value="104">Kiribati</option>
                            <option value="105">Kosovo</option>
                            <option value="106">Kuwait</option>
                            <option value="107">Kyrgyzstan</option>
                            <option value="108">Laos</option>
                            <option value="109">Latvia</option>
                            <option value="110">Lebanon</option>
                            <option value="111">Lesotho</option>
                            <option value="112">Liberia</option>
                            <option value="113">Libya</option>
                            <option value="114">Liechtenstein</option>
                            <option value="115">Lithuania</option>
                            <option value="116">Luxembourg</option>
                            <option value="117">Macau</option>
                            <option value="118">Macedonia</option>
                            <option value="119">Madagascar</option>
                            <option value="120">Malawi</option>
                            <option value="121">Malaysia</option>
                            <option value="122">Maldives</option>
                            <option value="123">Mali</option>
                            <option value="124">Malta</option>
                            <option value="125">Marshall Islands</option>
                            <option value="126">Martinique</option>
                            <option value="127">Mauritania</option>
                            <option value="128">Mauritius</option>
                            <option value="129">Mayotte</option>
                            <option value="130">Mexico</option>
                            <option value="131">Moldova</option>
                            <option value="132">Monaco</option>
                            <option value="133">Mongolia</option>
                            <option value="134">Montenegro</option>
                            <option value="135">Montserrat</option>
                            <option value="136">Morocco</option>
                            <option value="137">Mozambique</option>
                            <option value="138">Namibia</option>
                            <option value="139">Nauru</option>
                            <option value="140">Nepal</option>
                            <option value="141">Netherlands</option>
                            <option value="142">Netherlands Antilles</option>
                            <option value="143">New Caledonia</option>
                            <option value="144">New Zealand</option>
                            <option value="145">Nicaragua</option>
                            <option value="146">Niger</option>
                            <option value="147">Nigeria</option>
                            <option value="148">Niue</option>
                            <option value="149">Norfolk Island</option>
                            <option value="150">North Korea</option>
                            <option value="151">Northern Mariana Islands</option>
                            <option value="152">Norway</option>
                            <option value="153">Oman</option>
                            <option value="154">Pakistan</option>
                            <option value="155">Palau</option>
                            <option value="156">Palestine</option>
                            <option value="157">Panama</option>
                            <option value="158">Papua New Guinea</option>
                            <option value="159">Paraguay</option>
                            <option value="160">Peru</option>
                            <option value="161">Philippines</option>
                            <option value="162">Poland</option>
                            <option value="163">Portugal</option>
                            <option value="164">Puerto Rico</option>
                            <option value="165">Qatar</option>
                            <option value="166">Republic of the Congo</option>
                            <option value="167">RÃ©union</option>
                            <option value="168">Romania</option>
                            <option value="169">Russia</option>
                            <option value="170">Rwanda</option>
                            <option value="171">Saint BarthÃ©lemy</option>
                            <option value="172">Saint Helena</option>
                            <option value="173">Saint Kitts and Nevis</option>
                            <option value="174">Saint Martin</option>
                            <option value="175">Saint Pierre and Miquelon</option>
                            <option value="176">Saint Vincent and the Grenadines</option>
                            <option value="177">Samoa</option>
                            <option value="178">San Marino</option>
                            <option value="179">SÃ£o TomÃ© and PrÃ&shy;ncipe</option>
                            <option value="180">Saudi Arabia</option>
                            <option value="181">Senegal</option>
                            <option value="182">Serbia</option>
                            <option value="183">Seychelles</option>
                            <option value="184">Sierra Leone</option>
                            <option value="185">Singapore</option>
                            <option value="186">Slovakia</option>
                            <option value="187">Slovenia</option>
                            <option value="188">Solomon Islands</option>
                            <option value="189">Somalia</option>
                            <option value="190">South Africa</option>
                            <option value="191">South Korea</option>
                            <option value="192">Spain</option>
                            <option value="193">Sri Lanka</option>
                            <option value="194">St. Lucia</option>
                            <option value="195">Sudan</option>
                            <option value="196">Suriname</option>
                            <option value="197">Swaziland</option>
                            <option value="198">Sweden</option>
                            <option value="199">Switzerland</option>
                            <option value="200">Syria</option>
                            <option value="201">Taiwan</option>
                            <option value="202">Tajikistan</option>
                            <option value="203">Tanzania</option>
                            <option value="204">Thailand</option>
                            <option value="205">The Bahamas</option>
                            <option value="206">The Gambia</option>
                            <option value="207">Timor-Leste</option>
                            <option value="208">Togo</option>
                            <option value="209">Tokelau</option>
                            <option value="210">Tonga</option>
                            <option value="211">Trinidad and Tobago</option>
                            <option value="212">Tunisia</option>
                            <option value="213">Turkey</option>
                            <option value="214">Turkmenistan</option>
                            <option value="215">Turks and Caicos Islands</option>
                            <option value="216">Tuvalu</option>
                            <option value="217">Uganda</option>
                            <option value="218">Ukraine</option>
                            <option value="219">United Arab Emirates</option>
                            <option value="220">United Kingdom</option>
                            <option value="221">United States</option>
                            <option value="222">Uruguay</option>
                            <option value="223">US Virgin Islands</option>
                            <option value="224">Uzbekistan</option>
                            <option value="225">Vanuatu</option>
                            <option value="226">Vatican City</option>
                            <option value="227">Venezuela</option>
                            <option value="228">Vietnam</option>
                            <option value="229">Wallis and Futuna</option>
                            <option value="230">Yemen</option>
                            <option value="231">Zambia</option>
                            <option value="232">Zimbabwe</option>--}}
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="example-text-input" class=" col-form-label">Phone <span class="text-danger">*</span></label>
                        <input class="form-control" name="phone" type="text" placeholder="" id="example-text-input" required
                        value="{{isset($contact->phone)? $contact->phone:""}}">
                    </div>
                    <div class="col-md-6">
                        <label for="example-text-input" class=" col-form-label">Email<span class="text-danger">*</span></label>
                        <input class="form-control" name="contact_email" type="email" placeholder="" id="example-text-input" required
                        value="{{isset($contact->email)? $contact->email:""}}">
                    </div>
                    <div class="col-md-6">
                        <label for="example-text-input" class=" col-form-label">Home page</label>
                        <input class="form-control" name="home_page" type="text" placeholder="" id="example-text-input"
                        value="{{isset($contact->url)? $contact->url:""}}">
                    </div>
                </div>
                <h3 class="text-semibold">Subscription Settings</h3>

                <div class="row mb-3">

                    <div class="col-md-4">

                        <label class="form-check-label" for="invalidCheck1">
                            <input type="checkbox" id="invalidCheck1" name="subscribe_confirmation">
                            Send subscription confirmation email (Double Opt-In)
                        </label>
                        <br>
                        <span class="text-muted">
                                                    When people subscribe to your list, send them a subscription confirmation email.
                                            </span>

                    </div>
                    <div class="col-md-4">

                        <label class="form-check-label" for="invalidCheck2">
                            <input type="checkbox" id="invalidCheck2" name="send_welcome_email">
                            Send a final welcome email
                        </label>
                        <br>
                        <span class="text-muted">
                                                When people opt-in to your list, send them an email welcoming them to your list. The final welcome email can be edited in the List -> Forms / Pages management
                                            </span>

                    </div>
                    <div class="col-md-4">
                        <label class="form-check-label" for="invalidCheck3">
                            <input type="checkbox" id="invalidCheck3" name="unsubscribe_notification">
                            Send unsubscribe notification to subscribers
                        </label>
                        <br>
                        <span class="text-muted">
                                                Send subscribers a final “Goodbye” email to let them know they have unsubscribed.
                                            </span>
                    </div>
                </div>
                <hr >
                {{--<div class="text-end">
                    <button type="submit" class="btn btn-primary">{!! trans('messages.save') !!}
                        <span class="material-icons-round">east</span>
                    </button>
                </div>--}}
            </form>

        </div>
    </div>


    <script>
        $(document).ready(function () {
            $(document).on('click','.nav-link',function() {
                var crnt_tab_id=$(this).data('tab')
                var crnt_tab= $("#myTabContent").find(crnt_tab_id);
                crnt_tab.removeClass('hide')
                crnt_tab.addClass('show')
                crnt_tab.siblings().removeClass('show')
                crnt_tab.siblings().addClass('hide')

            });
        });
    </script>
    @else
        <div class="empty-list">
		<span class="material-icons-outlined">
			auto_awesome
		</span>
            <span class="line-1">
			{{ trans('messages.list_empty_line_1') }}
		</span>
            <span class="line-2">
			{{ trans('messages.list_empty_line_2') }}
		</span>
        </div>
    @endif

@endsection
