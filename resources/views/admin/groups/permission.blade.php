@extends('layouts.admin')
@section('title', 'Phân quyền nhóm người dùng')
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Phân quyền nhóm: {{ $group->name }}</h1>
    </div>
    @if (session('msg'))
        <div class="alert alert-primary" role="alert">
            <strong>{{ session('msg') }}</strong>
        </div>
    @endif
    <form action="" method="post">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th width="20%">Modules</th>
                    <th>Quyền</th>
                </tr>
            </thead>
            <tbody>
                @if ($modules->count() >0)
                    @foreach ($modules as $module)
                        <tr>
                            <td scope="row">{{ ucfirst($module->title) }}</td>
                            <td>
                                <div class="row">
                                    @if (!empty($roleListArr))
                                        @foreach ($roleListArr as $roleName => $roleLabel)
                                            <div class="col-1">
                                                <label for="role_{{ $module->name }}_{{ $roleName }}">
                                                    <input type="checkbox" name="role[{{ $module->name }}][]" value="{{ $roleName }}" id="role_{{ $module->name }}_{{ $roleName }}" {{ isRole($roleArr, $module->name, $roleName)?'checked':false }}>
                                                    {{ $roleLabel }}
                                                </label>
                                            </div>
                                        @endforeach
                                    @endif
                                    @if ($module->name == 'groups')
                                        <div class="col-2">
                                            <label for="role_{{ $module->name }}_permission">
                                                <input type="checkbox" name="role[{{ $module->name }}][]" value="permission" id="role_{{ $module->name }}_permission"  {{ isRole($roleArr, $module->name, 'permission')?'checked':false }}>
                                                Phân quyền
                                            </label>
                                        </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        <button type="submit" class="btn btn-primary">Phân quyền</button>
        @csrf
    </form>
@endsection