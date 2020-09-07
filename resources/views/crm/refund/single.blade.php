@extends('crm.layout.app')
@section('content')
    <!-- Page header -->
    <div class="page-header page-header-light">
        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="{{route('crm.dashboard')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                    <span class="breadcrumb-item active">Refunds details</span>
                </div>
                <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>
        </div>
    </div>
    <!-- /page header -->

    <!-- Content area -->
    <div class="content">
        <!-- Multi-column layout -->
        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">Question Summary</h5>
                <div class="header-elements">
                    <div class="list-icons">
                        <a class="list-icons-item" data-action="collapse"></a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <h1 class="font-weight-semibold">{{ucfirst($question->question_title)}}</h1>
                <p class="mb-3">{{ substr(strip_tags($question->description),0,300)  }}<a href="">View Details</a></p>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-xl-4">
                <div class="card card-body">
                    <div class="media">
                        <div class="media-body text-left">
                            <h3 class="font-weight-semibold mb-0"><a href="">{{$refund->user->username}}</a></h3>
                            <span class="text-uppercase font-size-sm text-muted">Refund Asked</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-4">
                <div class="card card-body">
                    <div class="media">
                        <div class="mr-3 align-self-center">
                            <i class="icon-question4 icon-3x text-success-400"></i>
                        </div>
                        <div class="media-body text-right">
                            <h3 class="font-weight-semibold mb-0"><a href="">{{$refund->expert->username}}n</a></h3>
                            <span class="text-uppercase font-size-sm text-muted">Expert</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-xl-4">
                <div class="card card-body">
                    <div class="media">
                        <div class="mr-3 align-self-center">
                            <i class="icon-coin-dollar icon-3x text-success-400"></i>
                        </div>
                        <div class="media-body text-right">
                            <h3 class="font-weight-semibold mb-0">$ {{$refund->amount}}</h3>
                            <span class="text-uppercase font-size-sm text-muted">Amount</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                <div class="mb-3">
					<h6 class="mb-0 font-weight-semibold">Talk With Experts</h6>
					<span class="text-muted d-block">Place conversation to get the reasons for refund</span>
				</div>
                <div class="nav-tabs-responsive">

                    <ul class="nav nav-tabs nav-tabs-highlight flex-nowrap mb-0">

                            <li class="nav-item">
                                <a href="#{{$refund->expert->username}}" class="nav-link active" data-toggle="tab">

                                    <img src="{{($refund->expert->avatar =='')?asset('assets/images/admin.jpg'): asset('public/'.$refund->expert->avatar)}}" alt="" class="rounded-circle mr-2" width="20" height="20">
                                    {{$refund->expert->username}}
                                    <span class="badge badge-mark ml-2 border-success"></span>
                                </a>
                            </li>

                    </ul>
                </div>

                <div class="tab-content card card-body border-top-0 rounded-0 rounded-bottom mb-0">
                    <div class="tab-pane fade show active" id="{{$refund->expert->username}}">
                        <ul class="media-list media-chat mb-3">
                            @php
                            $chats = App\Chat::where(['user_id'=>$refund->expert_id,'question_id'=>$refund->question_id])->get();
                            @endphp
                            @foreach($chats as $chat)
                                @if($chat->admin==0)
                                    <li class="media">
                                        <div class="mr-3">
                                            <a href="#">
                                                <img src="{{($refund->expert->avatar =='')?asset('assets/images/admin.jpg'): asset('public/'.$refund->expert->avatar)}}" class="rounded-circle" width="40" height="40" alt="">
                                            </a>
                                        </div>

                                        <div class="media-body">
                                            <div class="media-chat-item">{{$chat->massage}}</div>
                                            <div class="font-size-sm text-muted mt-2">{{$chat->created_at}} <a href="#"><i class="icon-pin-alt ml-2 text-muted"></i></a></div>
                                        </div>
                                    </li>
                                @else
                                    <li class="media media-chat-item-reverse">
                                        <div class="media-body">
                                            <div class="media-chat-item">{{$chat->massage}}</div>
                                            <div class="font-size-sm text-muted mt-2">{{$chat->created_at}} <a href="#"><i class="icon-pin-alt ml-2 text-muted"></i></a></div>
                                        </div>
                                        <div class="ml-3">
                                            <a href="#">
                                                <img src="{{asset('assets/images/face1.jpg')}}" class="rounded-circle" width="40" height="40" alt="">
                                            </a>
                                        </div>
                                    </li>
                                @endif
                            @endforeach
                        </ul>

                        <form action="{{route('crm.chat')}}" method="POST">
                            @csrf
                            <input type="hidden" name="user_id" value="{{$refund->expert_id}}">
                            <input type="hidden" name="question_id" value="{{$refund->question_id}}">
                            <textarea name="message" class="form-control mb-3" rows="3" cols="1" placeholder="Enter your message..." required></textarea>
                            <div class="d-flex align-items-center">
                                <button type="submit" class="btn bg-teal-400 btn-labeled btn-labeled-right ml-auto"><b><i class="icon-paperplane"></i></b> Send</button>
                            </div>
                        </form>
                    </div>
                </div>
            <div>

        </div>

            </div>
        </div>
        <!-- /multi-column layout -->
    </div>
