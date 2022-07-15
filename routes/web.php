<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('test',function () {
 $email=\App\SendEmail::templateApi();

});

Route::any('/webhooks', 'AdminController@webhooks')->name('webhooks');

Auth::routes();


Route::middleware(['auth.shopify'])->group(function() {
//setup
    Route::get('/step/1', 'AdminController@step1')->name('step_1');
    Route::post('/step/1', 'AdminController@saveStep1')->name('step_1.save');
    Route::get('/step/2', 'AdminController@step2')->name('step_2');
    Route::post('/step/2', 'AdminController@saveStep2')->name('step_2.save');
    Route::get('/step/finish', 'AdminController@finish')->name('finish');

Route::get('/', 'AdminController@index')->name('home');

    Route::get('sync/customers', 'CustomerController@syncCustomers')->name('syncCustomer');
    Route::get('sync/products', 'ProductController@SyncProducts')->name('syncProduct');

Route::get('/account/api', 'AdminController@api')->name('api');
Route::post('/account/api/update', 'AdminController@apiUpdate')->name('api.update');




//Campaign

Route::get('/campaigns', 'CampaignController@index')->name('campaigns');
Route::get('/campaigns/start', 'CampaignController@startCampaign')->name('campaigns.start');
Route::get('campaigns/listing/{page?}', 'CampaignController@listing')->name('campaigns.listing');
Route::get('campaigns/overview/{id}', 'CampaignController@overview')->name('campaigns.overview');
Route::get('campaigns/pause/{id}', 'CampaignController@pauseCampaign')->name('campaigns.pause');
Route::get('campaigns/quick-view', 'CampaignController@quickView')->name('campaigns.quickView');

Route::get('campaigns/{uid}/subscribers', 'CampaignController@subscribers');
Route::get('campaigns/{uid}/subscribers/listing', 'CampaignController@subscribersListing');

Route::get('campaigns/select-type', 'CampaignController@selecttype')->name('campaigns.selecttype');

Route::get('campaigns/create', 'CampaignController@create')->name('campaigns.create');
Route::get('campaigns/{uid}/recipients', 'CampaignController@recipients');
Route::post('campaigns/{uid}/recipients', 'CampaignController@recipients');

Route::get('campaigns/{uid}/setup', 'CampaignController@setup')->name('campaigns.setup');
Route::post('campaigns/{uid}/setup', 'CampaignController@setup')->name('campaigns.setups_save');
Route::get('campaigns/{uid}/template', 'CampaignController@template')->name('campaigns.template');
Route::post('campaigns/{uid}/template', 'CampaignController@template')->name('campaigns.template_save');
Route::get('campaigns/{uid}/schedule', 'CampaignController@schedule')->name('campaigns.schedule');
Route::post('campaigns/{uid}/schedule', 'CampaignController@schedule')->name('campaigns.schedule_save');
Route::get('campaigns/{uid}/confirm', 'CampaignController@confirm');
Route::post('campaigns/{uid}/confirm', 'CampaignController@confirm');

Route::get('campaigns/{uid}/edit', 'CampaignController@edit');
Route::patch('campaigns/{uid}/update', 'CampaignController@update');

Route::match(['get', 'post'], 'campaigns/{uid}/template/builder-plain', 'CampaignController@builderPlainEdit');
Route::match(['get', 'post'], 'campaigns/{uid}/template/builder-classic', 'CampaignController@builderClassic');
Route::match(['get', 'post'], 'campaigns/{uid}/plain', 'CampaignController@plain');
Route::get('campaigns/{uid}/template/change/{template_uid}', 'CampaignController@templateChangeTemplate');




Route::post('campaigns/{uid}/custom-plain/off', 'CampaignController@customPlainOff');
Route::post('campaigns/{uid}/custom-plain/on', 'CampaignController@customPlainOn');
Route::post('campaigns/{uid}/remove-attachment', 'CampaignController@removeAttachment');
Route::get('campaigns/{uid}/download-attachment', 'CampaignController@downloadAttachment');
Route::post('campaigns/{uid}/upload-attachment', 'CampaignController@uploadAttachment');
Route::get('campaigns/{uid}/template/builder-select', 'CampaignController@templateBuilderSelect');


Route::get('campaigns/{uid}/template/review-iframe', 'CampaignController@templateReviewIframe');
Route::get('campaigns/{uid}/template/review', 'CampaignController@templateReview');
Route::get('campaigns/select-type', 'CampaignController@selectType');
Route::get('campaigns/{uid}/list-segment-form', 'CampaignController@listSegmentForm');
Route::get('campaigns/{uid}/preview/content/{subscriber_uid?}', 'CampaignController@previewContent');
Route::get('campaigns/{uid}/preview', 'CampaignController@preview');

//Products

Route::get('products', 'ProductController@index')->name('products');
Route::get('products/listing', 'ProductController@listing');
Route::get('/products/widget/products/options', 'ProductController@widgetProductOptions');
Route::get('/products/widget/products/list', 'ProductController@widgetProductList');
Route::post('/products/widget/product', 'ProductController@widgetProduct');

//list

Route::get('/lists', 'ListController@index')->name('lists');
Route::get('/lists/create', 'ListController@create')->name('lists.create');
Route::post('/lists/store', 'ListController@store')->name('lists.store');
Route::get('lists/listing/{page?}', 'ListController@listing')->name('lists.listing');
Route::get('lists/overview/{id}', 'ListController@overview')->name('lists.overview');
Route::get('lists/quick-view', 'ListController@quickView')->name('lists.quickView');


//Template
Route::post('templates/{uid}/export', 'TemplateController@export');
Route::match(['get','post'], 'templates/{uid}/change-name', 'TemplateController@changeName');
Route::match(['get','post'], 'templates/{uid}/categories', 'TemplateController@categories');

Route::match(['get','post'], 'templates/{uid}/update-thumb-url', 'TemplateController@updateThumbUrl');
Route::match(['get','post'], 'templates/{uid}/update-thumb', 'TemplateController@updateThumb');

Route::get('/templates', 'TemplateController@index')->name('templates');

Route::get('templates/listing/{page?}', 'TemplateController@listing');
Route::get('templates/{uid}/preview', 'TemplateController@preview');
Route::get('templates/builder/templates/{category_uid?}', 'TemplateController@builderTemplates');

Route::get('templates/delete', 'TemplateController@delete');
Route::get('templates/upload', 'TemplateController@uploadTemplate');

Route::post('templates/builder/create', 'TemplateController@builderCreate');
Route::get('templates/builder/create', 'TemplateController@builderCreate');

Route::get('templates/{uid}/edit', 'TemplateController@edit');
Route::patch('templates/{uid}/update', 'TemplateController@update');
Route::post('templates/{uid}/copy', 'TemplateController@copy');
Route::get('templates/{uid}/copy', 'TemplateController@copy');
///
});
// Campaigns Templates Edit
Route::get('campaigns/{uid}/template/content', 'CampaignController@templateContent');
Route::match(['get', 'post'], 'campaigns/{uid}/template/edit', 'CampaignController@templateEdit');
Route::match(['get', 'post'], 'campaigns/{uid}/template/upload', 'CampaignController@templateUpload');
Route::get('campaigns/{uid}/template/layout/list', 'CampaignController@templateLayoutList');
Route::match(['get', 'post'], 'campaigns/{uid}/template/layout', 'CampaignController@templateLayout');
Route::get('campaigns/{uid}/template/create', 'CampaignController@templateCreate');
// Templates Edit
Route::post('templates/{uid}/builder/edit/asset', 'TemplateController@uploadTemplateAssets');
Route::get('templates/{uid}/builder/edit/content', 'TemplateController@builderEditContent');
Route::post('templates/{uid}/builder/edit', 'TemplateController@builderEdit');
Route::get('templates/{uid}/builder/edit', 'TemplateController@builderEdit');
//
Route::get('segments/select_box', 'SegmentController@selectBox');

