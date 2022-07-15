<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\CampaignsListsSegment;
use App\Customer;
use App\EmailResponce;
use App\ErrorLog;
use App\Mail_list;
use App\Product;
use App\Setting;
use App\Template;
use App\TemplateCategory;
use App\TemplatesCategory;
use App\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use SendGrid\EventWebhook\EventWebhook;

class AdminController extends Controller
{

    public function index(){
        if(Auth::user()->is_setup==0){
            return redirect(route('step_1'));
        }
        cookie()->queue(cookie()->forever('custom_shopify', Auth::user()->name));
        if(Cookie::get('custom_url') != null){
            $custom_url=Cookie::get('custom_url');
//            dd($custom_url);
            cookie()->queue(cookie()->forever('custom_url', null));
            return redirect($custom_url);
        }
        $setting=Setting::where('shop_id',Auth::id())->first();
//        dd($setting);
//        $list_id="";$campaign_id='';
        try{
            $c_url=$setting->api_end_point."/campaigns";
            $c_client = new Client();
            $c_result = $c_client->request('GET',$c_url . '?api_token='.$setting->api_token,[
                'verify' => false]);
            $c_json = $c_result->getBody();
            $campaigns = json_decode($c_json, False);
//        dd($campaigns);
            /*foreach ($campaigns as $campaign){
                $campaign_id=$campaign->uid;
            }
            if($campaign_id !=''){
                $c_url2=$setting->api_end_point."/campaigns/".$campaign_id;
                $c_client2 = new Client();
                $c_result2 = $c_client2->request('GET',$c_url2 . '?api_token='.$setting->api_token,[
                    'verify' => false]);
                $c_json2 = $c_result2->getBody();
                $campaigns_2 = json_decode($c_json2, False);
            }*/


            $l_url=$setting->api_end_point."/lists";
            $l_client = new Client();
            $l_result = $l_client->request('GET',$l_url . '?api_token='.$setting->api_token,[
                'verify' => false]);
            $l_json = $l_result->getBody();
            $lists = json_decode($l_json, False);
            /*foreach ($lists as $list){
                $list_id=$list->uid;
            }
            if($list_id !=''){

                $l_url2=$setting->api_end_point."/lists/".$list_id;
                $l_client2 = new Client();
                $l_result2 = $l_client2->request('GET',$l_url2 . '?api_token='.$setting->api_token,[
                    'verify' => false]);
                $l_json2 = $l_result2->getBody();
                $lists_2 = json_decode($l_json2, False);
            }*/
        }catch (\Exception $exception){
            $lists=array();$campaigns=array();
        }
        if($campaigns==null){$campaigns=array();}
        if($lists==null){$lists=array();}

//        $campaigns=array();
//        $lists=array();
        return view('dashboard', [
            'campaigns' => $campaigns,
            'lists' => $lists,
        ]);

    }

    public function api(){
        $setting=Setting::where('shop_id',Auth::id())->first();//Auth::id();
        return view('api',compact('setting'));
    }
    public function apiUpdate(Request $request){
        $request->validate([
            'api_end_point'     =>  'required',
            'api_token'           => 'required',
        ]);

        $setting=Setting::where('shop_id',Auth::id())->first();//Auth::id();
        $setting->api_end_point=$request->input('api_end_point');
        $setting->api_token=$request->input('api_token');
        $setting->save();
        return back()->with('alert-success','Api updated!');
    }

     public function webhooks(Request $request){
//         MFkwEwYHKoZIzj0CAQYIKoZIzj0DAQcDQgAEzldrxypiLxSByZsdgUTi0Ew2j23IXJHZ5h7mJ7TJOPoAXrt3uxD9Y8d/9eqPzZN+jUEQ0+qn2jgSZBoS62/1aA==
       /* $test=ErrorLog::where('id',52)->first();
        $test=explode('.',$test->error);
        dd($test[0]);*/
         try {

             $data = json_encode($request->all());
             $curent_date= Carbon::now()->format("Y-m-d H:i:s");

             foreach (json_decode($data) as $record) {

                 $record = json_decode(json_encode($record));
                 $sg_message_id=$record->sg_message_id;
                 $sg_message_id=explode('.',$sg_message_id);
                 $message_id=$sg_message_id[0];
                 $status=$record->event;
                 $email_responce=EmailResponce::where('message_id',$message_id)->first();
                 if($email_responce !=null){
                     $email_responce->event=$status;
                     if($status=="open"){
                         $email_responce->opened_at=$curent_date;
                     }
                     if($status=="click"){
                         $email_responce->clicked_at=$curent_date;
                     }
                     $email_responce->save();
                 }

                /* $error = new ErrorLog();
                 $error->title='sendgrig Webhooks';
                 $error->error=json_encode($record);
                 $error->save();*/
             }
         }
         catch (\Exception $e){

             $error = new ErrorLog();
             $error->title='Sendgrid Webhooks';
             $error->error=$e->getMessage();
             $error->save();
         }
     }

