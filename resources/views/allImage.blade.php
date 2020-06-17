@extends('layouts.app')

@section('title')
All Images | VSSI Cloud
@endsection

@section('content')

  <!-- Page Content -->
    <div class="container-fluid">
      <h1 class="mt-4">All Images</h1>
        <div class="row">
            <div class="col-md-12">
                @if (session('vms'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                  {{ session('vms') }} has been created successfully
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                @endif
                <div class="card " >
                    <div class="card-header">

                        <ul class="nav nav-pills card-header-pills" id="pills-tab" role="tablist">
                         
                          <li class="nav-item">
                            <a class="nav-link active" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="true">Images</a>
                          </li>
                          
                          
                        </ul>
                    </div>

                    <div class="card-body">
                        
                        <div class="tab-content" id="pills-tabContent">

                        
                            <!-- All VM -->
                          
                            <table class="table table-hover table-striped dataTable" id="showVm">
                              <thead>
                                <tr>
                                  <th scope="col">App Name</th>
                                  <th scope="col">Image</th>
                                  <th scope="col">OS</th>
                                  <th scope="col">Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                @if(count($images))
                                    @foreach($images as $image)
                                        <tr id="{{$image->id}}">
                                          <th scope="row">{{$image->name}}</th>
                                          <td>{{$image->image}}</td>
                                          <td>{{$image->os}}</td>
                                          <td>
                                            
                                            <a  class="btn btn-danger deletevm" id="deletevm" data-order="{{ $image->id }}"
                                            data-order_destroy_route="{{ route('deleteImage', ['id' => $image->id]) }}" data-toggle="tooltip" data-placement="top" title="Delete VM">
                                            <i class="far fa-trash-alt"></i></i>
                                          </a>
                                            
                                          
                                           </td>
                                        </tr>
                                        
                                    @endforeach
                                @endif
                                
                              </tbody>
                            </table>
                          

                          
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

 
@endsection
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
@section('js')
<script src="{{ asset('js/datatable.js')}}" crossorigin="anonymous"></script>
<script src="{{ asset('js/datatable-bootstrap.js')}}" crossorigin="anonymous"></script>
<script src="{{ asset('js/datatables-demo.js')}}"></script>
<script>
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
  $('#vmmessgae').hide();
  
  $(document).ready(function(){
    

      $('#showVm ').on('click','tr td #deletevm', function(){
        
          $('#jiraModal').modal('show');
              var order = $(this).attr('data-order');
              var orderRoute = $(this).attr('data-order_destroy_route');
            
              deleteOrder(order ,orderRoute);

             
          });

          var deleteOrder = function(order,orderRoute)
          {
             var ask =  confirm("Are you sure ?");

             if(ask == true)
             {
                  $('#deleteModal').modal('show');
                  $.ajax({
                      type:'POST',
                      url: orderRoute,
                      data: {order :order},
                        
                      }).done(function(data) {
                        //console.log(data)

                        alert('Image Deleted');
                        
                        location.reload(true);
                       
                        
                        
                  }).fail(function() {
                      
                  })
                 
             }
          }
  

    
  });
  
</script>
@endsection
  