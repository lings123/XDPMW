<nav class="nav__sidebar user_profile_nav">
    <ul>
        <li @if(url()->current() == route('user.profile'))  @endif>
            <a href="{{ route('user.profile') }}">Thông tin cá nhân</a>
        </li>
        <li @if(url()->current() == route('get.password'))  @endif>
            <a href="{{ route('get.password')}}">Đổi mật khẩu</a>
        </li>
      
    </ul>
</nav>