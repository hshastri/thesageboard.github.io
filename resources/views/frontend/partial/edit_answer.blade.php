<div id="editID" class="comment-respond page-content clearfix">
    <form action="{{route('answer-edit', base64_encode($answer->id))}}" method="post" class="comment-form">
        @csrf
        <div id="respond-textarea">
            <p>
                <label class="required" for="comment">Answer Edit</label>
                <textarea class="comment-area" name="answer" aria-required="true" cols="58" rows="8">{{$answer->answer}}</textarea>
            </p>
        </div>
        <p class="form-submit">
            <input name="submit" type="submit" id="submit" value="Edit your answer" class="button small edit-answer-button">
        </p>
    </form>
</div>
