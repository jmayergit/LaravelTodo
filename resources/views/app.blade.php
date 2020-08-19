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
                background-color: rgb(238 238 238 / 12%);
                margin: 0px;
                font: 14px 'Helvetica Neue', Helvetica, Arial, sans-serif;
            }

            body > * {
                box-sizing: border-box;
            }

            input {
                font: inherit;
                font-weight: 100;
            }

            input:focus {
                outline: none; 
            }

            nav {
                height: 30px;
                background-color: beige;
                display: flex;
                align-items: center;
                padding: 10px 40px;
            }

            .view-container {
                max-width: 800px;
                margin: 0 auto;
            }

            .home {
                display: block;
            }

            button:focus {
                outline: none;
            }
        </style>
    </head>
    <body>
        <div id="app">
            <nav>
                <router-link to="/">
                    <div class="home">
                        @svg('home.svg', 'home')
                    </div>
                </router-link>
            </nav>
            <div class="view-container">
                <router-view></router-view>
            </div>
        </div>
        <script src="/js/app.js"></script>
    </body>
</html>
