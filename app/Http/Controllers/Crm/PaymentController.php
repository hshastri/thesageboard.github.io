<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use App\PaymentDetails;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function transaction(){
        $payments = PaymentDetails::where('payment_status','Paid')->orderBy('created_at', 'desc')->get();
        return view('crm.payment.transaction', compact('payments'));
    }

    public function transaction_details($id){
        $transaction = PaymentDetails::findOrFail(base64_decode($id));
        return view('crm.payment.transaction_details', compact('transaction'));
    }
}
