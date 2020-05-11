@extends('layouts.app')

@section('title')
All Instances | VSSI Cloud
@endsection

@section('content')

  <!-- Page Content -->
    <div class="container-fluid">
      <h1 class="mt-4">All Instances</h1>
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
                            <a class="nav-link active" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="true">All Openstack VMs</a>
                          </li>
                          
                          
                        </ul>
                    </div>

                    <div class="card-body">
                        
                        <div class="tab-content" id="pills-tabContent">

                        
                            <!-- All VM -->
                          
                            <table class="table table-hover table-striped dataTable" id="showVm">
                              <thead>
                                <tr>
                                  <th scope="col">VM</th>
                                  <th scope="col">JIRA</th>
                                  <th scope="col">User</th>
                                  <th scope="col">Nic 1</th>
                                  <th scope="col">Nic 2</th>
                                  <th scope="col">App</th>
                                  <th scope="col">Created by</th>
                                  {{-- <th scope="col">Created at</th> --}}
                                  <th scope="col">Action</th>
                                </tr>
                              </thead>
                              <tbody>
                                @if(count($allVM))
                                    @foreach($allVM as $myVM)
                                        <tr id="{{$myVM->id}}">
                                          <th scope="row">{{$myVM->name}}</th>
                                          <td>{{$myVM->jira}}</td>
                                          <td>{{$myVM->username}}</td>
                                          <td>{{$myVM->nic1}}</td>
                                          <td>{{$myVM->nic2}}</td>
                                          <td>{{$myVM->application->name}}</td>
                                          <td>{{$myVM->created_by}}</td>
                                          {{-- <td>{{$myVM->created_at}}</td> --}}
                                          <td>
                                            
                                            <a  class="btn btn-danger deletevm" data-order="{{ $myVM->name }}"
                                            data-order_destroy_route="{{ route('deletevm', ['id' => $myVM->id]) }}" data-toggle="tooltip" data-placement="top" title="Delete VM">
                                            <i class="far fa-trash-alt"></i></i>
                                          </a>
                                            
                                            <a class="btn btn-warning " href="{{route('vmRecreate', ['id' => $myVM->id])}}" data-toggle="tooltip" data-placement="top" title="Re-create VM">
                                              <i class="fas fa-retweet"></i>
                                            </a>
                                            <a class="btn btn-info " href="{{route('showVM', ['id' => $myVM->id, 'vmid' => $myVM->vm_uid ])}}" data-toggle="tooltip" data-placement="top" title="View Server Detail">
                                              <i class="far fa-eye"></i>
                                            </a>
                                            {{-- <a  class="btn btn-info showlog" data-toggle="modal" data-target="#logs{{$myVM->id}}" data-order="{{$myVM->id}}"><img src="{{ asset('images/eye-fill.svg') }}" alt="" width="24" height="24" title="View log"></a> --}}
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
            <p>We are deleting vm and it may take few min so please do not refresh the page</p>
          </div>
         
        </div>
      </div>
    </div>
  <!-- jira ticket -->
  <div class="modal fade" tabindex="-1" role="dialog" id="jiraModal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Jira Request For VM Deletion</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p> <div class="form-group">
            <label for="exampleInputEmail1">JIRA Ticket</label>
            <input type="text" class="form-control" id="jira">
            <input type="hidden" value="" id="orderHidden">
            <input type="hidden" value="" id="orderRouteHidden">
          </div>
        </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="deleteCnfm">Delete</button>
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

        $('#showVm ').on('click','tr td #deletevm', function(){
            $('#jiraModal').modal('show');
                var order = $(this).attr('data-order');
                var orderRoute = $(this).attr('data-order_destroy_route');
                $('#orderHidden').val(order);
                $('#orderRouteHidden').val(orderRoute);
                //console.log(order);

               
            });

            $('#deleteCnfm').on('click', function(){
              var order = $('#orderHidden').val();
              var orderRoute=  $('#orderRouteHidden').val();
              var jira = $('#jira').val();
              $('#jiraModal').modal('hide');
              deleteOrder(order ,orderRoute, jira);

            });

            var deleteOrder = function(order,orderRoute,jira)
            {
               var ask =  confirm("Are you absolutely sure you want to delete " + order + "? This action cannot be undone." +
            "This will permanently delete " + order + ", and remove all collections and resources associated with it.");

               if(ask == true)
               {
                    $('#deleteModal').modal('show');
                    $.ajax({
                        type:'POST',
                        url: orderRoute,
                        data: {jira :jira},
                          
                        }).done(function(data) {
                          //console.log(data)
                          $('#deleteModal').modal('hide');
                          //$('#'+data).hide();
                          $('#orderHidden').val("");
                          $('#orderRouteHidden').val("");
                          $('#jira').val("");
                          alert('VM Deleted');
                          
                          location.reload(true);
                         
                          
                          
                    }).fail(function() {
                        
                    })
                   
               }
            }
    

      
    });
    
</script>
@endsection
  