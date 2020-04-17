@extends('layouts.app')

@section('title')
{{$serverDetail->name}} Detail | VSSI Cloud
@endsection

@section('content')

  <h1 class="mt-4">{{$serverDetail->jira}} Server Detail</h1>
  
  <div class="row">
    <div class="card mb-4">
      <div class="card-header">
        <i class="fas fa-table mr-1"></i>Add App Images
        <a class="btn btn-success pull-right"  href=""><i class="fas fa-text-height"></i></a>
      </div>
      <div class="card-body">
        <table class="table table-borderless">
          
          <tbody>
            <tr>
              <th scope="row">Server Name</th>
              <td>Mark</td>
            </tr>
            <tr>
              <th scope="row">Jira Ticket</th>
              <td>Mark</td>
            </tr>
            <tr>
              <th scope="row">Hostname</th>
              <td>Mark</td>
            </tr>
            <tr>
              <th scope="row">UserName</th>
              <td>Mark</td>
            </tr>
            <tr>
              <th scope="row">Email</th>
              <td>Mark</td>
            </tr>
            <tr>
              <th scope="row">Server OS</th>
              <td>Mark</td>
            </tr>
            <tr>
              <th scope="row">Server UID</th>
              <td>Mark</td>
            </tr>
            <tr>
              <th scope="row">Nic1</th>
              <td>Mark</td>
            </tr>
            <tr>
              <th scope="row">Nic2</th>
              <td>Mark</td>
            </tr>
            <tr>
              <th scope="row">Flavor</th>
              <td>Mark</td>
            </tr>
            <tr>
              <th scope="row">Flavor</th>
              <td>Mark</td>
            </tr>
            <tr>
              <th scope="row">Created By</th>
              <td>Mark</td>
            </tr>
            <tr>
              <th scope="row">Created At</th>
              <td>Mark</td>
            </tr>
          </tbody>
        </table>

        
      </div>
   </div>
  </div>


@endsection
    
@section('js')
  
@endsection
  