@extends('layouts.admin')
@section('title', 'Dach sách người dùng')
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Danh sách người dùng</h1>
    </div>
    @if (session('msg'))
        <div class="alert alert-primary" role="alert"> <strong>{{session('msg')}}</strong></div>
    @endif
    @can('create', App\Models\User::class)
        <a href="{{route('admin.users.add')}}" class="btn btn-success mb-3">Thêm người dùng</a>
    @endcan
    <table class="table table-bordered">
        <thead>
            <tr>
                <th width="5%">#</th>
                <th scope="col">Họ tên</th>
                <th scope="col">Email</th>
                <th scope="col">Nhóm</th>
                @can('users.edit')
                    <th width="5%">Sửa</th>
                @endcan
                @can('users.delete')
                    <th width="5%">Xoá</th>
                @endcan
            </tr>
        </thead>
        <tbody>
            @if ($listUser->count() > 0)
                @foreach ($listUser as $key => $user)
               <tr>
                    <th scope="row">{{$key+1}}</th>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->group->name}}</td>
                    @can('users.edit')
                        <td>
                            <a href="{{ route('admin.users.edit', ['user'=> $user->id])}}" class="btn btn-warning btn-sm">Sửa</a>
                        </td>
                    @endcan
                    @can('users.delete')
                       <td>
                        @if (Auth::user()->id !== $user->id)
                            <a onclick="return confirm('Bạn có chắc chắn muốn xoá?')" href="{{ route('admin.users.delete', ['user'=> $user->id])}}" class="btn btn-danger btn-sm">Xoá</a>
                        @endif
                    </td> 
                    @endcan
                </tr>
                @endforeach   
            @else
                <tr><td colspan="6" style="text-align: center">Không tồn tại người dùng nào trong hệ thống</td></tr>
            @endif
        </tbody>
    </table>
@endsection