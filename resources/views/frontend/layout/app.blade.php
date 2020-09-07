<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="robots" content="index, follow">
    <meta name="description" content="@yield('meta_description', "An On-Demand Advice Platform for all of Life's Questions.")" />
    <meta name="keywords" content="@yield('meta_keywords', "sage advice,advice platform,advice online,advice from experts,expert advice online,ask an expert,ask an expert online,ask questions online,q&a websites,consultant,need a consultant,comparison")">
    <meta name="author" content="thesageboard.com">
    <meta name="sitemap_link" content="{{ route('/') }}">

    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="@yield('org_meta_title', config('app.name', 'thesageboard'))">
    <meta itemprop="description" content="@yield('org_meta_description', "An On-Demand Advice Platform for all of Life's Questions.")">
    <meta itemprop="image" content="{{asset('assets/front/images/logo.png')}}">

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="website">
    <meta name="twitter:site" content="@publisher_handle">
    <meta name="twitter:title" content="@yield('twitter_meta_title', config('app.name', 'thesageboard'))">
    <meta name="twitter:description" content="@yield('twitter_meta_desctiption', "An On-Demand Advice Platform for all of Life's Questions.")">
    <meta name="twitter:creator" content="@author_handle">
    <meta name="twitter:image" content="{{asset('assets/front/images/logo.png')}}">

    <!-- Open Graph data -->
    <meta property="og:title" content="@yield('open_meta_title', config('app.name', 'thesageboard'))" />
    <meta property="og:type" content="Sage Advice , On Demand" />
    <meta property="og:url" content="{{ route('/') }}" />
    <meta property="og:image" content="{{asset('assets/front/images/logo.png')}}" />
    <meta property="og:description" content="@yield('open_meta_description', "An On-Demand Advice Platform for all of Life's Questions.")" />
    <meta property="og:site_name" content="{{ config('app.name') }}" />

    <link rel="icon" href="{{ URL::asset('assets/thesageboard-favicon.png') }}" type="image/x-icon"/>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('meta_title', config('app.name', 'thesageboard'))</title>

    @include('frontend.inc.css')

    <style>
        .error{
            color: #fd8900 !important;
            width: 80% !important;
            display: inline-block;
        }
    </style>
        <!-- Facebook Pixel Code -->
        <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '550118752596570');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=550118752596570&ev=PageView&noscript=1"
    /></noscript>
    <!-- End Facebook Pixel Code -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-162905713-2"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'UA-162905713-2');
    </script>
</head>
<body>
<div class="loader"><div class="loader_html"></div></div>
<div id="wrap" class="grid_1200">
    @include('frontend.inc.header')
    @yield('main')
    @include('frontend.inc.footer')
    <div class="modal align-middle animated bounceIn" id="loginBox">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="border-bottom: unset">
                    <button class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body text-center py-3">
                    <h1 style="margin-top: -1em;">Join the Sage Community</h1>
                    <p>You must be logged in to perform this operation.</p>
                    <div class="row">
                        <div class="col-md-6 offset-md-3 pr-3 pr-md-0">
                            <a class="social-login facebook" href="{{ route('social.login', ['provider' => 'facebook']) }}" class="login100-form-btn-facebook"><i class="font-facebook-1"></i>Continue with Facebook</a>
                            <a class="social-login google" href="{{ route('social.login', ['provider' => 'google']) }}" class="login100-form-btn-google"><i class="font-google"></i>Continue with Google</a>
                            <p class="mt-4"><a href="{{route('expert-register')}}">Sign Up with Email</a>.By Signing up you indicate that your have read and agree to Sage's <a target="_blank" href="{{route('terms-and-conditions')}}" style="color: #00df73">Terms of Conditions</a> and <a target="_blank" href="{{route('policy')}}" style="color: #00df73">Privacy Policy</a></p>
                            <p class="mt-3">Already have an account ? <a href="{{route('login')}}" style="color: blue">Log in</a></p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="feedback-wrapper">
        <span class="form-initiator shadow"><span>Feedback</span></span>
        <div class="user-feedback shadow-lg">
            <form action="{{route('feedback')}}" class="user-feedback-form" method="post">
                @csrf
                <h4>How would you rate your experience on this page?</h4>
                <p class="mb-2"><span class="level"></span></p>
                <div class="form-group d-flex feedback-count" id="feedback-radios">
                    <div class="feedback-items">
                        <input type="radio" name="score" value="1" id="feedback-one" required>
                        <label for="feeback-one">1</label>
                    </div>
                    <div class="feedback-items">
                        <input type="radio" name="score" value="2" id="feedback-two" required>
                        <label for="feeback-two">2</label>
                    </div>
                    <div class="feedback-items">
                        <input type="radio" name="score" value="3" id="feedback-three" required>
                        <label for="feeback-three">3</label>
                    </div>
                    <div class="feedback-items">
                        <input type="radio" name="score" id="feedback-four" required>
                        <label for="feeback-four">4</label>
                    </div>
                    <div class="feedback-items">
                        <input type="radio" name="score" value="5" id="feedback-five" required>
                        <label for="feeback-five">5</label>
                    </div>
                    <div class="feedback-items">
                        <input type="radio" name="score" value="6" id="feedback-six" required>
                        <label for="feeback-six">6</label>
                    </div>
                    <div class="feedback-items">
                        <input type="radio" name="score" value="7" id="feedback-seven" required>
                        <label for="feeback-seven">7</label>
                    </div>
                    <div class="feedback-items">
                        <input type="radio" name="score" value="8" id="feedback-eight" required>
                        <label for="feeback-eight">8</label>
                    </div>
                    <div class="feedback-items">
                        <input type="radio" name="score" value="9" id="feedback-nine" required>
                        <label for="feeback-nine">9</label>
                    </div>
                    <div class="feedback-items">
                        <input type="radio" name="score" value="10" id="feedback-ten" required>
                        <label for="feeback-ten">10</label>
                    </div>
                </div>
                <div class="form-group feedback-comment">
                    <label for="feedback-comment">Additional feedback</label>
                    <textarea name="comment" id="feedback-comment" cols="30" rows="2" required></textarea>
                </div>
                <div class="form-group">
                    @if(Auth::check() && Auth::user()->id)
                    <button type="submit" class="w-100 d-block btn btn-success">Submit</button>
                    @else
                        <button type="button" class="w-100 d-block btn btn-success" id="notlogin">Submit</button>
                    @endif
                </div>
            </form>
        </div>

    </div>

