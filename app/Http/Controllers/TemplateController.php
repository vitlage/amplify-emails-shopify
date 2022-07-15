<?php

namespace App\Http\Controllers;

use App\TemplateCategory;
use Illuminate\Http\Request;
use App\Library\Rss;
use App\Template;

class TemplateController extends Controller
{
    public function index(){


        return view('templates.index');

    }


    public function listing(Request $request)
    {


//        dd($request->user());

        if ($request->from == 'mine') {
            $templates = $request->user()->templates();


        } elseif ($request->from == 'gallery') {
            $templates = Template::shared();

        }

        // view
        $view = $request->view ? $request->view : 'list';

        // sort, pagination
        $templates = $templates->search($request->keyword)
            ->categoryUid($request->category_uid)
//            ->notAssociated()
            ->orderBy($request->sort_order, $request->sort_direction)
            ->paginate($request->per_page ? $request->per_page : ($view == 'grid' ? 8 : 15));


        return view('templates._list_' . $view, [
            'templates' => $templates,
        ]);
    }
    public function preview(Request $request, $id)
    {
        $template = Template::where('uid', '=', $id)->first();
        $previousURL = url()->previous();
        cookie()->queue(cookie()->forever('custom_url', $previousURL));
//        dd($template);
       /* // authorize
        if (!$request->user()->customer->can('preview', $template)) {
            return $this->notAuthorized();
        }*/

        return view('templates.preview', [
            'template' => $template,
        ]);
    }

    public function delete(Request $request)
    {

        $templates = Template::whereIn(
            'uid',
            is_array($request->uids) ? $request->uids : explode(',', $request->uids)
        );
        $total = $templates->count();
        $deleted = 0;
        foreach ($templates->get() as $template) {
                $template->deleteAndCleanup();
                $deleted += 1;
        }

        echo trans('messages.templates.deleted', [ 'deleted' => $deleted, 'total' => $total]);
    }
    public function updateThumb(Request $request, $uid)
    {
        $template = Template::findByUid($uid);



        if ($request->isMethod('post')) {
            // make validator
            $validator = \Validator::make($request->all(), [
                'file' => 'required',
            ]);

            // redirect if fails
            if ($validator->fails()) {
                return response()->view('templates.updateThumb', [
                    'template' => $template,
                    'errors' => $validator->errors(),
                ], 400);
            }

            // update thumb
            $template->uploadThumbnail($request->file);

            return response()->json([
                'status' => 'success',
                'message' => trans('messages.template.thumb.uploaded'),
            ], 201);
        }

        return view('templates.updateThumb', [
            'template' => $template,
        ]);
    }
    public function updateThumbUrl(Request $request, $uid)
    {
        $template = Template::findByUid($uid);


        if ($request->isMethod('post')) {
            // make validator
            $validator = \Validator::make($request->all(), [
                'url' => 'required|url',
            ]);

            // redirect if fails
            if ($validator->fails()) {
                return response()->view('templates.updateThumbUrl', [
                    'template' => $template,
                    'errors' => $validator->errors(),
                ], 400);
            }

            // update thumb
            $template->uploadThumbnailUrl($request->url);

            return response()->json([
                'status' => 'success',
                'message' => trans('messages.template.thumb.uploaded'),
            ], 201);
        }

        return view('templates.updateThumbUrl', [
            'template' => $template,
        ]);
    }

    public function uploadTemplate(Request $request)
    {



    }

    public function builderCreate(Request $request){

// authorize
// if (!$request->user()->customer->can('create', Template::class)) {
//     return $this->notAuthorized();
// }

// validate and save posted data
if ($request->isMethod('post')) {
    // Get selected template
    $selectedTemplate = Template::findByUid($request->template);

    // Copy
    $template = $request->user()->copyTemplateAs($selectedTemplate, $request->name);

    return redirect()->action('TemplateController@builderEdit', $template->uid);
} else {
    $template = new Template();
    $template->name = trans('messages.untitled_template');

    return view('templates.builder.create', [
        'template' => $template,
    ]);
}
    }


    public function builderTemplates(Request $request)
    {
        // category
        $category = TemplateCategory::findByUid($request->category_uid);
        // sort, pagination
        $templates = $category->templates()->shared()->search($request->keyword)
            ->orderBy($request->sort_order, $request->sort_direction)
            ->paginate($request->per_page);

        // authorize
        /*if (!$request->user()->customer->can('create', Template::class)) {
            return $this->notAuthorized();
        }*/

        return view('templates.builder.templates', [
            'templates' => $templates,
        ]);
    }
    public function builderEditContent(Request $request, $uid)
    {
        // Generate info
        $user = $request->user();
        $template = Template::findByUid($uid);

        // authorize
//        if (!$request->user()->customer->can('update', $template)) {
//            return $this->notAuthorized();
//        }

        return view('templates.builder.content', [
            'content' => $template->content,
        ]);
    }

