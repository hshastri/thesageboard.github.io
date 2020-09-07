
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 " />
    <title>Decline Private Question Answer</title>
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

        .button {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            font-weight: 600;
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
    <tr style="height:15px;"></tr>
    <tr>
        <td style="padding: 15px;border: 1px solid rgb(189, 185, 185); border-radius: 10px">
            <p><a href="{{url('user-profile/'.$array['question_askar_id'])}}" style="color:#00df73; font-weight:600">{{$array['question_askar']}}</a> has declined your answer. If you feel your answer was acceptable, please choose the “Admin Review” option from the question link below and a Sage representative will open a case to resolve the dispute.</p>
            <p>Please visit <a class="button" style="color: white;" href="{{url('user-question-details/'.$array['question_id'].'/'.$array['answer_user_id'])}}"> Private Question </a> to view the answer.</p>
        </td>
    </tr>
</table>
</body>
</html>
