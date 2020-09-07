@extends('frontend.layout.app')
@section('main')
    <section class="container main-content">
        <div class="gap"></div>
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="page-content page-shortcode question-sucess">
                    <div class="box_icon">
                        <div class="clearfix"></div>
                        <div class="success-checkmark">
                            <div class="check-icon">
                                <span class="icon-line line-tip"></span>
                                <span class="icon-line line-long"></span>
                                <div class="icon-circle"></div>
                                <div class="icon-fix"></div>
                            </div>
                        </div>
                        <div class="t_center congrate-message">
                            <h2>Congratulations !</h2>
                            <p class="success-message">You have posted your question successfully. <br/>
                                Check your question details <a target="_blank" href="{{route('question-details', [base64_encode($question_id) , $question_slag] )}}">Here</a>.
                            </p>
                            <div class="dialogue-start">
                                <p class="mb-2 mb-md-3">Would you like an expert to provide a reliable and fast answer?</p>
                                <a href="{{route('chosen-expert', base64_encode($question_id) )}}" class="submit-button mr-4">Yes</a>
                                <a href="{{route('question-details', [base64_encode($question_id) , $question_slag])}}" class="submit-button">No</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- End main -->
        </div><!-- End row -->
    </section><!-- End container -->
@endsection
@push("js")

    <script>

    </script>
@endpush
