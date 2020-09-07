@extends('frontend.layout.app')
@section('main')
    <section class="container main-content">
        <div class="d-flex justify-content-center mt-3" style="margin-bottom: -1em">
            <div class="offset-1 col-11">
                <h2>Top Expert</h2>
            </div>
        </div>
        <div class="d-flex justify-content-center">
            <div class="col-md-10 expert-info-card">
                    <form action="{{route('users')}}" method="GET">
                        @csrf
                        <div class="d-flex justify-content-center">
                        <div class="col-10">
                            <div class="input-group">
                                <input type="text" name="name" class="expert_search" placeholder="Search" value="{{@$setname}}" required>
                                <div class="input-group-append">
                                    <button class="btn btn-secondary expert_search_btn" type="submit">
                                        <i class="icon-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-2">
                            <button type="button" class="btn"><i class="icon-filter"></i> Filter</button>
                        </div>
                        </div>
                    </form>

                 @foreach($expert as $users)
                    <div class="d-flex justify-content-center info-card">
                    <div class="col-2">
                        <a href="#" >
                            <img alt="" src="{{($users->avatar =='')?asset('assets/images/avatar.png'): asset('public/'.$users->avatar)}}" class="expert_image">
                        </a>
                    </div>
                    <div class="col-10">
                        <h3 style="margin: 0px;"><a class="expert-name" href="{{route('profile', $users->username)}}">{{$users->first_name}} {{$users->last_name}}</a></h3>
                        <div class="mb-2 mt-1">
                            <span class="meta-author"><i class="icon-user"></i><a href="#">{{@$users->user_details[0]->profession}}</a></span>
                            <span class="meta-date"><i class="icon-time"></i>{{$users->created_at}}</span>
                            {{--<span class="meta-categories"><i class="icon-suitcase"></i><a href="#">Wordpress</a></span>
                            <span class="meta-comment"><i class="icon-comments-alt"></i><a href="#">15 comments</a></span>--}}
                        </div>
                        <p>{!! @$users->user_details[0]->bio !!}</p>
                        <ul>
                            @if(@$users->user_details[0]->speciality)
                                @foreach(json_decode(@$users->user_details[0]->speciality) as $key => $value)
                                    @if($value)
                                        <li><a href="">{{$value}}</a></li>
                                    @endif
                                @endforeach
                            @endif

                        </ul>
                    </div>
                </div>
                 @endforeach


            </div><!-- End main -->
        </div><!-- End row -->
        <div class="d-flex justify-content-end">
            <div class="col-8 pagination">
                {{ $expert->links() }}
            </div>
        </div>
    </section><!-- End container -->


@endsection
