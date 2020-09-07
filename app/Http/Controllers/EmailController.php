<?php

namespace App\Http\Controllers;

use App\Answer;
use App\AskQuestion;
use App\Payments;
use App\User;
use Illuminate\Http\Request;
use Mail;
use App\Mail\EmailManager;
use Auth;
class EmailController extends Controller
{

    public function newRegisterEmail($name,$email,$token){
        $link = url('verify/'.$token);
        $subject="Confirm Your Email";
        $content="Dear ".$name."<br> <a href=\"{$link}\">Please Click here for Confirm your mail.</a>";
        $this->send($email,$subject,$content);
    }

    public function fogetPassword($name,$email,$token){
        $subject="Verify your Account";
        $content="Dear ".$name."<br> <br> Your one-time code is :". $token;
        $this->send($email,$subject,$content);
    }

    public function send($email,$subject, $content)
    {
        $array['view'] = 'crm.emails.content';
        $array['subject'] = $subject;
        $array['from'] = env('MAIL_FROM_ADDRESS');
        $array['content'] = $content;


        if (env('MAIL_USERNAME') != null) {
            try {
                Mail::to($email)->queue(new EmailManager($array));
            } catch (\Exception $e) {
                dd($e,1);
            }
        }
        else {
            flash("Please configure SMTP first")->error();
            return back();
        }
        /*flash($alert)->success();*/
        return ;
    }

    public function sendInvitation($name,$email,$token , $sendName , $body=null){
        $url = url('sage/'.$token);
        $subject="Sage Expertise Referral";
        $content= "Hi ". $name. "<br/> <br/>" . $sendName . " would like to invite you to register with the new on-demand advice platform, Sage. You can use the referral link below to register. <br/> <br/> At Sage, our main priority is building a community of experts - 'Sages' - where the success of the Sages leads to the success of the site, and vice versa. We believe Sages are the critical element to building a game-changing platform, and we will treat you as such. We believe that if we have the best experts, then we will be the first place people seek advice for their most important questions. <br/> <br/>  Registering with this new link provides your referrer with passive earning potential from questions you answer. To be clear, this will not impact your current or future earnings potential negatively! Sage sets aside a percentage of revenue from all \"answers\" to pay out to each Sage's referral tree. This revenue comes from a shared pool of dollars and does not negatively impact either the referrer's earnings, or the referree’s earnings. By helping your referrer build their tree, you increase their earnings potential on our platform. Subsequently, by building your own tree, you also increase your own earnings potential for the same reasons.<br/> <br/>Please see our helpful FAQ pages at www.thesageboard.com  for more detail. <br/><br/>". $url ."<br/><br/>Kind Regards,<br/>Peter @Sage";
        if($body!=null){
            $findtext = ["#USERNAME#", "#MYNAME#" ,'#INVITELINK#'];
            $replacetext   = [$name, $sendName, $url];
            $newPhrase = str_replace($findtext, $replacetext, $body);
            $content  =  $newPhrase;
        }
        $this->send($email,$subject,$content);
    }

    // Someone asks me a private question
    public function askPrivateQuestion($question_id, $expertiseId){

        $ask_question = AskQuestion::where('id', $question_id)->first();
        $subject = "New Private Question Request";

        $array['view'] = 'crm.emails.askQuestion';
        $array['subject'] = $subject;
        $array['from'] = env('MAIL_FROM_ADDRESS');
        $array['question_title'] = $ask_question->question_title;
        $array['description'] = $ask_question->description;

        foreach ($expertiseId as  $id) {
            $expert = User::where('id', $id)->first();
            $expert_name = $expert->first_name.' '.$expert->last_name;
            $this->sendHtmlMail($expert->email , $array);
        }
    }

    // Someone answers my private question
    public function ansPrivateQuestion($question_id){
        $ask_question = AskQuestion::where('id', $question_id)->first();

        $question_user_id = User::where('id', $ask_question->user_id)->first();
        $subject = "New answer received to your Private Question Request";

        $array['view'] = 'crm.emails.answer-question';
        $array['subject'] = $subject;
        $array['from'] = env('MAIL_FROM_ADDRESS');
        $array['answer_user_name'] = Auth::user()->first_name.' '.Auth::user()->last_name;
        $array['answer_user_id'] = base64_encode(Auth::user()->id);
        $array['question_id'] = base64_encode($question_id);
        $this->sendHtmlMail($question_user_id->email , $array);
    }

    // Someone accepts  my private answer
    public function acceptPrivateAnswer($answer_userId , $payment_amount){

        $answer_user_id = User::where('id', $answer_userId)->first();
        $subject = "Your answer has been accepted";
        $array['view'] = 'crm.emails.accept-answer';
        $array['subject'] = $subject;
        $array['from'] = env('MAIL_FROM_ADDRESS');
        $array['accepted_buy'] = Auth::user()->first_name.' '.Auth::user()->last_name;
        $array['accepted_id'] = base64_encode(Auth::user()->id);
        $array['amount'] = $payment_amount;
        $array['user_name'] = $answer_user_id->first_name.' '.$answer_user_id->last_name;
        $this->sendHtmlMail($answer_user_id->email , $array);
        $this->acceptPrivateAnswerPayment($answer_userId, $payment_amount);
    }

