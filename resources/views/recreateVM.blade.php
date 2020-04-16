@extends('layouts.app')

@section('title')
Recreate {{$vmDetail->name}} | VSSI Cloud
@endsection

@section('content')

  <!-- Page Content -->
    <div class="container-fluid">
      <h1 class="mt-4">Create Instance</h1>
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
                <div class="card mb-4" >
                    <div class="card-header">

                        <ul class="nav nav-pills card-header-pills" id="pills-tab" role="tablist">
                          <li class="nav-item">
                            <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Create</a>
                          </li>

                         
                          <li class="nav-item">
                            <a class="nav-link" id="pills-terminal-tab" data-toggle="pill" href="#pills-terminal" role="tab" aria-controls="pills-terminal" aria-selected="false">Terminal</a>
                          </li>
                          
                        </ul>
                    </div>

                    <div class="card-body">
                        
                        <div class="tab-content" id="pills-tabContent">

                          <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                            <div class="row">
                            <div class="col-md-4">

                                <div class="card" id="vmmessgae">

                                  <div class="card-header">
                                    Creating VM for you
                                  </div>
                                  <div class="card-body">
                                    <h5 class="card-title">
                                        <div class="spinner-grow text-primary" role="status">
                                          <span class="sr-only">Loading...</span>
                                        </div>
                                        <div class="spinner-grow text-secondary" role="status">
                                          <span class="sr-only">Loading...</span>
                                        </div>
                                        <div class="spinner-grow text-success" role="status">
                                          <span class="sr-only">Loading...</span>
                                        </div>
                                        <div class="spinner-grow text-danger" role="status">
                                          <span class="sr-only">Loading...</span>
                                        </div>
                                        <div class="spinner-grow text-warning" role="status">
                                          <span class="sr-only">Loading...</span>
                                        </div>
                                        <div class="spinner-grow text-info" role="status">
                                          <span class="sr-only">Loading...</span>
                                        </div>
                                        <div class="spinner-grow text-light" role="status">
                                          <span class="sr-only">Loading...</span>
                                        </div>
                                    </h5>
                                    <p class="card-text">Please dont go back or refresh this page. You can view the logs in the terminal</p>
                                    
                                  </div>
                                </div>

                               
                                <form id="hide-vm" class="form">
                                  <div class="form-group">
                                    <label for="uname1">JIRA Ticket</label>
                                    <input type="text" class="form-control"  id="jira" required>
                                    
                                    <input type="hidden"  id="vmid" value="{{$vmDetail->id}}">
                                   
                                  </div>
                                  <div class="form-group">
                                    <label for="flavor">Flavors</label>
                                    <select class="form-control"  id="flavor" required>
                                      <option value="">Select Flavor</option>  
                                      @foreach($flavors as $flavor)
                                      <option value="{{$flavor->id}}">{{$flavor->name}}</option>
                                      @endforeach
                                    </select>
                                    <div class="invalid-feedback">Please select flavor </div>
                                  </div>
                                
                                  <div class="form-group">
                                    <label for="exampleFormControlSelect1">Application</label>
                                    <select class="form-control"  id="app" required>
                                    <option value="">Select Application Image</option>
                                    @foreach ($apps as $app)
                                        <option value="{{$app->id}}">{{$app->name}}</option>
                                    @endforeach
                                      
                                    </select>
                                    <div class="invalid-feedback">Please select application </div>
                                  </div>

                                

                                  <button type="button" id="launchVM" class="btn btn-success">Launch VM</button>
                                </form>
                                
                            </div>
                            <div class="col-md-4 offset-md-2">
                              
                              @if($vmDetail)
                              
                              <table class="table table-bordered">
                                <thead >
                                  <tr>
                                    <th scope="col">VM Name</th>
                                    <th scope="col">{{$vmDetail->name}}</th>
                                    
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <th >Email</th>
                                    <td>{{$vmDetail->email}}</td>
                                    
                                  </tr>
                                  <tr>
                                    <th >Jira Ticket</th>
                                    <td>{{$vmDetail->jira}}</td>
                                    
                                  </tr>
                                  <tr>
                                    <th >HostName</th>
                                    
                                    <td>{{$vmDetail->hostname}}</td>
                                  </tr>
                                  <tr>
                                    <th >Nic 1</th>
                                    <td>{{$vmDetail->nic1}}</td>
                                    
                                  </tr>
                                  <tr>
                                    <th >Nic 2</th>
                                    <td>{{$vmDetail->nic2}}</td>
                                    
                                  </tr>
                                  
                                  
                                </tbody>
                              </table>
                              @endif
                              
                            </div>
                        </div>
                            

                              
                          </div>
                           

                            <!-- All VM -->
                          <div class="tab-pane fade" id="pills-terminal" role="tabpanel" aria-labelledby="pills-terminal-tab" style="color: #fff;background: #000">
                            <div class="container" id="terminal-body" style="padding: 3%;line-height: 30px">
                                <h2 color='#20ff00'>Terminal</h2>

                                <h3>No output detected.</h3>
                            </div>
                          </div> <!-- All vM -->
                          
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- delete Modal -->
  
   
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
      
      $("#launchVM").click(function(event) {
        //event.preventDefault()
        var vmid = $('#vmid').val();
        var jira = $('#jira').val();
        var app = $('#app option:selected').val();
        var flavor = $('#flavor option:selected').val();

        // Fetch form to apply custom Bootstrap validation
        var form = $("#hide-vm")
    
        if (form[0].checkValidity() === false) {
          //console.log(form[0].checkValidity());
          event.preventDefault()
          event.stopPropagation()
          form.addClass('was-validated');
        }else{
          //=============ajax call=====================

          form.addClass('was-validated');
          $('#hide-vm').hide();
          $('#vmmessgae').show();
              
  
              $.ajax({
                  type:'POST',
                  url: "{{route('postVmRecreate')}}",
                  data: {vmid :vmid, 
                    jira :jira,
                    app :app,  
                    flavor:flavor},
                  xhr: function () {
                      var xhr = $.ajaxSettings.xhr() ;
                      xhr.onprogress = function (e) {
                          //console.log(e.currentTarget.responseText);
                          $('#terminal-body').html(e.currentTarget.responseText);  
                      }
                      
                      return xhr ;
                       
                  },
                  success: function(data){
                      $('#vmmessgae').hide();
                       $('#hide-vm').show();
                      // console.log(data);
                       //alert(vmname+ ' VM Created');
                      //  setTimeout(function() {
                      //   location.reload(true);
                      // }, 10000);
                       
                  }
                  
              })
             

          // ==============ajax call ends here===========

        }
        
        
        
      });


      // ==============================

      $('[ip-mask]').ipAddress();

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
                          setTimeout(function() {
                            location.reload(true);
                          }, 10000);
                          
                          
                    }).fail(function() {
                        
                    })
                   
               }
            }
    

      
    });
    
</script>
@endsection
  