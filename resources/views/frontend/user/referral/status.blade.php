@extends('frontend.user.user_app')
@section('user_content')
    <div class="row">
        <div class="col-md-12 my-3 activity-questions-answers">
            <div class="profile-bg">
                <h3>My Referral Link</h3>
               {{-- <p class="referral-link d-inline-block py-3 pr-5 pl-2 rounded bg-dark"><code>https://thesageboard.com/peter/kdya5jd</code></p>--}}
                <h4 class="mt-4">
                    <a class="page-links" href="{{route('referral')}}">My Tree</a>
                    <a  class="page-links active" href="{{route('referral-status')}}">My Status</a>
                    <a  class="page-links" href="{{route('send-invitation')}}">Send Invitation</a>
                </h4>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col"><b>#</b></th>
                            <th scope="col"><b>Name</b></th>
                            <th scope="col"><b>Email Address</b></th>
                            <th scope="col"><b>Link</b></th>
                            <th scope="col"><b>Status</b></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($referral as $key =>$ref)
                        <tr>
                            <td scope="row">{{ ($key+1)  }}</td>
                            <td>{{$ref->first_name}} {{$ref->last_name}}</td>
                            <td>{{$ref->email}}</td>
                            <td><span>{{url('sage/'.$ref->remember_token)}}</span><i class="fas fa-clone copy"></i></td>
                            <td>
                                @if($ref->isRegister=='0')
                                    <span class="badge badge-info">Sent</span>
                                @else
                                    <span class="badge badge-success">Registered</span>
                                @endif

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="5">{{$referral->links()}}</td>
                    </tr>
                    </tfoot>
                </table>

            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function(e) {
            $('i.copy').on('click', function(e) {
                var $temp = $("<input>");
                $("body").append($temp);
                $temp.val($(this).siblings('span').text()).select();
                document.execCommand("copy");
                $temp.remove();
                $(this).text('Copied');
            });
        });
    </script>
@endpush
