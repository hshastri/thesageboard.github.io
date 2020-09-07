<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0 " />
        <title>John Doe has answered your question</title>
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;600;700"/>
        <style>
            body {
                font-family: 'Nunito', sans-serif;
                font-size: 15px;
                color: rgba(0,0,0,0.87);
                margin: auto;
                padding: 0;
                line-height: 22px;
            }
            img {
                max-width: 100%;
                max-height: 100%;
                vertical-align: middle;
            }
            a, a:hover {
                text-decoration: none;
            }
            .sage-logo {
                width: 30%;
            }
        </style>
    </head>
    <body class="sage-email-body">
        <table class="sage-full-wrap" valign="top"align="center" width="50%" cellspacing="0" cellpadding="0" border="0">
            <tr style="height: 32px"></tr>
            <tr>
                <td align="center">
                    <div class="sage-logo">
                        <img src="{{asset('assets/front/images/logo.png')}}" alt="">
                    </div>
                </td>
            </tr>
            @yield('email-body')
        </table>
    </body>
</html>
