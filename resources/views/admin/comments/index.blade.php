@extends('admin._layout.layout')

@section('seo_title',__('Comments'))

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>@lang('Comments')</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{route('admin.index.index')}}">@lang('Home')</a></li>
                    <li class="breadcrumb-item active">@lang('Comments')</li>
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
                        <h3 class="card-title">Search Comments</h3>
                        
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form id="entities-filter-form">
                            <div class="row"> 
                                <div class="col-md-2 form-group">
                                    <label>Posts</label>
                                    <select 
                                        class="form-control" 
                                        name="post_id"
                                        style="width: 650px;"
                                        >
                                        <option value="">--Choose Post --</option>
                                        @foreach(\App\Models\Post::query()->orderBy('created_at')->get() AS $post)
                                        <option value="{{$post->id}}">{{$post->name}}</option>
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
                        <h3 class="card-title">@lang('All Comments')</h3>
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
                                    <th class="text-center">Comment</th>                                  
                                    <th class="text-center">Post</th>   
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

 



<!-- /.modal -->
<form action="{{route('admin.comments.enable')}}" method="post" class="modal fade" id="enable-modal">
    @csrf
    <input type="hidden" name="id" value="">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Enable Comment</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to enable comment?</p>
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
<form action="{{route('admin.comments.disable')}}" class="modal fade" id="disable-modal" method="POST">
    @csrf
    <input type="hidden" name="id" value="">

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Disable Comment</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to disable comment?</p>
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
 

@endsection



@push('footer_javascript')
<script type="text/javascript"> 
    // inicijalizujemo select2 plugin:
    $('#entities-filter-form [name="post_id"]').select2({
        "theme": "bootstrap4"
    });
//    $('#entities-filter-form [name="status"]').select2({
//          "theme": "bootstrap4"
//    });
    $('#entities-filter-form [name]').on('change keyup', function(){
         $('#entities-filter-form').trigger('submit');
    });
    //
    $('#entities-filter-form').on('submit', function (e) {
        e.preventDefault();        
            // dalje treba reload DataTable - kao posle brisanja
        entitiesDataTable.ajax.reload(null, true); // dokum: datatables plugin
        // null, false: drugi parametar false znaci - ne resetuj paginaciju, ne vracaj na prvu stranicu
        // a nama ovde TREBA DA RESETUJE PAGINACIJU, DA VRATI NA PRVU STRANICU, ZATO JE true
    });
    //
    let entitiesDataTable = $('#entities-list-table').DataTable({
        "serverSide": true, // ne sortiraj sam nego cu ja na serverskoj strani
        "processing": true,
        "ajax": {
            "url": "{{route('admin.comments.datatable')}}",
            "type": "post",
            "data": 
//                    {
//                "_token": "{{csrf_token()}}"
//            }
                function(dtData){ // umesto fiksnih vrednosti - anonimna f koja dinamicki dohvata vrednosti sa polja forme
                                // drData - su parametri od DataTables
                       dtData["_token"] = "{{csrf_token()}}";
                       //                       
                       dtData["body"] =  $('#entities-filter-form [name="body"]').val(); 
                       dtData["post_id"] =  $('#entities-filter-form [name="post_id"]').val();
                       dtData["status"] =  $('#entities-filter-form [name="status"]').val();                 
                       // $('#entities-filter-form').serialize(); // moze ovako ali vraca string u obliku koji ima url sto nam nije ovde odgovarajuce pa ostavljamo pojedinacno gore                       
                }
        },
        "pageLength": 5,
        "lengthMenu": [5, 10, 12, 15, 20, 25, 50, 100, 250],
        "order": [[4, 'desc']], // sortira inicijalno po sestoj koloni // index 0
        "columns": [
        // Onoliko objekata koliko je kolona I REDOSLED KOJI JE U thead OVDE PRATI
            {"name": "id", "data": "id"}, // podsetnik
            {"name": "status", "data": "status"},          
            {"name": "body", "data": "body"},            
            {"name": "post_name", "data": "post_name"},
            {"name": "created_at", "data": "created_at", "className": "text-center"},
            {"name": "actions", "data": "actions", "orderable": false, "searchable": false, "className": "text-center"}
        ]
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
        $('#enable-modal [data-container="body"]').html(name);
    });
    $('#enable-modal').on('submit', function (e) {
        e.preventDefault();
        $(this).modal('hide');
        $.ajax({
            "url": $(this).attr('action'), //citanje actio atributa sa forme
            "type": "post",
            "data": $(this).serialize() //citanje svih polja na formi  tj sve sto ima "name" atribut
        }).done(function (response) {
            toastr.success(response.system_message);
            // da refreshujemo datatables!!!
            entitiesDataTable.ajax.reload(null, false);//drugi parametar false zaci da se NE RESETUJE paginacija
        }).fail(function (xhr) {
            // toastr.error("@lang('Error occured while enabling user')");            
            let systemError="@lang('Error occured while enabling comment')";
            if(xhr.responseJSON && xhr.responseJSON['system_error']){ // ako postoji responseJson i ako je setovan system_error
                systemError = xhr.responseJSON['system_error'];
            }
            toastr.error(systemError); // prikazi sto je zapisano u systemError
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
        $('#disable-modal [data-container="body"]').html(name);
    });
    $('#disable-modal').on('submit', function (e) {
        e.preventDefault();
        $(this).modal('hide');
        $.ajax({
            "url": $(this).attr('action'), //citanje actio atributa sa forme
            "type": "post",
            "data": $(this).serialize() //citanje svih polja na formi  tj sve sto ima "name" atribut
        }).done(function (response) {
            toastr.success(response.system_message);
            // da refreshujemo datatables!!!
            entitiesDataTable.ajax.reload(null, false);//drugi parametar false zaci da se NE RESETUJE paginacija
        }).fail(function (xhr) {
           // toastr.error("@lang('Error occured while disabling user')");           
            let systemError="@lang('Error occured while disabling comment')";
            if(xhr.responseJSON && xhr.responseJSON['system_error']){ // ako postoji responseJson i ako je setovan system_error
                systemError = xhr.responseJSON['system_error'];
            }
            toastr.error(systemError); // prikazi sto je zapisano u systemError     
        });
    });
//
//

</script>
@endpush
 