@extends('layouts.app')

@section('title')
{{$serverDetail->name}} Detail | VSSI Cloud
@endsection

@section('content')

  <h1 class="mt-4">{{$serverDetail->name}} Server Detail</h1>
  
  <div class="row">
    <div class="card mb-4">
      <div class="card-header">
        <i class="fas fa-table mr-1"></i>Add App Images
        <a class="btn btn-success pull-right"  href=""><i class="fas fa-text-height"></i></a>
      </div>
      <div class="card-body">

        
      </div>
   </div>
  </div>


@endsection
    
@section('js')
  
@endsection
  