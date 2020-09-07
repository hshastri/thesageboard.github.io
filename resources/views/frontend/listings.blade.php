@extends('frontend.layout.app')
@section('main')
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8 offset-md-2 mt-4">
                <div class="alert alert-success bg-white suggestion-topic mb-5">
                    <h4 class="m-0">Please help us keep our database comprehensive. If you have any suggestions for topics, sub-topics or tags, please submit via our form here: <a href="https://bit.ly/2CF5xZV" target="_blank" class="shadow">Link</a></h4>
                </div>
                <div class="row">
                    @foreach($category as $category)
                    <div class="col-md-6">
                        <div class="listing-wrapper">
                            <ul class="parent">
                                <li class="shadow p-2 mt-3 rounded-lg">
                                    <a class="parent-item" href="{{route('filter-topic' ,base64_encode($category->id))}}">{{$category->name}}</a>
                                    <p>{{$category->description}}</p>
                                    @foreach($category->subcategory as $sub)
                                    <ul class="child">
                                        <li><a class="child-item" href="{{route('filter-subtopic' ,base64_encode($sub->id))}}">{{$sub->name}}</a></li>
                                    </ul>
                                    @endforeach
                                </li>
                            </ul>
                        </div>
                    </div>
                    @endforeach
                </div>
                <!--<div class="row mt-4">
                    <div class="tag-listing-wrapper">
                        <h3>Here our tags</h3>


                    </div>
                </div>-->

            </div>
        </div>
    </div>
@endsection