</div><!-- End wrap -->
<div class="go-up"><i class="icon-angle-up"></i></div>
@include('frontend.inc.js')

<script type="text/javascript">
    $(document).ready(function(){
        let myVar;
        if (window.location.hash && window.location.hash == '#_=_' || window.location.hash == '#') {
            window.location.hash = '';
        }

        $('.form-initiator').on('click', function(e) {
            $(this).find('i').toggleClass('right');
            $(this).parent('.feedback-wrapper').toggleClass('push-top');
            $(this).next('.user-feedback').toggleClass('show');
        });
        $('.feedback-count input[type=radio]').on('click', function() {
            var value = $(this).val();
            if(value <= 3) {
                $('.user-feedback p span').text('Very Poor').css('background', 'rgb(223, 0, 0)');
            } else if(value <= 7) {
                $('.user-feedback p span').text('Good').css('background', '#00df73');
            } else if(value <= 10) {
                $('.user-feedback p span').text('Very Good').css('background', 'rgb(10, 142, 78)');
            }
        });

        @if(Auth::check() && Auth::user()->id)
        myVar = setInterval(notification_Count, 10000);
        @else
        clearInterval(myVar);
        @endif

    });

    var title = document.title;
    function notification_Count(){
        let url='{{route('unseen')}}';
        $.get(url, function(data){
            if(data['cnt']!=0){
                stay = true;
                $('.unseen').css('display' ,'block');
                $('.unseen').html(data['cnt']);
                var newTitle = '(' + data['cnt'] + ') ' + title;
                document.title = newTitle;
            }else{
                document.title = title;
                $('.unseen').css('display' ,'none');
            }
        });
    }

    function getNotifyData(url) {
        $('.unseen').css('display' ,'none');
        $('.sage-notifications').toggle('slow');
        $.get(url, function(data){
            $('.notifybody').html(data);
        });
    }

    function readNotication(url){
        $.get(url, function(){
            return true;
        });
    }

    $('#notlogin').on('click', function(e) {
        $('.feedback-wrapper').toggleClass('push-top');
        $('.user-feedback').toggleClass('show');
        $("#loginBox").modal()
    });
</script>

<script type="text/javascript">
    function showFrontendAlert(type, message){
        if(type == 'danger'){
            type = 'error';
        }
        /*swal({
            position: 'top-end',
            type: type,
            title: message,
            showConfirmButton: false,
            timer: 2000
        });*/

        swal.fire({
            title: message,
            showClass: {
                popup: 'animated fadeInDown faster'
            },
            hideClass: {
                popup: 'animated fadeOutUp faster'
            }
        })
    }

    function popupConfirm() {
        $("#loginBox").modal()
    }
</script>

@foreach (session('flash_notification', collect())->toArray() as $message)
    <script type="text/javascript">
        showFrontendAlert('{{ $message['level'] }}', '{!! $message['message'] !!}');
    </script>
@endforeach
@stack('js')
<script>
    function checklogin() {
        @if (!Auth::check())
        showFrontendAlert('danger', 'Please login First');
        @endif
    }
</script>

</body>
</html>
