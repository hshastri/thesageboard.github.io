<div class="col-md-6 mb-5">
    <div class="row">
        <div class="col-md-2 pr-0">
            <input type="checkbox" class="dialogue-box-checkbox sage-check-box" name="experties_ids[]" value="{{@$expert->id}}" id="{{@$exp->user_id}}" onclick="setAmount('{{@$expert->id}}')">
        </div>
        <div class="col-md-10 pl-0">
            <div class="author-img">
                <img width="60" height="60" src="{{(@$expert->avatar =='')?asset('assets/images/admin.jpg'): asset('public/'.@$expert->avatar)}}" alt="profile-pic">
            </div>
            <div class="expert-details">
                <h3><a target="_blank" href="{{route('profile' ,$expert->username)}}">{{@$expert->first_name}} {{@$expert->last_name}}</a> <span class="show-exp-summary fas fa-info-circle"></span></h3>
                <span class="comment" id="amt_{{@$expert->id}}" data-amt="{{@$exp->expertise_rate}}">Amount : {{@$exp->expertise_rate}}</span>
                <span class="comment">Score : {{@$exp->reputation_score}} Point</span>
                <div class="expert-summary shadow d-flex">
                    <span class="close">X</span>
                    <img src="{{(@$expert->avatar =='')?asset('assets/images/admin.jpg'): asset('public/'.@$expert->avatar)}}" alt="image">
                    <div class="summary">
                        <h3>{{@$expert->first_name}} {{@$expert->last_name}}</h3>
                        <h4>{{@$exp->profession}}</h4>
                        <div class="expert-statistics mt-2">
                            <span>Response Time: {{$expert->art($expert->id)}}</span>
                            <span>Answers: {{App\Answer::where('user_id', $expert->id)->count()}}</span>
                            <span>Acceptance: {{$expert->acceptence($expert->id)}}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
