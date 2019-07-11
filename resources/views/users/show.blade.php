@extends('layouts.app')

@section('title', $user->name . ' 的个人中心')

@section('styles')
<style>
    .user-name {
        width: 100%;
        text-align: center;
    }

    .avatar {
        width: 80%;
    }

    .card-avatar {
        margin-top: 15px;
        ;
    }
</style>
@endsection

@section('content')

<div class="row">

    <div class="col-lg-3 col-md-3 hidden-sm hidden-xs user-info">
        <div class="card">
            <div class="user-name card-avatar">
                <img class="card-img-top img-thumbnail rounded-circle align-self-start avatar" src="{{$user->avatar}}"
                    alt="{{ $user->name }}">
            </div>
            <hr>
            <div class="card-body">
                <div class="user-name">
                    <h5>
                        <strong>{{$user->name}}</strong>
                    </h5>
                    <p>
                        E-mail：{{$user->email}}
                        <br>
                        注册于：{{$user->created_at->diffForHumans()}}
                    </p>
                </div>
                <hr>
                <div class="user-name">
                    <h6><b>个人简介</b></h6>
                    <p>
                        {{$user->introduction}}
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
        {{-- 用户发布的内容 --}}
        <div class="card ">
            <div class="card-body">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link bg-transparent {{ active_class(if_query('tab', null)) }}"
                            href="{{ route('users.show', $user->id) }}">
                            Ta 的话题
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link bg-transparent {{ active_class(if_query('tab', 'replies')) }}"
                            href="{{ route('users.show', [$user->id, 'tab' => 'replies']) }}">
                            Ta 的回复
                        </a>
                    </li>
                </ul>
                @if (if_query('tab', 'replies'))
                @include('users._replies', ['replies' => $user->replies()->with('topic')->recent()->paginate(10)])
                @else
                @include('users._topics', ['topics' => $user->topics()->recent()->paginate(15)])
                @endif
            </div>
        </div>

    </div>
</div>
@stop