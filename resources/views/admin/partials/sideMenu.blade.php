<nav class="side-nav">
    <ul>
        <li>
            <a href="{{ route('admin.dashboard') }}"
               class="side-menu {{ isset($page) ? ($page == 'homepage' ? 'side-menu--active' : '') : '' }}">
                <div class="side-menu__icon"><i data-lucide="home"></i></div>
                <div class="side-menu__title"> Trang chủ</div>
            </a>
        </li>
        <li class="side-nav__devider my-6"></li>
        <!--Nhóm người dùng-->
        @include('admin.partials.common.sideMenuItems', [
                    'page' => $page,
                    'pageTags' => [
                        [
                            'manage-users' => [
                                'display' => 'Quản lý người dùng',
                                'icon' => 'users',
                            ],
                        ],
                        [
                            'manage-user' => [
                                'display' => 'Quản lý học sinh',
                                'icon' => 'user',
                                'route' => 'admin.user.index',
                            ],
                        ],
                        [
                            'manage-teacher' => [
                                'display' => 'Quản lý giáo viên',
                                'icon' => 'pen-tool',
                                'route' => 'admin.teacher.index',
                            ],
                        ],
                    ],
                ])
    </ul>
</nav>
