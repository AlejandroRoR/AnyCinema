<!DOCTYPE html>
<!-- saved from url=(0028)http://example.com/image.png -->
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style type="text/css">
        body {
            background-color: #ffffff;
            margin: 0;
            padding: 0;
            font-family: -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", "Open Sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
            
        }
        div {
            width: 600px;
            
            margin: 2em auto;
            padding: 2em;
            background-color: #ececec;
            border-radius: 0.5em;
            box-shadow: 2px 3px 7px 2px rgba(0,0,0,0.02);
        }
        h1{
            text-align: center;
        }
        p{
            text-align: center;
        }
        a:link, a:visited {
            color: #38488f;
            text-decoration: none;
        }
        @media (max-width: 700px) {
            div {
                margin: 0 auto;
                width: auto;
            }
        }

        </style>    
    </head>

<body>
    @foreach ($tickets as $t)
    <div>
        <h1>AnyCinema</h1>
        <hr>
        <p>FILA: {{ $t->fila }}</p>
        <p>BUTACA: {{ $t->columna }}</p>
        <p>{{ $t->precio }} €</p>
    </div>
    @endforeach


</body>
</html>

