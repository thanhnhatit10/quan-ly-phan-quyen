@extends('layouts.admin')
@section('title', 'Sửa nhóm người dùng')
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Sửa nhóm người dùng</h1>
    </div>
    @if ($errors->any())
        <x-alert type="danger" message="Vui lòng kiểm tra lại dữ liệu" />
    @endif
    <form action="" method="post">
        @csrf
        <div class="form-group">
            <label for="exampleInputEmail1">Tên nhóm</label>
            <input type="text" name="name" value="{{old('name')?? $group->name}}" class="form-control @error('name') is-invalid @enderror" placeholder="Nhập tên nhóm...">
            @error('name')
                <small style="color: red; font-size: 15px;font-style: italic">{{ $message}}</small>     
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Sửa nhóm người dùng</button>
    </form>
@endsection