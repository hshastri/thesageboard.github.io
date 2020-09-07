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
                            <a class="nav-link" href="#expertise-area">Expertise Area <span class="sr-only">(current)</span></a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>

        <div id="expertise-area" class="col-md-12 my-5">
            <div class="profile-bg">
                <h1>Expertise Area</h1>
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{route('expertise')}}" method="post">
                            @csrf
                            <input type="hidden" name="expertise" value="1">

                            <div class="form-group row">
                                <label for="sage-demand-money" class="col-sm-2 col-form-label font-weight-bold">Your Answer Fee</label>
                                <div class="col-md-8">
                                    <input type="number" name="expertise_rate" id="sage-demand-money" class="col-4" value="{{@$user_details->expertise_rate}}">
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
    </div>
@endsection
@push('js')

    <script>

        @if(@$user_details->expert_category!=null && @$user_details->expert_subcategory!=null && @$user_details->speciality!=null)
            var selectedValuesCategory = [];
            var selectedValuesSubCategory = [];
            @foreach(json_decode(@$user_details->expert_category) as $secategory)
            selectedValuesCategory.push({{$secategory}})
            @endforeach
            getsubcategory(selectedValuesCategory)

            @foreach(json_decode(@$user_details->expert_subcategory) as $sesubcategory)
            selectedValuesSubCategory.push({{$sesubcategory}})
            @endforeach

            @foreach(json_decode(@$user_details->speciality) as $speciality)
            $("#sage-sub-tags").val("{{$speciality}}");
            @endforeach
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
