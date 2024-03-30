<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller{
    //-------------------------------------------------------------------------------------------------------- 
    public function index()
    {
        $title = 'Danh sách khách hàng';
        $data = User::all();
        return view('admin.user.index', compact('data','title'));
    }
    //-------------------------------------------------------------------------------------------------------- 
    public function view_add(){
        return view('admin.user.add');
    }

    public function add(Request $request){

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'image_url' => $request->image_url,
            'address' => $request->address,
            'google_id' => $request->google_id,
        ]);

        return redirect()->route('admin.user');
    }

//-------------------------------------------------------------------------------------------------------- 
    public function view_edit($userID){
        $user = User::find($userID);
        return view('admin.user.edit', compact('user'));
    }

    public function edit(Request $request, $userID){
        $User = User::find($userID);
        $User->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'image_url' => $request->image_url,
            'address' => $request->address,
            'google_id' => $request->google_id,
        ]);
    
        return redirect()->route('admin.user', ['id' => $userID]);
}
//-------------------------------------------------------------------------------------------------------- 
    public function delete($id){
        User::destroy($id);
        return redirect()->back();
    }


}
