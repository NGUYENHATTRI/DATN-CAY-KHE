<?php

namespace App\Http\Controllers\Admin;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\PostModel;
use App\Models\User;
use Illuminate\Support\Facades\DB;
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
        $admins = User::all()->where('role',1);
        $posts = PostModel::all();
        return view('admin.blog.create', compact('admins', 'posts','title'));
    }
    public function create_(Request $request)
    {
       
        $request->validate([
            'title' => 'required|string|max:100',
            'content' => 'required|string',
        ], [
            'title.required' => 'Tiêu đề không được bỏ trống',
            'content.required' => 'NộI dung không được bỏ trống',
        ]);
        if ($request->hasFile('thumnail')) {
            $image = $request->file('thumnail');
            $imageName = rand(0,99) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/product'), $imageName);
            return redirect()->route('admin.blog'); 
        }
        $name = DB::table('users')
        ->select('name')
        ->where('userID', '=', $request->admin_id)
        ->first();
        $name_admin = $name ? $name->name : null;
        PostModel::create([
            'title'=> $request->title,
            'thumnail'=> $request->thumnail,
            'admin_id'=> $request->admin_id,
            'name_admin'=>  $name_admin,
            'content' => $request->content,
            'post_time'=> Carbon::now(),
        ]);
        notify()->success('Tạo thành công', 'Tạo thành công');

        return redirect()->route('admin.blog');
    }
    public function edit($postID)
    {
        $title = 'Chỉnh sửa bài viết';
        $admins =  User::all()->where('role',1);
        $post = PostModel::find($postID);
        return view('admin.blog.edit', compact('admins','post','title'));
    }
    public function edit_(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:100',
            'content' => 'required|string',
        ], [
            'title.required' => 'Tiêu đề không được bỏ trống',
            'content.required' => 'NộI dung không được bỏ trống',
        ]);
        if ($request->hasFile('thumnail')) {
            $image = $request->file('thumnail');
            $imageName = rand(0,99) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/product'), $imageName);
            return redirect()->route('admin.blog'); 
        }
        $name = DB::table('users')
        ->select('name')
        ->where('userID', '=', $request->admin_id)
        ->first();
        $name_admin = $name ? $name->name : null;
        PostModel::where('postID', $request->postID)->update([
            'title'=> $request->title,
            'thumnail'=> $request->thumnail,
            'admin_id'=> $request->admin_id,
            'name_admin'=>  $name_admin,
            'content' => $request->content,
            'post_time'=> Carbon::now(),
        ]);
        notify()->success('Chỉnh sửa thành công', 'Chỉnh sửa thành công');

        return redirect()->route('admin.editBlog', ['id' => $request->postID]);
    }

    public function delete($postID)
    {
        PostModel::destroy($postID);
        return redirect()->back();
    }
}
