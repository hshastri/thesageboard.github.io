@extends('frontend.layout.app')
@section('main')
    <section class="registration-wrapper">
        <div class="custom-container">
            <div class="row sage-margin-right">
                <div class="col-md-8 offset-md-2 pl-md-5 pb-md-4">
                    <div class="page-content">
                        <h2 class="mb-5">Register As An Expert</h2>
                        <form action="{{route('expert-register')}}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group ">
                                                <label>First Name <span style="color: red">*</span></label>
                                                <input type="text" name="first_name" class="form-control" required value="{{old('first_name')}}" style="width: 100% !important;margin-bottom:0px !important;">
                                                @if($errors->has('first_name'))
                                                    <span class="form-text text-danger"> {{$errors->first('first_name')}}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group ">
                                                <label >Last Name <span style="color: red">*</span></label>
                                                <input type="text" name="last_name"  class="form-control" required value="{{old('last_name')}}" style="width: 100% !important;margin-bottom:0px !important;">
                                                @if($errors->has('last_name'))
                                                    <span class="form-text text-danger"> {{$errors->first('last_name')}}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="your_email">E-mail Address <span style="color: red">*</span></label>
                                        <input type="text" name="email" class="form-control" required="" pattern="[^@]+@[^@]+.[a-zA-Z]{2,6}" aria-required="true" required style="width: 100% !important;margin-bottom:0px !important;" autocomplete="off">
                                        @if($errors->has('email'))
                                            <span class="form-text text-danger"> {{$errors->first('email')}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Phone Number <span style="color: red">*</span></label>
                                        <input type="text" name="phone" class="form-control" required="" required style="width: 100% !important;margin-bottom:0px !important;" value="{{old('phone')}}">
                                        @if($errors->has('phone'))
                                            <span class="form-text text-danger"> {{$errors->first('phone')}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Username <span style="color: red">*</span></label>
                                        <input type="text" name="username" class="form-control" required="" required style="width: 100% !important;margin-bottom:0px !important;" autocomplete="off" value="{{old('username')}}">
                                        @if($errors->has('username'))
                                            <span class="form-text text-danger"> {{$errors->first('username')}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row cat-sub">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-3">
                                            <label>Expertise Area <span style="color: red">*</span></label>
                                            <p>N.B What you select for topic, sub topic will be listed a/c to those.</p>
                                        </div>
                                        <div class="col-9">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group ">
                                                        <label for="sage-category">Topic <span style="color: red">*</span></label>
                                                        <select id="sage-category" class="categories" name="expert_category[]" multiple="multiple" required>
                                                            @foreach($category as $category)
                                                                <option value="{{$category->id}}">{{$category->name}}</option>
                                                            @endforeach
                                                        </select>
                                                        @if($errors->has('expert_category'))
                                                            <span class="form-text text-danger"> {{$errors->first('expert_category')}}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group ">
                                                        <label for="sage-sub-category">Sub Topic <span style="color: red">*</span></label>
                                                        <select id="sage-sub-category" class="subcategories" name="expert_subcategory[]" multiple="multiple" required>

                                                        </select>
                                                        @if($errors->has('expert_subcategory'))
                                                            <span class="form-text text-danger"> {{$errors->first('expert_subcategory')}}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Specialty <span style="color: red">*</span></label>
                                        <input type="text" class="speciality"  name="speciality[]" style="width: 44em">
                                        @if($errors->has('speciality'))
                                            <span class="form-text text-danger"> {{$errors->first('speciality')}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Profession <span style="color: red">*</span></label>
                                        <input type="text" name="profession" class="form-control" required="" required style="width: 100% !important;margin-bottom:0px !important;" value="{{old('profession')}}">
                                        @if($errors->has('profession'))
                                            <span class="form-text text-danger"> {{$errors->first('profession')}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group ">
                                                <label>Password <span style="color: red">*</span></label>
                                                <input type="Password" name="password" class="form-control" required required style="width: 100% !important;margin-bottom:0px !important;">
                                                @if($errors->has('password'))
                                                    <span class="form-text text-danger"> {{$errors->first('password')}}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group ">
                                                <label >Confirm Password <span style="color: red">*</span></label>
                                                <input type="password" class="form-control" name="confirm_password" required required style="width: 100% !important;margin-bottom:0px !important;">
                                                @if($errors->has('confirm_password'))
                                                    <span class="form-text text-danger"> {{$errors->first('confirm_password')}}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-checkbox">
                                <input id="terms-condition" type="checkbox" name="checkbox" class="sage-check-box" required>
                                <label for="terms-condition" class="container" style=" margin-top: -1.5em; margin-left: .5em;">I agree to the <a  href="javascript:void(0)" onclick="show_policy_modal()" class="text" style="color: #00d773">Terms and Conditions</a></label>
                                @if($errors->has('checkbox'))
                                    <span class="form-text text-danger"> {{$errors->first('checkbox')}}</span>
                                @endif
                            </div>
                            <div class="form-row-last">
                                <input type="submit" name="register" class="button small color" value="Register">
                            </div>

                        </form>
                    </div><!-- End page-content -->
                </div><!-- End col-md-6 -->
                {{--<div class="col-md-4 sage-guidline pr-0">
                    <div class="page-content pb-5 ">
                        <div class="form-style form-style-3 pb-5">
                            <h2 class="mt-2">Guidline</h2>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Et molestie ac feugiat sed. Diam volutpat commodo. Eu ultrices: Vitae auctor eu augue ut. Malesuada nunc vel risus commodo viverra. Praesent elementum facilisis leo vel.</p>
                            <h2>Save Time</h2>
                            <p>Our platform is developed to save your valuable time. It's much more simple and easier to use. Always we keen to catch your attention</p>

                            <a href="{{route('login')}}" class="btn btn-success ml-5">Have an Account</a>
                            <a href="{{route('register')}}" class="btn btn-primary ml-5 mt-2">Become an User &nbsp;</a>
                           </div>

                        </div>
                    </div>
                </div>--}}
            </div><!-- End row -->
        </div><!-- End login -->
    </section>


    <!-- Modal -->
    <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" id="modal-content">

            </div>
        </div>
    </div>

@endsection
@push('js')

    <script>
        $(document).ready(function() {
            $('.categories').select2();
            $('.subcategories').select2();
        });
        $('.categories').on('select2:select select2:unselect', function(e) {
            var select_val = $(e.currentTarget).val();
            $.post('{{ route('populated-subcategory') }}', {_token:'{{ @csrf_token() }}',data:select_val}, function(data){
                $('.subcategories').html(data)
            });
        });

        $( function() {
            var availableTags = [
                @foreach($tag as $tag)
                "{{$tag->tags}}",
                 @endforeach
            ];
            function split( val ) {
                return val.split( /,\s*/ );
            }
            function extractLast( term ) {
                return split( term ).pop();
            }

            $(".speciality").on( "keydown", function( event ) {
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
                        // prevent value inserted on focus
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

        function show_policy_modal(){
            $.get('{{ route('policy') }}', function(data){
                $('#modal-content').html(data);
                $('#exampleModalLong').modal('show', {backdrop: 'static'});
            });
        }

    </script>
@endpush
