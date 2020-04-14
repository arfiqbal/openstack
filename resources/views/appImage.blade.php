@extends('layouts.app')

@section('title')
Add Application
@endsection

@section('content')

  <h1 class="mt-4">Dashboard</h1>
  <ol class="breadcrumb mb-4">
      <li class="breadcrumb-item active">Dashboard</li>
  </ol>
  <div class="row">
    <div class="card mb-4">
      <div class="card-header"><i class="fas fa-table mr-1"></i>Add App Images</div>
      <div class="card-body">
        {!! Form::open(['route' => 'route.name']) !!}

          <div class="form-group">
            <label for="exampleFormControlSelect1">Application Image</label>
            <select class="form-control"  id="app" required>
            <option value="">Select Application Image</option>
            @foreach ($apps as $app)
                <option value="{{$app->id}}">{{$app->name}}</option>
            @endforeach
              
            </select>
            <div class="invalid-feedback">Please select application image</div>
          </div>

          <div class="form-group">
            <label for="lastName">App Name</label>
            <input type="text" class="form-control"  id="lastName" required>
          
          </div>

          <div class="form-group">
            <label for="lastName">OS </label>
            <input type="text" class="form-control"  id="lastName" required>
          
          </div>

         {!! Form::close() !!}
      </div>
   </div>
  </div>


@endsection
    
@section('js')
  
@endsection
  