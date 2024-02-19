<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Page;
use Illuminate\Http\Request;
use App\Models\WebSetting;
use App\Models\DocumentType;
use Session;
use Auth;

class PageController extends Controller
{
    public function setting()
    {
        if (Auth::user()->role_id != 1) { return redirect('dashboard'); }
        $pages = Page::all();

        $keys = array(
            "topbaremail",
            "Ph_num",
            "fblink",
            "instlink",
            "xlink",
            "inlink",

            "hero_title",
            "hero_desc",
            "highlight_text",
            "hero_short_desc",


            "card1_title",
            "card1_desc",
            "card2_title",
            "card2_desc",
            "card3_title",
            "card3_desc",
            "card4_title",
            "card4_desc",

            "st_one",
            "st_two",
            "st_three",
            "st_four",

            "tutor_one",
            "tutor_two",
            "tutor_three",
            "tutor_four",

            "org_one",
            "org_two",
            "org_three",
            "org_four",

            "faq_desc",
            "accfirst_title",
            "accfirst_desc",
            "accsec_title",
            "accsec_desc",
            "accthird_title",
            "accthird_desc",
            "accfour_title",
            "accfour_desc",

            "pricing_title",
            "pricing_desc",
            "pricing_short_desc",

            "pricecard1_desc",
            "pricecard2_desc",
            "pricecard3_desc",
            "price_desc",

            "card5_title",
            "card5_desc",
            "card6_title",
            "card6_desc",

        );

          $web_settings = array();

          $settings = WebSetting::whereIn('field_key', $keys)->get();

          if (sizeOf($settings) > 0) {
            foreach ($settings as $setting) {
              $web_settings[$setting->field_key] = $setting->field_value;
            }
          }
        return view('super-admin.Pages.index', compact('pages','web_settings'));
    }

    public function bloglisting(Request $request){
        if (Auth::user()->role_id != 1) { return redirect('dashboard'); }
        $blogs = Blog::query();
        $search = $request->input('search');
        $category = $request->input('category');
        
        if (!empty($search)) {
                            $blogs->where('slug', 'like', '%' . $search . '%')
                             ->orWhere('title', 'like', '%' . $search . '%')
                             ->orWhere('content', 'like', '%' . $search . '%');
            };

        if (!empty($category)) {
              $blogs->where('category_id',$category);
           };


        $blogs=$blogs->paginate(5);   
        return view('super-admin.Pages.bloglist', compact('blogs'));
    }

    public function SettingRequest(Request $request)
    {
        $page = Page::find($request->id);
        $page->home_hero_section = !empty($request->post('home_hero_section')) ? $request->post('home_hero_section') : $page->home_hero_section;
        $page->home_why_choose = !empty($request->post('home_why_choose')) ? $request->post('home_why_choose') : $page->home_why_choose;
        $page->header = !empty($request->post('header')) ? $request->post('header') : $page->header;
        $page->footer = !empty($request->post('footer')) ? $request->post('footer') : $page->footer;
        $page->student_apply_steps = !empty($request->post('student_apply_steps')) ? $request->post('student_apply_steps') : $page->student_apply_steps;
        $page->tutor_apply_steps = !empty($request->post('tutor_apply_steps')) ? $request->post('tutor_apply_steps') : $page->tutor_apply_steps;
        $page->organization_apply_steps = !empty($request->post('organization_apply_steps')) ? $request->post('organization_apply_steps') : $page->organization_apply_steps;
        $page->faq = !empty($request->post('faq')) ? $request->post('faq') : $page->faq;
        $page->benefits_tutor = !empty($request->post('benefits_tutor')) ? $request->post('benefits_tutor') : $page->benefits_tutor;
        $page->tutor_cost = !empty($request->post('tutor_cost')) ? $request->post('tutor_cost') : $page->tutor_cost;
        $page->online_tutoring = !empty($request->post('online_tutoring')) ? $request->post('online_tutoring') : $page->online_tutoring;
        $page->good_tutor = !empty($request->post('good_tutor')) ? $request->post('good_tutor') : $page->good_tutor;
        $page->save();
    }

    public function doctypeList(){
      $doc_types = DocumentType::all();
      return view('super-admin.docTypes.index', compact('doc_types'));
    }

    public function storeDocType(Request $request)
    {
        $doc_type = DocumentType::where('title',$request->doc_name)->first();
        if($doc_type){
          return redirect('setting/document_types')->with('error', 'Document Type already exist!');
        }
        $doc_type = new DocumentType;
        $doc_type->title = $request->doc_name;
        $doc_type->save();

        return redirect('setting/document_types')->with('success', 'Document type added successfully.');

    }

    public function updateDocType(Request $request)
    {
      $doc_type = DocumentType::where('id',$request->doc_id)->first();
      if(!$doc_type){
        return redirect('setting/document_types')->with('error', 'Document Type not found!');
      }else{
        $doc_type->title = $request->up_doc_name;
        $doc_type->save();
      }

      return redirect('setting/document_types')->with('success', 'Document type updated successfully.');

    }
}
