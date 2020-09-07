@extends('crm.layout.app')
@section('content')
    <!-- Page header -->
    <div class="page-header page-header-light">

        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="{{route('crm.dashboard')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                    <span class="breadcrumb-item active">Tags</span>
                </div>
                <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
            </div>
        </div>
    </div>
    <!-- /page header -->

    <!-- Content area -->
    <div class="content">
        <!-- Multi-column layout -->
        <div class="card">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">Tags</h5>
                <a href="javascript:void(0)" onclick="show_add_tag_modal()" class="btn btn-outline-success">Add Tags</a>
            </div>
            <table class="table datatable-colvis-multi" id="example">
                <thead>
                <tr>
                    <th>SL</th>
                    <th>Tags</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($tags_all as $key =>$tags)
                    <tr>

                        <td width="20%">{{ ($key+1)  }}</td>
                        <td width="50%">{{$tags->tags}}</td>
                        <td width="20%">
                            @if($tags->status=='Active')
                                <span style="color: blue">{{$tags->status}}</span>
                            @else
                                <span style="color: red">{{$tags->status}}</span>
                            @endif
                        </td>
                        <td width="10%">
                            <div class="btn-group">
                                <a href="javascript:void(0)" onclick="show_edit_tag_modal('{{route('tags.edit', base64_encode($tags->id))}}')"><i class="fas fa-edit mr-3 fa-1x"></i></a>
                                <a href="javascript:void(0)" onclick="confirm_modal('{{route('tags.destroy',base64_encode($tags->id))}}')" > <i class="fas fa-trash mr-3 fa-1x"></i> </a>
                            </div>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>

        </div>
        <!-- /multi-column layout -->
    </div>

    <div id="tag_modal" class="modal fade m-5" data-keyboard="false" data-backdrop="static" tabindex="-1">
        <div class="modal-dialog mt-5">
            <div class="modal-content" id="modal-content">

            </div>
        </div>
    </div>

@endsection
@push('js')
    <script type="text/javascript">
        function show_add_tag_modal(){
            $.get('{{ route('tags.create') }}', function(data){
                $('#modal-content').html(data);
                $('#tag_modal').modal('show', {backdrop: 'static'});
            });
        }

        function show_edit_tag_modal(dataUrl){
            $.get(dataUrl, function(data){
                $('#modal-content').html(data);
                $('#tag_modal').modal('show', {backdrop: 'static'});
            });
        }
    </script>
@endpush

