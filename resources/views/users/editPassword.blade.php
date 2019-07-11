@extends('layouts.app')
@section('title','修改密码')
@section('content')
<div class="offset-md-2 col-md-8">
    <div class="card ">
        <div class="card-header">
            <h4>修改密码</h4>
        </div>
        <div class="card-body">
            @include('shared._error')
            <form action="{{route('users.password',$user->id)}}" method="POST">
                @csrf
                @method('PATCH')          
                <div class="form-group">
                    <label for="password_old">旧密码：</label>
                    <input type="password" name="password_old" class="form-control" value="{{ old('password_old') }}">
                </div>

                <div class="form-group">
                    <label for="password">新密码：</label>
                    <input type="password" name="password" class="form-control" value="{{ old('password') }}">
                </div>

                <div class="form-group">
                    <label for="password_confirmation">确认密码：</label>
                    <input type="password" name="password_confirmation" class="form-control"
                        value="{{ old('password_confirmation') }}">
                </div>

                <button type="submit" class="btn btn-primary">修改</button>

            </form>
        </div>
    </div>
</div>
@endsection
