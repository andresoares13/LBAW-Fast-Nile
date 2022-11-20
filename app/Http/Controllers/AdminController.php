<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Admin;

class AdminController extends Controller
{

    public function show($id)
    {
      if (!Auth::guard('admin')->check()){
        return redirect('/home');
      }
      $admin = Admin::find($id);
      return view('pages.profileAdmin', ['admin' => $admin]);
    }



    public function showEdit($id){
      if (!Auth::guard('admin')->check()){
        return redirect('/home');
      }
      $admin = Admin::find($id);
      if ($admin->id == Auth::guard('admin')->user()->id){
        return view('pages.profileEditAdmin', ['admin' => $admin]);
      }
      else{
        abort(403);
      }
    }

    public function showPicture($id){
      if (!Auth::guard('admin')->check()){
        return redirect('/home');
      }
      $admin = Admin::find($id);
      if ($admin->id == Auth::guard('admin')->user()->id){
        return view('pages.profileAdminPicture', ['admin' => $admin]);
      }
      else{
        abort(403);
      }
    }


    public function editProfile(Request $request){
      if (!Auth::guard('admin')->check()){
        abort(403);
      }
      if ($request->input('admin') == Auth::guard('admin')->user()->id){
        $admin = Admin::find($request->input('admin'));
        $admin->names = $request->input('name');
        
        $admin->save();
        return redirect('profileAdmin/'.$request->input('admin'));
      }
      else{
        abort(403);
      }
    }


    public function updatePicture(Request $request)
    {
      if (!Auth::guard('admin')->check()){
        abort(403);
      }
      if ($request->input('admin') == Auth::guard('admin')->user()->id){
        if($request->hasFile('image')){
            $filename = $request->image->getClientOriginalName();
            $filename = $request->input('admin') . "." .pathinfo($filename,PATHINFO_EXTENSION);
            
            $request->image->storeAs('',$filename,'my_files3');
            $admin = Admin::find($request->input('admin'));
            $admin->picture = $filename;
            $admin->save();
            
        }
        return redirect('profileAdmin/'.$request->input('admin'));
      }
      else{
        abort(403);
      }
    }
}
