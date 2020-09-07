@extends('crm.layout.app')
@section('content')
    <div class="page-header page-header-light">

        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="{{route('crm.dashboard')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                    <span class="breadcrumb-item active">Policy Settings</span>
                </div>
                <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header header-elements-inline">
                    <h6 class="card-title">Policy Settings</h6>
                    <div class="header-elements">
                        <div class="list-icons">
                            <a class="list-icons-item" data-action="collapse"></a>
                            <a class="list-icons-item" data-action="reload"></a>
                            <a class="list-icons-item" data-action="remove"></a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{route('crm.policy_settings')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label>Policy Settings</label>
                            <textarea class="form-control" id="policy" rows="20" name="item[policy_settings]">
                                {{$result}}
                            </textarea>
                        </div>


                        <div class="d-flex justify-content-between pull-right" style="float: right">
                            <button type="submit" class="btn bg-blue">Submit <i class="icon-paperplane ml-2"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src='https://cdn.tiny.cloud/1/sjfoumrxpjum4qzmvwoptu3k7fh010z4lsc22vvnpzb60g2n/tinymce/5/tinymce.min.js' referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#policy',
            placeholder: 'Type here...',
            menubar:false,
            min_height: 250,
            branding: false,
            plugins: 'image link imagetools textpattern preview code paste toc',
            toolbar: 'undo redo | formatselect | forecolor | alignleft aligncenter alignright alignjustify | bold italic | textpattern code preview toc',
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
            automatic_uploads: true,
            relative_urls: false,
        });
    </script>
@endpush
