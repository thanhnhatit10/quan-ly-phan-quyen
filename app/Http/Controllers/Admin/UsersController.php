<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Groups;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function index(User $user)
    {
        $userID = Auth::user()->id;
        if(Auth::user()->user_id == 0){
            $listUser = $user->all();
        }else {
            $listUser = $user->where('user_id', $userID)->get();
        }
        
        return view('admin.users.lists', compact('listUser'));
    }
    public function add()
    {
        $groups = Groups::all();
        return view('admin.users.add', compact('groups'));  
    }
    public function postAdd(Request $request, User $user)
    {
        $request->validate(
            [   
                'name' => 'required|string|min:8|max:30',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:10',
                'group_id' => ['required', function($attribute, $value, $fail){
                    if($value ==0){
                        $fail('Vui lòng chọn nhóm');
                    }
                }],
            ],
            [
                'name.required' => 'Vui lòng nhập họ tên.',
                'name.string' => 'Họ tên bắt buộc là chuỗi.',
                'name.min' => 'Họ tên không nhỏ hơn :min kí tự.',
                'name.max' => 'Họ tên không vượt quá :max kí tự.',
                'email.required' => 'Email bắt buộc phải nhập.',
                'email.email' => 'Email không đúng định dạng.',
                'email.unique' => 'Email đã tồn tại trong hệ thống.',
                'password.required' => 'Mật khẩu bắt buộc phải nhập.',
                'password.min' => 'Mật khẩu phải lớn hơn :min kí tự.',
            ]
        );

        // Lưu vào database
        $user->name =  $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->group_id = $request->group_id;
        $user->user_id = Auth::user()->id;
        $user->save();
        return redirect()->route('admin.users.index')->with('msg', 'Thêm người dùng thành công.');
    }
    public function edit(User $user)
    {
        $this->authorize('update', $user);
        $groups = Groups::all();
        return view('admin.users.edit', compact('groups', 'user'));
    }

    public function postEdit(Request $request, User $user)
    {
        $this->authorize('update', $user);
        $password = $request->password?'required|min:10':'';
        $request->validate(
            [   
                'name' => 'required|string|min:8|max:30',
                'email' => 'required|email|unique:users,email,'.$user->id,
                'password' => $password,
                'group_id' => ['required', function($attribute, $value, $fail){
                    if($value ==0){
                        $fail('Vui lòng chọn nhóm');
                    }
                }],
            ],
            [
                'name.required' => 'Vui lòng nhập họ tên.',
                'name.string' => 'Họ tên bắt buộc là chuỗi.',
                'name.min' => 'Họ tên không nhỏ hơn :min kí tự.',
                'name.max' => 'Họ tên không vượt quá :max kí tự.',
                'email.required' => 'Email bắt buộc phải nhập.',
                'email.email' => 'Email không đúng định dạng.',
                'email.unique' => 'Email đã tồn tại trong hệ thống.',
                'password.required' => 'Mật khẩu bắt buộc phải nhập.',
                'password.min' => 'Mật khẩu phải lớn hơn :min kí tự.',
            ]
        );
        // Lưu vào database
        $user->name =  $request->name;
        $user->email = $request->email;
        if(!empty($request->password)){
            $user->password = Hash::make($request->password);
        } 
        $user->group_id = $request->group_id;
        $user->save();
        return back()->with('msg', 'Cập nhật người dùng thành công.');

    }
    public function delete(User $user)
    {
        $this->authorize('delete', $user);
        if(Auth::user()->id != $user->id){
            $status = User::destroy($user->id);
            if($status){
                return redirect()->route('admin.users.index')->with('msg', 'Xoá người dùng thành công.');
            }
        }
        return redirect()->route('admin.users.index')->with('msg', 'Bạn không thể xoá người dùng này.');
    }
}