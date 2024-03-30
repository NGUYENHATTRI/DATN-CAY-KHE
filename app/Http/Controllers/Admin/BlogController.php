<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PostModel;
use App\Models\User;


use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $title = 'Danh sách bài viết';
        $data = PostModel::all();
        return view('admin.blog.index', compact('data','title'));
    }
    public function create()
    {
        $title = 'Thêm bài viết';
        $admins = User::all();
        $posts = PostModel::all();
        return view('admin.blog.create', compact('admins', 'posts','title'));
    }
    public function create_(Request $request)
    {
        PostModel::create([
            'title'=> $request->title,
            'thumnail'=> $request->thumnail,
            'admin_id'=> $request->admin_id,
            'content' => $request->content,
        ]);
        return redirect()->route('admin.blog');
    }
    public function edit($postID)
    {
        $title = 'Chỉnh sửa bài viết';
        $admins =  User::all();
        $post = PostModel::find($postID);
        return view('admin.blog.edit', compact('admins','post','title'));
    }
    public function edit_(Request $request)
    {
        PostModel::where('postID', $request->postID)->update([
            'content' => $request->content
        ]);
        return redirect()->route('admin.editBlog', ['id' => $request->postID]);
    }

    public function delete($postID)
    {
        PostModel::destroy($postID);
        return redirect()->back();
    }
}
