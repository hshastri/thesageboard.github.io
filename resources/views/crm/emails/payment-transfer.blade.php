@extends('crm.emails.layout')
@section('email-body')
<tr style="height:15px;"></tr>
<tr>
    <td style="padding: 15px;border: 1px solid rgb(189, 185, 185); border-radius: 10px">
        <p>Your requested transfer of <span style="color:#00df73; font-weight:600">amount transferred</span> has been completed and should be available in your Paypal account.</p>
    </td>
</tr>

@endsection
