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
                        <li class="acttive done">
                            <div class="icon">2</div>
                            <div class="title">Bio</div>
                        </li>
                        <li class="acttive done">
                            <div class="icon">3</div>
                            <div class="title">Topic</div>
                        </li>
                        <li class="acttive done">
                            <div class="icon">4</div>
                            <div class="title">Fees</div>
                        </li>
                        <li class="acttive done">
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
                <div class="registration-success col-md-8 offset-md-2 pb-md-4">
                    <div class="text-center my-5">
                        <div class="success-checkmark">
                            <div class="check-icon">
                                <span class="icon-line line-tip"></span>
                                <span class="icon-line line-long"></span>
                                <div class="icon-circle"></div>
                                <div class="icon-fix"></div>
                            </div>
                        </div>
                        <h1 class="mb-2">Congratulations!</h1>
                        <h3>You have finished your SAGE registration successfully!</h3>
                        <a href="{{route('questions')}}" class="submit-button">Go To Public Questions</a>
                    </div>
                </div><!-- End col-md-6 -->
            </div><!-- End row -->
        </div><!-- End login -->
    </section>

@endsection
@push('js')

@endpush
