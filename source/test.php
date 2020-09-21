<?php

?>
<html>

<head>
    <style>
        #col div {
            background-color: magenta;
            height: 3%;
            border: solid 1px;
        }

        #log {
            background-color: black;
        }

        /* Small devices (landscape phones, 576px and up) */
        @media (min-width: 576px) {
            #log {
                background-color: red;
            }
        }

        /* Medium devices (tablets, 768px and up) */
        @media (min-width: 768px) {
            #log {
                background-color: green;
            }
        }

        /* Large devices (desktops, 992px and up) */
        @media (min-width: 992px) {
            #log {
                background-color: blue;
            }
        }

        /* // Extra large devices (large desktops, 1200px and up) */
        @media (min-width: 1200px) {
            #log {
                background-color: yellow;
            }
        }
    </style>
    <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.0/css/bootstrap.css">-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap-grid.min.css" integrity="sha512-QTQigm89ZvHzwoJ/NgJPghQPegLIwnXuOXWEdAjjOvpE9uaBGeI05+auj0RjYVr86gtMaBJRKi8hWZVsrVe/Ug==" crossorigin="anonymous" />

</head>

<body>
    <div class="container">
        <div class="row" id="col">
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 ">1</div>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 ">2</div>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 ">3</div>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 ">4</div>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 ">5</div>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 ">6</div>
        </div>
    </div>
    <div class="container-md">
        <div class="row" id="col">
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 ">1</div>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 ">2</div>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 ">3</div>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 ">4</div>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 ">5</div>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 ">6</div>
        </div>
    </div>
    <div class="container-lg">
        <div class="row" id="col">
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 ">1</div>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 ">2</div>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 ">3</div>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 ">4</div>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 ">5</div>
            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 ">6</div>
        </div>
    </div>
    <div id="log"></div>
    <script type="text/javascript">
        var viewport = '';
        viewport += 'document.documentElement.clientWidth 문서의 viewport크기 : ';
        viewport += document.documentElement.clientWidth;
        viewport += '<br>window.innerWidth 브라우저 viewport의 스크롤 포함 크기 : ';
        viewport += window.innerWidth;
        viewport += '<br>window.outerWidth 브라우저 창 크기 : ';
        viewport += window.outerWidth;
        viewport += '<br>document.documentElement.offsetWidth 문서의 크기 : ';
        viewport += document.documentElement.offsetWidth;
        viewport += '<br>screen.width 스크린 크기 : ';
        viewport += screen.width;

        document.getElementById('log').innerHTML = viewport;
    </script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.0/js/bootstrap.min.js"></script>
</body>

</html>