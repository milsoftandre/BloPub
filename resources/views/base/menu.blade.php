<div class="nav-container">
    <div class="mobile-topbar-header">
        <div>
            <img src="{{ asset('assets/images/logo-icon.png')  }}" class="logo-icon" alt="logo icon">
        </div>
        <div>
            <h4 class="logo-text">BLOGFLY</h4>
        </div>
        <div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
        </div>
    </div>
    <nav class="topbar-nav">
        <ul class="metismenu" id="menu">
            <li>
                <a href="{{ route('dashboard') }}" class="">
                    <div class="parent-icon"><i class='bx bx-home-circle'></i>
                    </div>
                    <div class="menu-title">{{__('menu.index')}}</div>
                </a>
            </li>
            <li>
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bx bx-category"></i>
                    </div>
                    <div class="menu-title">{{__('menu.tasks')}}</div>
                </a>
                <ul style="height: 0px;" class="mm-collapse">
                    @if (Auth::user()->type=='1')
                    <li> <a href="{{ route('tasks.create') }}"><i class="bx bx-right-arrow-alt"></i>{{__('menu.add')}}</a></li>
                    @endif
                    <li> <a href="{{ route('tasks.index') }}"><i class="bx bx-right-arrow-alt"></i>{{__('menu.tasksall')}}</a></li>

                        <li> <a href="{{ route('tasks.index',['status'=>1]) }}"><i class="bx bx-right-arrow-alt"></i>{{__('menu.task1')}}</a></li>
                        <li> <a href="{{ route('tasks.index',['status'=>2]) }}"><i class="bx bx-right-arrow-alt"></i>{{__('menu.task2')}}</a></li>
                        <li> <a href="{{ route('tasks.index',['status'=>4]) }}"><i class="bx bx-right-arrow-alt"></i>{{__('menu.task3')}}</a></li>
                        <li> <a href="{{ route('tasks.index',['status'=>5]) }}"><i class="bx bx-right-arrow-alt"></i>{{__('menu.task4')}}</a></li>
                        <li> <a href="{{ route('tasks.index',['status'=>6]) }}"><i class="bx bx-right-arrow-alt"></i>{{__('menu.task6')}}</a></li>
                </ul>
            </li>
            <li>
                <a class="" href="{{ route('finance.index') }}">
                    <div class="parent-icon"><i class="bx bx-line-chart"></i>
                    </div>
                    <div class="menu-title">{{__('menu.finance')}}</div>
                </a>

            </li>
            @if (Auth::user()->type=='0' || Auth::user()->type=='2')
                <li>
                    <a class="" href="{{ route('withdrawal.index') }}">
                        <span class="alert-count ">{{\App\Models\Withdrawal::where('status',0)->count()}}</span>
                        <div class="parent-icon"><i class='bx bx-bookmark-heart'></i>
                        </div>
                        <div class="menu-title">{{__('menu.withdrawal')}}</div>
                    </a>
                </li>
            @endif
            @if (Auth::user()->type=='0' || Auth::user()->type=='1')

            <li>
                <a class="" href="{{ route('hand.index') }}">
                    <div class="parent-icon"><i class="bx bx-lock"></i>
                    </div>
                    <div class="menu-title">{{__('menu.hand')}}</div>
                </a>

            </li>
            <li>
                <a class="" href="{{ route('client.index') }}">
                    <div class="parent-icon icon-color-6"> <i class="bx bx-donate-blood"></i>
                    </div>
                    <div class="menu-title">{{(Auth::user()->type=='0')?__('employee.ad'):__('menu.clientuser')}}</div>
                </a>
            </li>
            @endif
            @if (Auth::user()->type=='0' || Auth::user()->type=='1')
            <li>
                <a class="has-arrow" href="javascript:;">
                    <div class="parent-icon"><i class='bx bx-message-square-edit'></i>
                    </div>
                    <div class="menu-title">{{__('menu.sys')}}</div>
                </a>
                <ul style="height: 0px;" class="mm-collapse">
                    @if (Auth::user()->type=='0' || Auth::user()->type=='1')
                    <li> <a href="{{ route('group.index') }}"><i class="bx bx-right-arrow-alt"></i>{{__('menu.group')}}</a></li>
                    @endif
                        @if (Auth::user()->type=='0')
                            <li> <a href="{{ route('agent.index') }}"><i class="bx bx-right-arrow-alt"></i>{{__('menu.agent')}}</a></li>

                            <li> <a href="{{ route('employee.index') }}"><i class="bx bx-right-arrow-alt"></i>{{__('menu.employee')}}</a></li>
                            <li> <a href="{{ route('services.index') }}"><i class="bx bx-right-arrow-alt"></i>{{__('menu.services')}}</a></li>

                            <li> <a href="{{ route('settings.index') }}"><i class="bx bx-right-arrow-alt"></i>{{__('menu.settings')}}</a></li>
                            <li> <a href="{{ route('templates.index') }}"><i class="bx bx-right-arrow-alt"></i>{{__('menu.templates')}}</a></li>
                            <li> <a href="{{ route('apid') }}"><i class="bx bx-right-arrow-alt"></i>API</a></li>
                        @endif
                </ul>
            </li>
            @endif
        </ul>
    </nav>
</div>

