<?php

namespace App\Http\Controllers;
use App\AskQuestion;
use App\BasicSetting;
use App\Http\Controllers\EmailController;
use App\Notify;
use App\PaymentDetails;
use App\Payments;
use App\UserDetails;
use Illuminate\Support\Str;
use Omnipay\Omnipay;
use Illuminate\Http\Request;
use Session;
class PaypalController extends Controller
{
    public $gateway;
    /*public function __construct()
    {
        $paypal_user_name = BasicSetting::where('key','paypal_user_name')->first();
        $paypal_password = BasicSetting::where('key','paypal_password')->first();
        $paypal_signature = BasicSetting::where('key','paypal_signature')->first();
        $mode = BasicSetting::where('key','paypal_mode')->first();

        $this->gateway = Omnipay::create('PayPal_Express');
        $this->gateway->setUsername($paypal_user_name->value);
        $this->gateway->setPassword($paypal_password->value);
        $this->gateway->setSignature($paypal_signature->value);
        $this->gateway->setTestMode(($mode->value == 'sandbox') ? true : false);

    }*/

    public function checkout($amount){
        $mode = BasicSetting::where('key','paypal_mode')->first();

        $purchaseData   = [
            'testMode'  => ($mode->value == 'sandbox') ? true : false,
            'amount'    => $amount,
            'currency'  => 'usd',
            'returnUrl' => url('payments/success'),
            'cancelUrl' => url('payments/cancel')
        ];

        $response   = $this->gateway->purchase($purchaseData)->send();
        if ($response->isSuccessful()){
            $result = $response->getData();
        } else if ($response->isRedirect()){
            $response->redirect();
        } else {
            flash($response->getMessage())->error();
            return back();
        }
    }

    public function success(Request $request){

        $transaction = $this->gateway->completePurchase(array(
            'payer_id'              => $request->PayerID,
            'transactionReference'  => $request->token,
            'amount'  => Session::get('amount')
        ));
        $response             = $transaction->send();
        $purchaseResponseData = $response->getData();
        $transactionDetails   = $this->gateway->fetchCheckout(array(
            'payer_id'              => $request->PayerID,
            'transactionReference'  => $request->token,
        ));
        $response             = $transactionDetails->send();
        $checkoutResponseData = $response->getData();
        $this->completePaymant($checkoutResponseData,$purchaseResponseData);
    }

    public function completePaymant($checkData, $purchases){

        $payment_id = Session::get('payment_id');
        $experts_ids = Session::get('experts_ids');

        $askquestion = AskQuestion::where('payment_id', $payment_id)->first();
        $askquestion->question_label = "Premium";
        $askquestion->type = "Private";
        $askquestion->save();

        foreach ($experts_ids as  $id) {
            $serve =new Payments();
            $serve->payment_id = $payment_id;
            $serve->question_id = $askquestion->id;
            $serve->user_id = $askquestion->user_id;
            $serve->expert_id = $id;
            $users = UserDetails::where('user_id',$id)->first();
            $comission = BasicSetting::where('key','comission')->first();
            $rate = ($users->expertise_rate*$comission->value)/100;
            $serve->amount = $users->expertise_rate-$rate;
            $serve->save();
        }


        $payments =  PaymentDetails::where('payment_uid',$payment_id )->first();
        $payments->payment_status ="Paid";
        $payments->paypal_paid_amount = $checkData['AMT'];
        $payments->paypal_transaction_id = $checkData['TRANSACTIONID'];
        $payments->paypal_email = $checkData['EMAIL'];
        $payments->paypal_first_name = $checkData['FIRSTNAME'];
        $payments->paypal_last_name = $checkData['LASTNAME'];
        if($payments->save()){

            $cost =new Payments();
            $cost->payment_id = $payment_id;
            $cost->question_id = $askquestion->id;
            $cost->cost_id = $askquestion->user_id;
            $cost->status = "Cost";
            $cost->amount = $checkData['AMT'];
            $cost->save();

            flash('Payment complete Successfully')->success();

            return redirect()->to('/')->send();
        }else{

            flash('Something went wrong')->error();
            return redirect()->route('/');
        }

    }

    public function cancel(Request $request){
        dd($request->all());
    }


