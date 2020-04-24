@extends('layouts.app')

@section('title')
Add Application | VSSI Cloud
@endsection

@section('content')

  <h1 class="mt-4">Add Application</h1>
  <ol class="breadcrumb mb-4">
      <li class="breadcrumb-item active">App</li>
  </ol>
  @if (session('status'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ session('status') }} has been added successfully
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    @endif
  <div class="row">
    
    <div class="card mb-4">
      <div class="card-header"><i class="fas fa-table mr-1"></i>Add App Images</div>
      <div class="card-body">

        {!! Form::open(['route' => 'postImage']) !!}

          <div class="form-group">
            <label for="exampleFormControlSelect1" style="display: block">Application Image</label>
            <select class="form-control" name="image"   required>
            <option value="">Select Application Image</option>
            @foreach ($apps as $app)
                <option value="{{$app->id}}_{{$app->name}}">{{$app->name}}</option>
            @endforeach
              
            </select>
            <div class="invalid-feedback">Please select application image</div>
          </div>

          <div class="form-group">
            <label for="lastName">App Name</label>
            <input type="text" class="form-control"  name="app" required>
          
          </div>

          <div class="form-group">
            <label for="lastName" style="display: block">OS </label>
            
            <select class="form-control"  name="os" required>
                <option value="">Select Image OS</option>
             
                <option value="centos">CentOS</option>
                <option value="rhel">RHEL</option>
                <option value="ubuntu">Ubuntu</option>
                <option value="window">Window</option>
             
                
              </select>

          </div>

          <div class="form-group">
            <label for="lastName">OS Version</label>
            <input type="text" class="form-control"  name="version" required>
          
          </div>

          <button type="submit" class="btn btn-primary">Submit</button>

         {!! Form::close() !!}
      </div>
   </div>
  </div>


@endsection
    
@section('js')
  
@endsection
  