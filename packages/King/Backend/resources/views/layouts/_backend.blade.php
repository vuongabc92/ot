<!doctype html>
<html lang="en" class="no-js">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{ asset('packages/king/backend/css/reset.css') }}"> <!-- CSS reset -->
        <link rel="stylesheet" href="{{ asset('packages/king/backend/css/bootstrap.css') }}"> <!-- CSS reset -->
        <link rel="stylesheet" href="{{ asset('packages/king/backend/css/font-awesome.css') }}"> <!-- CSS reset -->
        <link rel="stylesheet" href="{{ asset('packages/king/backend/css/common.css') }}"> <!-- Resource style -->
        <link rel="stylesheet" href="{{ asset('packages/king/backend/css/style.css') }}"> <!-- Resource style -->
        <script src="{{ asset('packages/king/backend/js/modernizr.js') }}"></script> <!-- Modernizr -->

        <title>King Elephant</title>
    </head>
    <body>
        <header class="cd-main-header">
            <a href="#0" class="cd-logo"><img src="{{ asset('packages/king/backend/images/cd-logo.svg') }}" alt="Logo"></a>

            <div class="cd-search is-hidden">
                <form action="#0">
                    <input type="search" placeholder="Search...">
                </form>
            </div> <!-- cd-search -->

            <a href="#0" class="cd-nav-trigger">Menu<span></span></a>

            <nav class="cd-nav">
                <ul class="cd-top-nav">
                    <li><a href="#0">Tour</a></li>
                    <li><a href="#0">Support</a></li>
                    <li class="has-children account">
                        <a href="#0">
                            @if (check_file(config('back.avatar_path') . user()->avatar))
                                <img src="{{ asset(config('back.avatar_path') . user()->avatar) }}" alt="avatar">
                            @else
                                <b class="default-avatar default-image avatar-header _r50 fa fa-image"></b>
                            @endif
                            <span class="username">{{ user()->username }}</span>
                        </a>

                        <ul>

                            <li><a href="#0">My Account</a></li>
                            <li><a href="#0">Edit Account</a></li>
                            <li><a href="{{ route('backend_logout') }}">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </header> <!-- .cd-main-header -->

    <main class="cd-main-content">
        <nav class="cd-side-nav">
            <ul>
                <li class="cd-label">Main</li>
                <li class="has-children overview">
                    <a href="#0">Overview</a>

                    <ul>
                        <li><a href="#0">All Data</a></li>
                        <li><a href="#0">Category 1</a></li>
                        <li><a href="#0">Category 2</a></li>
                    </ul>
                </li>
                <li class="has-children notifications">
                    <a href="#0">Notifications<span class="count">3</span></a>

                    <ul>
                        <li><a href="#0">All Notifications</a></li>
                        <li><a href="#0">Friends</a></li>
                        <li><a href="#0">Other</a></li>
                    </ul>
                </li>

                <li class="has-children comments active">
                    <a href="#0">Comments</a>

                    <ul>
                        <li><a href="#0">All Comments</a></li>
                        <li><a href="#0">Edit Comment</a></li>
                        <li><a href="#0">Delete Comment</a></li>
                    </ul>
                </li>
            </ul>

            <ul>
                <li class="cd-label">Secondary</li>
                <li class="has-children users">
                    <a href="{{ route('backend_post_categories') }}">
                        <b class="fa fa-list"></b>
                        <span>{{ _t('backend_pc') }}</span>
                    </a>
                    <ul>
                        <li><a href="{{ route('backend_post_categories') }}">{{ _t('backend_pc_list') }}</a></li>
                        <li><a href="{{ route('backend_pc_add') }}">{{ _t('backend_pc_new') }}</a></li>
                    </ul>
                </li>
                <li class="has-children users">
                    <a href="{{ route('backend_users') }}">
                        <b class="glyphicon glyphicon-user"></b>
                        <span>{{ _t('backend_users') }}</span>
                    </a>
                    <ul>
                        <li><a href="{{ route('backend_users') }}">{{ _t('backend_user_all') }}</a></li>
                        <li><a href="{{ route('backend_user_add') }}">{{ _t('backend_user_new') }}</a></li>
                    </ul>
                </li>
                <li class="has-children users">
                    <a href="{{ route('backend_roles') }}">
                        <b class="fa fa-code-fork"></b>
                        <span>{{ _t('backend_roles') }}</span>
                    </a>
                    <ul>
                        <li><a href="{{ route('backend_roles') }}">{{ _t('backend_role_all') }}</a></li>
                        <li><a href="{{ route('backend_role_add') }}">{{ _t('backend_role_new') }}</a></li>
                    </ul>
                </li>
            </ul>

            <ul>
                <li class="cd-label">Action</li>
                <li class="action-btn"><a href="#0">+ Button</a></li>
            </ul>
        </nav>

        <div class="content-wrapper">
            <div class="_fwfl _mt20 king-content">
                @yield('content')
            </div>
        </div> <!-- .content-wrapper -->
    </main> <!-- .cd-main-content -->
    <script src="{{ asset('packages/king/backend/js/jquery-2.1.4.js') }}"></script>
    <script src="{{ asset('packages/king/backend/js/jquery-ui-1.11.4.js') }}"></script>
    <script src="{{ asset('packages/king/backend/js/jquery.menu-aim.js') }}"></script>
    <script src="{{ asset('packages/king/backend/js/bootstrap.js') }}"></script>
    <script src="{{ asset('tinymce/js/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('packages/king/backend/js/main.js') }}"></script> <!-- Resource jQuery -->
    <script type="text/javascript">
        tinymce.init({
            selector: "#_tinymce",
            theme: "modern",
            subfolder:"",
            plugins: [
            "advlist autolink link image lists charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code insertdatetime media nonbreaking",
            "table contextmenu directionality emoticons paste textcolor filemanager"
            ],
            image_advtab: true,
            toolbar: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect forecolor backcolor | link unlink anchor | image media | print preview code"
        });
    </script>

</body>
</html>