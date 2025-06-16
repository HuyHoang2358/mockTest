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

        <!--Quản lý Nhóm người dùng-->
        @include('admin.partials.common.sideMenuItems', [
            'page' => $page,
            'pageTags' => [
                [
                    'manage-users' => [
                        'display' => 'Quản lý tài khoản',
                        'icon' => 'users',
                    ],
                ],
                [
                    'manage-user' => [
                        'display' => 'Tài khoản học sinh',
                        'icon' => 'user',
                        'route' => 'admin.user.index',
                    ],
                ],
                [
                    'manage-teacher' => [
                        'display' => 'Tài khoản giáo viên',
                        'icon' => 'pen-tool',
                        'route' => 'admin.teacher.index',
                    ],
                ],
            ],
        ])
        <!--Quản lý danh mục -->
        @include('admin.partials.common.sideMenuItems', [
           'page' => $page,
           'pageTags' => [
               [
                   'manage-category' => [
                       'display' => 'Quản lý dạnh mục',
                       'icon' => 'bookmark',
                   ],
               ],
               [
                   'manage-question-type' => [
                       'display' => 'Loại câu hỏi',
                       'icon' => 'layers',
                       'route' => 'admin.question-type.index'
                   ],
               ]
           ],
       ])
        <!--Quản lý dữ liệu -->
        @include('admin.partials.common.sideMenuItems', [
           'page' => $page,
           'pageTags' => [
               [
                   'manage-data' => [
                       'display' => 'Quản lý dữ liệu',
                       'icon' => 'hard-drive',
                   ],
               ],
               [
                   'manage-folder' => [
                       'display' => 'Thư mục',
                       'icon' => 'folder',
                       'route' => 'admin.folder.index',
                   ],
               ]
           ],
       ])
    </ul>
</nav>
