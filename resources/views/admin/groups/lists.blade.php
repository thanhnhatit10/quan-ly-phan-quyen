@extends('layouts.admin')
@section('title', 'Dach sách nhóm')
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Danh sách nhóm</h1>
    </div>
    @if (session('msg'))
        <div class="alert alert-primary" role="alert"> <strong>{{session('msg')}}</strong></div>
    @endif
    @can('create', App\Models\Groups::class)
        <a href="{{route('admin.groups.add')}}" class="btn btn-success mb-3">Thêm nhóm</a>
    @endcan
    <table class="table table-bordered">
        <thead>
            <tr>
                <th width="5%">#</th>
                <th scope="col">Tên nhóm</th>
                <th width="15%">Người đăng</th>
                @can('groups.permission')
                    <th width="10%">Phân quyền</th>
                @endcan
                @can('groups.edit')
                   <th width="5%">Sửa</th> 
                @endcan
                @can('groups.delete')
                    <th width="5%">Xoá</th>
                @endcan 
            </tr>
        </thead>
        <tbody>
            @if ($listGroups->count() > 0)
                @foreach ($listGroups as $key => $group)
               <tr>
                    <th scope="row">{{$key+1}}</th>
                    <td>{{$group->name}}</td>
                    <td>{{!empty($group->postBy->name)?$group->postBy->name: ''}}</td>
                    @can('groups.permission')
                        <td><a href="{{route('admin.groups.permission', ['group'=> $group->id])}}" class="btn btn-primary">Phân quyền</a></td>
                    @endcan
                    @can('groups.edit')
                        <td>
                            <a href="{{route('admin.groups.edit', ['group'=> $group->id])}}" class="btn btn-warning btn-sm">Sửa</a>
                        </td>
                    @endcan
                    @can('groups.delete')
                        <td>
                            <a onclick="return confirm('Bạn có chắc chắn muốn xoá?')" href="{{ route('admin.groups.delete', ['group'=> $group->id])}}" class="btn btn-danger btn-sm">Xoá</a>
                        </td>
                    @endcan
                    
                </tr>
                @endforeach   
            @else
                <tr><td colspan="6">Không tồn tại nhóm trong hệ thống</td></tr>
            @endif
        </tbody>
    </table>
@endsection