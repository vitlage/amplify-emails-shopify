<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Setting;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function syncCustomers(){

        $shop=Auth::user();
        $next='';
        $count = $shop->api()->rest('GET', '/admin/customers/count.json');
        $count=$count['body']['count'];
        for ($i=1;$i<=$count;$i++)
        {
            if ($i==1)
            {
                $customers=$shop->api()->rest('GET','/admin/customers.json',[
                    'limit'=>250
                ]);
                if (!$customers['errors'])
                {
                    if (isset($customers['link']['next']))
                    {
                        $next=$customers['link']['next'];
                    }
                    $customers=$customers['body']['customers'];
                    foreach ($customers as $customer)
                    {
                        $this->CreateUpdateCustomer($customer,$shop);
                    }
                }
            }else
            {
                $customers=$shop->api()->rest('GET','/admin/customers.json',[
                    'limit'=>250,
                    'page_info'=>$next
                ]);
                if (!$customers['errors'])
                {
                    if (isset($customers['link']['next']))
                    {
                        $next=$customers['link']['next'];
                    }
                    $customers=$customers['body']['customers'];
                    foreach ($customers as $customer)
                    {
                        $this->CreateUpdateCustomer($customer,$shop);
                    }
                }
            }
        }
    }
    public function CreateUpdateCustomer($customer,$shop)
    {
        $customer=json_decode(json_encode($customer),FALSE);

        $Customer=Customer::where([
            'shop_id'=>$shop->id,
            'customer_id'=>$customer->id
        ])->first();

        if ($Customer===null)
        {
            $Customer=new Customer();
            $Customer->shop_id=$shop->id;
            $Customer->customer_id=$customer->id;
        }

        $Customer->first_name=$customer->first_name;
        $Customer->last_name =$customer->last_name;
        $Customer->email=$customer->email;
        $Customer->phone=$customer->phone;
        $Customer->is_shopify=1;
        $Customer->created_at=Carbon::parse( $customer->created_at)->format('m/d/Y H:i:s');
        $Customer->updated_at=Carbon::parse( $customer->updated_at)->format('m/d/Y H:i:s');
        $Customer->save();
        if($shop->list_id !=null) {
            try {
                $setting = Setting::where('shop_id', $shop->id)->first();
                $list_uid = $shop->list_id;
                $url2 = $setting->api_end_point . "/subscribers";
                $client2 = new Client();
                $result2 = $client2->request('POST', $url2 . '?api_token=' . $setting->api_token, [
                    'verify' => false,
                    'form_params' => [
                        'list_uid' => $list_uid,
                        'EMAIL' => $Customer->email,
                        'tag' => '',
                        'FIRST_NAME' => $Customer->first_name,
                        'LAST_NAME' => $Customer->last_name
                    ]
                ]);
                $json2 = $result2->getBody();
                $jsonResultToArray2 = json_decode($json2, TRUE);
//            dd($jsonResultToArray2);
            }catch (\Exception $e){

            }
        }

    }

}