    public function logoutPage(){
        return view('logout_page');
    }
    // Installation setup code
    public function step1(){
        Session::put('step',1);

//        dd(Session::get('step'));
        if(Session::get('step') =="finish" && Session::get('step')!= null){

            return redirect(url('/step/'.Session::get('step')));
        }
        $current=1;
        $step=Session::get('step');


        if(Session::get('step')== null){
            Session::put('step',1);
            $step=1;
        }
        if(Session::get('step') > 1){
            Session::put('step',$step);
        }
        $setting=Setting::where('shop_id',Auth::id())->first();
        if($setting==null){
            $api_end_point ="";
            $api_token= "";
        }else{
           $api_end_point =$setting->api_end_point;
           $api_token= $setting->api_token;
        }
        return view('install.step1',compact('current','step','api_end_point','api_token'));
    }
    public function saveStep1(Request $request){
        $request->validate([
            'api_end_point'     =>  'required',
            'api_token'           => 'required',
        ]);
        $url=$request->input('api_end_point')."/login-token";
        $client = new Client();
        $result = $client->request('GET',$url . '?api_token='.$request->input('api_token'),[
            'verify' => false]);
        $json = $result->getBody();
        $user = json_decode($json, False);
        if($user==null){
            $current=1;
            $step=1;
            $connect_error='Invalid Api Endpoint Or Token';
            return view('install.step1',compact('connect_error','current','step'));
        }
//        dd($user);
        $setting=Setting::where('shop_id',Auth::id())->first();//Auth::id();
        if($setting===null){
            $setting= new Setting();
            $setting->shop_id=Auth::id();
        }
        $setting->api_end_point=$request->input('api_end_point');
        $setting->api_token=$request->input('api_token');
        $setting->save();
        Session::put('step',2);

//        dd($setting);
        return redirect(route('step_2'));
    }
    public function step2(){
        if(Session::get('step')!=2){
            return redirect(url('/step/'.Session::get('step')));
        }
        $current=2;
        $step=Session::get('step');
//        dd(Session::get('step'));
        return view('install.step2',compact('current','step'));

    }
    public function saveStep2(Request $request){
//        dd($request->all());
        if($request->input('subscribe_confirmation') && $request->input('subscribe_confirmation')=="on"){
            $subscribe_confirmation=1;
        }else{
            $subscribe_confirmation=0;
        }
        if($request->input('send_welcome_email') && $request->input('send_welcome_email')=="on"){
            $send_welcome_email=0;
        }else{
            $send_welcome_email=0;
        }
        if($request->input('unsubscribe_notification') && $request->input('unsubscribe_notification')=="on"){
            $unsubscribe_notification=0;
        }else{
            $unsubscribe_notification=0;
        }
        $setting=Setting::where('shop_id',Auth::id())->first();

        // create list
        try{
            $url=$setting->api_end_point."/lists";
            $client = new Client();
            $result = $client->request('POST',$url . '?api_token='.$setting->api_token,[
                'verify' => false,
                'form_params' => [
                    'name' => $request->input('name'),
                    'from_email' => $request->input('email'),
                    'from_name' => $request->input('from_name'),
                    'default_subject' => $request->input('email_subject'),
                    'contact[company]' => $request->input('company'),
                    'contact[state]' => $request->input('state'),
                    'contact[address_1]' => $request->input('address'),
                    'contact[address_2]' => $request->input('address2'),
                    'contact[city]' => $request->input('city'),
                    'contact[zip]' => $request->input('zip_code'),
                    'contact[phone]' => $request->input('phone'),
                    'contact[country_id]' => $request->input('country'),
                    'contact[email]' => $request->input('contact_email'),
                    'contact[url]' => $request->input('home_page'),
                    'subscribe_confirmation' => $subscribe_confirmation,
                    'send_welcome_email' => $send_welcome_email,
                    'unsubscribe_notification' => $unsubscribe_notification
                ]
            ]);
            $json = $result->getBody();
            $jsonResultToArray = json_decode($json, TRUE);
//         dd($jsonResultToArray['list_uid']);
            $list_uid = $jsonResultToArray['list_uid'];
            $new_list = Mail_list::where('uid', $list_uid)->first();
            if ($new_list == null) {
                $new_list = new Mail_list;
                $new_list->uid = $list_uid;

                $new_list->name = $request->input('name');
                $new_list->default_subject = $request->input('default_subject');
                $new_list->from_email = $request->input('from_email');
                $new_list->from_name = $request->input('from_name');
                $new_list->company = $request->input('company');
                $new_list->state = $request->input('state');
                $new_list->address_1 = $request->input('address');
                $new_list->address_2 = $request->input('address2');
                $new_list->city = $request->input('city');
                $new_list->zip = $request->input('zip_code');
                $new_list->phone = $request->input('phone');
                $new_list->country_id = $request->input('country');
                $new_list->contact_email = $request->input('contact_email');
                $new_list->home_page_url = $request->input('home_page');
                $new_list->subscribe_confirmation = $subscribe_confirmation;
                $new_list->send_welcome_email = $send_welcome_email;
                $new_list->unsubscribe_notification = $unsubscribe_notification;
                $new_list->is_custom = 1;

                $new_list->shop_id = Auth::id();
                $new_list->save();
            }
//        "list_uid" => "6193bc18e5fcd"
            // send customers to list
//        $list_uid = "619497d9e3221";
            $customers=Customer::where(['shop_id'=>Auth::id(),'is_shopify'=>1])->get();
            if($customers){
                foreach ($customers as $customer) {
                    if($customer->email){
                        DB::insert('insert into customer_lists (customer_id, list_id) values (?, ?)', [$customer->id, $new_list->id]);
                        $url2 = $setting->api_end_point . "/subscribers";
                        $client2 = new Client();
                        $result2 = $client2->request('POST', $url2 . '?api_token=' . $setting->api_token, [
                            'verify' => false,
                            'form_params' => [
                                'list_uid' => $list_uid,
                                'EMAIL' => $customer->email,
                                'tag' => '',
                                'FIRST_NAME' => $customer->first_name,
                                'LAST_NAME' => $customer->last_name
                            ]
                        ]);
                    }

                }
            }
            /*$json2 = $result2->getBody();
                   $jsonResultToArray2 = json_decode($json2, TRUE);
                   dd($jsonResultToArray2);*/
        }catch (\Exception $e){
            $error=explode('response:',(str_replace(["'","\n"],"",$e->getMessage())));
            if(isset($error[1])) {
                $error = str_replace(["[", "]"], "", $error[1]);


//            $error = $error[1];
//            $error = str_replace(['"'],'',$error);
                $error_m = (json_decode($error));
//            dd($error);
                $contact_url = "contact.url";
                if (isset($error_m->$contact_url)) {
                    $error = "The Home page url format is invalid. Please enter url like https://example.com";
                }
            }else{
                $error = (json_encode($error));
            }
            return redirect(url('/step/'.Session::get('step')))->with('error',$error);
        }
        Session::put('step',"finish");
        return redirect(route('finish'));

    }
    public function finish (){
        if(Session::get('step')!="finish"){
            return redirect(url('/step/'.Session::get('step')));
        }
        $user=Auth::user();
        $user->is_setup=1;
        $user->save();
        $current=3;
        $step=3;
        return view('install.finish',compact('current','step'));
    }
    // setup code end here


    public function AppUninstall($shop){

        $campaigns=Campaign::where('shop_id',$shop->id)->get();
        foreach ($campaigns as $campaign){
            EmailResponce::where('campaign_id',$campaign->id)->delete();
            CampaignsListsSegment::where('campaign_id',$campaign->id)->delete();
        }

        $customers=Customer::where('shop_id',$shop->id)->delete();
        $maillist=Mail_list::where('shop_id',$shop->id)->delete();
        $product=Product::where('shop_id',$shop->id)->delete();
        $setting=Setting::where('shop_id',$shop->id)->delete();
        $templates=Template::where('customer_id',$shop->id)->get();
        if($templates){
            foreach ($templates as $template){
                TemplatesCategory::where('template_id',$template->id)->delete();
            }
        }


        User::where('id',$shop->id)->forceDelete();
    }
}
