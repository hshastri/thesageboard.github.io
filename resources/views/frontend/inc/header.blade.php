
<header id="header">
    <section class="custom-container clearfix">
        <div class="row align-items-center">
            <div class="col-4 col-md-3 col-lg-2">
                <div class="logo"><a href="{{route('/')}}"><img alt="" src="{{asset('assets/front/images/logo.png')}}"></a></div>
            </div>
            <div class="col-6 col-md-7 col-lg-4">
                <div class="search-bar-area d-flex align-items-center">{{--
                    <form class="form-style form-style-2 search-bar-item search-form" action="{{route('questions')}}"method="GET">
                        @csrf
                        <p class="search-input">
                            <label for="question-search"><i class="fas fa-search"></i></label>
                            <input type="text" class="question-search" id="question-search" autocomplete="off" placeholder="Search Questions" name="question_title">
                        </p>
                    </form>--}}
                    <a class="ask-question-button border-gradient search-bar-item" href="{{route('ask-question')}}"> Ask a Question</a>
                </div>
            </div>
            <div class="col-2 col-md-2 col-lg-6">
                <nav class="navigation">
                    <ul>
                        <li class="{{userActiveRoute(['/'])}}">
                            <a href="{{route('/')}}"><i class="menu-icon fas fa-home"></i>Home</a>
                        </li>
                        <li class="{{userActiveRoute(['questions'])}}">
                            <a href="{{route('questions')}}"><i class="menu-icon fas fa-database"></i> Public Questions</a>
                        </li>
                        <li class="">
                            <a href="https://blog.thesageboard.com"><i class="menu-icon fas fa-blog"></i> Blog</a>
                        </li>
                        <li class="{{userActiveRoute(['listings'])}}"><a href="{{route("listings")}}"><i class="menu-icon fas fa-list"></i> Topics List</a></li>
                        <li class=""><a href="http://help.thesageboard.com" target="_blank"><i class="menu-icon fas fa-hands-helping"></i> Help </a></li>
                        @if(Auth::check() && Auth::user()->id)
                        <li class="">
                            <a href="javascript:void(0)" onclick="getNotifyData('{{route('getNotifydata')}}')" class="notification-tab">
                                <i class="menu-icon fas fa-bell"> </i> Notif <span class="unseen" style="display: none"></span>
                            </a>
                        </li>
                        <li class="{{userActiveRoute(['user-deshboard','profile-edit','users'])}}">
                            <a class="logged-username" href="javascript:void(0)">
                                <img alt="" src="{{(Auth::user()->avatar =='') ? asset('assets/images/admin.jpg'): asset('public/'.Auth::user()->avatar)}}">{{Auth::user()->first_name}}
                            </a>
                            <ul>
                                <li><a href="{{route('user-deshboard')}}">My Profile</a></li>
                                <li> <a href="{{route('logout')}}" id="">Logout</a></li>
                            </ul>
                        </li>
                        @else
                        <li class="{{userActiveRoute(['login'])}}">
                            <a href="{{route("login")}}"><i class="menu-icon fas fa-sign-in-alt"></i> Login</a></li>
                        <!-- <li class="{{userActiveRoute(['register'])}}"><i class="menu-icon fas fa-user-plus"></i><a href="{{route("register")}}"> Sign Up</a></li> -->
                        @endif
                    </ul>
                </nav>
            </div>
            <div class="sage-notifications animated" style="display: none">
                <div class="sage-notification-inner">
                    <div class="notification-header border-bottom">
                        <h3 class="mb-2">Notifications</h3>
                    </div>
                    <div class="sage-notification-body">
                        <div class="row notifybody">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- End container -->
</header>
