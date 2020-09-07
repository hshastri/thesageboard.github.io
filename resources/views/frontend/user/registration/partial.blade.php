<div class="col-md-12 pb-3 pb-sm-4 expertise-item" id="expertise-item-{{$i}}">
    <div class="row">
        <div class="col-md-6 topic-area specialty-tag">
            <div class="form-group">
                <select id="sage-topic-{{$i}}" name="expert_category[{{$i}}]" required class="sage-add-topic select-to-select2">
                    <option value="-1" selected='false'>Select Topic</option>
                    @foreach($category as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-6 sub-topic-area specialty-tag">
            <div class="form-group">
                <select id="sage-sub-topics-{{$i}}" name="expert_subcategory[{{$i}}][]" required class="add-subtopic select-to-select2" multiple="multiple"> </select>
            </div>
        </div>
    </div>
    <a href="javascript:void(0)" onclick="deleteThis({{$i}})"><span class="delete-expertise-item shadow"><i class="fas fa-trash"></i></span></a>
</div>
