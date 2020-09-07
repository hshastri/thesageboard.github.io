<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use DateTime;
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function user_details()
    {
        return $this->hasMany(UserDetails::class , 'user_id');
    }

    public function art($id){
        $answer = Answer::where('user_id',$id)->get();
        $total_hours= 0;
        if(count($answer)>0){
            $newhours = 0;

            foreach ($answer as $value){
                $question =  AskQuestion::where(['id'=>$value->question_id,'question_label'=>'Premium'])->first();
                if($question){
                    $date1 = new DateTime($question->created_at);
                    $date2 = new DateTime($value->created_at);

                    $diff = $date2->diff($date1);
                    $hours = $diff->h;
                    $hours = $hours + ($diff->days*24);
                    $newhours = $newhours + $hours;
                }
            }
            $total_hours = $newhours/count($answer);
        }

        return convertHour($total_hours);
    }

    public function acceptence($id){
        $aap=0;
        $answer = Answer::where('user_id',$id);
        $total_answer = $answer->count();
        $accepted_answer = $answer->where('accepted','yes')->count();
        if($total_answer>0){
            $aap =floor(($accepted_answer*100)/$total_answer) ;
        }
        return $aap;
    }
}
