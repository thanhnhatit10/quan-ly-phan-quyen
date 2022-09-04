<?php

namespace App\Http\Controllers\Admin;

use App\Models\Groups;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Modules;
use Illuminate\Support\Facades\Auth;
use Nette\Utils\Json;

class GroupsController extends Controller
{
    public function index()
    {
        $userID = Auth::user()->id;
        if(Auth::user()->user_id == 0){ 
            $listGroups =  Groups::all();
        }else {
            $listGroups = Groups::where('user_id', $userID)->get();
        }
        return view('admin.groups.lists', compact('listGroups'));
    }
    public function add()
    {
        return view('admin.groups.add');
    }

    public function postAdd(Request $request, Groups  $group)
    {
        $request->validate(
            [
                'name'=> 'required|unique:groups,name',
            ], 
            [
                'name.required' => 'Tên nhóm bắt buộc phải nhập.',
                'name.unique' => 'Tên bị trùng, vui lòng chọn tên khác',
            ]
        );

        $group->name =  $request->name;
        $group->user_id = Auth::user()->id;
        $group->save();
        return redirect()->route('admin.groups.index')->with('msg', 'Thêm nhóm người dùng thành công');
    }

    public function edit(Groups $group)
    {
        $this->authorize('update', $group);
        return view('admin.groups.edit', compact('group'));
    }

    public function postEdit(Groups $group, Request $request)
    {
        $this->authorize('update', $group);
        $request->validate(
            [
                'name'=> 'required|unique:groups,name,'.$group->id,
            ], 
            [
                'name.required' => 'Tên nhóm bắt buộc phải nhập.',
                'name.unique' => 'Tên bị trùng, vui lòng chọn tên khác',
            ]
        );
        $group->name =  $request->name;
        $group->save();
        return redirect()->route('admin.groups.index')->with('msg', 'Sửa nhóm người dùng thành công');
    }

    public function delete(Groups $group)
    {
        $this->authorize('delete', $group);
        $userCount =  $group->users->count();
        if($userCount == 0){
            $status = Groups::destroy($group->id);
            if($status){
                return redirect()->route('admin.groups.index')->with('msg', 'Xoá nhóm thành công.');
            }
        }else {
            return redirect()->route('admin.groups.index')->with('msg', 'Không thể xoá nhóm này. Vui lòng thử lại sau');
        }
    }

    public function permission(Groups $group)
    {
        $this->authorize('permission', $group);
        $modules = Modules::all();
        $roleListArr = [
            'view' => 'Xem',
            'add' => 'Thêm',
            'edit' => 'Sửa',
            'delete' => 'Xoá',
        ];
        $roleJson = $group->permission;
        if(!empty($roleJson)){
            $roleArr = Json::decode($roleJson, true);
        }else {
            $roleArr = [];
        }
        return view('admin.groups.permission', compact('group', 'modules', 'roleListArr', 'roleArr'));
    }

    public function postPermission(Request $request, Groups $group)
    {
        $this->authorize('permission', $group);
        $roleArr =  $request->role??[];
        $roleJson =  Json::encode($roleArr);
        $group->permission = $roleJson;
        $status = $group->save();
        if($status){
            return redirect()->route('admin.groups.permission', ['group'=> $group->id])->with('msg', 'Phân quyền thành công.');
        }
        return redirect()->route('admin.groups.permission', ['group'=> $group->id])->with('msg', 'Phân quyền thất bại.');
    }
}
