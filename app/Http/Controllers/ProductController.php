<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        return view('products.index');
    }
    public function listing(Request $request)
    {
        // search
        $products = $request->user()->products()
            ->search($request->keyword);



        // order + pagination
        $products = $products->orderBy($request->sort_order, $request->sort_direction)
            ->paginate($request->per_page);

        // view
        $view = $request->view ? $request->view : 'grid';

        return view('products._list_' . $view, [
            'products' => $products,
        ]);
    }
    public function widgetProductList(Request $request)
    {
        return Product::generateWidgetProductListHtmlContent($request->all());
    }
    public function widgetProductOptions(Request $request)
    {
        $shop_id=Auth::id();
        $results = Product::search($request->keyword)
            ->where('shop_id',$shop_id)
            ->paginate($request->per_page)
            ->map(function ($item, $key) {
                return ['text' => $item->title, 'id' => $item->shopify_id];
            })->toArray();

        $json = '{
            "items": ' .json_encode($results). ',
            "more": ' . (empty($results) ? 'false' : 'true') . '
        }';

        return $json;
    }
    public function widgetProduct(Request $request)
    {
        return Product::generateWidgetProductHtmlContent($request->all());
    }

    public function SyncProducts()
    {
        $shop=Auth::user();
        $next='';

        $count = $shop->api()->rest('GET', '/admin/products/count.json');
//        dd($count);

        if ($count['errors']!==true)
        {
            $count=$count['body']['count'];
        }
//            dd($count);
        if(is_numeric($count)) {
            $count = ceil($count / 250);
            for ($i = 1; $i <= $count; $i++) {
                $products = $shop->api()->rest('GET', '/admin/products.json', [
                    'limit' => 250,
                    'page_info' => $next
                ]);
//                dd($products);
                if (!$products['errors']) {
//                    dd($products);
                    $next = isset($products['link']['next'])?$products['link']['next']:"";
                    $products = $products['body']['products'];
                    foreach ($products as $product) {
                        $this->CreateUpdateProduct($product, $shop->id);
                    }
                }
            }
        }

        return back()->with('success','Product Sync Successfully!');
    }
    public function CreateUpdateProduct($product,$shop_id){

        $product=json_decode(json_encode($product),FALSE);
//        dd($product);

        $Product=Product::where([
            'shop_id'=> $shop_id,
            'shopify_id'=>$product->id
        ])->first();
        if ($Product===null){
            $Product=new Product();
            $Product->shop_id=$shop_id;
            $Product->shopify_id=$product->id;
            $Product->content=$product->body_html;
            if(isset($product->image->src)){
                $Product->image=$product->image->src;

            }
        }
        $Product->title=$product->title;

        if (count($product->variants) >= 1) {
            foreach ($product->variants as $variant) {
                $price = $variant->price;
                break;
            }
        }else{
            $price = '';

        }
        $Product->price=$price;

        $Product->save();
    }
}
