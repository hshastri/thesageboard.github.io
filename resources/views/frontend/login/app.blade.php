<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <link rel="icon" href="{{ URL::asset('assets/thesageboard-favicon.png') }}" type="image/x-icon"/>
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{asset('assets/front/css/sweetalert2.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/front/css/fontello/css/fontello.css')}}">
        <link rel="stylesheet" type="text/css" href="{{asset('assets/login/main.css')}}">
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
        <section class="login-page-wrapper">
            <div class="login-area">
                <div class="middle-content shadow-lg p-3 px-md-4 py-md-4 py-lg-5">
                    <div class="row">
                    @yield('login_content')
                    </div>
                </div>
            </div>
        </section>
        <script src="{{asset('assets/login/jquery-3.2.1.min.js')}}"></script>
        <script src="{{asset('assets/login/animsition.min.js')}}"></script>
        <script src="{{asset('assets/login/main.js')}}"></script>
        <script src="{{asset('assets/front/js/sweetalert2.min.js')}}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
        <script type="text/javascript">
            function showFrontendAlert(type, message){
                if(type == 'danger'){
                    type = 'error';
                }
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
        </script>
        @foreach (session('flash_notification', collect())->toArray() as $message)
            <script type="text/javascript">
                showFrontendAlert('{{ $message['level'] }}', '{{ $message['message'] }}');
            </script>
        @endforeach
        @yield('js')

    </body>
</html>
