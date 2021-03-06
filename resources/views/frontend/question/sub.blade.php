@extends('frontend.layout.app')
@section('main')
    <section class="container main-content">
        <div class="row mt-5">
            <div class="col-md-10 offset-md-2">
                <ul class="process-steps">
                    <li class="acttive done">
                        <div class="icon">1</div>
                        <div class="title">Topic </div>
                    </li>
                    <li class="acttive done">
                        <div class="icon">2</div>
                        <div class="title">Sub-Topic</div>
                    </li>
                   {{-- <li>
                        <div class="icon">3</div>
                        <div class="title">Type</div>
                    </li>--}}
                    <li>
                        <div class="icon">3</div>
                        <div class="title">Expert List</div>
                    </li>
                    <li>
                        <div class="icon">4</div>
                        <div class="title">Payment</div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 offset-md-2">
                <div class="page-content page-shortcode mt-4">
                    <div class="box_icon">
                        <h2>What sub-topic does your question relate to?</h2>
                        <div class="gap"></div>
                        <div class="poll_2">
                            <form class="form-style form-style-3" method="post" action="">
                                @csrf
                                <div class="form-inputs clearfix">
                                    @foreach($subcategory as $subcategory)
                                        <p>
                                            <input name="subcategory_id" type="radio" value="{{$subcategory->id}}" style="border-color: #18b694" required>
                                            <label>{{$subcategory->name}}</label>
                                        </p>
                                    @endforeach
                                </div>
                                <div class="gap"></div>
                                <div>
                                    <a type="button" href="{{ URL::previous() }}" class="button medium gray-button custom-button" style="float: left">Back</a>
                                    <button type="submit" class="button medium lime-green-button custom-button" style="float: right">Next</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div><!-- End main -->
        </div>
        <!-- End row -->
    </section><!-- End container -->
@endsection
