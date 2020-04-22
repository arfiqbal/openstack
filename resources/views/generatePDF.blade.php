@extends('layouts.pdfMaster')

@section('title')
Weekly Report - {{date('d-m-Y')}}
@endsection

@section('content')
<h1>Weekly Report - {{date('d-m-Y')}}</h1>

<table class="table">
  <thead class="thead-dark">
    <tr>
      <th>Ticket</th>
      <th>Name</th>
      <th>Requester</th>
      <th>IP</th>
      <th>Created By</th>
      <th>Created At</th>
    </tr>
  </thead>
  <tbody>
    @foreach($newvm as $server)
    <tr>
      <td>{{$server->jira}}</td>
      <td>{{$server->name}}</td>
      <td>{{$server->firstname}} {{$server->lastname}}</td>
      <td>{{$server->nic1}}/{{$server->nic2}}</td>
      <td>{{$server->created_by}}</td>
      <td>{{$server->created_at}}</td>
    </tr>
    @endforeach
  <tfoot class="thead-dark">
    <tr>
      <th colspan="5">Total</th>
      
      <th>{{count($newvm)}}</th>
    </tr>
  </tfoot>
  </tbody>
</table>
@endsection