@endsection
@section('sidebar-right')
<div class="sidebar sidebar-light sidebar-right sidebar-expand-md">
    <div class="sidebar-mobile-toggler text-center">
        <a href="#" class="sidebar-mobile-expand">
            <i class="icon-screen-full"></i>
            <i class="icon-screen-normal"></i>
        </a>
        <span class="font-weight-semibold">Right sidebar</span>
        <a href="#" class="sidebar-mobile-right-toggle">
            <i class="icon-arrow-right8"></i>
        </a>
    </div>
    <div class="sidebar-content">

        <div class="card mb-2">
            <div class="card-header bg-transparent header-elements-inline">
                <span class="text-uppercase font-size-sm font-weight-semibold">Take Action</span>
                <div class="header-elements">
                    <div class="list-icons">
                        <a class="list-icons-item" data-action="collapse"></a>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <ul class="nav nav-sidebar" data-nav-type="accordion">
                    <li class="nav-item pl-2 pt-3">
                        @if(@$refund->status=="Pending")
                        <a  class="btn btn-primary" href="javascript:void(0)" onclick="show_refund_modal('{{route("release-refund",$refund->id)}}')">Release Refund</a>
                        <a class="btn btn-danger" href="javascript:void(0)" onclick="show_refund_modal('{{route("suspend-refund",$refund->id)}}')">Suspend</a>
                         @else
                            <a  class="btn btn-primary" href="javascript:void(0)">{{$refund->status}}</a>
                        @endif
                    </li>
                </ul>
            </div>
        </div>
        <div class="card mb-2">
            <div class="card-header bg-transparent header-elements-inline">
                <span class="text-uppercase font-size-sm font-weight-semibold">Dialogue Content</span>
                <div class="header-elements">
                    <div class="list-icons">
                        <a class="list-icons-item" data-action="collapse"></a>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <ul class="nav nav-sidebar" data-nav-type="accordion">
                    <li class="nav-item-header">Category title</li>
                    <li class="nav-item">
                        <span class="nav-link"><i class="icon-list"></i> Topic: <b class="ml-2"> {{$question->category->name}}</b></span>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link"><i class="icon-list"></i> Sub-topic: <b class="ml-2">{{$question->subcategory->name}}</b></span>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link"><i class="icon-man-woman"></i> Public/Private: <b class="ml-2">{{$question->question_label}}</b></span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card mb-2">
            <div class="card-header bg-transparent header-elements-inline">
                <span class="text-uppercase font-size-sm font-weight-semibold">Selected Experts</span>
                <div class="header-elements">
                    <div class="list-icons">
                        <a class="list-icons-item" data-action="collapse"></a>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <ul class="nav nav-sidebar" data-nav-type="accordion">
                    @foreach(json_decode($question->experties_ids) as $expert)

                        @php
                            $user = App\User::where('id', $expert)->first();
                            $user_details = App\UserDetails::where('user_id', $expert)->first();
                        @endphp

                        <li class="nav-item">
                            <a href="#" class="pl-3 nav-link"><i class="text-success {{($refund->expert_id==$user->id)?'icon-checkmark4':'text-danger'}}"></i>{{$user->username}}<span class="ml-3 badge badge-success">$ {{$user_details->expertise_rate}}</span></a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>

<div id="modal_refund" class="modal fade m-5" data-keyboard="false" data-backdrop="static" tabindex="-1">
    <div class="modal-dialog modal-sm mt-5">
        <div class="modal-content" id="modal-content">

        </div>
    </div>
</div>


@endsection


@push('js')
    <script>
        function show_refund_modal(dataUrl){
            $.get(dataUrl, function(data){
                $('#modal-content').html(data);
                $('#modal_refund').modal('show', {backdrop: 'static'});
            });
        }


    </script>
@endpush
