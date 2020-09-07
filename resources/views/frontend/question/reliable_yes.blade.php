@extends('frontend.layout.app')
@section('main')
    <section class="container main-content">
        <div class="row mt-5">
            <div class="col-md-2"></div>
            <div class="col-md-10">
                <ul class="process-steps">
                    <li class="acttive done">
                        <div class="icon">1</div>
                        <div class="title">Topic </div>
                    </li>
                    <li>
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
                        <h2>What Topic does your question relate to?</h2>
                        <div class="gap"></div>
                        <div class="poll_2">
                            <form class="form-style form-style-3" method="post" action="">
                                @csrf
                                <div class="form-inputs clearfix">
                                    @foreach($category as $category)
                                    <p>
                                        <input name="category_id" type="radio" value="{{$category->id}}" style="border-color: #18b694" required>
                                        <label>{{$category->name}}</label>
                                         <p style="margin-left: 2em; margin-top: -1em; color:black">{{$category->description}}</p>
                                    </p>
                                    @endforeach
                                </div>

                                <div class="gap"></div>
                                <div style="float: right">
                                    <button type="submit" class="button medium lime-green-button custom-button">Next</button>
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
@push("js")

    <script>

    </script>
@endpush
