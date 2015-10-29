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

        <title>@yield('title') King Elephant</title>
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
                            <li><a href="{{ route('backend_user_edit', user()->id) }}">{{ _t('backend_common_editacc') }}</a></li>
                            <li><a href="{{ route('backend_logout') }}">{{ _t('backend_common_logout') }}</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </header> <!-- .cd-main-header -->

    <main class="cd-main-content">
        <nav class="cd-side-nav">
            <ul>
                <li class="cd-label">Products</li>
                <li class="about has-children {{ nav_active('category-one', $active) }}">
                    <a href="{{ route('backend_category_one', 'products') }}">
                        <b class="fa fa-th-list"></b>
                        <span>{{ _t('backend_co') }}</span>
                    </a>
                    <ul>
                        <li><a href="{{ route('backend_category_one', 'products') }}">{{ _t('backend_co_list') }}</a></li>
                        <li><a href="{{ route('backend_co_add', 'products') }}">{{ _t('backend_co_new') }}</a></li>
                    </ul>
                </li>
                <li class="about has-children {{ nav_active('category-two', $active) }}">
                    <a href="{{ route('backend_category_two') }}">
                        <b class="fa fa-th-list"></b>
                        <span>{{ _t('backend_ct') }}</span>
                    </a>
                    <ul>
                        <li><a href="{{ route('backend_category_two') }}">{{ _t('backend_ct_list') }}</a></li>
                        <li><a href="{{ route('backend_ct_add') }}">{{ _t('backend_ct_new') }}</a></li>
                    </ul>
                </li>
                <li class="about has-children {{ nav_active('category-three', $active) }}">
                    <a href="{{ route('backend_category_three') }}">
                        <b class="fa fa-th-list"></b>
                        <span>{{ _t('backend_cth') }}</span>
                    </a>
                    <ul>
                        <li><a href="{{ route('backend_category_three') }}">{{ _t('backend_cth_list') }}</a></li>
                        <li><a href="{{ route('backend_cth_add') }}">{{ _t('backend_cth_new') }}</a></li>
                    </ul>
                </li>
                <li class="about has-children {{ nav_active('product', $active) }}">
                    <a href="{{ route('backend_products') }}">
                        <b class="fa fa-th-list"></b>
                        <span>{{ _t('backend_products') }}</span>
                    </a>
                    <ul>
                        <li><a href="{{ route('backend_products') }}">{{ _t('backend_product_list') }}</a></li>
                        <li><a href="{{ route('backend_product_add') }}">{{ _t('backend_product_new') }}</a></li>
                    </ul>
                </li>
            </ul>
            <ul>
                <li class="cd-label">Main menu</li>
                <li class="about {{ nav_active('post-about', $active) }}">
                    <a href="{{ route('backend_post_edit', ['slug' => 'about', 'id' => 1]) }}">
                        <b class="fa fa-bullhorn"></b>
                        <span>{{ _t('backend_about') }}</span>
                    </a>
                </li>
                <li class="contact {{ nav_active('post-contact', $active) }}">
                    <a href="{{ route('backend_post_edit', ['slug' => 'contact', 'id' => 2]) }}">
                        <b class="fa fa-credit-card"></b>
                        <span>{{ _t('backend_contact') }}</span>
                    </a>
                </li>
                <li class="sliders {{ nav_active('image-sliders', $active) }}">
                    <a href="{{ route('backend_images', ['slug' => 'sliders']) }}">
                        <b class="fa fa-sliders"></b>
                        <span>{{ _t('backend_sliders') }}</span>
                    </a>
                </li>
                <li class="sliders {{ nav_active('meta', $active) }}">
                    <a href="{{ route('backend_meta') }}">
                        <b class="fa fa-bookmark-o"></b>
                        <span>{{ _t('backend_meta') }}</span>
                    </a>
                </li>
                <li class="map {{ nav_active('map', $active) }}">
                    <a href="{{ route('backend_map') }}">
                        <b class="fa fa-map-marker"></b>
                        <span>{{ _t('backend_map') }}</span>
                    </a>
                </li>
                <li class="has-children users {{ nav_active('user', $active) }}">
                    <a href="{{ route('backend_users') }}">
                        <b class="glyphicon glyphicon-user"></b>
                        <span>{{ _t('backend_users') }}</span>
                    </a>
                    <ul>
                        <li><a href="{{ route('backend_users') }}">{{ _t('backend_user_all') }}</a></li>
                        <li><a href="{{ route('backend_user_add') }}">{{ _t('backend_user_new') }}</a></li>
                    </ul>
                </li>
                <li class="has-children roles {{ nav_active('role', $active) }}">
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
                <li class="cd-label">Develop</li>
                <li class="has-children post-categories {{ nav_active('post-category', $active) }}">
                    <a href="{{ route('backend_post_categories') }}">
                        <b class="fa fa-newspaper-o"></b>
                        <span>{{ _t('backend_pc') }}</span>
                    </a>
                    <ul>
                        <li><a href="{{ route('backend_post_categories') }}">{{ _t('backend_pc_list') }}</a></li>
                        <li><a href="{{ route('backend_pc_add') }}">{{ _t('backend_pc_new') }}</a></li>
                    </ul>
                </li>
                <li class="has-children post-categories {{ nav_active('image-category', $active) }}">
                    <a href="{{ route('backend_image_categories') }}">
                        <b class="fa fa-image"></b>
                        <span>{{ _t('backend_ic') }}</span>
                    </a>
                    <ul>
                        <li><a href="{{ route('backend_image_categories') }}">{{ _t('backend_ic_list') }}</a></li>
                        <li><a href="{{ route('backend_ic_add') }}">{{ _t('backend_ic_new') }}</a></li>
                    </ul>
                </li>
                <li class="has-children post-categories {{ nav_active('category-root', $active) }}">
                    <a href="{{ route('backend_category_root') }}">
                        <b class="fa fa-th-list"></b>
                        <span>{{ _t('backend_cr') }}</span>
                    </a>
                    <ul>
                        <li><a href="{{ route('backend_category_root') }}">{{ _t('backend_cr_list') }}</a></li>
                        <li><a href="{{ route('backend_cr_add') }}">{{ _t('backend_cr_new') }}</a></li>
                    </ul>
                </li>
            </ul>
            <ul>
                <li class="cd-label">Quick</li>
                <li class="action-btn"><a href="{{ route('backend_logout') }}">{{ _t('backend_common_logout') }}</a></li>
            </ul>
        </nav>

        <div class="content-wrapper">
            <div class="_fwfl _mt20 _mb20 king-content">
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

        $('#check-all').on('click', function(){
            var checkBoxes = $("input[name=list_checked\\[\\]]");
            checkBoxes.prop("checked", this.checked);
        });
    </script>

</body>
</html>