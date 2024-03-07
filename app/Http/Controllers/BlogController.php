<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Blog;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    public function blog_create(){
        if (Auth::user()->role_id != 1) { return redirect('dashboard'); }
       return view('super-admin.blog.index');
    }

    public function blog_create_Request(Request $request) {
        if (Auth::user()->role_id != 1) { return redirect('dashboard'); }
        $image = $request->file('image');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $image->move(public_path('images'), $imageName);

        $blog = new Blog();
        $blog->slug = $request->post('slug');
        $blog->image = 'images/' . $imageName;
        $blog->author_id = Auth::id();
        $blog->title = $request->post('title');
        $blog->status = 'Published';
        $blog->category_id = $request->post('category_id');
        $blog->content = $request->post('content');
        $blog->save();

        $ActivityLogs = new ActivityLog;
        $ActivityLogs->user_id = Auth::id();
        $ActivityLogs->title = "Blog Create Request ";
        $ActivityLogs->description = $blog->slug." Blog Create Request By  ".Auth::user()->first_name."  ".Auth::user()->last_name;
        $ActivityLogs->save();

        return back()->with('success', 'Successfully created the blog');
    }


    public function blog_update(Request $request){
        if (Auth::user()->role_id != 1) { return redirect('dashboard'); }
        $blog=Blog::find($request->id);
        return view('super-admin.blog.update',compact('blog'));
    }

    public function blog_update_Request(Request $request){
        if (Auth::user()->role_id != 1) { return redirect('dashboard'); }
        $image = $request->file('image');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $image->move(public_path('images'), $imageName);

        $Blog =Blog::find($request->id);
        $Blog->slug = $request->post('slug');
        $Blog->image = 'images/' . $imageName;
        $Blog->author_id = Auth::id();
        $Blog->title = $request->post('title');
        $Blog->status = 'Published';
        $Blog->category_id = $request->post('category_id');
        $Blog->content = $request->post('content');
        $Blog->save();

        $ActivityLogs = new ActivityLog;
        $ActivityLogs->user_id = Auth::id();
        $ActivityLogs->title = "Blog Update Request ";
        $ActivityLogs->description = $request->post('slug')." Blog Update Request By  ".Auth::user()->first_name."  ".Auth::user()->last_name;
        $ActivityLogs->save();

        return back()->with('success','Update blog Successfully');
    }

    public function blog_delete(Request $request){
        if (Auth::user()->role_id != 1) { return redirect('dashboard'); }
        $blog=Blog::find($request->id);

        $ActivityLogs = new ActivityLog;
        $ActivityLogs->user_id = Auth::id();
        $ActivityLogs->title = "Blog Deleted ";
        $ActivityLogs->description = $blog->slug." Blog Deleted By  ".Auth::user()->first_name."  ".Auth::user()->last_name;
        $ActivityLogs->save();

        $blog->delete();
        return back()->with('success','Delete blog Successfully');
    }



}
