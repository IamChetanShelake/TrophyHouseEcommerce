<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Designer Panel - @yield('title')</title>
    <link rel="stylesheet" href="{{ asset('admin/assets/css/style.css') }}">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                @include('designer.sidebar')
            </div>
            <div class="col-md-9">
                <div class="p-4">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
</body>

</html>
