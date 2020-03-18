@extends('layouts.app')

@section('title')
Create VM | All VM
@endsection

@section('content')

  <!-- Page Content -->
    <div class="container">
        <div class="row">
            <div class="col-md-12 ">
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
                            <a class="nav-link active" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="true">All Openstack VMs</a>
                          </li>
                          
                          
                        </ul>
                    </div>

                    <div class="card-body">
                        
                        <div class="tab-content" id="pills-tabContent">

                        
                            <!-- All VM -->
                          
                            <table class="table table-hover table-striped" id="showVm">
                              <thead>
                                <tr>
                                  <th scope="col">Name</th>
                                  <th scope="col">Email</th>
                                  <th scope="col">Nic 1</th>
                                  <th scope="col">Nic 2</th>
                                  <th scope="col">Application</th>
                                  <th scope="col">Created by</th>
                                  <th scope="col">Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                @if(count($allVM))
                                    @foreach($allVM as $myVM)
                                        <tr id="{{$myVM->id}}">
                                          <th scope="row">{{$myVM->name}}</th>
                                          <td>{{$myVM->email}}</td>
                                          <td>{{$myVM->nic1}}</td>
                                          <td>{{$myVM->nic2}}</td>
                                          <td>{{$myVM->application->name}}</td>
                                          <td>{{$myVM->created_by}}</td>
                                          <td>
                                            
                                            <a  class="btn btn-danger deletevm" data-order="{{ $myVM->name }}"
                                            data-order_destroy_route="{{ route('deletevm', ['id' => $myVM->id]) }}"><img src="{{ asset('images/trash.svg') }}" alt="" width="24" height="24" title="DELETE VM"></a>
                                            

                                            <a  class="btn btn-info showlog" data-toggle="modal" data-target="#logs{{$myVM->id}}" data-order="{{$myVM->id}}"><img src="{{ asset('images/eye-fill.svg') }}" alt="" width="24" height="24" title="View log"></a>
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

    <!-- delete Modal -->
    

    <div class="modal" tabindex="-1" role="dialog" id="deleteModal">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Deleting Vm</h5>
            
              <div class="spinner-border text-danger" role="status">
                <span class="sr-only">Loading...</span>
              </div>
              
            </button>
          </div>
          <div class="modal-body">
            <p>We are deleting vm and it may take few min so please donot refresh the page</p>
          </div>
         
        </div>
      </div>
    </div>
   
    <!-- log Modal -->
<div class="modal fade modal-xl" id="mylogmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalScrollableTitle">View Log</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      
      </div>
      
    </div>
  </div>
</div>
@endsection
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
@section('js')
    <script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#vmmessgae').hide();
    
    $(document).ready(function(){
      
        $('#showVm  .showlog').click(function(){
                var id = $(this).attr('data-order');
                //console.log(id);
                $.get(
                   '<?=URL::to("vm");?>',
                   {'id': id },
                  function(result){

                    //console.log(result);

                    if(result){
                        $('.modal-body').html(result);
                        $('#mylogmodal').modal();
                    }
                  }
                );

        })

        $('#showVm tr td .deletevm').on('click', function(){
                var order = $(this).attr('data-order');
                var orderRoute = $(this).attr('data-order_destroy_route');

                //console.log(order);

               deleteOrder(order ,orderRoute);
            });

            var deleteOrder = function(order,orderRoute)
            {
               var ask =  confirm("Are you absolutely sure you want to delete " + order + "? This action cannot be undone." +
            "This will permanently delete " + order + ", and remove all collections and resources associated with it.");

               if(ask == true)
               {
                    $('#deleteModal').modal('show');
                    $.ajax({
                        type:'POST',
                        url: orderRoute,
                          
                        }).done(function(data) {
                          //console.log(data)
                          $('#deleteModal').modal('hide');
                          //$('#'+data).hide();
                          alert('VM Deleted');
                          
                          location.reload(true);
                         
                          
                          
                    }).fail(function() {
                        
                    })
                   
               }
            }
    

      
    });
    
</script>
@endsection
  