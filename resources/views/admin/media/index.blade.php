@extends('admin.layout.master')
@section('page-title')
    Manage Media
@endsection
@section('main-content')

    <!-- Main content -->
    <section class="content">
      
      <!-- /.row -->
     <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title"> 
                    <a id="activeAllStatus" url="{{ route('media.active.status') }}" class="btn btn-danger btn-xm"><i class="fa fa-eye"></i></a>
                    <a id="deactiveAllStatus" url="{{ route('media.deactive.status') }}" class="btn btn-danger btn-xm"><i class="fa fa-eye-slash"></i></a>
                    <a id="deleteAll" url="{{ route('media.delete.all') }}" class="btn btn-danger btn-xm"><i class="fa fa-trash"></i></a>
                    <!-- adding link of create page -->
                    <a href="/admin/media/create" class="btn btn-default btn-xm"><i class="fa fa-plus"></i></a>
              </h3>
              <div class="box-tools">
                <form method="get" action="/admin/media">
                  <div class="input-group input-group-sm" style="width: 250px;">
                  <input type="text" name="s" value="{{ (request()->get('s')) ? request()->get('s') : null }}" class="form-control pull-right" placeholder="Search">

                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>

                  </div>
                </div>
              </form>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              @if($medias)
              <table class="table table-bordered">
                <thead style="background-color: #F8F8F8;">
                  <tr>
                    <th width="4%"><input type="checkbox" name="" id="checkAll"></th>
                    <th width="20%">Title</th>
                    <th width="20%">Media Type</th>
                    <th width="20%">Media Image</th>
                    <th width="10%">Status</th>
                    <th width="10%">Manage</th>
                  </tr>
                </thead>
                <!-- // inserting record //-->
                @foreach($medias as $media)
                <tr>
                  <td><input type="checkbox" name="statusAll[]" value="{{ $media->id }}" id="" class="checkSingle"></td>
                  <td>{{$media->title }}</td> <!-- $media->decrypted_attributes['title'] -->
                  <td>{{ $media->media_type }}</td>
                  <td>
                    @if($media->media_img == 'No Image Found')
                    <img src="/assets/admin/dist/img/no-img.jpg" width="80" height="80" class="img-thumbnail" alt="No image found">
                    @else
                    <img src="/uploads/{{ $media->media_img}}"
                    width="80" height="80" class="img-thumbnail" alt="{{ $media->title }}">
                    @endif
                  </td>
                  <td>
                    <form method="POST" action="/admin/media/{{ $media->id }}/status">
                      @csrf
                      @method('put')
                      <!-- //status //-->
                      @if($media->status == 'DEACTIVE')
                       <button class="btn btn-danger btn-sm singleStatus"><i class="fa fa-thumbs-down"></i></button>
                    @else
                     <button class="btn btn-info btn-sm singleStatus"><i class="fa fa-thumbs-up"></i></button>
                    @endif
                    </form>
                  </td>
                  <td>
                    <form method="POST" action="/admin/media/{{ $media->id }}">
                      @csrf
                      @method('delete')
                      <a href="/admin/media/{{ $media->id }}/edit" class="btn btn-info btn-flat btn-sm"> <i class="fa fa-edit"></i></a>
                      <!-- Go to media edit page -->
                      <button type="submit" class="btn btn-danger btn-flat btn-sm singleDelete"> <i class="fa fa-trash-o"></i></button>
                    </form>
                  </td>
                </tr>
                @endforeach
            </table>
            </div>
            <!-- /.box-body -->
            <!-- //pagination// -->
              <div class="box-footer clearfix">
                        <div class="row">
                            <div class="col-sm-6">
                                <span style="display:block;font-size:15px;line-height:34px;margin:20px 0;">
                                    Showing {{($medias->currentpage()-1)*$medias->perpage()+1}} to {{$medias->currentpage()*$medias->perpage()}}
                        of  {{$medias->total()}} entries
                                    </span>
                            </div>
                          <div class="col-sm-6 text-right">
                              {{ $medias->links() }}
                          </div>
                        </div>
                    </div>
                    @else
                    <div class="alert alert-danger">No record found!</div>
                    @endif
          </div>
            <!-- /.box-body -->
          </div>


    </section>
    <!-- /.content -->

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
    $(".singleStatus").on('click', function(event)
    {
        event.preventDefault();
        //disable link fucntionality
        var self=$(this);
        // this means current class
        var url= self.closest('form').attr('action');
        // where ajax will go, closest means very close
        self.html('<img src="/assets/admin/dist/img/ajax-loader.gif">');
        $.ajax({
    url: url,
    type: 'PUT',
})
         .done(function(data){
           if (data == 'ACTIVE'){  
            self.closest('form').find('button').removeClass('btn-danger');
            self.closest('form').find('button').addClass('btn-info');
            self.html('<i class="fa fa-thumbs-up"></i>');
           }
          else
          {
            self.closest('form').find('button').removeClass('btn-info');
            self.closest('form').find('button').addClass('btn-danger');
            self.html('<i class="fa fa-thumbs-down"></i>');
          }
      })
       .fail(function() {
                alert("Opps! Something went wrong.");
                // console.log("error");
            })
        .always(function(){
            console.log("complete");
          });

        });
         // single delete ajax
        $(".singleDelete").on('click', function(event) {
    event.preventDefault();
    if (confirm('Are you sure you want to delete this?')) {
        var self = $(this);
        var url = self.closest('form').attr('action');
        // if form =attr(action) and if url(a) then href in attr
        $.ajax({
            url: url,
            type: 'DELETE', 
             // Corrected method to DELETE
        })
        .done(function(data) {
            if (data == 'true') {
                self.closest('tr').css('background-color', 'red').fadeOut('slow');
                self.remove();
            }
        })
        .fail(function(data) {
            alert("Oops! Something went wrong.");
        })
        .always(function() {
            console.log("complete");
        });
    } 
    else {
        return false;
    }
});
        // active all Status
        $("#activeAllStatus").on('click', function(event){
            event.preventDefault();
            var statusAllValue=[];
            // each one which is checked in statusAll
            $("input[name='statusAll[]']:checked").each(function() {
                statusAllValue.push($(this).val());
            });
            $.ajax({
                url: $("#activeAllStatus").attr('url'),
                type: 'GET',
                data: {statusAll: statusAllValue},
            })
            .done(function(data)
            // foreach in js
            {
                $.each(data, function(index, val){
                    $("input[value='"+val.id+"']")
                    .closest('tr')
                    .find('.singleStatus')
                    .removeClass('btn-danger')
                    .addClass('btn-info')
                    .html('<i class="fa fa-thumbs-up"></i>')
                });
            })
            .fail(function(){
                console.log("error");
            })
            .always(function(){
                console.log("complete");
            });
        });
        // deactive all status
          $("#deactiveAllStatus").on('click', function(event){
            event.preventDefault();
            var statusAllValue=[];
            // each one which is checked in statusAll
            $("input[name='statusAll[]']:checked").each(function() {
                statusAllValue.push($(this).val());
            });
            $.ajax({
                url: $("#deactiveAllStatus").attr('url'),
                type: 'GET',
                data: {statusAll: statusAllValue},
            })
            .done(function(data){
                $.each(data, function(index, val){
                    $("input[value='"+val.id+"']")
                    .closest('tr')
                    .find('.singleStatus')
                    .removeClass('btn-info')
                    .addClass('btn-danger')
                    .html('<i class="fa fa-thumbs-down"></i>')
                });
            })
            .fail(function(){
                console.log("error");
            })
            .always(function(){
                console.log("complete");
            });
        });
          // delete all
          $("#deleteAll").on('click', function(event){
            event.preventDefault();
            var statusAllValue=[];
            // each one which is checked in statusAll
            $("input[name='statusAll[]']:checked").each(function() {
                statusAllValue.push($(this).val());
            });
            $.ajax({
                url: $("#deleteAll").attr('url'),
                type: 'GET',
                data: {statusAll: statusAllValue},
            })
            .done(function(data){
               location.reload(true);
            })
            .fail(function(){
                console.log("error");
            })
            .always(function(){
                console.log("complete");
            });
        });

        });
    </script>
    @endsection