    public function sdk(Request $request){

        $payment_id = Session::get('payment_id');
        $experts_ids = Session::get('experts_ids');

        $askquestion = AskQuestion::where('payment_id', $payment_id)->first();
        $askquestion->question_label = "Premium";
        $askquestion->type = "Private";
        $askquestion->save();

        foreach ($experts_ids as  $id) {
            $serve =new Payments();
            $serve->payment_id = $payment_id;
            $serve->question_id = $askquestion->id;
            $serve->user_id = $askquestion->user_id;
            $serve->expert_id = $id;
            $users = UserDetails::where('user_id',$id)->first();
            $comission = BasicSetting::where('key','comission')->first();
            $rate = ($users->expertise_rate*$comission->value)/100;
            $serve->amount = $users->expertise_rate-$rate;
            $serve->save();

            $value = Str::limit($askquestion->question_title, 50);
            $this->notifyComment($askquestion->user_id , $askquestion->id , $id , $value , 3);
        }

        $payments =  PaymentDetails::where('payment_uid',$payment_id )->first();
        $payments->payment_status ="Paid";
        $payments->paypal_paid_amount = Session::get('orginalAmount');
        $payments->paypal_transaction_id = $request->data['orderID'];
        $payments->payerID = $request->data['payerID'];
        /*$payments->paymentID = $request->data['paymentID'];*/
        $payments->paymentID = $payment_id;

        if($payments->save()){
            $cost =new Payments();
            $cost->payment_id = $payment_id;
            $cost->question_id = $askquestion->id;
            $cost->cost_id = $askquestion->user_id;
            $cost->status = "Cost";
            $cost->amount = Session::get('orginalAmount');
            $cost->save();


            $emails = new EmailController();
            $emails->askPrivateQuestion($askquestion->id, $experts_ids);

            return response()->json([
                'status' => '200',
            ]);
        }else{
            return response()->json([
                'status' => '400',
            ]);
        }

    }

    public function getBarerToken(){
       $client_id =  BasicSetting::where('key','paypal_client_id')->first();
       $secrect =  BasicSetting::where('key','paypal_secrect')->first();
       $mode =  BasicSetting::where('key','paypal_mode')->first();
       $url='https://api.sandbox.paypal.com/v1/oauth2/token';
       if($mode->value=='live'){
           $url ='https://api.paypal.com/v1/oauth2/token';
       }


        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
        curl_setopt($ch, CURLOPT_USERPWD, $client_id->value . ':' . $secrect->value);

        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = 'Accept-Language: en_US';
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        return $result;

    }

    public function makeRefund($transaction_id, $barer_token, $amount){

        $mode =  BasicSetting::where('key','paypal_mode')->first();


        $post_data['total'] = $amount;
        $post_data['currency'] = "USD";
        $data['amount'] = $post_data;
        $postdata = json_encode($data);

        $url='https://api.sandbox.paypal.com/v1/payments/sale/'.$transaction_id.'/refund';
        if($mode->value=='live'){
            $url ='https://api.paypal.com/v1/payments/sale/'.$transaction_id.'/refund';
        }

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,$url );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);

        $headers = array();
        $headers[] = 'Content-Type: application/json';
        $headers[] = 'Authorization: Bearer '.$barer_token.'';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
        return $result;
    }

    public function payoutRequest($barer_token, $amount , $email,$batch_id){

        $mode =  BasicSetting::where('key','paypal_mode')->first();
        $url='https://api.sandbox.paypal.com/v1/payments/payouts';
        if($mode->value=='live'){
            $url ='https://api.paypal.com/v1/payments/payouts';
        }

        $batch ="Payouts_".$batch_id;
        $data ='{
          "sender_batch_header": {
            "sender_batch_id":"'.$batch.'",
            "email_subject": "You have a payout!",
            "email_message": "You have received a payout! Thanks for using our service!"
          },
          "items": [
            {
              "recipient_type": "EMAIL",
              "amount": {
                "value":"'.$amount.'",
                "currency": "USD"
              },
              "note": "Thanks for your patronage!",
              "sender_item_id":"'.$batch_id.'",
              "receiver": "'.$email.'"
            }
          ]
        }';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                "Content-Type: application/json",
                "Authorization: Bearer ".$barer_token,
                "Content-length: ".strlen($data))
        );
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);

        return $result;
    }

    public function notifyComment($create_user_id , $qid , $notifyUser , $title , $type){
        $not =  new Notify();
        $not->create_user_id = $create_user_id;
        $not->question_id = $qid;
        $not->notify_user_id = $notifyUser;
        $not->notify_title = $title;
        $not->type = $type;
        $not->save();
    }
}
