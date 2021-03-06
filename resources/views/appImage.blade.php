@extends('layouts.app')

@section('title')
Add Application | VSSI Cloud
@endsection

@section('content')

  <h1 class="mt-4">Add Application Images</h1>
  <ol class="breadcrumb mb-6">
      <li class="breadcrumb-item active">Add Image</li>
  </ol>
  @if (session('status'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      {{ session('status') }} 
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    @endif
    <div class="row">
      <div class="col-sm-6">
        <div class="card mb-6">
          <div class="card-header">
            <i class="fas fa-table mr-1"></i>Add App Images
          </div>
          <div class="card-body">

            {!! Form::open(['route' => 'postImage']) !!}

              <div class="form-group">
                <label for="exampleFormControlSelect1" style="display: block">Application Image</label>
                <select class="form-control" name="image"   required>
                <option value="">Select Application Image</option>
                @foreach ($apps as $app)
                    <option value="{{$app->id}}?{{$app->name}}">{{$app->name}}</option>
                @endforeach
                  
                </select>
                <div class="invalid-feedback">Please select application image</div>
              </div>

              <div class="form-group">
                <label for="lastName">App Name</label>
                <input type="text" class="form-control"  name="app" required>
                <small class="form-text text-muted">eg : ce, de, apx max 3 letter</small>
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
                <small class="form-text text-muted">for window 10, ubuntu = 18.04, RHEL = 7  only version</small>
              </div>

              <button type="submit" class="btn btn-primary">Submit</button>

            {!! Form::close() !!}
          </div>
      </div>
    </div>
   {{--  ***********************  --}}
   <div class="col-sm-6">
    <div class="card mb-6">
      <div class="card-header">
        <i class="fas fa-table mr-1"></i>Add App Images with ID
      </div>
      <div class="card-body">

        {!! Form::open(['route' => 'postImageId']) !!}

          <div class="form-group">
            <label for="exampleFormControlSelect1" style="display: block">Application Image ID</label>
            <input type="text" class="form-control"  name="image" required>
            <small class="form-text text-muted">Copy and paste image id from openstack console</small>
            <div class="invalid-feedback">Please add Image id</div>
          </div>

          <div class="form-group">
            <label for="lastName">App Name</label>
            <input type="text" class="form-control"  name="app" required>
            <small class="form-text text-muted">eg : ce, de, apx max 3 letter</small>
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
   
   {{--  ***********************  --}}
    </div> {{--row--}}
  </div>


@endsection
    
@section('js')
  
@endsection
  