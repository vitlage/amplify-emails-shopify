<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    public static $itemsPerPage = 16;

    public function scopeSearch($query, $keyword)
    {
        // Keyword
        if (!empty(trim($keyword))) {
            foreach (explode(' ', trim($keyword)) as $k) {
                $query = $query->where(function ($q) use ($k) {
                    $q->orwhere('products.title', 'like', '%'.strtolower($k).'%');
                });
            }
        }
    }
    public function getImageUrl()
    {
        if ($this->image != null ||$this->image != "") {
            return $this->image;
        } else {
            return \URL::asset('images/no-product-image.png');
        }
    }

    public static function generateWidgetProductListHtmlContent($params)
    {
        $shop_id=Auth::id();
        if($params['sort']){
            $products = Product::limit($params['count'])
                ->where('shop_id',$shop_id)
                ->orderBy(explode('-', $params['sort'])[0], explode('-', $params['sort'])[1])
                ->get();
        }else{
            $products = Product::limit(2)
                ->where('shop_id',$shop_id)
                ->get();
        }


        return view('products.widgetProductListHtmlContent', [
            'products' => $products,
            'options' => $params,
        ]);
    }

    public static function generateWidgetProductHtmlContent($params)
    {
//        $product = self::findByUid($params['id']);
        $product = self::where('shopify_id',$params['id'])->first();

        // replace tags
        $html = $params['content'];
        $html = str_replace('*|PRODUCT_NAME|*', $product->title, $html);
        $html = str_replace('*|PRODUCT_DESCRIPTION|*', substr(strip_tags($product->description), 0, 200), $html);
        $html = str_replace('*|PRODUCT_PRICE|*', format_price($product->price), $html);
        $html = str_replace('*|PRODUCT_QUANTITY|*', $product->title, $html);
        $html = str_replace('*|PRODUCT_URL|*', action('ProductController@index'), $html);
        $html = str_replace('*%7CPRODUCT_URL%7C*', action('ProductController@index'), $html);

        // try to replace product image
        $dom = new \DOMDocument();
        $dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'), LIBXML_NOWARNING | LIBXML_NOERROR | LIBXML_HTML_NODEFDTD);

        $imgs = $dom->getElementsByTagName("img");
        foreach ($imgs as $img) {
            $att = $img->getAttribute('builder-element');
            if ($att == 'ProductImgElement') {
                $img->setAttribute('src', $product->getImageUrl());
            }
        }

        return $dom->saveHTML();
    }
}
