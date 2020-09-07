
@foreach($category as $key => $category)
    <optgroup label="{{$category->name}}">
        @foreach($category->subcategory as $subcategory)
         <option value="{{$subcategory->id}}">{{$subcategory->name}}</option>
        @endforeach
    </optgroup>
@endforeach
