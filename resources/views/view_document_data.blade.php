
<!DOCTYPE html>

<html lang="en">
<head>
<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>DOCUMENT LISTING</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
<link  href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</head>
<body>

<!-- ---------------------------------------- -->
<!-- <div id="app" class="app"> -->
<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">

              @if(Auth::check())
                <li class="nav-item dropdown">
                  <a href="#" id="navbarDropdown" class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-globe"></i>Notification <span class="badge badge-danger" id="count-notification">{{auth()->user()->unreadNotifications->count()}}
                    </span><span class="caret"></span>
                  </a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    @if(auth()->user()->unreadNotifications->count())
                    @foreach(auth()->user()->unreadNotifications as $notification)
                    <a href="#" class="dropdown-item">
                        {{$notification->data['lesson']['body']}}{{$notification->data['lesson']['title']}}
                    </a>
                    @endforeach
                    @else
                    <a href="#" class="dropdown-item">
                      No Notification
                    </a>
                    @endif
                  </div>
                </li>

              @endif

                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
<!-- ----------------------------------------- -->


<div class="container">
<h2>DOCUMENT LISTING - <a href="https://www.tutsmake.com" target="_blank">TutsMake</a></h2>
<br>
<a href="https://www.tutsmake.com/how-to-install-yajra-datatables-in-laravel/" class="btn btn-secondary">Back to Post</a>
<a href="javascript:void(0)" class="btn btn-info ml-3" id="create-new-product">Add New Document</a>
<br><br>

<table class="table table-bordered table-striped" id="laravel_datatable">
   <thead>
      <tr>
         <th>ID</th>
         <th>Document Name</th>
         <th>Department</th>
         <th>Description</th>
         <th>File URL</th>
         <th>Status</th>
         <th>Date</th>
         <th>Action</th>


      </tr>
   </thead>
</table>
</div>

<div class="modal fade" id="ajax-product-modal" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title" id="productCrudModal"></h4>
    </div>
    <div class="modal-body">
        <form id="DocumentForm" name="DocumentForm" class="form-horizontal">

           <input type="hidden" name="product_id" id="product_id">
            <!-- <div class="form-group">
                <label for="name" class="col-sm-2 control-label">ID</label>
                <div class="col-sm-12">
                    <input type="text" class="form-control" id="title" name="title" placeholder="Enter Id" value="" maxlength="50" required="">
                </div>
            </div> -->
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Document Name</label>
                <div class="col-sm-12">
                    <input type="text" class="form-control" id="document_name" name="document_name" placeholder="Enter Document name" value="" maxlength="50" required="">
                </div>
            </div>
            <div class="form-group"  maxlength="4" size="4">
                <label for="description">Department</label>
                <select class="form-control" name="department">
                    <option>IT</option>
                    <option>Manufacturing</option>
                    <option>Transport</option>
                    <option>Human Resource</option>

                </select>
            </div>

            <div class="form-group">
                <label for="title">Document</label>
              <input type="file" class="form-control" name="fileToUpload" id="fileToUpload">
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Description</label>
                <div class="col-sm-12">
                    <input type="text" class="form-control" id="description" name="description" placeholder="Enter Description" value="" required="">
                </div>
            </div>
            <div class="col-sm-offset-2 col-sm-10">
             <button type="submit" class="btn btn-primary" id="btn-save" value="create">Save changes
             </button>
            </div>

        </form>
    </div>
    <div class="modal-footer">

    </div>
</div>
</div>
</div>
</body>

</html>

<script>
 var SITEURL = '{{URL::to('')}}';
 $(document).ready( function () {
   $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
  $('#laravel_datatable').DataTable({
         processing: true,
         serverSide: true,
         ajax: {
          url: SITEURL + "/viewFile",
          type: 'GET',
         },
         columns: [
                  {data: 'id', name: 'id', 'visible': true},
                  // {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,searchable: false},
                  { data: 'Document_name', name: 'Document_name' },
                  { data: 'Department', name: 'Department' },
                  { data: 'Description', name: 'Description' },
                  { data: 'File', name: 'File' },
                  { data: 'status', name: 'status' },
                  { data: 'updated_at', name: 'updated_at' },
                  {data: 'action', name: 'action', orderable: false},
               ],
        order: [[0, 'desc']]
      });

 /*  When user click add user button */
    $('#create-new-product').click(function () {
        $('#btn-save').val("create-product");
        $('#product_id').val('');
        $('#productForm').trigger("reset");
        $('#productCrudModal').html("Add New Document");
        $('#ajax-product-modal').modal('show');
    });

   /* When click edit user */
    $('body').on('click', '.edit-record', function () {
      var user_id = $(this).data('id');
      // console.log(user_id);
      $.get('document-list/' + user_id +'/edit', function (data) {
         $('#title-error').hide();
         $('#product_code-error').hide();
         $('#description-error').hide();
         $('#productCrudModal').html("Edit Document");
          $('#btn-save').val("edit-product");
          $('#ajax-product-modal').modal('show');
          $('#product_id').val(data.id);
          $('#title').val(data.title);
          $('#product_code').val(data.product_code);
          $('#description').val(data.description);
      })
   });

    $('body').on('click', '#delete-record', function () {

        var record_id = $(this).data("id");

        if(confirm("Are You sure want to delete !")){
          $.ajax({
              type: "get",
              url: SITEURL + "/viewFile/delete/"+record_id,
              success: function (data) {
              var oTable = $('#laravel_datatable').dataTable();
              oTable.fnDraw(false);
              },
              error: function (data) {
                  console.log('Error:', data);
              }
          });
        }
    });

   });

if ($("#DocumentForm").length > 0) {
      $("#DocumentForm").validate({

     submitHandler: function(form) {

      var actionType = $('#btn-save').val();
      $('#btn-save').html('Sending..');

      $.ajax({
          data: $('#DocumentForm').serialize(),
          url: SITEURL + "document-list/store",
          type: "POST",
          dataType: 'json',
          success: function (data) {

              $('#DocumentForm').trigger("reset");
              $('#ajax-product-modal').modal('hide');
              $('#btn-save').html('Save Changes');
              var oTable = $('#laravel_datatable').dataTable();
              oTable.fnDraw(false);

          },
          error: function (data) {
              console.log('Error:', data);
              $('#btn-save').html('Save Changes');
          }
      });
    }
  })
}
</script>
