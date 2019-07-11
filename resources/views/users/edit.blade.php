@extends('layouts.app')

@section('title', $user->name . ' -编辑')
@section('styles')
<style>
    .avatar {
        width: 200px;
        height: 200px;
    }
</style>
@endsection

@section('content')

<div class="container">
    <div class="col-md-8 offset-md-2">

        <div class="card">
            <div class="card-header">
                <h4>
                    <i class="glyphicon glyphicon-edit"></i> 编辑个人资料
                </h4>
            </div>

            <div class="card-body">

                <form action="{{ route('users.update', $user->id) }}" method="POST" accept-charset="UTF-8"
                    enctype="multipart/form-data">
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    @include('shared._error')

                    <div class="form-group">
                        <label for="name-field">用户名</label>
                        <input class="form-control" type="text" name="name" id="name-field" value="{{ $user->name }}"
                            readonly />
                    </div>
                    <div class="form-group">
                        <label for="email-field">邮 箱</label>
                        <input class="form-control" type="text" name="email" id="email-field" value="{{ $user->email }}"
                            readonly />
                    </div>
                    <div class="form-group">
                        <label for="introduction-field">个人简介</label>
                        <textarea name="introduction" id="introduction-field" class="form-control"
                            rows="5">{{ old('introduction', $user->introduction) }}</textarea>
                    </div>

                    <div class="form-group mb-4">
                        <label for="" class="avatar-label">用户头像</label>
                        {{-- <input type="file" name="avatar" class="form-control-file"> --}}
                        <input type="file" accept="image/*" name="avatar" onchange="loadAvatar(this)" value=""
                            id="avatar" style="display:none" />
                        @if($user->avatar)
                        <br>
                        <div onclick="avatarClick()">
                            <img id="avatarImage"
                                class="thumbnail img-responsive img-thumbnail img-circle rounded-circle avatar"
                                src="{{ $user->avatar }}" style="" />
                        </div>
                        @endif
                    </div>

                    <div class="well well-sm">
                        <button type="submit" class="btn btn-primary">保 存</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
<script>
    function avatarClick() {
        $('#avatar').click();
    }

    function loadAvatar(imgFile) {
        var file = imgFile.files[0];
        if (file != undefined) {
            var reader = new FileReader();
            reader.readAsDataURL(file); //将文件读取为Data URL小文件   这里的小文件通常是指图像与 html 等格式的文件
            reader.onload = function (e) {
                $("#avatarImage").attr("src", e.target.result);
            }
        }
    }

</script>
@endsection