    // Payment Received (after accepted answer on private question)
    public function acceptPrivateAnswerPayment($answer_userId , $payment_amount){

        $answer_user_id = User::where('id', $answer_userId)->first();

        $subject = "Payment Received";
        $array['view'] = 'crm.emails.payment-receive';
        $array['subject'] = $subject;
        $array['from'] = env('MAIL_FROM_ADDRESS');
        $array['accepted_buy'] = Auth::user()->first_name.' '.Auth::user()->last_name;
        $array['accepted_id'] = base64_encode(Auth::user()->id);
        $array['amount'] = $payment_amount;
        $array['user_name'] = $answer_user_id->first_name.' '.$answer_user_id->last_name;
        $this->sendHtmlMail($answer_user_id->email , $array);
        /*$payments = Payments::where('expert_id',$answer_userId)->orderBy('created_at', 'desc')->limit(10)->get();*/
    }

    // Someone accepts  my private answer
    public function declinePrivateAnswer($answer_userId , $question_id){

        $answer_user_id = User::where('id', $answer_userId)->first();
        $name = Auth::user()->first_name.' '.Auth::user()->last_name;

        $subject = $name. " Decline your answer";
        $array['view'] = 'crm.emails.decline-answer';
        $array['subject'] = $subject;
        $array['from'] = env('MAIL_FROM_ADDRESS');
        $array['question_askar'] = $name;
        $array['question_askar_id'] = base64_encode(Auth::user()->id);
        $array['user_name'] = $answer_user_id->first_name.' '.$answer_user_id->last_name;

        $array['answer_user_id'] = base64_encode($answer_user_id->id);
        $array['question_id'] = base64_encode($question_id);

        $this->sendHtmlMail($answer_user_id->email , $array);
    }

    // Someone answers one of my public questions
    public function ansPublicQuestion($question_id , $answer_id){
        $ask_question = AskQuestion::where('id', $question_id)->first();

        $answer = Answer::where('id',$answer_id)->first();

        $question_user_id = User::where('id', $ask_question->user_id)->first();
        $name = Auth::user()->first_name.' '.Auth::user()->last_name;
        $subject = $name." answered your question about ". $ask_question->question_title;

        $array['view'] = 'crm.emails.answer-public';
        $array['subject'] = $subject;
        $array['from'] = env('MAIL_FROM_ADDRESS');
        $array['answer_user_name'] = $name;
        $array['answer_user_id'] = base64_encode(Auth::user()->id);
        $array['question_id'] = base64_encode($question_id);
        $array['answer'] = $answer->answer;

        $this->sendHtmlMail($question_user_id->email , $array);
    }

    // Someone answers a public question I've answered
    public function replyPublicQuestion($question_id , $answer_id){
        $ask_question = AskQuestion::where('id', $question_id)->first();

        $answer = Answer::where('id',$answer_id)->first();

        $question_user_id = User::where('id', $ask_question->user_id)->first();
        $name = Auth::user()->first_name.' '.Auth::user()->last_name;
        $subject = $name." also added an answer to ". $ask_question->question_title;

        $array['view'] = 'crm.emails.answer-reply';
        $array['subject'] = $subject;
        $array['from'] = env('MAIL_FROM_ADDRESS');
        $array['answer_user_name'] = $name;
        $array['answer_user_id'] = base64_encode(Auth::user()->id);
        $array['question_id'] = base64_encode($question_id);
        $array['answer'] = $answer->answer;

        $this->sendHtmlMail($question_user_id->email , $array);
    }

    // Someone accepts  my public  answer
    public function acceptPublicAnswer($answer_userId , $question_id , $answer_id){
        $ask_question = AskQuestion::where('id', $question_id)->first();
        $answer_user_id = User::where('id', $answer_userId)->first();
        $answer = Answer::where('id',$answer_id)->first();

        $subject = $ask_question->question_title." has been accepted";
        $array['view'] = 'crm.emails.accept-public-answer';
        $array['subject'] = $subject;
        $array['from'] = env('MAIL_FROM_ADDRESS');
        $array['question_askar'] = Auth::user()->first_name.' '.Auth::user()->last_name;
        $array['question_askar_id'] = base64_encode(Auth::user()->id);
        $array['question_title'] = $ask_question->question_title;
        $array['user_name'] = $answer_user_id->first_name.' '.$answer_user_id->last_name;
        $array['answer_user_id'] = base64_encode($answer_user_id->id);
        $array['question_id'] = base64_encode($question_id);
        $array['answer'] = $answer->answer;

        $this->sendHtmlMail($answer_user_id->email , $array);
    }

    public function sendHtmlMail($email, $data){
        if (env('MAIL_USERNAME') != null) {
            try {
                Mail::to($email)->queue(new EmailManager($data));
            } catch (\Exception $e) {
                dd($e,1);
            }
        }
        else {
            flash("Please configure SMTP first")->error();
            return back();
        }
        return ;
    }
}
