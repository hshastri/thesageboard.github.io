@if($question_details->question_label=='Premium')
    <aside class="col-md-3 sidebar mt-3 mt-sm-3 mt-md-0">
        @if($ctid!='nai')
            <div class="widget">
                @if(@$accept_answer=="yes")
                    <span class="executed-action accepted mb-3 py-3"><i class="font-ok-circled"></i> Accepted </span>
                @endif
                @if(@$accept_answer=="reject")
                    <span class="executed-action rejected"><i class="fas fa-ban"></i> Rejected </span>
                @endif
                @if(Auth::check() && Auth::user()->id == $question_details->user_id && $accept_answer=='no')
                    <a href="javascript:void(0)" onclick="accept_private_answer('{{route('private-answer-accept',['qid'=>base64_encode($question_details->id), 'eid'=>$uid ,'cid'=>$ctid] )}}')" class="private-question-action shadow-sm accept">Accept Answer</a>
                    <a href="javascript:void(0)" onclick="get_refund_modal('{{route('make-refund',['qid'=>base64_encode($question_details->id), 'eid'=>$uid] )}}')" class="private-question-action shadow-sm decline">Decline</a>
                @endif
            </div>
        @endif
        <div class="widget widget_stats">
            <div class="ul_list ul_list-icon-ok">
                <ul>
                    <li><i class="fa fa-question"></i>&nbsp;Topic  : <span>{{@$question_details->category->name}}</span> </li>
                    <li><i class="fa fa-book-reader"></i>&nbsp;Sub Topic  : <span>{{@$question_details->subcategory->name}}</span> </li>
                    <li><i class="fa fa-book"></i>&nbsp;Question Type : <span>{{@$question_details->question_label}}</span> </li>
                    <li><i class="fa fa-user"></i>&nbsp;Selected Expert : <span> {{App\User::where('id', base64_decode($uid))->value('username')}}</span> </li>
                </ul>
            </div>
        </div>
    </aside>
@endif
@if($question_details->question_label=='General')
    <aside class="col-md-3 sidebar mt-3 mt-sm-3 mt-md-0">
        <div class="widget widget_stats">
            <div class="ul_list ul_list-icon-ok">
                <ul>
                    <li><i class="fa fa-question"></i>&nbsp;Topic  : <span>{{@$question_details->category->name}}</span> </li>
                    <li><i class="fa fa-book-reader"></i>&nbsp;Sub Topic  : <span>{{@$question_details->subcategory->name}}</span> </li>
                </ul>
            </div>
        </div>
    </aside>
@endif
