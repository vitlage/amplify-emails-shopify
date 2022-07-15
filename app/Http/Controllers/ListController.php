<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Mail_list;
use App\Setting;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use stdClass;
class ListController extends Controller
{

    public function index(){

        return view('lists.index');
    }
    public function listing(Request $request)
    {

        $setting=Setting::where('shop_id',Auth::id())->first();
        try {
            $url = $setting->api_end_point . "/lists";

            $client = new Client();
            $result2 = $client->request('GET', $url . '?api_token=' . $setting->api_token, [
                'verify' => false]);
            $json = $result2->getBody();

            $lists = json_decode($json, False);

            // dd($lists);
            $user = Auth::user();
// return json_encode($lists);
//         dd($lists);
            foreach ($lists as $getlist) {
//                dd($getlist);
                $list = Mail_list::where('uid', $getlist->uid)->first();
                if ($list == null) {
                    $list = new Mail_list;
                    $list->uid = $getlist->uid;

                    $list->name = $getlist->name;
                    $list->default_subject = $getlist->default_subject;
                    $list->from_email = $getlist->from_email;
                    $list->from_name = $getlist->from_name;
                    $list->created_at = $getlist->created_at;
                    $list->updated_at = $getlist->updated_at;

                    $list->shop_id = $user->id;
                    $list->save();
                }
                $url2=$setting->api_end_point."/subscribers/";
                $client2 = new Client();
                $result2 = $client2->request('GET',$url2 . '?api_token='.$setting->api_token.'&list_uid='.$getlist->uid.'&per_page=10000&page=1',[
                    'verify' => false
                ]);
                $json2 = $result2->getBody();
                $subscribers = json_decode($json2, False);
//                dd($subscribers);
                $subscribers_ids=array();
                foreach ($subscribers as $subscriber) {
//                    dd($subscriber);
                    $customer = Customer::where('email', $subscriber->email)->first();
                    if ($customer == null) {
                        $customer = new Customer();
                        $customer->customer_id = $subscriber->uid;
                        $customer->shop_id = $user->id;

                        $customer->first_name = $subscriber->FIRST_NAME;
                        $customer->last_name = $subscriber->LAST_NAME;
                        $customer->email = $subscriber->email;
                        $customer->status = $subscriber->status;
                        $customer->address = isset($subscriber->ADDRESS)?$subscriber->ADDRESS:'';

                        $customer->save();
                    }
                    array_push($subscribers_ids,$customer->id);

                }
                $list->has_subscriber()->sync($subscribers_ids);

            }


        } catch (\Exception $exception) {
//            dd($exception);
        }

        //        dd($lists);
        $lists=Mail_list::where('shop_id',Auth::id())->get();

        return view('lists._list', [
            'lists' => $lists,
        ]);
    }

    public function create(Request $request)
    {
        // Generate info

        $s_customers=Customer::where('shop_id',Auth::id())->where('is_shopify',1)->get();
        $o_customers=Customer::where('shop_id',Auth::id())->where('is_shopify',0)->get();
        return view('lists.create',compact('s_customers','o_customers'));
    }

    public function store(Request $request){
//        dd($request->all());
        $user=Auth::user();
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
//        dd($jsonResultToArray);

        $list_uid = $jsonResultToArray['list_uid'];
        $url=$setting->api_end_point."/lists/".$list_uid;
        $client = new Client();
        $result = $client->request('GET',$url . '?api_token='.$setting->api_token,[
            'verify' => false]);
        $json = $result->getBody();
        $lists = json_decode($json, False);
        $list =       $lists->list;
//        dd($list->uid);

        $new_list = Mail_list::where('uid', $list_uid)->first();
        if ($new_list == null) {
            $new_list = new Mail_list;
            $new_list->uid = $list_uid;

            $new_list->name = $request->input('name');
            $new_list->default_subject = $request->input('email_subject');
            $new_list->from_email = $request->input('email');
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

            $new_list->shop_id = $user->id;
            $new_list->save();
            $new_list->has_subscriber()->sync($request->subscriber);
        }
        // send customers to list
//        $list_uid = "619497d9e3221";
        /*foreach ($request->subscriber as $subscriber) {
            $customer=Customer::where('id',$subscriber)->first();

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
        }*/

        /*$json2 = $result2->getBody();
        $jsonResultToArray2 = json_decode($json2, TRUE);
        dd($jsonResultToArray2);*/
        $request->session()->flash('alert-success', trans('messages.list.created'));

        return redirect()->action('ListController@index');

    }

