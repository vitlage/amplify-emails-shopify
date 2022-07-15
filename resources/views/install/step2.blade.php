
@extends('layouts.core.install')

@section('title', trans('messages.database'))

@section('content')

    <h3 class="text-primary"><span class="material-icons-outlined">
dns
</span> Mail List</h3>
    @if (Session::has('error'))
        <div class="alert alert-danger alert-noborder">
            <p class="text-semibold">
                {{ Session::get('error') }}
            </p>
        </div>
    @endif
    @if (isset($connect_error))
        <div class="alert alert-danger alert-noborder">
            {{ $connect_error }}
        </div>
    @endif

    <form action="{{route('step_2.save')}}" method="post" class="">
        @csrf
        <h3 class="text-semibold">Identity</h3>
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="example-text-input" class=" col-form-label">Name <span class="text-danger">*</span></label>
                <input class="form-control" name="name" value="{{ old('name') }}" type="text" placeholder="User name" id="" required>
            </div>
            <div class="col-md-6">
                <label for="example-text-input" class=" col-form-label">Email <span class="text-danger">*</span></label>
                <input class="form-control" name="email" value="{{ old('email') }}" type="email" placeholder="info@example.com" id="" required>

            </div>
            <div class="col-md-6">
                <label for="example-text-input" class=" col-form-label">Default From name <span class="text-danger">*</span></label>
                <input class="form-control" name="from_name" value="{{ old('from_name') }}" type="text" placeholder="User name" id="" required>
            </div>
            <div class="col-md-6">
                <label for="example-text-input" class=" col-form-label">Default email subject <span class="text-danger">*</span></label>
                <input class="form-control" name="email_subject" type="text" value="{{ old('email_subject') }}" placeholder="Email Subject" id="" required>

            </div>
        </div>
        <h3 class="text-semibold">Contact information</h3>
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="example-text-input" class=" col-form-label">Company / Organization <span class="text-danger">*</span></label>
                <input class="form-control" name="company" type="text" placeholder="Company Name" value="{{ old('company') }}" required>
            </div>
            <div class="col-md-6">
                <label for="example-text-input" class=" col-form-label">State / Province / Region <span class="text-danger">*</span></label>
                <input class="form-control" name="state" type="text" placeholder=" State / Province / Region" value="{{ old('state') }}" required>
            </div>
            <div class="col-md-6">
                <label for="example-text-input" class=" col-form-label">Address 1 <span class="text-danger">*</span></label>
                <input class="form-control" name="address" type="text" placeholder="3728 Davis Avenue" value="{{ old('address') }}" required>
            </div>
            <div class="col-md-6">
                <label for="example-text-input" class=" col-form-label">City  <span class="text-danger">*</span></label>
                <input class="form-control" name="city" type="text" placeholder="Rochelle Park" value="{{ old('city') }}" required>
            </div>
            <div class="col-md-6">
                <label for="example-text-input" class=" col-form-label">Address 2 </label>
                <input class="form-control" name="address2" type="text" placeholder="20 Red Bud Lane" value="{{ old('address2') }}" >
            </div>
            <div class="col-md-6">
                <label for="example-text-input" class=" col-form-label">Zip / Postal code  <span class="text-danger">*</span></label>
                <input class="form-control" name="zip_code" type="text" placeholder="42716" value="{{ old('zip_code') }}" required>
            </div>
            <div class="col-md-6">
                <label for="example-text-input" class=" col-form-label">Country<span class="text-danger">*</span></label>
                <select name="country" class="form-select" required>
                    <option value="" selected disabled>Choose</option>
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
                    <option value="232">Zimbabwe</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="example-text-input" class=" col-form-label">Phone <span class="text-danger">*</span></label>
                <input class="form-control" name="phone" type="text" placeholder="+1 (349) 144-8841" value="{{ old('phone') }}" required>
            </div>
            <div class="col-md-6">
                <label for="example-text-input" class=" col-form-label">Email<span class="text-danger">*</span></label>
                <input class="form-control" name="contact_email" type="email" placeholder="info@example.com" value="{{ old('contact_email') }}" required>
            </div>
            <div class="col-md-6">
                <label for="example-text-input" class=" col-form-label">Home page</label>
                <input class="form-control" name="home_page" type="text" placeholder="https://example.com" value="{{ old('home_page') }}" >
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
        <div class="text-end">
            <button type="submit" class="btn btn-primary">{!! trans('messages.save') !!} <span class="material-icons-round">
east
</span></button>
        </div>
    </form>
@endsection
