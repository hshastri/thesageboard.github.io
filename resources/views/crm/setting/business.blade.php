@extends('crm.layout.app')
@section('content')
    <div class="page-header page-header-light">

        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="{{route('crm.dashboard')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                    <span class="breadcrumb-item active">Payments Settings</span>
                </div>
                <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>
        </div>
    </div>
    <div class="content">
       <div class="row">
           <div class="col-md-6">
               <div class="card">
                   <div class="card-header header-elements-inline">
                       <h6 class="card-title">Question Item Per Page</h6>
                       <div class="header-elements">
                           <div class="list-icons">
                               <a class="list-icons-item" data-action="collapse"></a>
                               <a class="list-icons-item" data-action="reload"></a>
                               <a class="list-icons-item" data-action="remove"></a>
                           </div>
                       </div>
                   </div>
                   <div class="card-body">
                       <form action="{{route('crm.business_settings')}}" method="post">
                           @csrf
                           <div class="form-group">
                               <label>Item Per Page</label>
                               <input type="number" class="form-control" placeholder="Item Per Page" name="item[items_per_page]" value="{{@$result['items_per_page']}}" required>
                           </div>

                           <div class="d-flex justify-content-between pull-right" style="float: right">
                               <button type="submit" class="btn bg-blue">Submit <i class="icon-paperplane ml-2"></i></button>
                           </div>
                       </form>
                   </div>
               </div>
               <div class="card">
                   <div class="card-header header-elements-inline">
                       <h6 class="card-title">Per Question Comission</h6>
                       <div class="header-elements">
                           <div class="list-icons">
                               <a class="list-icons-item" data-action="collapse"></a>
                               <a class="list-icons-item" data-action="reload"></a>
                               <a class="list-icons-item" data-action="remove"></a>
                           </div>
                       </div>
                   </div>
                   <div class="card-body">
                       <form action="{{route('crm.business_settings')}}" method="post">
                           @csrf
                           <div class="form-group">
                               <label>Comission Percentage</label>
                               <input type="number" class="form-control" placeholder="Ex: 20" name="item[comission]" value="{{@$result['comission']}}" required>
                           </div>

                           <div class="d-flex justify-content-between pull-right" style="float: right">
                               <button type="submit" class="btn bg-blue">Submit <i class="icon-paperplane ml-2"></i></button>
                           </div>
                       </form>
                   </div>
               </div>
           </div>
           <div class="col-md-6">
               <div class="card">
                   <div class="card-header header-elements-inline">
                       <h6 class="card-title">Category Section Settings</h6>
                       <div class="header-elements">
                           <div class="list-icons">
                               <a class="list-icons-item" data-action="collapse"></a>
                               <a class="list-icons-item" data-action="reload"></a>
                               <a class="list-icons-item" data-action="remove"></a>
                           </div>
                       </div>
                   </div>
                   <div class="card-body">
                       <form action="{{route('crm.business_settings')}}" method="post">
                           @csrf
                           <input type="hidden" name="item[categories_id]" id="categories_id">

                           <ul id="sortable">
                               @foreach ($categories as $categories)
                                   <li class="ui-state-default" id="{{$categories->id}}">{{$categories->name}}</li>
                               @endforeach
                           </ul>
                           <div class="d-flex justify-content-between pull-right" style="float: right">
                               <button type="submit" class="btn bg-blue">Submit <i class="icon-paperplane ml-2"></i></button>
                           </div>
                       </form>
                   </div>
               </div>
           </div>
           <div class="col-md-6">
               <div class="card">
                   <div class="card-header header-elements-inline">
                       <h6 class="card-title">General Reputation Score Settings</h6>
                       <div class="header-elements">
                           <div class="list-icons">
                               <a class="list-icons-item" data-action="collapse"></a>
                               <a class="list-icons-item" data-action="reload"></a>
                               <a class="list-icons-item" data-action="remove"></a>
                           </div>
                       </div>
                   </div>
                   <div class="card-body">
                       <form action="{{route('crm.business_settings')}}" method="post">
                           @csrf
                           <div class="form-group">
                               <label>Question Up Vote Score</label>
                               <input type="number" class="form-control" placeholder="Question Up vote Score" name="item[general_question_up_vote_score]" value="{{@$result['general_question_up_vote_score']}}" required>
                           </div>

                           <div class="form-group">
                               <label>Question Down Vote Score</label>
                               <input type="number" class="form-control" placeholder="Question Up vote Score" name="item[general_question_down_vote_score]" value="{{@$result['general_question_down_vote_score']}}" required>
                           </div>

                           <div class="form-group">
                               <label>Answer Up vote Score</label>
                               <input type="number" class="form-control" placeholder="Answer Up vote Score" name="item[general_answer_up_vote_score]" value="{{@$result['general_answer_up_vote_score']}}" required>
                           </div>

                           <div class="form-group">
                               <label>Answer Down vote Score</label>
                               <input type="number" class="form-control" placeholder="Answer Down vote Score" name="item[general_answer_down_vote_score]" value="{{@$result['general_answer_down_vote_score']}}" required>
                           </div>

                           <div class="d-flex justify-content-between pull-right" style="float: right">
                               <button type="submit" class="btn bg-blue">Submit <i class="icon-paperplane ml-2"></i></button>
                           </div>
                       </form>
                   </div>
               </div>
           </div>
           <div class="col-md-6">
               <div class="card">
                   <div class="card-header header-elements-inline">
                       <h6 class="card-title">Premium Reputation Score Settings</h6>
                       <div class="header-elements">
                           <div class="list-icons">
                               <a class="list-icons-item" data-action="collapse"></a>
                               <a class="list-icons-item" data-action="reload"></a>
                               <a class="list-icons-item" data-action="remove"></a>
                           </div>
                       </div>
                   </div>
                   <div class="card-body">
                       <form action="{{route('crm.business_settings')}}" method="post">
                           @csrf
                           <div class="form-group">
                               <label>Question Up Vote Score</label>
                               <input type="number" class="form-control" placeholder="Question Up vote Score" name="item[premium_question_up_vote_score]" value="{{@$result['premium_question_up_vote_score']}}" required>
                           </div>

                           <div class="form-group">
                               <label>Question Down Vote Score</label>
                               <input type="number" class="form-control" placeholder="Question Up vote Score" name="item[premium_question_down_vote_score]" value="{{@$result['premium_question_down_vote_score']}}" required>
                           </div>

                           <div class="form-group">
                               <label>Answer Up vote Score</label>
                               <input type="number" class="form-control" placeholder="Answer Up vote Score" name="item[premium_answer_up_vote_score]" value="{{@$result['premium_answer_up_vote_score']}}" required>
                           </div>

                           <div class="form-group">
                               <label>Answer Down vote Score</label>
                               <input type="number" class="form-control" placeholder="Answer Down vote Score" name="item[premium_answer_down_vote_score]" value="{{@$result['premium_answer_down_vote_score']}}" required>
                           </div>

                           <div class="d-flex justify-content-between pull-right" style="float: right">
                               <button type="submit" class="btn bg-blue">Submit <i class="icon-paperplane ml-2"></i></button>
                           </div>
                       </form>
                   </div>
               </div>
           </div>
       </div>
    </div>
@endsection
@push('js')
    <script>

        $( function() {
            $( "#sortable" ).sortable({
                update: function( event, ui ) {
                    setId();
                }
            });
            $( "#sortable" ).disableSelection();

        });

        function setId(){
            var rels = [];
            $('ul').each(function() {
                $(this).find('li').each(function(){
                    let id = $(this).attr('id')
                    if(id!=undefined){
                        rels.push($(this).attr('id'));
                    }
                });
            });
           $('#categories_id').val(rels)
        }

    </script>
@endpush
