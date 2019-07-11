<nav class="navbar navbar-expand-lg navbar-light bg-light navbar-static-top">
  <div class="container">
    <!-- Branding Image -->
    <a href="{{ url('/') }}">
      <div class="text site-logo" style="color:#888888;display: flex;">
        <img class="ui image" style="width:26px;height:26px;margin-top:-2px;" src="/web/logo.png">
        <span class="site-name"></span>
        <i class="dropdown icon ml-3"></i>
      </div>
      <a class="navbar-brand" href="{{ url('/') }}">
        <strong>{{env('APP_NAME')}}</strong>
      </a>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <!-- Left Side Of Navbar -->
      <ul class="navbar-nav mr-auto">
        <li class="nav-item {{ active_class(if_route('topics.index')) }}">
          <a class="nav-link" href="{{ route('topics.index') }}">话题</a>
        </li>
        @foreach (category_list() as $item)
        <li class="nav-item {{ category_nav_active($item->id) }}">
          <a class="nav-link" href="{{ route('categories.show', $item->id) }}">{{$item->name}}</a>
        </li>
        @endforeach
      </ul>

      <!-- Right Side Of Navbar -->
      <ul class="navbar-nav navbar-right">
        <li class="nav-item">
          <a class="nav-link" href="{{ route('topics.create') }}">
            <i class="fa fa-paper-plane"></i> 发布
          </a>
        </li>
        <!-- Authentication Links -->
        @guest
        <li class="nav-item">
          <a class="nav-link" href="{{ route('login') }}">
            <i class="fa fa-globe"></i> 登录
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('register') }}">
            <i class="fa fa-user-plus"></i>
            注册
          </a>
        </li>
        @else
        <li class="nav-item notification-badge">
          <a class="nav-link mr-3 badge badge-pill badge-{{ Auth::user()->notification_count > 0 ? 'hint' : 'secondary' }} text-white"
            href="{{ route('notifications.index') }}">
            {{ Auth::user()->notification_count }}
          </a>
        </li>
        <li class="nav-item dropdown">
        <li class="nav-item dropdown">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <img src="{{Auth::user()->avatar}}" class="img-responsive img-circle rounded-circle align-self-start"
              height="25px" width="25px">
            <b>{{ Auth::user()->name }}</b>
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            @can('manage_contents')
            <a class="dropdown-item" href="{{ url(config('administrator.uri')) }}">
              <i class="fas fa-tachometer-alt mr-2"></i>
              管理后台
            </a>
            <div class="dropdown-divider"></div>
            @endcan
            <a class="dropdown-item" href="{{ route('users.show', Auth::id()) }}">
              <i class="far fa-user mr-2"></i>
              个人中心
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{ route('users.edit', Auth::id()) }}">
              <i class="far fa-edit mr-2"></i>
              编辑资料
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="{{route('users.password',Auth::id())}}">
              <i class="fa fa-key mr-2"></i>
              修改密码
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" id="logout" href="#">
              <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('您确定要退出吗？');">
                {{ csrf_field() }}
                <button class="btn btn-block btn-danger" type="submit" name="button">退出</button>
              </form>
            </a>
          </div>
        </li>
        @endguest
      </ul>
    </div>
  </div>
</nav>