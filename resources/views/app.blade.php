<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Todo</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <style>
            body {
                max-width: 800px;
                margin: 0 auto;
                background-color: rgb(238 238 238 / 12%);
            }

            body > * {
                box-sizing: border-box;
            }

            input:focus {
                outline: none; 
            }
        </style>
    </head>
    <body>
        <div id="app">
            <router-view></router-view>
        </div>
        <script src="/js/app.js"></script>
    </body>
</html>