    public function overview($id)
    {
        $setting=Setting::where('shop_id',Auth::id())->first();
        $get_list=Mail_list::where(['uid'=>$id,'is_custom'=>1])->first();
//        dd($get_list);
        if($get_list !=null){

            $get_subscribers = $get_list->has_subscriber;
            $subscribers=array();
            foreach ($get_subscribers as $customers){
                array_push($subscribers,$customers);
            }
            $list = new stdClass();
            $list->uid= $get_list->uid;
            $list->name=$get_list->name;
            $list->default_subject= $get_list->default_subject;
            $list->from_email= $get_list->from_email;
            $list->from_name= $get_list->from_name;
            $list->remind_message= null;
            $list->status= "";
            $list->created_at= $get_list->created_at;
            $list->updated_at= $get_list->updated_at;

//            $list=(object) $list;//convert arry to stdclass
            $contact = new stdClass();

            $contact->company= $get_list->company;
            $contact->address_1= $get_list->address_1;
            $contact->address_2= $get_list->address_2;
            $contact->country= $get_list->has_country->name;
            $contact->state= $get_list->state;
            $contact->zip= $get_list->zip;
            $contact->phone= $get_list->phone;
            $contact->email= $get_list->contact_email;
            $contact->city= $get_list->city;
            $contact->url= $get_list->home_page_url;


            $statistics = new stdClass();
            $statistics->subscriber_count=count($subscribers);
            $statistics->open_uniq_rate='';
            $statistics->click_rate='';
            $statistics->subscribe_rate='';
            $statistics->unsubscribe_rate='';
            $statistics->unsubscribe_count='';
            $statistics->unconfirmed_count='';
        }
        else {
            try {
                $url = $setting->api_end_point . "/lists/" . $id;
                $client = new Client();
                $result = $client->request('GET', $url . '?api_token=' . $setting->api_token, [
                    'verify' => false]);
                $json = $result->getBody();
                $lists = json_decode($json, False);
//                dd($lists);
                $url2 = $setting->api_end_point . "/subscribers/";
                $client2 = new Client();
                $result2 = $client2->request('GET', $url2 . '?api_token=' . $setting->api_token . '&list_uid=' . $id . '&per_page=1000&page=1', [
                    'verify' => false
                ]);
                $json2 = $result2->getBody();
                $subscribers = json_decode($json2, False);

//            dd($subscribers);
                $list = $lists->list;
                $contact = $lists->contact;
                $statistics = $lists->statistics;
                //        dd($lists);
            } catch (\Exception $exception) {
                $subscribers = [];
                $list = null;
                $contact = null;
                $statistics = null;
            }
        }
//        dd($statistics);

        return view('lists.overview', [
            'list' => $list,
            'contact' => $contact,
            'statistics' => $statistics,
            'subscribers' => $subscribers,
        ]);
    }
    public function quickView(Request $request){
        $id = $request->uid;
        $setting=Setting::where('shop_id',Auth::id())->first();
        $url=$setting->api_end_point."/lists/".$id;
        $client = new Client();
        $result2 = $client->request('GET',$url . '?api_token='.$setting->api_token,[
            'verify' => false]);
        $json = $result2->getBody();
        $lists = json_decode($json, False);
//        dd($lists);
        return view('lists._quick_view', [
            'list' => $lists->list,
            'contact' => $lists->contact,
            'statistics' => $lists->statistics,
        ]);
    }
    function generateRandomString($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
