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
                <li class="cd-label">Main menu</li>
                <li class="about active">
                    <a href="{{ route('backend_post_edit', ['slug' => 'about', 'id' => 4]) }}">
                        <b class="fa fa-bullhorn"></b>
                        <span>{{ _t('backend_about') }}</span>
                    </a>
                </li>
                <li class="about">
                    <a href="{{ route('backend_post_edit', ['slug' => 'contact', 'id' => 5]) }}">
                        <b class="fa fa-credit-card"></b>
                        <span>{{ _t('backend_contact') }}</span>
                    </a>
                </li>
                <li class="sliders">
                    <a href="{{ route('backend_images', ['slug' => 'carousel']) }}">
                        <b class="fa fa-sliders"></b>
                        <span>{{ _t('backend_sliders') }}</span>
                    </a>
                </li>
                <li class="sliders">
                    <a href="{{ route('backend_meta') }}">
                        <b class="fa fa-bookmark-o"></b>
                        <span>{{ _t('backend_meta') }}</span>
                    </a>
                </li>
                <li class="has-children post-categories">
                    <a href="{{ route('backend_post_categories') }}">
                        <b class="fa fa-newspaper-o"></b>
                        <span>{{ _t('backend_pc') }}</span>
                    </a>
                    <ul>
                        <li><a href="{{ route('backend_post_categories') }}">{{ _t('backend_pc_list') }}</a></li>
                        <li><a href="{{ route('backend_pc_add') }}">{{ _t('backend_pc_new') }}</a></li>
                    </ul>
                </li>
                <li class="has-children post-categories">
                    <a href="{{ route('backend_image_categories') }}">
                        <b class="fa fa-image"></b>
                        <span>{{ _t('backend_ic') }}</span>
                    </a>
                    <ul>
                        <li><a href="{{ route('backend_image_categories') }}">{{ _t('backend_ic_list') }}</a></li>
                        <li><a href="{{ route('backend_ic_add') }}">{{ _t('backend_ic_new') }}</a></li>
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
                <li class="has-children roles">
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
    <script src="{{ asset('packages/king/backend/js/main.js') }}"></script>
    <script type="text/javascript">
        tinymce.init({
            selector: "#_tinymce",
            theme: "modern",
            skin: "lightgray",
            menubar: false,
            subfolder: "",
            resize: false,
            plugins: [
            "advlist autolink link image lists charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code insertdatetime media nonbreaking",
            "table contextmenu directionality emoticons autoresize paste textcolor filemanager hr fullscreen"
            ],
            image_advtab: true,
            toolbar1: "bold,italic,strikethrough,bullist,numlist,blockquote,hr,alignleft,aligncenter,alignright,link,unlink,wp_more,spellchecker,dfw,wp_adv,separator,image,fullscreen",
            toolbar2: "fontsizeselect,formatselect,underline,alignjustify,forecolor,paste,removeformat,charmap,outdent,indent,undo,redo,wp_help",
            toolbar3: "",
            toolbar4: "",
            fontsize_formats: "7px 8px 9px 10px 11px 12px 13px 14px 15px 16px 17px 18px 19px 20px 22px 24px 36px 40px"
        });
        //backcolor
    </script>

</body>
</html>