    public function uploadTemplateAssets(Request $request, $uid)
    {
        $template = Template::findByUid($uid);

        // authorize
        /*if (!$request->user()->customer->can('update', $template)) {
            return $this->notAuthorized();
        }*/

        if ($request->assetType == 'upload') {
            $assetUrl = $template->uploadAsset($request->file('file'));
        } elseif ($request->assetType == 'url') {
            $assetUrl = $template->uploadAssetFromUrl($request->url);
        } elseif ($request->assetType == 'base64') {
            $assetUrl = $template->uploadAssetFromBase64($request->url_base64);
        }

        return response()->json([
            'url' => $assetUrl
        ]);
    }

    public function create(Request $request)
    {
        // Generate info
        $user = $request->user();
        $template = new Template();

        // authorize
//        if (!$request->user()->customer->can('create', Template::class)) {
//            return $this->notAuthorized();
//        }

        // Get old post values
        if (null !== $request->old()) {
            $template->fill($request->old());
        }

        return view('templates.create', [
            'template' => $template,
        ]);
    }
    public function edit(Request $request, $uid)
    {
        // Generate info
        $user = $request->user();
        $template = Template::findByUid($uid);



        // Get old post values
        if (null !== $request->old()) {
            $template->fill($request->old());
        }

        return view('templates.edit', [
            'template' => $template,
        ]);
    }
    public function update(Request $request, $id)
    {
        // Generate info
        $user = $request->user();
        $template = Template::findByUid($request->uid);


        // Save template
        $template->fill($request->all());

        $rules = array(
            'name' => 'required',
            'content' => 'required',
        );

        // make validator
        $validator = \Validator::make($request->all(), $rules);

        // redirect if fails
        if ($validator->fails()) {
            // faled
            return response()->json($validator->errors(), 400);
        }

        $template->updateContent($request->content);

        // success
        return response()->json([
            'status' => 'success',
            'message' => trans('messages.template.updated'),
        ], 201);
    }

    public function builderEdit(Request $request, $uid)
    {
        // Generate info
        $user = $request->user();
        $template = Template::findByUid($uid);

        // authorize
//        if (!$request->user()->customer->can('update', $template)) {
//            return $this->notAuthorized();
//        }

        // validate and save posted data
        if ($request->isMethod('post')) {
            $rules = array(
                'content' => 'required',
            );

            $this->validate($request, $rules);

            $template->updateContent($request->content);

            return response()->json([
                'status' => 'success',
            ]);
        }

        return view('templates.builder.edit', [
            'template' => $template,
            'templates' => $request->user()->getBuilderTemplates(),
        ]);
    }
    public function changeName(Request $request)
    {
        $template = Template::findByUid($request->uid);



        if ($request->isMethod('post')) {
            // change name
            $validator = $template->changeName($request->name);

            if ($validator->fails()) {
                return response()->view('templates.changeName', [
                    'template' => $template,
                    'errors' => $validator->errors(),
                ], 400);
            }

            return response()->json([
                'status' => 'success',
                'message' => trans('messages.template.name.changed'),
            ], 201);
        }

        return view('templates.changeName', [
            'template' => $template,
        ]);
    }
    public function categories(Request $request, $uid)
    {
        $template = Template::findByUid($uid);



        if ($request->isMethod('post')) {
            foreach ($request->categories as $key => $value) {
                $category = \App\TemplateCategory::findByUid($key);
                if ($value == 'true') {
                    $template->addCategory($category);
                } else {
                    $template->removeCategory($category);
                }
            }
        }

        return view('templates.categories', [
            'template' => $template,
        ]);
    }

    public function export(Request $request)
    {
        $template = Template::findByUid($request->uid);

        $zipPath = $template->createTmpZip();

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }
    public function copy(Request $request)
    {
        $template = Template::findByUid($request->uid);

        if ($request->isMethod('post')) {

            $template->copy([
                'name' => $request->name,
                'customer_id' => $request->user()->id,
            ]);

            echo trans('messages.template.copied');
            return;
        }

        return view('templates.copy', [
            'template' => $template,
        ]);
    }

}
