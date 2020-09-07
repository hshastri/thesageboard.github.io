@extends('frontend.layout.app')
@section('main')
    <div class="section-warp ask-me">
        <div class="custom-container">
            <div class="row">
                <div class="col-md-5 singup-proccess-area mb-4">
                    <div class="singup-process-wrapper">
                        <h3>Get Started with Sage:</h3>
                        <div class="tabs-warp m-0">
                            <ul class="tabs">
                                <li class="tab"><a href="#" class="">Seekers (Ask Questions)</a></li>
                                <li class="tab question-sage"><a href="#" class="current">Sages (Answer Questions)</a></li>
                            </ul>
                            <div class="tab-inner-warp">
                                <div class="tab-inner" id="widget_question">
                                    <div class="seeker-process singup-process">
                                        <div class="proccess-step" title="Sign Up">
                                            <span class="flex-item step-icon mr-3"><i class="fas fa-user-plus"></i></span>
                                            <div class="process-title-desc mt-2">
                                                <h3 class="flex-item singup-process-title">Register Your Account.</h3>
                                                <p class="flex-item singup-process-desc"><a style="color: #c8d846" href="{{route('login')}}">Register here</a> by e-mail or social login.</p>
                                            </div>
                                        </div>
                                        <div class="proccess-step" title="Ask Your Question">
                                            <span class="flex-item step-icon mr-3"><i class="fas fa-question-circle"></i></span>
                                            <div class="process-title-desc mt-2">
                                                <h3 class="flex-item singup-process-title">Ask Your Question.</h3>
                                                <p class="flex-item singup-process-desc">Pick a topic, write your question, post publicly, or ask a sage.</p>
                                            </div>
                                        </div>
                                        <div class="proccess-step" title="Get Advice">
                                            <span class="flex-item step-icon mr-3"><i class="fas fa-user-tie"></i></span>
                                            <div class="process-title-desc mt-2">
                                                <h3 class="flex-item singup-process-title">Sages Like You Give Advice.</h3>
                                                <p class="flex-item singup-process-desc">Our breadth of sages will ensure you always get great advice.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-inner-warp">
                                <div class="tab-inner" id="widget_question">
                                    <div class="sage-signup-process singup-process">
                                        <div class="proccess-step" title="Sign Up">
                                            <span class="flex-item step-icon mr-3"><i class="fas fa-user-plus"></i></span>
                                            <div class="process-title-desc mt-2">
                                                <h3 class="flex-item singup-process-title">Register Your Account.</h3>
                                                <p class="flex-item singup-process-desc"><a style="color: #c8d846" href="{{route('login')}}">Register here</a> by e-mail or social login.</p>
                                            </div>
                                        </div>
                                        <div class="proccess-step" title="Complete Profile">
                                            <span class="flex-item step-icon mr-3"><i class="fas fa-id-card"></i></span>
                                            <div class="process-title-desc mt-2">
                                                <h3 class="flex-item singup-process-title">Fill Out Your Profile.</h3>
                                                <p class="flex-item singup-process-desc">Add a bio, expertise areas, and photo.</p>
                                            </div>
                                        </div>
                                        <div class="proccess-step" title="Make Money">
                                            <span class="flex-item step-icon mr-3"><i class="fas fa-file-invoice-dollar"></i></span>
                                            <div class="process-title-desc mt-2">
                                                <h3 class="flex-item singup-process-title">Set Your Answer Rates.</h3>
                                                <p class="flex-item singup-process-desc">Give thoughtful advice and build your reputation score.</p>
                                            </div>
                                        </div>
                                        <div class="proccess-step" title="Enable Passive Earnings">
                                            <span class="flex-item step-icon mr-3"><i class="fas fa-sitemap"></i></span>
                                            <div class="process-title-desc mt-2">
                                                <h3 class="flex-item singup-process-title">Create a Referral Tree.</h3>
                                                <p class="flex-item singup-process-desc">Invite other potential sages and earn money when they answer questions.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 offset-md-1">
                    <div class="ml-md-5">
                        <h3>What is Sage?</h3>
                        <div class="intro-video">
                            <iframe src="https://www.youtube.com/embed/n-ynjUBydM8" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                    </div>

                </div>
                <div class="col-md-5">
                    <div class="sage-introductory-content row">
                        <div class="col-md-12 mb-4">
                            <div class="sage-introductory-item d-flex">
                                <span class="title-icon mr-2"><i class="fas fa-user-cog"></i></span>
                                <div class="heading-content">
                                    <h3 class="mb-1">We’re Your Single Source for Advice.</h3>
                                    <p>Sage gathers experts into a single online portal. No more searching multiple websites or physical locations.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-4">
                            <div class="sage-introductory-item d-flex">
                                <span class="title-icon mr-2"><i class="fas fa-question"></i></span>
                                <div class="heading-content">
                                    <h3 class="mb-1">Public and Private Questions.</h3>
                                    <p>Start by posting your question in the free public forum. Or go directly to the sages to ask a private question! Our sages answer both public and private questions.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-4">
                            <div class="sage-introductory-item d-flex">
                                <span class="title-icon mr-2"><i class="fas fa-file-invoice-dollar"></i></span>
                                <div class="heading-content">
                                    <h3 class="mb-1">Transparent Billing.</h3>
                                    <p>Ask your question, select your sage, make payment, and get your personalized advice. It’s like grabbing a cup of coffee, but for advice.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 offset-md-1">
                    <div class="sage-introductory-content row">
                        <div class="col-md-12 mb-4">
                            <div class="sage-introductory-item d-flex">
                                <span class="title-icon mr-2"><i class="fas fa-comments-dollar"></i></span>
                                <div class="heading-content">
                                    <h3 class="mb-1">Always giving free advice? Make money doing it.</h3>
                                    <p>People already recognize your time and knowledge are valuable. With Sage, you can do what you’re good at and get paid for it.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-4">
                            <div class="sage-introductory-item d-flex">
                                <span class="title-icon mr-2"><i class="fas fa-funnel-dollar"></i></span>
                                <div class="heading-content">
                                    <h3 class="mb-1">Set Your Own Rates.</h3>
                                    <p>The community decides how much your advice is worth through upvotes, downvotes, and best answers. Give thoughtful advice, build your following, increase your potential.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-4">
                            <div class="sage-introductory-item d-flex">
                                <span class="title-icon mr-2"><img src="{{asset('assets/front/images/icon/man-to-man.png')}}" alt=""></span>
                                <div class="heading-content">
                                    <h3 class="mb-1">Earn Passive Income Through Referrals.</h3>
                                    <p>We’ve created a revenue-sharing model unmatched in the industry. Sages earn passive income by referring other sages. Create a referral tree that pays you when your referrals answer questions.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="go-to-latest-questions text-center mt-3 mt-md-4">
                                <p>Go to Latest Questions</p>
                                <span class="icon-angle-down bounce-3"></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="quote-item-wrapper">
                                <div class="quote-item mb-3 clearfix">
                                    <h3 class="quote m-0">Real knowledge is to know the extent of one’s ignorance.</h3>
                                    <div class="quote-author d-flex float-right mt-3">
                                        <div class="author">
                                            <img src="{{asset('assets/images/quotes-author/confucius.jpeg')}}" alt="">
                                        </div>
                                        <h4>Confucius</h4>
                                    </div>
                                </div>
                                <div class="quote-item mb-3 clearfix">
                                    <h3 class="quote m-0">“Knowledge has a beginning but no end.”</h3>
                                    <div class="quote-author d-flex float-right mt-3">
                                        <div class="author">
                                            <img src="{{asset('assets/images/quotes-author/geeta.png')}}" alt="">
                                        </div>
                                        <h4>Geeta Iyengar</h4>
                                    </div>
                                </div>
                                <div class="quote-item mb-3 clearfix">
                                    <h3 class="quote m-0">“The good life is one inspired by love and guided by knowledge.”</h3>
                                    <div class="quote-author d-flex float-right mt-3">
                                        <div class="author">
                                            <img src="{{asset('assets/images/quotes-author/bertrand.png')}}" alt="">
                                        </div>
                                        <h4>Bertrand Russell</h4>
                                    </div>
                                </div>
                                <div class="quote-item mb-3 clearfix">
                                    <h3 class="quote m-0">“A people without the knowledge of their past history, origin and culture is like a tree without roots.”</h3>
                                    <div class="quote-author d-flex float-right mt-3">
                                        <div class="author">
                                            <img src="{{asset('assets/images/quotes-author/marcus.jpg')}}" alt="">
                                        </div>
                                        <h4>Marcus Garvey</h4>
                                    </div>
                                </div>
                                <div class="quote-item mb-3 clearfix">
                                    <h3 class="quote m-0">“Your earning ability today is largely dependent upon your knowledge, skill and your ability to combine that knowledge and skill in such a way that you contribute value for which customers are going to pay.”</h3>
                                    <div class="quote-author d-flex float-right mt-3">
                                        <div class="author">
                                            <img src="{{asset('assets/images/quotes-author/Brian-Tracy.jpg')}}" alt="">
                                        </div>
                                        <h4>Brian Tracy</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div><!-- End container -->
    </div>
    {{--
    <section class="category-container">
        <div class="custom-container">
            <div class="row">
                <div class="col-md-12">
                    <div class="owl-carousel category-carousel sage-carousel">
                      @if($category)
                            @foreach($category as $key => $category)
                                @php
                                 $cat = App\Category::where('id',$category)->first();
                                @endphp
                                <div class="cat-item">
                                        <a href="{{route('show-question',base64_encode($cat->id))}}">
                                            <span class="cat-icon"><i class="{{$cat->icon}}"></i></span>
                                            <span class="cat-name">{{$cat->name}}</span>
                                        </a>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div><!-- End row -->
        </div>
    </section>--}}
    <section class="expert-question mt-3 mb-4">
        <div class="custom-container">
            <div class="row mt-sm-4 mt-md-4 mt-lg-5">
                <div class="col-md-9">
                    <h2>Top Experts</h2>
                    <div class="row top-expert-list">
                        @php
                            $i=0
                        @endphp
                        @foreach($user as $user)
                            @if(@$user->user->role=="Expertise" && $i<=5)
                                @php
                                    $i++;
                                    $score =  $user->general_reputation_score + $user->expert_reputation_score;
                                @endphp
                                <div class="col-md-6 col-sm-6 col-lg-4 px-4 mb-4 element-animation">
                                    <div class="top-experts">
                                        <div class="badge-card shadow">
                                            <i original-title="{{App\Badge::where('score','<=',$score)->orderBy('id', 'DESC')->value('name')}}" class="{{App\Badge::where('score','<=',$score)->orderBy('id', 'DESC')->value('icon')}} tooltip-n"></i>
                                            <span class="tooltip-n" original-title="Reputation Score">{{$score}}</span>
                                        </div>
                                        <div class="expert-card pt-3">
                                            <a class="d-block" href="{{route('profile', $user->user->username)}}">
                                                <div class="exp-avatar">
                                                    <img src="{{(@$user->user->avatar =='')?asset('assets/images/img_avatar.png'): asset('public/'.$user->user->avatar)}}" alt="profile-pic">
                                                </div>
                                                <div class="profile-details">
                                                    <h2 class="exp-title">{{$user->user->first_name}} {{$user->user->last_name}}</h2>
                                                    <p class="job-title mb-md-2">{{@$user->profession}}</p>
                                                </div>
                                            </a>
                                            <hr class="hr-2 my-1 my-sm-1 my-md-2 my-lg-3">
                                            <div class="activity-log">
                                                <div class="row text-center">
                                                    <div class="col-md-6 col-sm-6 col-6 p-0">
                                                        <h2 class="title-2">{{App\Answer::where(['user_id'=> $user->user_id,'type'=>'1'])->count()}}</h2>
                                                        <p class="followers">Answers</p>
                                                    </div>
                                                    <div class="col-md-6 col-sm-6 col-6 p-0">
                                                        <h2 class="title-2">{{@$user->user->art($user->user_id)}}</h2>
                                                        <p class="followers">Avg. Response Time</p>
                                                    </div>
                                                </div>

                                                <div class="row text-center">
                                                    <div class="col-md-6 col-sm-6 col-6 p-0">
                                                        <h2 class="title-2">{{@$user->user->acceptence($user->user_id)}}</h2>
                                                        <p class="followers">Acceptance %</p>
                                                    </div>
                                                    <div class="col-md-6 col-sm-6 col-6 p-0">
                                                        <h2 class="title-2">{{$user->general_reputation_score + $user->expert_reputation_score}}</h2>
                                                        <p class="followers">Reputation Score</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="widget">
                        <h3 class="widget_title">Quick Links</h3>
                        <ul>
                            <li><a href="http://help.thesageboard.com/general/what-exactly-is-sage" target="_blank" class="text-primary"> What Exactly is Sage?</a></li>
                            <li><a href="http://help.thesageboard.com/how-to/how-do-i-ask-a-question" _target="_blank" class="text-primary">How do I Ask a Question?</a></li>
                            <li><a href="http://help.thesageboard.com/how-to/how-do-i-earn-money" target="_blank" class="text-primary">How do I Earn Money?</a></li>
                        </ul>
                    </div>
                    <div class="widget widget_stats mt-3">
                        <h3 class="widget_title">Sage - Metrics</h3>
                        <div class="ul_list ul_list-icon-ok">
                            <ul>
                                <li><i class="icon-question-sign"></i>Questions ( <span>{{App\AskQuestion::count()}}</span> )</li>
                                <li><i class="icon-comment"></i>Answers ( <span>{{App\Answer::where('type',1)->count()}}</span> )</li>
                                <li><i class="icon-user"></i>Registered Users  ( <span>{{App\User::where('type','user')->count()}}</span> )</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="top-questions-area pt-md-3 pt-lg-4" id="latest-questions">
        <div class="container">
            <div class="row">
                <div class="col-md-10 top-questions"></div>
                {{--<div class="col-md-4 mt-4 mt-md-4 mt-lg-5">
                    <div class="widget widget_stats">
                        <h3 class="widget_title"><a target="_blank" href="https://ls.thesageboard.com/intro-video">An Introduction to the Sage Platform</a></h3>
                        <div class="ul_list ul_list-icon-ok w-100">
                            <iframe style="width:100%; height:190px" src="https://www.youtube.com/embed/n-ynjUBydM8" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                    </div>
                    <div class="widget widget_stats mt-3">
                        <h3 class="widget_title">Stats</h3>
                        <div class="ul_list ul_list-icon-ok">
                            <ul>
                                <li><i class="icon-question-sign"></i>Questions ( <span>{{App\AskQuestion::count()}}</span> )</li>
                                <li><i class="icon-comment"></i>Answers ( <span>{{App\Answer::where('type',1)->count()}}</span> )</li>
                            </ul>
                        </div>
                    </div>
                </div>--}}
            </div>
        </div>
    </section>

