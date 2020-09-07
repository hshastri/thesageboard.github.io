@extends('frontend.layout.app')
@section('main')
    <section class="py-4 registration-steps" style="background:#3e3e3e">
        <div class="custom-container mt-3">
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <ul class="process-steps">
                        <li class="acttive done">
                            <div class="icon">1</div>
                            <div class="title">Basic Info</div>
                        </li>
                        <li class="">
                            <div class="icon">2</div>
                            <div class="title">Bio</div>
                        </li>
                        <li>
                            <div class="icon">3</div>
                            <div class="title">Topic</div>
                        </li>
                        <li>
                            <div class="icon">4</div>
                            <div class="title">Fees</div>
                        </li>
                        <li>
                            <div class="icon">5</div>
                            <div class="title">Success</div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <section class="registration-wrapper">
        <div class="container">
            <div class="row sage-margin-right">
                <div class="col-md-8 offset-md-2 pb-md-4">
                    <h2 class="my-3 my-sm-4 my-md-4 text-center">Let's fill out Bio Information</h2>
                    <form action="{{route('expert-bio')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group ">
                                            <input type="text" class="form-control-plaintext" name="profession" placeholder="Expertise Headline(required)" value="{{@$user_details->profession}}">
                                            <span class="form-text text-muted"><small> e.g. Founder, Technologist, Coach, Engineering Leader.</small></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="row align-items-end">
                                    <div class="col-4 col-md-4">
                                        <div class="image-preview">
                                            <img src="{{(Auth::user()->avatar =='')?asset('assets/images/admin.jpg'): asset('public/'.Auth::user()->avatar)}}" alt="admin" id="avatar">
                                        </div>
                                    </div>
                                    <div class="col-3 col-md-3 profile-uploader">
                                        <input type="file" name="file" class="w-100" id="expert-profile-uploader">
                                        <div class="uploader-trigger text-center">
                                            <label class="upload" for="expert-profile-uploader">Upload</label>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="row mt-5 registration-textarea">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="expert-bio">Expert Biography</label>
                                    <textarea name="bio" class="w-100 h-sm-25" id="expert-bio" cols="40" rows="10">{{$user_details->bio}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="form-group">
                                    <input type="text" name="graduation"  class="form-control" required  placeholder="Education Summary" value="{{@$user_details->graduation}}">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <input type="text" name="country" class="form-control" value="{{@$user_details->country}}" required placeholder="Country">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="hometown" required placeholder="Location" value="{{@$user_details->hometown}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <a href="{{route('user-deshboard')}}" class="submit-button text-center float-left"> Skip </a>
                                <input type="submit" name="register" class="submit-button float-right" value="Next">
                            </div>
                        </div>
                    </form>
                </div><!-- End col-md-6 -->
            </div><!-- End row -->
        </div><!-- End login -->
    </section>

@endsection
@push('js')
    <script src='https://cdn.tiny.cloud/1/sjfoumrxpjum4qzmvwoptu3k7fh010z4lsc22vvnpzb60g2n/tinymce/5/tinymce.min.js' referrerpolicy="origin"></script>
    <script>
        $(document).ready(function() {
            tinymce.init({
                selector: '#expert-bio',
                placeholder: 'Type here...',
                menubar:false,
                min_height: 250,
                branding: false,
                plugins: 'paste',
                toolbar: 'formatselect ',
                paste_as_text: true,
                plugins: 'lists paste',
                toolbar: 'formatselect | numlist bullist',
                block_formats: 'Normal=p',
                paste_as_text: true,
            });

            $("#expert-profile-uploader").change(function(){
                readURL(this);
            });
        });
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('.image-preview img').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endpush
