@extends('layouts.admin')
@section('title', 'Thêm người dùng')
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Thêm người dùng</h1>
    </div>
    @if ($errors->any())
        <x-alert type="danger" message="Vui lòng kiểm tra lại dữ liệu" />
    @endif
    <form action="" method="post">
        @csrf
        <div class="form-group">
            <label for="exampleInputEmail1">Họ tên</label>
            <input type="text" name="name" value="{{old('name')}}" class="form-control @error('name') is-invalid @enderror" placeholder="Nhập họ tên...">
            @error('name')
                <small style="color: red; font-size: 15px;font-style: italic">{{ $message}}</small>     
            @enderror
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Email</label>
            <input type="text" name="email" value="{{old('email')}}" class="form-control @error('email') is-invalid @enderror" placeholder="Nhập email...">
            @error('email')
                <small style="color: red; font-size: 15px;font-style: italic">{{ $message}}</small>     
            @enderror
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Mật khẩu</label>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Nhập mật khẩu...">
            @error('password')
                <small style="color: red; font-size: 15px;font-style: italic">{{ $message}}</small>     
            @enderror
        </div>
        <div class="form-group">
            <label for="">Nhóm</label>
            <select name="group_id" class="custom-select @error('group_id') is-invalid @enderror">
                <option selected value="0">Vui lòng chọn nhóm</option>
                @foreach ($groups as  $item)
                    <option  value="{{$item->id}}" {{old('group_id')==$item->id?'selected':false}}>{{$item->name}}</option>
                @endforeach
              </select>
            @error('group_id')
                <small style="color: red; font-size: 15px;font-style: italic">{{ $message}}</small>     
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Thêm người dùng</button>
    </form>
@endsection