<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TutorialController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    public function blogs()
    {
        $blogs = DB::table('blogs')
        ->where('type', 'Tutorial')
        ->where("is_deleted", 0)
        ->orderBy('id', 'desc')
        ->paginate(20);
        return view("tutorials.blogs",  compact("blogs"));
    }
    public function blog($id)
    {
        $blog = DB::table('blogs')
        ->where('type', 'Tutorial')
        ->where('id', $id)->where('is_deleted', 0)->first();
        if(@$blog) {
            return view("tutorials.blog", compact("blog"));
        }
        abort(404, 'page not found');
    }
    public function view_blogs(Request $request)
    {
        $blogs = DB::table('blogs')
        ->where('is_deleted', 0)
        ->where('type', 'Tutorial')
        ->where(function ($query) use ($request) {
            if(!empty(@$request->get('search'))) {
                $query->where('blog_name', 'LIKE', '%'.$request->input('search').'%')
                ->orWhere('description', 'LIKE', '%'.$request->input('search').'%');
            }
        })
        ->orderBy('id', 'desc')
        ->paginate(20);
        return view("tutorials.view_blogs", compact("blogs"));
    }

    public function add_blog()
    {
        return view("tutorials.add_blog");
    }
    public function save_blog(Request $request)
    {
        $this->validate($request, [
            "title" => "required",
            "description" => "required",
        ]);

        $id = DB::table('blogs')->insertGetId([
            "type" => "Tutorial",
            "blog_name" => $request->input('title'),
            "description" => $request->input('description'),
            "iframe" => $request->input('iframe'),
        ]);
        if($request->hasFile("media")) {
            $imageName = mt_rand(1,1000).''.time() . '.' . $request->file('media')->getClientOriginalExtension();
            $request->file('media')
            ->move(storage_path().'/app/public/BlogMedia', $imageName);
            DB::table('blogs')->where('id', $id)->update([
                "media" => $imageName,
            ]);
        }
        return redirect()->back()->with('success', 'New tutorial added');
    }
    public function edit_blog($id)
    {
        $blog = DB::table('blogs')
        ->where('type', 'Tutorial')
        ->where('id', $id)->where('is_deleted', 0)->first();
        if(@$blog) {
            return view("tutorials.edit_blog", compact("blog"));
        }
        abort(404, "page not found");
    }
    public function play_blog($id)
    {
        $blog = DB::table('blogs')
        ->where('type', 'Tutorial')
        ->where('id', $id)->where('is_deleted', 0)->first();
        if(@$blog) {
            return view("tutorials.play_blog", compact('blog'));
        }
        abort(404, "page not found");
    }
    public function update_blog(Request $request, $id)
    {
        $this->validate($request, [
            "title" => "required",
            "description" => "required",
        ]);
        DB::table('blogs')
        ->where('type', 'Tutorial')
        ->where('id', $id)->update([
            "blog_name" => $request->input('title'),
            "description" => $request->input('description'),
            "iframe" => $request->input('iframe'),
            "updated_at" => date("Y-m-d H:i:s"),
        ]);
        if($request->hasFile("media")) {
            $imageName = mt_rand(1,1000).''.time() . '.' . $request->file('media')->getClientOriginalExtension();
            $request->file('media')
            ->move(storage_path().'/app/public/BlogMedia', $imageName);
            DB::table('blogs')->where('id', $id)->update([
                "media" => $imageName,
            ]);
        }
        return redirect()->back()->with('success', 'Tutorial updated');
    }
    public function delete_blog($id)
    {
        DB::table('blogs')
        ->where('type', 'Tutorial')
        ->where('id', $id)->where('is_deleted', 0)->update([
            "is_deleted" => 1,
            "deleted_at" => date("Y-m-d H:i:s"),
        ]);
        return redirect()->back()->with('success', 'Tutorial deleted');
    }
}