Route::get('logout',function (){
    auth()->logout();
    return redirect()->route('app_login');
});
Route::get('/app_login', 'AdminController@logoutPage')->name('app_login');

Route::get('/files/{uid}/{name?}', [ function ($uid, $name) {
    // Do not use $user->getAssetsPath($name), avoid one SQL query!
    $path = storage_path('app/users/' . $uid . '/home/files/' . $name);
    $mime_type = \App\Library\File::getFileType($path);
    if (\File::exists($path)) {
        return response()->file($path, array('Content-Type' => $mime_type));
    } else {
        abort(404);
    }
}])->where('name', '.+')->name('user_files');

// assets path for customer thumbs
Route::get('/thumbs/{uid}/{name?}', [ function ($uid, $name) {
    // Do not use $user->getThumbsPath($name), avoid one SQL query!
    $path = storage_path('app/users/' . $uid . '/home/thumbs/' . $name);
    if (\File::exists($path)) {
        $mime_type = \App\Library\File::getFileType($path);
        return response()->file($path, array('Content-Type' => $mime_type));
    } else {
        abort(404);
    }
}])->where('name', '.+')->name('user_thumbs');

// assets path for email
// Deprecated, used for templates generated by older version of Acelle
Route::get('/p/assets/{path}', [ function ($token) {
    // Notice $path should be relative only for acellemail/storage/ folder
    // For example, with a real path of /home/deploy/acellemail/storage/app/sub/example.png => $path = "app/sub/example.png"
    $decodedPath = \App\Library\StringHelper::base64UrlDecode($token);
    $absPath = storage_path($decodedPath);

    if (\File::exists($absPath)) {
        $mime_type = \App\Library\File::getFileType($absPath);
        return response()->file($absPath, array('Content-Type' => $mime_type));
    } else {
        abort(404);
    }
}])->name('public_assets_deprecated');

// assets path for email
Route::get('assets/{dirname}/{basename}', [ function ($dirname, $basename) {
    $dirname = \App\Library\StringHelper::base64UrlDecode($dirname);
    $absPath = storage_path(join_paths($dirname, $basename));

    if (\File::exists($absPath)) {
        $mimetype = \App\Library\File::getFileType($absPath);
        return response()->file($absPath, array('Content-Type' => $mimetype));
    } else {
        abort(404);
    }
}])->name('public_assets');
