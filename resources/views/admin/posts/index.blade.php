@extends('admin._layout.layout')

@section('seo_title',__('Posts'))

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>@lang('Posts')</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{route('admin.index.index')}}">@lang('Home')</a></li>
                    <li class="breadcrumb-item active">@lang('Posts')</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Search Products</h3>
                        <div class="card-tools">
                            <a href="{{route('admin.posts.add')}}" class="btn btn-success">
                                <i class="fas fa-plus-square"></i>
                                @lang('Add new Post')
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form id="entities-filter-form">
                            <div class="row">
                                <div class="col-md-3 form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" name="name" placeholder="Search by name">
                                </div>
                                <div class="col-md-2 form-group">
                                    <label>User</label>
                                    <select class="form-control" name="user_id">
                                        <option value="">--Choose User --</option>
                                        @foreach(\App\Models\User::query()->orderBy('name')->get() AS $user)
                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2 form-group">
                                    <label>Category</label>
                                    <select class="form-control" name="category_id">
                                        <option value="">--Choose Category --</option>
                                        @foreach(\App\Models\Category::query()->orderBy('priority')->get() AS $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-1 form-group">
                                    <label>Status</label>
                                    <select class="form-control" name="status">
                                        <option value="">-- All --</option>
                                        <option value="1">Enabled</option>
                                        <option value="0">Disabled</option>
                                    </select>
                                </div>
                                <div class="col-md-1 form-group">
                                    <label>Important</label>
                                    <select class="form-control" name="index_page">
                                        <option value="">-- All --</option>
                                        <option value="1">yes</option>
                                        <option value="0">no</option>
                                    </select>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>Tags</label>
                                    <select class="form-control" name="tag_ids" multiple>
                                        @foreach(\App\Models\Tag::query()->orderBy('name')->get() AS $tag)
                                        <option value="{{$tag->id}}">{{$tag->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">

                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">@lang('All Posts')</h3>
                        <div class="card-tools">

                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">


                        <table id="entities-list-table" class="table table-bordered">
                            <thead>                  
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Photo</th>
                                    <th style="width: 20%;">Name</th>
                                    <th class="text-center">Imp</th>
                                    <th class="text-center">Comm</th>
                                    <th class="text-center">Views</th>
                                    <th class="text-center">Author</th>
                                    <th class="text-center">Categ</th>
                                    <th class="text-center">Tags</th>
                                    <th class="text-center">Created</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>


                                <?php
                                /*
                                  @foreach($posts as $post)
                                  <tr>
                                  <td>#{{$post->id}}</td>
                                  <td class="text-center">
                                  <img
                                  src="{{$post->getPhoto1Url()}}"
                                  style="max-width: 80px;"
                                  >
                                  </td>
                                  <td>
                                  <strong>{{$post->name}}</strong>
                                  </td>
                                  <td>
                                  {{optional($post->user)->name}}
                                  </td>
                                  <td>
                                  {{optional($post->category)->name}}
                                  </td>
                                  <td>
                                  {{optional($post->tags)->pluck('name')->join(', ')}}
                                  </td>
                                  <td class="text-center">{{$post->created_at}}</td>
                                  <td class="text-center">
                                  <div class="btn-group">
                                  <a
                                  href="{{$post->getFrontUrl()}}"
                                  class="btn btn-info"
                                  target="_blank"
                                  >
                                  <i class="fas fa-eye"></i>
                                  </a>
                                  <a href="{{route('admin.posts.edit',['post'=>$post->id])}}" class="btn btn-info">
                                  <i class="fas fa-edit"></i>
                                  </a>
                                  <button
                                  type="button"
                                  class="btn btn-info"
                                  data-toggle="modal"
                                  data-target="#delete-modal"

                                  data-action="delete"
                                  data-id="{{$post->id}}"
                                  >
                                  <i class="fas fa-trash"></i>
                                  </button>
                                  </div>
                                  </td>
                                  </tr>
                                  @endforeach
                                 */
                                ?>
                            </tbody>
                        </table>

                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">

                    </div>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->


<form action="{{route('admin.posts.delete')}}" 
      method="post" 
      class="modal fade" 
      id="delete-modal"
      >
    @csrf

    <input type="hidden" name="id" value="" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Delete Post</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete post?</p>
                <strong data-container="name"></strong>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger">Delete</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</form>
<!-- /.modal -->

  

<!-- /.modal -->
<form action="{{route('admin.posts.enable')}}" method="post" class="modal fade" id="enable-modal">
    @csrf
    <input type="hidden" name="id" value="">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Enable Post</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to enable post?</p>
                <strong data-container="name"></strong>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-check"></i>
                    Enable
                </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</form>
<form action="{{route('admin.posts.disable')}}" class="modal fade" id="disable-modal" method="POST">
    @csrf
    <input type="hidden" name="id" value="">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Disable Post</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to disable post?</p>
                <strong data-container="name"></strong>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-minus-circle"></i>
                    Disable
                </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</form>
<!-- /.modal -->


<!-- /.modal -->
<form action="{{route('admin.posts.important')}}" method="post" class="modal fade" id="important-modal">
    @csrf
    <input type="hidden" name="id" value="">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Important Post</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to make post important?</p>
                <strong data-container="name"></strong>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-check"></i>
                    Important
                </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</form>
<form action="{{route('admin.posts.unimportant')}}" class="modal fade" id="unimportant-modal" method="POST">
    @csrf
    <input type="hidden" name="id" value="">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Unimportant Post</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to make post unimportant?</p>
                <strong data-container="name"></strong>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-minus-circle"></i>
                    Unimportant
                </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</form>
<!-- /.modal -->

@endsection



@push('footer_javascript')
<script type="text/javascript">
    // inicijalizujemo select2 plugin:
    $('#entities-filter-form [name="user_id"]').select2({
        "theme": "bootstrap4"
    });
    $('#entities-filter-form [name="category_id"]').select2({
        "theme": "bootstrap4"
    });
    $('#entities-filter-form [name="index_page"]').select2({
        "theme": "bootstrap4"
    });
    $('#entities-filter-form [name="status"]').select2({
        "theme": "bootstrap4"
    });
    $('#entities-filter-form [name="tag_ids"]').select2({
        "theme": "bootstrap4"
    });
    //
    // submit:
    $('#entities-filter-form [name]').on('change keyup', function () {
        $('#entities-filter-form').trigger('submit');
    });
    //
    $('#entities-filter-form').on('submit', function (e) {
        e.preventDefault(); 
        entitiesDataTable.ajax.reload(null, true);  
    }); 
    //
    let entitiesDataTable = $('#entities-list-table').DataTable({
        "serverSide": true,  
        "processing": true,
        "ajax": {
            "url": "{{route('admin.posts.datatable')}}",
            "type": "post",
            "data":
//                    {
//                "_token": "{{csrf_token()}}"
//            }
                    function (dtData) {   
                        dtData["_token"] = "{{csrf_token()}}";
                        //                       
                        dtData["name"] = $('#entities-filter-form [name="name"]').val();
                        dtData["category_id"] = $('#entities-filter-form [name="category_id"]').val();
                        dtData["user_id"] = $('#entities-filter-form [name="user_id"]').val();
                        dtData["status"] = $('#entities-filter-form [name="status"]').val();
                        dtData["index_page"] = $('#entities-filter-form [name="index_page"]').val();
                        dtData["comments"] = $('#entities-filter-form [name="comments"]').val();
                        dtData["views"] = $('#entities-filter-form [name="views"]').val();
                        dtData["tag_ids"] = $('#entities-filter-form [name="tag_ids"]').val();
                        // $('#entities-filter-form').serialize(); // moze ovako ali vraca string u obliku koji ima url sto nam nije ovde odgovarajuce pa ostavljamo pojedinacno gore                       
                    }
        },
        "pageLength": 10,
        "lengthMenu": [5, 10, 12, 15, 20, 25, 50, 100, 250],
        "order": [[6, 'desc']],  
        "columns": [ 
            {"name": "id", "data": "id"}, // podsetnik
            {"name": "status", "data": "status"},
            {"name": "photo", "data": "photo", "orderable": false, "searchable": false, "className": "text-center"},
            {"name": "name", "data": "name"},
            {"name": "index_page", "data": "index_page"},
            {"name": "comments", "data": "comments", "searchable": false},
            {"name": "views", "data": "views", "searchable": false},
            {"name": "user_name", "data": "user_name"},
            {"name": "category_name", "data": "category_name"},
            {"name": "tags", "data": "tag", "orderable": false}, // , "data": "updated_at", "orderable": false}, // da nema sortiranja 
            {"name": "created_at", "data": "created_at", "className": "text-center"},
            {"name": "actions", "data": "actions", "orderable": false, "searchable": false, "className": "text-center"}
        ]
    });
    // 
    /*** DELETE ***/ 
    $('#entities-list-table').on('click', '[data-action="delete"]', function () {
        //e.stopPropagetion();
        //e.preventDefault();
        // let id= $(this).data('id');
        let id = $(this).attr('data-id');
        let name = $(this).attr('data-name');
        $('#delete-modal [name="id"]').val(id);
        $('#delete-modal [data-container="name"]').html(name);
    });
    $('#delete-modal').on('submit', function (e) {  
        e.preventDefault();
  
        $(this).modal('hide');  
        $.ajax({ 
            "url": $(this).attr('action'),   
            "type": "post",
            "data": $(this).serialize()   
        }).done(function (response) { // kad se zavrsi:
            toastr.success(response.system_message); 
            // osveziti datatables:                    
            entitiesDataTable.ajax.reload(null, false);   
        }).fail(function () {
            toastr.error("@lang('Error occured while deleting post!')");  
        });
    });
//    
//     
//************* ENABLE / DISABLE **************************/
    $('#entities-list-table').on('click', '[data-action="enable"]', function (e) {
        //e.stopPropagation();
        //e.preventDefault();
        //let id = $(this).data('id');
        let id = $(this).attr('data-id');
        let name = $(this).attr('data-name');
        $('#enable-modal [name="id"]').val(id);
        $('#enable-modal [data-container="name"]').html(name);
    });
    $('#enable-modal').on('submit', function (e) {
        e.preventDefault();
        $(this).modal('hide');
        $.ajax({
            "url": $(this).attr('action'),  
            "type": "post",
            "data": $(this).serialize()  
        }).done(function (response) {
            toastr.success(response.system_message);
            // da refreshujemo datatables!!!
            entitiesDataTable.ajax.reload(null, false); 
        }).fail(function (xhr) {
            // toastr.error("@lang('Error occured while enabling post')");            
            let systemError = "@lang('Error occured while enabling post')";
            if (xhr.responseJSON && xhr.responseJSON['system_error']) {  
                systemError = xhr.responseJSON['system_error'];
            }
            toastr.error(systemError);  
        });
    });
////
    $('#entities-list-table').on('click', '[data-action="disable"]', function (e) {
        //e.stopPropagation();
        //e.preventDefault();
        //let id = $(this).data('id');
        let id = $(this).attr('data-id');
        let name = $(this).attr('data-name');
        $('#disable-modal [name="id"]').val(id);
        $('#disable-modal [data-container="name"]').html(name);
    });
    $('#disable-modal').on('submit', function (e) {
        e.preventDefault();
        $(this).modal('hide');
        $.ajax({
            "url": $(this).attr('action'),  
            "type": "post",
            "data": $(this).serialize() 
        }).done(function (response) {
            toastr.success(response.system_message);
            // da refreshujemo datatables!!!
            entitiesDataTable.ajax.reload(null, false); 
        }).fail(function (xhr) {
            // toastr.error("@lang('Error occured while disabling post')");           
            let systemError = "@lang('Error occured while disabling post')";
            if (xhr.responseJSON && xhr.responseJSON['system_error']) {  
                systemError = xhr.responseJSON['system_error'];
            }
            toastr.error(systemError);     
        });
    });
//
//
//************* IMPORTANT **************************/
    $('#entities-list-table').on('click', '[data-action="important"]', function (e) {
        //e.stopPropagation();
        //e.preventDefault();
        //let id = $(this).data('id');
        let id = $(this).attr('data-id');
        let name = $(this).attr('data-name');
        $('#important-modal [name="id"]').val(id);
        $('#important-modal [data-container="name"]').html(name);
    });
    $('#important-modal').on('submit', function (e) {
        e.preventDefault();
        $(this).modal('hide');
        $.ajax({
            "url": $(this).attr('action'),  
            "type": "post",
            "data": $(this).serialize()  
        }).done(function (response) {
            toastr.success(response.system_message);
            // da refreshujemo datatables!!!
            entitiesDataTable.ajax.reload(null, false); 
        }).fail(function (xhr) {
            // toastr.error("@lang('Error occured while making post important!')");            
            let systemError = "@lang('Error occured while making post important!')";
            if (xhr.responseJSON && xhr.responseJSON['system_error']) {  
                systemError = xhr.responseJSON['system_error'];
            }
            toastr.error(systemError);  
        });
    });
////
    $('#entities-list-table').on('click', '[data-action="unimportant"]', function (e) {
        //e.stopPropagation();
        //e.preventDefault();
        //let id = $(this).data('id');
        let id = $(this).attr('data-id');
        let name = $(this).attr('data-name');
        $('#unimportant-modal [name="id"]').val(id);
        $('#unimportant-modal [data-container="name"]').html(name);
    });
    $('#unimportant-modal').on('submit', function (e) {
        e.preventDefault();
        $(this).modal('hide');
        $.ajax({
            "url": $(this).attr('action'), 
            "type": "post",
            "data": $(this).serialize()  
        }).done(function (response) {
            toastr.success(response.system_message);
            // da refreshujemo datatables!!!
            entitiesDataTable.ajax.reload(null, false); 
        }).fail(function (xhr) {
            // toastr.error("@lang('Error occured while disabling post')");           
            let systemError = "@lang('Error occured while disabling post')";
            if (xhr.responseJSON && xhr.responseJSON['system_error']) { 
                systemError = xhr.responseJSON['system_error'];
            }
            toastr.error(systemError);  
        });
    });
</script>
@endpush
