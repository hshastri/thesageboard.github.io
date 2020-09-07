@extends('crm.layout.app')
@section('content')
    <!-- Page header -->
    <div class="page-header page-header-light">

        <div class="breadcrumb-line breadcrumb-line-light header-elements-md-inline">
            <div class="d-flex">
                <div class="breadcrumb">
                    <a href="{{route('crm.dashboard')}}" class="breadcrumb-item"><i class="icon-home2 mr-2"></i> Home</a>
                    <span class="breadcrumb-item active">Subcategory</span>
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
                <h5 class="card-title">Sub-Categories</h5>
                <a href="javascript:void(0)" onclick="show_add_sub_category_modal()" class="btn btn-outline-success">Add Subcategory</a>
            </div>
            <table class="table datatable-colvis-multi" id="example">
                <thead>
                <tr>
                    <th>SL</th>
                    <th>Category</th>
                    <th>Subcategory</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($subcategory as $key =>$subcategory)
                    <tr>
                    <td width="10%">{{$key+1}}</td>
                     <td width="20%">{{$subcategory->category->name}} </td>
                     <td width="30%">{{$subcategory->name}} </td>
                    <td width="20%">
                        @if($subcategory->status=='Active')
                            <span style="color: blue">{{$subcategory->status}}</span>
                        @else
                            <span style="color: red">{{$subcategory->status}}</span>
                        @endif
                    </td>
                    <td width="10%">
                        <div class="btn-group">
                            <a href="javascript:void(0)" onclick="show_edit_sub_category_modal('{{route('subcategory.edit', base64_encode($subcategory->id))}}')"><i class="fas fa-edit mr-3 fa-1x"></i></a>
                            <a href="javascript:void(0)" onclick="confirm_modal('{{route('subcategory.destroy', base64_encode($subcategory->id))}}')" > <i class="fas fa-trash mr-3 fa-1x"></i> </a>
                        </div>
                    </td>
                </tr>
                @endforeach

                </tbody>
            </table>
        </div>
        <!-- /multi-column layout -->
    </div>

    <div id="sub_category_modal" class="modal fade m-5" data-keyboard="false" data-backdrop="static" tabindex="-1">
        <div class="modal-dialog mt-5">
            <div class="modal-content" id="modal-content">

            </div>
        </div>
    </div>
@endsection
@push('js')
    <script type="text/javascript">
        function show_add_sub_category_modal(){
            $.get('{{ route('subcategory.create') }}', function(data){
                $('#modal-content').html(data);
                $('#sub_category_modal').modal('show', {backdrop: 'static'});
            });
        }

        function show_edit_sub_category_modal(dataUrl){
            $.get(dataUrl, function(data){
                $('#modal-content').html(data);
                $('#sub_category_modal').modal('show', {backdrop: 'static'});
            });
        }
    </script>
@endpush
