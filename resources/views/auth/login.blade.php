<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>VSSI CLOUD - Admin Login</title>
        <link href="{{ asset('css/styles.css')}}" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
        <style>
            .bg-primary{
                background-image: linear-gradient(to bottom right, #9d2828, #3c3c38) !important;
            }
            svg {
                font-family: 'Russo One', sans-serif;float: left; width: 40% !important;
               
            }
            svg text {
                text-transform: uppercase;
                animation: stroke 5s  ;
                stroke-width: 2;
                stroke: #fff;
                font-size: 170px;
            }
            @keyframes stroke {
                0%   {
                    fill: rgba(255, 255, 255); stroke: rgb(255, 255, 255);
                    stroke-dashoffset: 25%; stroke-dasharray: 0 50%; stroke-width: 2;
                }
                70%  {fill: rgba(72,138,20,0); stroke: rgb(253, 253, 253); }
                80%  {fill: rgba(72,138,20,0); stroke: rgb(255, 255, 255); stroke-width: 3; }
                100% {
                    fill: rgb(202, 206, 211); stroke: rgb(253, 253, 253); 
                    stroke-dashoffset: -25%; stroke-dasharray: 50% 0; stroke-width: 0;
                }
            }
        </style>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <svg viewBox="0 0 1320 300">
                        <text x="50%" y="50%" dy=".35em" text-anchor="middle">
                            VSSI CLOUD
                        </text>
                    </svg>	
                    <div class="container">
                        
                        <div class="row justify-content-center">
                            <div class="col-lg">
                              
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header">
                                        <h3 class="text-center font-weight-light my-4">{{ __('Login') }}</h3>
                                    </div>
                                    <div class="card-body">
                                        <form method="POST" action="{{ route('login') }}">
                                            @csrf
                    
                                            <div class="form-group row">
                                                <label for="username" class="col-md-4 col-form-label text-md-right">{{ __('Username') }}</label>
                    
                                                <div class="col-md-6">
                                                    <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>
                    
                                                    @error('username')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                    
                                            <div class="form-group row">
                                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
                    
                                                <div class="col-md-6">
                                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                    
                                                    @error('password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                    
                    
                                            <div class="form-group row mb-0">
                                                <div class="col-md-8 offset-md-4">
                                                    <button type="submit" class="btn btn-primary">
                                                        {{ __('Login') }}
                                                    </button>
                    
                                                    
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; VSSI CLOUD {{date('Y')}}</div>
                            
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="{{ asset('js/js.js')}}" crossorigin="anonymous"></script>
        <script src="{{ asset('js/popper.js') }}"  crossorigin="anonymous"></script>
        <script src="{{ asset('js/bootstrap.min.js')}}" crossorigin="anonymous"></script>
        <script src="{{ asset('js/scripts.js')}}"></script>
       
    </body>
</html>
