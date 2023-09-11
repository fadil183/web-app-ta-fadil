<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{
    function __construct(){
        $this->middleware('permission:manage-user-list|manage-user-create|manage-user-edit|manage-user-delete',['only'=>['index','show']]);
        $this->middleware('permission:manage-user-create',['only'=>['create','store']]);
        $this->middleware('permission:manage-user-edit',['only'=>['edit','update']]);
        $this->middleware('permission:manage-user-delete',['only'=>['destroy']]);
    }

    // menampilkan daftar semua data yang sudah ada
    public function index(Request $request): View {
    $data = User::latest()->paginate(5);
    return view('users.index',compact('data'))
        ->with('i', ($request->input('page', 1) - 1) * 5);
    }
    // menampilkan formulir untuk memasukan data user baru
    public function create():View
    {
        $roles=Role::pluck('name','name')->all();
        return view ('users.create',compact('roles'));
    }
    //menyimpan data user baru di penyimpanan
    public function store(Request $request):RedirectResponse{
        $this->validate($request,[
            'name'=>'required',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|same:confirm-password',
            'roles'=>'required'
        ]);

        $input = $request->all();
        $input['password']=Hash::make($input['password']);

        $user=User::create($input);
        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
            ->with('Success','User created successfully');
        
    }
    //menampilkan data user tertenttu
    public function show($id):view
    {
        $user=User::find($id);
        return view ('users.show', compact('user'));
    }
    //menampilkan fromulir untuk merubah data user
    public function edit($id):view
    {
        $user = User::find($id);
        $roles=Role::pluck('name','name')->all();
        $userRole=$user->roles->pluck('name','name')->all();

        return view('users.edit',compact('user','roles','userRole'));
    }
    //menyimpan data user baru yang telah diubah
    public function update(Request $request,$id):Redirectresponse{
        $this->validate($request, [
            'name'=>'required',
            'email'=>'required|email|unique:users,email,'.$id,
            'password'=> 'same:confirm-password',
            'roles'=>'required'
        ]);

        $input=$request->all();
        if(!empty($input['password'])){
            $input['password']=Hash::make($input['password']);
        }else{
            $input=Arr::except($input,array('password'));
        }
        //mencari id user yang ingin diubah
        $user=User::find($id);
        //mengubah data
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();

        $user->assignRole($request->input('roles'));
        
        return redirect()->route('users.index')
            ->with('success','User updated successfully');
    }
    //menghapus data user dari penyimpanan
    public function destroy($id):RedirectResponse{
        User::find($id)->delete();
        return redirect()->route('users.index')
            ->with('success','User deleted successfuly');
    }
}

