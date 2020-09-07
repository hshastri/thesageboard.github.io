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
                <div class="topic-rate col-md-8 offset-md-2 pb-md-4">
                    <div class="text-center my-5">
                        <h2 class="mb-2">How much would you like to charge for your advice?</h2>
                        <p>You can always change this amount later</p>
                    </div>
                    <form action="{{route('topic-valuation')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-md-3 offset-md-2">
                                        <label class="mt-2" for="answer-fee">Your Answer Fees (<i class="fas fa-dollar-sign d-inline-block"></i>)</label></span>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="number" id="answer-fee" name="expertise_rate" class="m-0 form-control" min="0" value="{{@$user_details->expertise_rate}}" required>
                                        </div>
                                    </div>
                                   {{-- <div class="col-10 ml-5">
                                        <p>
                                            <small id="passwordHelpBlock" class="form-text text-muted">Set your demand money dollar amount you will charge when answering the questions.</small>
                                        </p>
                                    </div>--}}

                                </div>
                            </div>
                            {{--<div class="col-12">
                                <div class="row">
                                    <div class="col-4">
                                        <span class="fas fa-home"></span>
                                        <span class="h6">House Planning</span>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="number" name="" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-4">
                                        <span class="fas fa-tractor"></span>
                                        <span class="h6">Agriculture</span>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="number" name="" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-4">
                                        <span class="fas fa-tv"></span>
                                        <span class="h6">Computer & Software</span>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="number" name="" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                            </div>--}}
                        </div>
                        <div class="row mt-5">
                            <div class="col-md-12">
                                <a href="{{route('add-expertise')}}" class="submit-button text-center float-left"> Back </a>
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

@endpush
