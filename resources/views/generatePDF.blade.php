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
 
  {{-- <tfoot class="thead-dark">
    <tr>
      <th colspan="4">Total</th>
      
      <th>{{count($newvm)}}</th>
    </tr>
  </tfoot> --}}
  </tbody>
</table>
@endsection