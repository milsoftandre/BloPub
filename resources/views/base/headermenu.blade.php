<header>
    <div class="topbar d-flex align-items-center">
        <nav class="navbar navbar-expand">
            <div class="topbar-logo-header">
                <div class="">
                    <img src="{{ asset('assets/images/logonobg.png')  }}" class="logo-icon" alt="logo icon">
                </div>
                <div class="">
                    <h4 class="logo-text">BLOGFLY</h4>
                </div>
            </div>
            <div class="mobile-toggle-menu"><i class='bx bx-menu'></i></div>
            <div class="search-bar flex-grow-1">
                <div class="position-relative search-bar-box">
                    @if (Session::get('locale')=='en')
                        <div class="menu-item me-lg-1">
                            <a class="menu-link py-3" href="{{ route('lang','ru') }}">
                                <span class="menu-title">Рус</span>
                            </a>
                        </div>
                    @endif
                    @if (Session::get('locale')=='ru' || !Session::get('locale'))
                        <div class="menu-item me-lg-1">
                            <a class="menu-link py-3" href="{{ route('lang','en') }}">
                                <span class="menu-title">Eng</span>
                            </a>
                        </div>
                    @endif


                </div>
            </div>

            @php
                $adminS = \App\Models\Settings::find(1);

                if(Auth::user()->lang!=Session::get('locale')){
                    \App\Models\Employee::find(Auth::user()->id)->update(['lang'=>Session::get('locale')]);
                    }



            @endphp
            <div class="top-menu ms-auto">
                <ul class="navbar-nav align-items-center">
                    <li class="hidden-xs">
                        <a class="nav-link" href="#">	{{__('menu.b')}}:
                            @if(Auth::user()->employees_id && Auth::user()->type != 2)
                                {{ number_format(\App\Models\Employee::find(Auth::user()->employees_id)->balance, 2, ',', ' ') }}
                            @endif
                            @if(Auth::user()->type == 2)
                                {{ number_format(Auth::user()->balance, 2, ',', ' ') }}
                            @endif
                            @if(!Auth::user()->employees_id && Auth::user()->type != 2)
                                {{ number_format(Auth::user()->balance, 2, ',', ' ') }}
                            @endif

                            {{$adminS->currency}}
                        </a>
                    </li>
                    <li class="nav-item mobile-search-icon">
                        <a class="nav-link" href="#">	<i class='bx bx-flag'></i>
                        </a>
                    </li>

                    <li class="nav-item dropdown dropdown-large">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="alert-count">{{ \App\Models\Notifications::where(['user_id'=>Auth::user()->id, 'status'=>0])->count() }}</span>
                            <i class='bx bx-bell'></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="javascript:;">
                                <div class="msg-header">
                                    <p class="msg-header-title">Уведомления</p>

                                </div>
                            </a>
                            <div class="header-notifications-list">
                                @foreach (\App\Models\Notifications::where(['user_id'=>Auth::user()->id, 'status'=>0])->get() as $row)
                                <a class="dropdown-item" href="{{ route('tasks.index') }}">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h6 class="msg-name">Задача<span class="msg-time float-end">{{$row->created_at}}</span></h6>
                                            <p class="msg-info">{{$row->text}}</p>
                                        </div>
                                    </div>
                                </a>
                                @endforeach
                            </div>
                            <a href="javascript:;">
                                <div class="text-center msg-footer">Посмотреть все уведомления</div>
                            </a>
                        </div>
                    </li>
                    <li class="nav-item dropdown dropdown-large">
                        <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="alert-count messcount" style="display:none">+</span>
                            <i class='bx bx-comment'></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="#" onclick="upChatRead(); $('.messcount').hide();">
                                <div class="msg-header">
                                    <p class="msg-header-title">Сообщения</p>
                                    <p class="msg-header-clear ms-auto">Пометить как прочитанные</p>
                                </div>
                            </a>
                            <div class="header-message-list" style="    display: none;">
                                <a class="dropdown-item" href="javascript:;">
                                    <div class="d-flex align-items-center">
                                        <div class="user-online">
                                            <img src="{{ asset('assets/images/avatars/avatar-1.png')  }}" class="msg-avatar" alt="user avatar">
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="msg-name">Иван иванов <span class="msg-time float-end">5 sec
												ago</span></h6>
                                            <p class="msg-info">Сообщение</p>
                                        </div>
                                    </div>
                                </a>

                            </div>
                            <a href="{{ route('chat') }}">
                                <div class="text-center msg-footer">Все чаты</div>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="user-box dropdown">
                <a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{(Auth::user()->file)?asset('upload/images/'.Auth::user()->file):asset('assets/images/avatars/avatar-2.png')}}" class="user-img" alt="user avatar">
                    <div class="user-info ps-3">
                        <p class="user-name mb-0">{{ Auth::user()->name }}</p>
                        <p class="designattion mb-0">{{ Auth::user()->email }}</p>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('profile') }}"><i class="bx bx-user"></i><span>{{__('menu.profile')}}</span></a>
                    </li>

                    <li>
                        <div class="dropdown-divider mb-0"></div>
                    </li>
                    <li><a class="dropdown-item" href="{{ route('logout') }}"><i class='bx bx-log-out-circle'></i><span>{{__('menu.logout')}}</span></a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</header>

