@extends('frontend.user.user_app')
@section('user_content')
    <div class="row">
        <div class="col-md-12 ">
            <nav class="navbar scrolltop-nav navbar-expand-lg sage-profile-edit-nav navbar-light bg-white shadow">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item active">
                            <a class="nav-link" href="#account-settings">Account Settings <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#basic-info">Basic Information</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#social-media">Social Media</a>
                        </li>
                        @if(Auth::user()->role=='General')
                        <li class="nav-item">
                            <a class="nav-link" href="#expertise-area">Expertise area</a>
                        </li>
                        @endif
                    </ul>
                </div>
            </nav>
        </div>

        <div id="account-settings" class="edit-item col-md-12 mt-3">
            <div class="profile-bg private-general-info">
                <h1>Account Settings</h1>
                <div class="row">
                    <div class="col-md-12">
                        <form class="sage-edit-profile-form none-edit" action="{{route('profile-edit')}}" method="post" enctype="multipart/form-data" changed="false">
                            @csrf
                            <input type="hidden" name="account" value="1">
                            <div class="form-group row">
                                <label for="firstname" class="col-sm-2 col-form-label">First Name</label>
                                <div class="col-sm-10 col-md-6">
                                    <input type="text" class="form-control-plaintext" id="firstname" name="first_name" value="{{Auth::user()->first_name}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="lastname" class="col-sm-2 col-form-label">Last Name</label>
                                <div class="col-sm-10 col-md-6">
                                    <input type="text" class="form-control-plaintext" id="lastname" name="last_name" value="{{Auth::user()->last_name}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="username" class="col-sm-2 col-form-label">Username</label>
                                <div class="col-sm-10 col-md-6">
                                    <input type="text" readonly class="form-control-plaintext" id="username" name="username" value="{{Auth::user()->username}}" style="background: transparent">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="sage-email" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10 col-md-6">
                                    <input type="text" class="form-control-plaintext" id="sage-email" name="email" value="{{Auth::user()->email}}" readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="sage-email" class="col-sm-2 col-form-label">Profile Headline</label>
                                <div class="col-sm-10 col-md-6">
                                    <input type="text" class="form-control-plaintext" name="profession" value="{{@$user_details->profession}}">
                                </div>
                            </div>

                            <div class="form-group row registration-textarea">
                                <label for="sage-biography" class="col-sm-2 col-form-label">Biography</label>
                                <div class="col-sm-10 col-md-10">
                                    <textarea class="form-control" id="sage-biography" rows="5" name="bio">{{$user_details->bio}}</textarea>
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label class="col-sm-2 col-md2 col-form-label">Profile Picture</label>
                                <div class="fileinputs col-md-10 sage-edit-profile">
                                    <div class="user-profile-img image-previewer" data-cropzee="cropzee-input">
                                        <img src="{{(Auth::user()->avatar =='')?asset('assets/images/admin.jpg'): asset('public/'.Auth::user()->avatar)}}" alt="admin" id="avatar">
                                    </div>
                                    <input type="file" class="file" name="file" id="cropzee-input">
                                    <div class="fakefile">
                                        <button type="button" class="button small margin_0" id="selectfile">Select file</button>
                                        <span><i class="icon-arrow-up"></i>Browse</span>
                                    </div>

                                </div>
                            </div>
                            <div class="form-group">
                                <input type="submit" value="Save" class="btn btn-success float-right">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div id="basic-info" class="edit-item col-md-12 mt-5">
            <div class="profile-bg">
                <h1>Basic Information</h1>
                <div class="row">
                    <div class="col-md-12">
                        <form class="sage-edit-profile-form none-edit" action="{{route('profile-edit')}}" method="post" changed="false">
                            @csrf
                            <input type="hidden" name="basic" value="1">
                            <h4>Education</h4>
                            <div class="form-group row">
                                <label for="sage-graduation" class="col-sm-2 col-form-label">Education Summary</label>
                                <div class="col-md-8">
                                    <input type="text" name="graduation" id="sage-graduation" class="form-control-plaintext" value="{{@$user_details->graduation}}">
                                </div>
                            </div>
                            {{--<div class="form-group row">
                                <label for="sage-college" class="col-sm-2 col-form-label">College</label>
                                <div class="col-md-8">
                                    <input type="text" name="college" id="sage-college" class="form-control-plaintext" value="{{@$user_details->college}}">
                                </div>
                            </div>--}}

                            <h4>Contact Information</h4>
                            <div class="form-group row">
                                <label for="sage-country" class="col-sm-2 col-form-label">Country</label>
                                <div class="col-md-6">
                                    <input type="text" name="country" id="sage-country" class="form-control-plaintext" value="{{@$user_details->country}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="sage-home-town" class="col-sm-2 col-form-label">Location</label>
                                <div class="col-md-6">
                                    <input type="text" name="hometown" id="sage-home-town" class="form-control-plaintext" value="{{@$user_details->hometown}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="sage-contact-phone" class="col-sm-2 col-form-label">Phone</label>
                                <div class="col-md-6">
                                    <input type="text" name="phone" id="sage-contact-phone" class="form-control-plaintext" value="{{@$user_details->phone}}">
                                </div>
                            </div>

                            <h4 class="mb-2 mr-2 d-inline-block">Mailing Address</h4>
                            <em class="d-inline-block " style="font-size: 12px">(<i class="fas info-circlr"></i>Optional. Please see our <a class="text-success" target="_blank" href="{{route('policy')}}">privacy policy</a> for more information on how we use your data.)</em>
                            <div class="form-group row">
                                <label for="sage-country" class="col-sm-2 col-form-label">Street</label>
                                <div class="col-md-6">
                                    <input type="text" name="street" id="sage-country" class="form-control-plaintext" value="{{@$user_details->street}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="sage-country" class="col-sm-2 col-form-label">City</label>
                                <div class="col-md-6">
                                    <input type="text" name="city" id="sage-country" class="form-control-plaintext" value="{{@$user_details->city}}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="sage-country" class="col-sm-2 col-form-label">Postal Code</label>
                                <div class="col-md-6">
                                    <input type="text" name="zipcode" id="sage-country" class="form-control-plaintext" value="{{@$user_details->zipcode}}">
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="sage-country" class="col-sm-2 col-form-label">Phone Number</label>
                                <div class="col-md-6">
                                    <input type="text" name="phone-number" id="sage-country" class="form-control-plaintext" value="">
                                </div>
                            </div>

                            <div class="form-group">
                                <input type="submit" value="Save" class="btn btn-success float-right">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div id="social-media" class="edit-item col-md-12 my-5">
            <div class="profile-bg">
                <h1>Social Media</h1>
                <div class="row">
                    <div class="col-md-12">
                        <form class="sage-edit-profile-form none-edit" action="{{route('profile-edit')}}" method="post" changed="false">
                            @csrf
                            <input type="hidden" name="zone" value="1">

                            <div class="form-group row">
                                <label for="sage-fb-link" class="col-sm-2 col-form-label">Website</label>
                                <div class="col-md-6">
                                    <input type="url" name="website" id="sage-fb-link" class="form-control-plaintext" value="{{@$user_details->website}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="sage-linkedIn-link" class="col-sm-2 col-form-label">Instagram</label>
                                <div class="col-md-6">
                                    <input type="url" name="googleplus" id="sage-linkedIn-link" class="form-control-plaintext" value="{{@$user_details->googleplus}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="sage-twitter-link" class="col-sm-2 col-form-label">Twitter Link</label>
                                <div class="col-md-6">
                                    <input type="url" name="twitterlink" id="sage-twitter-link" class="form-control-plaintext" value="{{@$user_details->twitterlink}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="sage-fb-link" class="col-sm-2 col-form-label">Facebook Link</label>
                                <div class="col-md-6">
                                    <input type="url" name="fblink" id="sage-fb-link" class="form-control-plaintext" value="{{@$user_details->fblink}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="sage-linkedIn-link" class="col-sm-2 col-form-label">linkedIn Link</label>
                                <div class="col-md-6">
                                    <input type="url" name="linkedin" id="sage-linkedIn-link" class="form-control-plaintext" value="{{@$user_details->linkedin}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="submit" value="Save" class="btn btn-success float-right">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @if(Auth::user()->role=='General')
        <div id="expertise-area" class="edit-item col-md-12 my-5">
            <div class="profile-bg">
                <h1>Expertise Area</h1>
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{route('profile-edit')}}" method="post" changed="false">
                        @csrf
                            <input type="hidden" name="expertise" value="1">
                            <div class="form-group row">
                                <label for="sage-demand-money" class="col-sm-2 col-form-label font-weight-bold">Your Answer Fee</label>
                                <div class="col-md-8">
                                    <input type="number" name="expertise_rate" id="sage-demand-money" class="col-4" min="0" value="{{@$user_details->expertise_rate}}">
                                    <small id="passwordHelpBlock" class="form-text text-muted">Set your demand money dollar amount you will charge when answering the questions.</small>
                                </div>
                            </div>
                            <div class="user-expertise-topic-sub-topics">
                                <div class="form-group row">
                                    <label for="sage-topics" class="col-sm-2 col-form-label">Add topic</label>
                                    <div class="col-md-8">
                                        <select id="sage-topics" class="form-control-plaintext" name="expert_category[]" multiple="multiple" required>
                                            @foreach($dbcategory as $dbcategory)
                                            <option value="{{$dbcategory->id}}">{{$dbcategory->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="sage-sub-topics" class="col-sm-2 col-form-label">Add sub-topic</label>
                                    <div class="col-md-8">
                                        <select id="sage-sub-topics" class="form-control-plaintext" name="expert_subcategory[]" multiple="multiple" required>
                                            {{--@foreach($dbsubcategory as $dbsubcategory)
                                                <option value="{{$dbsubcategory->id}}">{{$dbsubcategory->name}}</option>
                                            @endforeach--}}
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="sage-sub-tags" class="col-sm-2 col-form-label">Add tags</label>
                                    <div class="col-md-8">
                                        <input type="text" name="speciality[]" id="sage-sub-tags" class="form-control-plaintext">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="submit" value="Save" class="btn btn-success float-right">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
@endsection
@push('js')
    <script src='https://cdn.tiny.cloud/1/sjfoumrxpjum4qzmvwoptu3k7fh010z4lsc22vvnpzb60g2n/tinymce/5/tinymce.min.js' referrerpolicy="origin"></script>
    <script src="https://cdn.jsdelivr.net/gh/BossBele/cropzee@latest/dist/cropzee.js" defer></script>
    <script>

        $(document).ready(function() {
            tinymce.init({
                selector: '#sage-biography',
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

            $("#cropzee-input").cropzee({
                allowedInputs: ['gif','png','jpg','jpeg'],
                imageExtension:'image/jpeg',
            });

            $('form :input').on('change', function(e) {
                $(this).closest('form.sage-edit-profile-form').attr('changed', 'true').removeClass('none-edit');
            });

            $('body').on('click', 'form.none-edit :input', function(e) {
                $('form.sage-edit-profile-form').each(function(i, e) {
                    if($(e).attr('changed') == 'true') {
                        $(e).parents('.profile-bg').css('border', '6px solid rgb(214, 86, 66)');
                        var ID          = $(e).parents('.edit-item').attr('id');
                        var warning     = `<div class="form-edit-warning shadow-lg">You have unsaved data here. Please save this section first.</div>`;
                        $(warning).prependTo('#'+ID);
                        $('html, body').animate({
                            scrollTop: $("#"+ID).offset().top
                        }, 450);
                    }
                });
            });
            @if(json_decode(@$user_details->expert_category)!=null && json_decode(@$user_details->expert_subcategory)!=null && json_decode(@$user_details->speciality)!=null)
                var selectedValuesCategory = [];
                var selectedValuesSubCategory = [];
                @foreach(json_decode(@$user_details->expert_category) as $secategory)
                    selectedValuesCategory.push({{$secategory}})
                @endforeach
                getsubcategory(selectedValuesCategory)

                @foreach(json_decode(@$user_details->expert_subcategory) as $sesubcategory)
                selectedValuesSubCategory.push({{$sesubcategory}})
                @endforeach
                @if(@$user_details->speciality)
                    @foreach(json_decode(@$user_details->speciality) as $speciality)
                    $("#sage-sub-tags").val("{{$speciality}}");
                    @endforeach
                @endif
                @else
                $('#sage-topics').select2()
                $('#sage-sub-topics').select2()
            @endif

            $('#sage-topics').select2().val(selectedValuesCategory).trigger('change');
            setTimeout(function () {
                $('#sage-sub-topics').select2().val(selectedValuesSubCategory).trigger('change');
            },1000)
        });

        $('#sage-topics').on('select2:select select2:unselect', function(e) {
            var select_val = $(e.currentTarget).val();
            getsubcategory(select_val);
        });

        function getsubcategory(select_val){
            $.post('{{ route('populated-subcategory') }}', {_token:'{{ @csrf_token() }}',data:select_val}, function(data){
                $('#sage-sub-topics').html(data)
            });
        }

         $('input[type="file"]').change(function(e){
           var fileName = e.target.files[0].name;
           $('#selectfile').text(fileName);
            /* var url=window.location;
             url.replace("","#cropzee-modal");*/
       });

        /*function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#avatar').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }*/

        $( function() {
            var availableTags = [
                @foreach($dbtag as $dbtag)
                    "{{$dbtag->tags}}",
                @endforeach
            ];
            function split( val ) {
                return val.split( /,\s*/ );
            }
            function extractLast( term ) {
                return split( term ).pop();
            }

            $("#sage-sub-tags").on( "keydown", function( event ) {
                if ( event.keyCode === $.ui.keyCode.TAB &&
                    $( this ).autocomplete( "instance" ).menu.active ) {
                    event.preventDefault();
                }
            }).autocomplete({
                classes: {
                    "ui-autocomplete": "highlight"
                },
                minLength: 0,
                source: function( request, response ) {
                    // delegate back to autocomplete, but extract the last term
                    response( $.ui.autocomplete.filter(
                        availableTags, extractLast( request.term ) ) );
                },
                focus: function() {
                    return false;
                },
                select: function( event, ui ) {
                    var terms = split( this.value );
                    // remove the current input
                    terms.pop();
                    // add the selected item
                    terms.push( ui.item.value );
                    // add placeholder to get the comma-and-space at the end
                    terms.push( "" );
                    this.value = terms.join( ", " );
                    return false;
                }
            });
        } );
    </script>
@endpush