@endsection
@push('js')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script>
        $(document).ready(function(e) {
            $(window).resize(function(e) {
                classSlickSlider();
            })
            classSlickSlider();
        });
        function classSlickSlider() {
            $('.quote-item-wrapper').not('.slick-initialized').slick({
                dots: false,
                centerMode: false,
                vertical: false,
                lazyLoad: 'ondemand',
                autoplay: true,
                autoplaySpeed: 10000,
                arrows: false,
                infinite: true,
                slidesToShow: 1,
                slidesToScroll: 1,
            });
            $('.seeker-process').not('.slick-initialized').slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                dots: true,
                arrows: false,
                customPaging: function(slider, i) {
                    return '<button class="tab">' + $(slider.$slides[i]).attr('title') + '<i class="fa fa-sort-asc"></i></button>';
                },
            });
            $('.question-sage').on('click', function(e) {
                $('.sage-signup-process').not('.slick-initialized').slick({
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    dots: true,
                    arrows: false,
                    customPaging: function(slider, i) {
                        console.log(slider.$slides[i]);
                        return '<button class="tab">' + $(slider.$slides[i]).attr('title') + '<i class="fa fa-sort-asc"></i></button>';
                    },
                });
            });
        }

        $.post('{{ route('home.load_question') }}', {_token:'{{ csrf_token() }}'}, function(data){
            $('.top-questions').html(data);
        });
    </script>

@endpush
