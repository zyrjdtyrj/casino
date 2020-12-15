<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>@yield('title')</title>
</head>
<body class="bg-dark text-white">
    <div class="cover-container d-flex  p-3 mx-auto flex-column">
        <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-dark border-bottom box-shadow">
            <h5 class="my-0 text-white mr-md-auto font-weight-normal">Test Casino</h5>
            <nav class="my-2 my-md-0 mr-md-3">
                <a class="p-2 text-white" href="#">Features</a>
                <a class="p-2 text-white" href="#">Enterprise</a>
                <a class="p-2 text-white" href="/registration">Registration</a>
                <a class="p-2 text-white="#">Pricing</a>
            </nav>
            <a class="btn btn-warning" href="/signin">Sign up</a>
        </div>
    </div>
    <div class="container pb-5">
        <h1>@yield('title')</h1>
        @yield('body')
    </div>
</body>
</html>
