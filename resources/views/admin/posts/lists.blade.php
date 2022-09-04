@extends('layouts.admin')
@section('title', 'Dach sách bài ')
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Danh sách bài </h1>
    </div>
    @if (session('msg'))
        <div class="alert alert-primary" role="alert"> <strong>{{session('msg')}}</strong></div>
    @endif
    @can('create', App\Models\Posts::class)
        <a href="{{route('admin.posts.add')}}" class="btn btn-success mb-3">Thêm bài viết</a>
    @endcan
    <table class="table table-bordered">
        <thead>
            <tr>
                <th width="5%">#</th>
                <th scope="col">Tiêu đề</th>
                <th scope="col">Nội dung</th>
                <th width="10%">Người tạo</th>
                @can('posts.edit')
                    <th width="5%">Sửa</th>
                @endcan
                @can('posts.delete')
                    <th width="5%">Xoá</th>
                @endcan
            </tr>
        </thead>
        <tbody>
            @if ($listPosts->count() > 0)
                @foreach ($listPosts as $key => $post)
               <tr>
                    <th scope="row">{{$key+1}}</th>
                    <td>{{$post->title}}</td>
                    <td>{{$post->content}}</td>
                    <td>{{$post->user->name}}</td>
                    @can('posts.edit')
                        <td>
                            <a href="{{ route('admin.posts.edit', ['post'=> $post->id])}}" class="btn btn-warning btn-sm">Sửa</a>  
                        </td>
                    @endcan
                    @can('posts.delete')
                        <td>
                            <a onclick="return confirm('Bạn có chắc chắn muốn xoá?')" href="{{ route('admin.posts.delete', ['post'=> $post->id])}}" class="btn btn-danger btn-sm">Xoá</a>
                        </td>
                    @endcan
                </tr>
                @endforeach   
            @else
                <tr><td colspan="6">Không tồn tại người dùng nào trong hệ thống</td></tr>
            @endif
        </tbody>
    </table>
@endsection