
@extends('frontend.user.user_app')
@section('user_content')

    <div class="row">
        <div class="col-md-12 mb-5 question-details">
            <form method="post" action="{{ route('question-edit', base64_encode($question->id)) }}">
                @csrf
                <h2 class="mb-4"><a href="{{route('question-details', base64_encode($question->id))}}">{{$question->question_title}}</a></h2>
                <div class="form-group row">
                    <div class="col-lg-12">
                        <textarea id="question-details" aria-required="true" cols="58" rows="8" name="description" required>{{@$question->description}}</textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 pull-left">
                        <button type="submit" class="btn btn-success pull-left" style="text-transform:unset !important">Update Question</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
@push('js')
    <script src='https://cdn.tiny.cloud/1/sjfoumrxpjum4qzmvwoptu3k7fh010z4lsc22vvnpzb60g2n/tinymce/5/tinymce.min.js' referrerpolicy="origin"></script>
    <script>
        let category_id;
        let sub_category_id;

        tinymce.init({
            selector: '#question-details',
            placeholder: 'Type here...',
            menubar:false,
            min_height: 250,
            branding: false,
            toolbar_mode: 'sliding',
            toolbar_sticky: true,
            body_class: 'sage-asked-content',
            content_css: '{{asset("assets/front/css/asked-content.css")}}',
            plugins: 'image link imagetools textpattern lists preview code paste',
            toolbar: 'undo redo | formatselect | numlist bullist | forecolor | alignleft aligncenter alignright alignjustify | bold italic | link image | textpattern code preview',
            textpattern_patterns: [
                {start: '*', end: '*', format: 'italic'},
                {start: '**', end: '**', format: 'bold'},
                {start: '#', end: '#', format: 'h1'},
                {start: '##', format: 'h2'},
                {start: '~', end: '~', cmd: 'createLink', value: 'https://tiny.cloud'}
            ],
            images_reuse_filename: false,
            paste_as_text: true,
            block_formats: 'Heading 1=h1; Heading 2=h2; Normal=p; Code Block=pre',
            a11y_advanced_options: true,
            image_advtab: true,
            image_uploadtab: true,
            imagetools_toolbar: "rotateleft rotateright | flipv fliph | editimage imageoptions",
            automatic_uploads: true,
            images_upload_url: "{{route('upload')}}",
            relative_urls: false,
            images_upload_handler: function (blobInfo, success, failure) {
                // if( blobInfo.blob().size >= 2000000) {
                //     failure('You are not allowed to upload more than 2MB file size');
                //     return;
                // }
                var xhr, formData;
                xhr = new XMLHttpRequest();
                xhr.withCredentials = false;
                xhr.open('POST', '{{route('upload')}}');
                xhr.setRequestHeader('x-csrf-token', '{{ @csrf_token() }}');
                xhr.onload = function() {
                    var json;
                    if (xhr.status != 200) {
                        failure('HTTP Error: ' + xhr.status);
                        return;
                    }

                    if(xhr.responseText) {
                        json = JSON.parse(xhr.responseText);
                        if (!json || typeof json.location != 'string') {
                            failure('Invalid JSON: ' + xhr.responseText);
                            return;
                        }
                    } else {
                        failure('You are not allowed to upload more than 2MB file size');
                        return;
                    }
                    success(json.location);
                };
                formData = new FormData();
                if( typeof(blobInfo.blob().name) !== undefined ) {
                    fileName = blobInfo.blob().name;
                } else {
                    fileName = blobInfo.filename();
                }
                formData.append('file', blobInfo.blob(), fileName);
                xhr.send(formData);
            },
        });

    </script>
@endpush
