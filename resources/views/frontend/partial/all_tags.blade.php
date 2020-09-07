@foreach($tags as $tags)
    <li onclick=setTagsValue("{{$tags->tags}}") style="cursor: pointer;border-bottom: 1px solid #f3f5f7;">{{$tags->tags}}</li>
@endforeach

