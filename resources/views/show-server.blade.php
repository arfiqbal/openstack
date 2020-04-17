@extends('layouts.app')

@section('title')
{{$serverDetail->name}} Detail | VSSI Cloud
@endsection

@section('content')

  <h1 class="mt-4">{{$serverDetail->jira}} Server Detail</h1>
  
  <div class="row">
    <div class="col-md-8">
    <div class="card ">
      <div class="card-header">
        <i class="fas fa-table mr-1"></i>Add App Images
        <a class="btn btn-success float-righ"  id="showFlvr"><i class="fas fa-text-height"></i></a>
      </div>
      
      <div class="card-body">
        <table class="table table-borderless">
          
          <tbody>
            <tr>
              <th scope="row">Server Name</th>
              <td>{{$serverDetail->name}}</td>
            </tr>
            <tr>
              <th scope="row">Jira Ticket</th>
              <td>{{$serverDetail->jira}}</td>
            </tr>
            <tr>
              <th scope="row">Hostname</th>
              <td>{{$serverDetail->hostname}}</td>
            </tr>
            <tr>
              <th scope="row">UserName</th>
              <td>{{$serverDetail->username}}</td>
            </tr>
            <tr>
              <th scope="row">Email</th>
              <td>{{$serverDetail->email}}</td>
            </tr>
            <tr>
              <th scope="row">Server OS</th>
              <td>{{$serverDetail->application->os}}</td>
            </tr>
            <tr>
              <th scope="row">Server UID</th>
              <td>{{$serverDetail->vm_uid}}</td>
            </tr>
            <tr>
              <th scope="row">Nic1</th>
              <td>{{$serverDetail->nic1}}</td>
            </tr>
            <tr>
              <th scope="row">Nic2</th>
              <td>{{$serverDetail->nic2}}</td>
            </tr>
            <tr>
              <th scope="row">Flavor</th>
              <td>{{$serverDetail->jira}}</td>
            </tr>
            <tr>
              <th scope="row">Flavor</th>
              <td>{{$getFlavor}}</td>
            </tr>
            <tr>
              <th scope="row">Created By</th>
              <td>{{$serverDetail->created_by}}</td>
            </tr>
            <tr>
              <th scope="row">Created At</th>
              <td>{{$serverDetail->created_at}}</td>
            </tr>
          </tbody>
        </table>

        
      </div>
      </div>
   </div>
  </div>

  <div class="modal" tabindex="-1" role="dialog" id="flvrModal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Change Flavor </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
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
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="updateFlvr">Save changes</button>
        </div>
      </div>
    </div>
  </div>

@endsection
    
@section('js')

<script>
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
  
  
  $(document).ready(function(){

    $("#showFlvr").click(function(event) {
      $('#flvrModal').modal('show');
    });

    $('#updateFlvr').on('click',function(){
      var flavor = $('#flavor option:selected').val();
      var vmuid = "{{$serverDetail->id}}";
      $.ajax({
        type:'POST',
        url: "<?= URL::to("change-flavor");?>",
        data: {flavor :flavor,vmuid:vmuid},
          
        }).done(function(data) {
          console.log(data);
        })
    });

  });
</script>
  
@endsection
  