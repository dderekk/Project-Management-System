<!DOCTYPE html>
<html>
<head>
  <title>@yield('title')</title>
  <meta charset="UTF-8" />

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

  <!-- My CSS -->
  <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}" /> 

</head>

<body>
    <!-- Display User's Name and Type -->
    @if(Auth::check())
        <div class="text-center">
            <strong>{{ Auth::user()->name }}</strong> - 
            <span>{{ Auth::user()->type }}</span>
        </div>
    @endif

    <div class="jumbotron text-center" style="margin-bottom:0">
        <h1>@yield('heading')</h1>
        <p>@yield('intro')</p> 
    </div>

    
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">❤</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="{{url('/u')}}">Home<span class="sr-only">(current)</span></a>
                </li>
                <li>
                    <a class="nav-link" href="{{url('/plist')}}">All Projects<span class="sr-only">(current)</span></a>
                </li>
                @if(Auth::check() && Auth::user()->type === 'Industry Partner')
                <li class="nav-item">
                    <a class="nav-link" href="{{url('/project/create')}}">Create Project<span class="sr-only">(current)</span></a>
                </li>
                @elseif(Auth::check() && Auth::user()->type === 'Student')
                <li class="nav-item">
                    <a class="nav-link" href="{{url('/application/create')}}">Apply Project<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/profile/show/' . Auth::user()->id) }}">Profile<span class="sr-only">(current)</span></a>
                </li>
                @elseif(Auth::check() && Auth::user()->type === 'Teacher')
                <li class="nav-item">
                    <a class="nav-link" href="{{url('/profile/all')}}">View All Profiles<span class="sr-only">(current)</span></a>
                </li>
                @endif
            </ul>
            <ul class="navbar-nav">
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('login')}}">Log in</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('register')}}">Register</a>
                    </li>   
                @else
                    <li class="nav-item">
                        <label class="nav-link">Welcome {{Auth::user()->name}}</label>
                    </li>
                    <li class="nav-item">
                        <form class="nav-link" method="POST" action="{{url('/logout')}}">
                            {{csrf_field()}}
                            <input type="submit" value="Logout">
                        </form>
                    </li>
                @endguest
            </ul>
        </div>
    </nav>

    @if(session('error'))
        <div class = "alert">
            <ul>
                <li>{{session('error')}}</li>
            </ul>
        </div>
    @endif

    @yield('content')
    
    <!-- Bootstrap JavaScript and Popper.js -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
