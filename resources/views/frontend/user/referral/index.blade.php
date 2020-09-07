@extends('frontend.user.user_app')
@section('user_content')
    <div class="row">
        <div class="col-md-12 my-3 activity-questions-answers">
            <div class="profile-bg">
                <h3>My Referral Link</h3>
                <h4 class="mt-4">
                    <a class="page-links active" href="{{route('referral')}}">My Tree</a>
                    <a  class="page-links" href="{{route('referral-status')}}">My Status</a>
                    <a  class="page-links" href="{{route('send-invitation')}}">Send Invitation</a>
                </h4>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col"><b>Name</b></th>
                            <th scope="col"><b>Email Address</b></th>
                            <th scope="col"><b>Referral Counts</b></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tree as $key =>$ref)
                        <tr>
                            <td scope="row">{{$ref->user->first_name}} {{$ref->user->last_name}}</td>
                            <td>{{$ref->user->email}}</td>
                            <td>{{App\ReferralTree::where('user_id', $ref->ref_user_id)->count()}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="3">{{$tree->links()}}</td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection
