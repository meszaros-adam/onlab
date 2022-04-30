<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="{{'css/main.css'}}" rel="stylesheet">
    <title>Eseménynaptár</title>
</head>
<body>
    <div id="app">
        @if(Auth::check())
        <mainapp :user="{{Auth::user()}}"> </mainapp>
        @else
        <mainapp :user="false"> </mainapp>
        @endif
    </div>
    <script src="{{mix('/js/app.js')}}"></script>
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.js"></script>
</body>
</html>