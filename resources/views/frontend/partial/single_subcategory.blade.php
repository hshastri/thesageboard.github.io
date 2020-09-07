@foreach($subcategory as $subcategory)
    <p>
        <input name="subcategory_id" type="radio" value="{{$subcategory->id}}" style="border-color: #18b694" required onclick="setSubCat(this)">
        <label>{{$subcategory->name}}</label>
    </p>
@endforeach
