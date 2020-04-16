@extends('layouts.app')

@section('title')
Create VM | VSSI Cloud
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
                                
                                <!-- <form method="POST" action="" class="" novalidate>
                                    {{ csrf_field() }} -->

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
                                    <label for="uname1">VM Name</label>
                                    <input type="text" class="form-control"  id="vmname" required>
                                  
                                  </div>
                                  <div class="form-group">
                                    <label for="uname1">JIRA Ticket</label>
                                    <input type="text" class="form-control"  id="jira" required>
                                  
                                  </div>
                                  <div class="form-group">
                                    <label for="firstName">First Name</label>
                                    <input type="text" class="form-control"  id="firstName" required>
                                  
                                  </div>
                                  <div class="form-group">
                                    <label for="lastName">Last Name</label>
                                    <input type="text" class="form-control"  id="lastName" required>
                                  
                                  </div>

                                  <div class="form-group">
                                    <label for="uname1">Email</label>
                                    <input type="email" class="form-control"  id="email" required>
                                    
                                  </div>

                                  <div class="form-group">
                                    <label for="project">Project</label>
                                    <select class="form-control"  id="project" required>
                                    <option value="">Select Project</option>
                                    @foreach ($identity->listProjects(['domainId' => "default"]) as $project)
                                        <option value="{{$project->id}}">{{$project->name}}</option>
                                    @endforeach
                                      
                                    </select>
                                    <div class="invalid-feedback">Please select Project </div>
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
                                    <div id="getflv"></div>
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
                              
                              @if($lastVm)
                              <h4>Last VM Created on {{$lastVm->created_at}}</h4>
                              <table class="table table-bordered">
                                <thead >
                                  <tr>
                                    <th scope="col">VM Name</th>
                                    <th scope="col">{{$lastVm->name}}</th>
                                    
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <th >Email</th>
                                    <td>{{$lastVm->email}}</td>
                                    
                                  </tr>
                                  <tr>
                                    <th >HostName</th>
                                    
                                    <td>{{$lastVm->hostname}}</td>
                                  </tr>
                                  <tr>
                                    <th >Nic 1</th>
                                    <td>{{$lastVm->nic1}}</td>
                                    
                                  </tr>
                                  <tr>
                                    <th >Nic 2</th>
                                    <td>{{$lastVm->nic2}}</td>
                                    
                                  </tr>
                                  <tr>
                                    <th>Created By</th>
                                    <td>{{$lastVm->created_by}}</td>
                                    
                                  </tr>
                                  <tr>
                                    <th>Status</th>
                                    <td>@if($lastVm->active == 0)
                                      <b>Deleted</b> on {{$lastVm->updated_at}}
                                      @else 
                                      <b>Active</b>
                                      @endif

                                    </td>
                                    
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

      $('#flavor').change(function(){
        var flavor = $('#flavor option:selected').val();
        $.ajax({
          type:'POST',
          url: "<?= URL::to("get-flavor");?>",
          data: {flavor :flavor},
            
          }).done(function(data) {
            $('#getflv').text(data);
          })
      });
      
      $("#launchVM").click(function(event) {
        //event.preventDefault()
        var vmname = $('#vmname').val();
        var jira = $('#jira').val();
        var firstName = $('#firstName').val();
        var lastName = $('#lastName').val();
        var email = $('#email').val();
        var project = $('#project option:selected').val();
        var network = $('#network option:selected').val();
        var network1 = $('#network1 option:selected').val();
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
                  url: "<?= URL::to("vm");?>",
                  data: {vmname :vmname, 
                    email:email, 
                    project :project, 
                    firstName :firstName, 
                    jira :jira,
                    app :app, 
                    lastName :lastName, 
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

      
    });
    
</script>
@endsection
  