<ul class="vertical-nav-menu">
    <li class="app-sidebar__heading">Меню</li>
    @role('admin')
    <li class="mm-active">
        <a href="#">
            <i class="metismenu-icon pe-7s-bell"></i>
            Администрирование
            <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
        </a>
        <ul>
            <li>
                <a href="{{route('subjects.index')}}">
                    <i class="metismenu-icon">
                    </i> Предметы
                </a>
            </li>
            <li>
                <a href="{{route('groups.index')}}">
                    <i class="metismenu-icon">
                    </i> Группы
                </a>
            </li>
        </ul>
    </li>
    @endrole
    @role('teacher')
    <li class="mm-active">
        <a href="#">
            <i class="metismenu-icon pe-7s-display2"></i>
            Тесты
            <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
        </a>
        <ul>
            <li>
                <a href="{{route('questions.index')}}">
                    <i class="metismenu-icon">
                    </i>Вопросы
                </a>
            </li>
            <li>
                <a href="{{route('tests.index')}}">
                    <i class="metismenu-icon"></i>
                    Тесты
                </a>
            </li>
            <li>
                <a href="{{route('admin:results:index')}}">
                    <i class="metismenu-icon">
                    </i>Результаты
                </a>
            </li>
        </ul>
    </li>
    @endrole
    @role('admin')
    <li class="mm-active">
        <a href="#">
            <i class="metismenu-icon pe-7s-mouse"></i>
            Пользователи
            <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
        </a>
        <ul>
            <li>
                <a href="{{route('user.index')}}">
                    <i class="metismenu-icon">
                    </i> Все пользователи
                </a>
            </li>
            <li>
                <a href="{{route('role.index')}}">
                    <i class="metismenu-icon">
                    </i> Управление доступом
                </a>
            </li>
        </ul>
    </li>
    @endrole
    @yield('dopMenu')
    <li class="mm-active">
        <a href="#">
            <i class="metismenu-icon pe-7s-user"></i>
            Учетная запись
            <i class="metismenu-state-icon pe-7s-angle-down caret-left"></i>
        </a>
        <ul>
            <li>
                <a>
                    <i class="metismenu-icon">
                    </i> {{Auth::user()->name}}
                </a>
            </li>
            <li>
                <a>
                    <i class="metismenu-icon">
                    </i> {{Auth::user()->email}} (#{{Auth::user()->id}})
                </a>
            </li>
            <li>
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                   class="font-weight-bold"
                >
                    <i class="metismenu-icon">
                    </i> Выйти
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                      style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </li>
    <li class="mm-active">
        <ul>


        </ul>
    </li>
</ul>
