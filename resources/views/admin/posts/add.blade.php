@extends('layouts.admin')
@section('title', 'Thêm bài viết')
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Thêm bài viết</h1>
    </div>
    @if ($errors->any())
        <x-alert type="danger" message="Vui lòng kiểm tra lại dữ liệu" />
    @endif
    <form action="" method="post">
        @csrf
        <div class="form-group">
            <label for="exampleInputEmail1">Tiêu đề</label>
            <input type="text" name="title" value="{{old('title')}}" class="form-control @error('title') is-invalid @enderror" placeholder="Nhập tiêu đề...">
            @error('title')
                <small style="color: red; font-size: 15px;font-style: italic">{{ $message}}</small>     
            @enderror
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Tiêu đề</label>
            <textarea name="content"  class="form-control @error('content') is-invalid @enderror" placeholder="Nhập nội dung...">{{old('content')}}</textarea>
            @error('content')
                <small style="color: red; font-size: 15px;font-style: italic">{{ $message}}</small>     
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Thêm bài viết</button>
    </form>
@endsection