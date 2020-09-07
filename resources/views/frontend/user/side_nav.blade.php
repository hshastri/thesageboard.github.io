<aside class="col-md-12 col-sm-12 col-lg-2 mb-0 mb-md-4 sidebar private-profile">
    <div class="mobile-menu-toggler">
        <span></span>
        <span></span>
        <span></span>
    </div>
    <div class="widget widget_menu animated mb-4 mb-lg-0">
        <ul>
            <li class="{{userActiveRoute(['user-deshboard'])}}"><a href="{{route('user-deshboard')}}" ><i class="fas fa-home"></i>My Profile</a></li>
          {{--  <li class=""><a href="{{route('profile-edit')}}" ><i class="fas fa-user-cog"></i>Settings</a></li>--}}
            <li class="{{userActiveRoute(['user-activity'])}}"><a href="{{route('user-activity')}}" ><i class="fas fa-tasks"></i>Activity</a></li>

            <li class="{{userActiveRoute(['wallet', 'in-progress', 'earnings', 'costs','refund','disbursement','payment-settings'])}}"><a href="{{route('wallet')}}" ><i class="fas fa-wallet"></i>Wallet</a></li>
            <li class="{{userActiveRoute(['expert-zone'])}}"><a href="{{route('expert-zone')}}" ><i class="far fa-folder-open"></i>Private Questions <span class="ques-notification">{{App\AskQuestion::whereRaw('JSON_SEARCH(experties_ids, "one","'.Auth::user()->id.'") IS NOT NULL')->where(['viewed'=>'0','question_label'=>'Premium'])->count()}}</span></a></li>
            @if(Auth::user()->role=='Expertise')
            <li class="{{userActiveRoute(['my-referral'])}}"><a href="{{route('referral')}}" ><i class="fas fa-user-plus"></i>My Referrals</a></li>
            @endif
            <li class="{{userActiveRoute(['profile-edit'])}}"><a href="{{route('profile-edit')}}" ><i class="far fa-edit"></i>Edit Profile</a></li>
            @if(Auth::user()->role=='Expertise')
            <li class="{{userActiveRoute(['add-expertise'])}}"><a href="{{route('add-expertise')}}" ><i class="fa fa-graduation-cap"></i>Expertise</a></li>
            @endif
            <li class="{{userActiveRoute(['claim'])}}"><a href="{{route('claim')}}" ><i class="fa fa-question"></i>Make a Claim</a></li>
        </ul>
    </div><!-- End widget_menu -->
</aside>
