@extends('frontend.user.user_app')
@section('user_content')
    <div class="row">
        <div class="col-md-12 my-3 activity-questions-answers">
            <div class="profile-bg">
                <h3>My Referral Link</h3>
                <h4 class="mt-4">
                    <a class="page-links" href="{{route('referral')}}">My Tree</a>
                    <a  class="page-links" href="{{route('referral-status')}}">My Status</a>
                    <a  class="page-links active" href="{{route('send-invitation')}}">Send Invitation</a>
                </h4>
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <h3 class="mb-4">Send a Referral.</h3>
                        <form action="{{route('send-invitation')}}" method="post">
                            @csrf
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <input type="text" name="first_name" id="referral-email-firstname" class="form-control-plaintext" placeholder="First Name" value="{{old('first_name')}}">
                                    @if($errors->has('first_name'))
                                        <span class="form-text text-danger"> {{$errors->first('first_name')}}</span>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="last_name" id="referral-email-firstname" class="form-control-plaintext" placeholder="Last Name" value="{{old('last_name')}}">
                                    @if($errors->has('last_name'))
                                        <span class="form-text text-danger"> {{$errors->first('last_name')}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <input type="email" name="email" class="form-control-plaintext" placeholder="Email Address">
                                    @if($errors->has('email'))
                                        <span class="form-text text-danger"> {{$errors->first('email')}}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <textarea name="emailbody" class="form-control" required id="email-template">
                                          Hi #USERNAME# <br/> <br/>  #MYNAME# would like to invite you to register with the new on-demand advice platform, Sage. You can use the referral link below to register. <br/> <br/> At Sage, our main priority is building a community of experts - 'Sages' - where the success of the Sages leads to the success of the site, and vice versa. We believe Sages are the critical element to building a game-changing platform, and we will treat you as such. We believe that if we have the best experts, then we will be the first place people seek advice for their most important questions. <br/> <br/>  Registering with this new link provides your referrer with passive earning potential from questions you answer. To be clear, this will not impact your current or future earnings potential negatively! Sage sets aside a percentage of revenue from all \"answers\" to pay out to each Sage's referral tree. This revenue comes from a shared pool of dollars and does not negatively impact either the referrer's earnings, or the referree’s earnings. By helping your referrer build their tree, you increase their earnings potential on our platform. Subsequently, by building your own tree, you also increase your own earnings potential for the same reasons.<br/> <br/>Please see our helpful FAQ pages at www.thesageboard.com  for more detail. <br/><br/> #INVITELINK# <br/><br/>Kind Regards,<br/>#MYNAME#"
                                    </textarea>
                                    @if($errors->has('email'))
                                        <span class="form-text text-danger"> {{$errors->first('email')}}</span>
                                    @endif
                                    <p style="color: red"><b>Email Template Note :</b> For send user first and last name use <b>#USERNAME#</b> . Sending Youe name use <b>#MYNAME# </b> and sending invitation url use <b>#INVITELINK#</b></p>
                                </div>
                            </div>

                           {{-- <div class="form-group row">
                                <div class="col-md-12">
                                    <p>Referral Link</p>
                                    <p><code>https://thesageboard.com/peter/kdya5jd</code></p>
                                </div>
                            </div>--}}

                            <div class="form-group">
                                <input type="submit" value="Send" class="w-100 d-block btn btn-success">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src='https://cdn.tiny.cloud/1/sjfoumrxpjum4qzmvwoptu3k7fh010z4lsc22vvnpzb60g2n/tinymce/5/tinymce.min.js' referrerpolicy="origin"></script>
    <script>
        $(document).ready(function() {
            tinymce.init({
                selector: '#email-template',
                placeholder: 'Type here...',
                menubar:false,
                min_height: 250,
                branding: false,
                plugins: 'paste',
                toolbar: 'formatselect ',
                paste_as_text: true,
                plugins: 'lists',
                toolbar: 'formatselect | numlist bullist',
                block_formats: 'Normal=p'
            });
        });

    </script>
@endpush
