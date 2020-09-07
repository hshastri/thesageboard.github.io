<div>
    <a href="{{route('filter-title' ,$searchItem)}}">
    <div class="sage-search-result custom-title">
        <div class="d-flex">
            <span class="filter-item icon mr-2"><i class="fas fa-search"></i></span>
            <span class="filter-item type mr-1">Search:</span>
            <span class="filter-item title">{{$searchItem}}</span>
        </div>
    </div>
    </a>
    @foreach($datas as $data)
        @if($data->type=='Topic')
        <a href="{{route('filter-topic' ,base64_encode($data->id))}}">
            <div class="sage-search-result topic-item">
                <div class="d-flex">
                    <span class="filter-item icon mr-2"><i class="{{$data->image}}"></i></span>
                    <span class="filter-item type mr-1">Topic:</span>
                    <span class="filter-item title">{{$data->datas}}</span>
                </div>
            </div>
        </a>
    @endif

    @if($data->type=='Subtopic')
        <a href="{{route('filter-subtopic' ,base64_encode($data->id))}}">
            <div class="sage-search-result topic-item">
                <div class="d-flex">
                    <span class="filter-item icon mr-2"><i class="fas fa-star"></i></span>
                    <span class="filter-item type mr-1">subTopic:</span>
                    <span class="filter-item title">{{$data->datas}}</span>
                </div>
            </div>
        </a>
        @endif

        @if($data->type=='Profile')
        <a href="{{route('user-profile' ,base64_encode($data->id))}}">
            <div class="sage-search-result profile-item">
                <div class="d-flex">
                    <span class="filter-item icon mr-2"><img src="{{($data->image =='')?asset('assets/images/admin.jpg'): asset('public/'.$data->image)}}"" alt=""></span>
                    <span class="filter-item type mr-1">Profile:</span>
                    <span class="filter-item title">{{$data->datas}}</span>
                </div>
            </div>
        </a>
        @endif
    @endforeach
</div>
