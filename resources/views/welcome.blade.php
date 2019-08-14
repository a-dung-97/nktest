<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>NK Test</title>


    {{-- <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css"> --}}

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset(mix('css/app.css')) }}">
</head>

<body>
    <div id="app">
        <noscript>
            <div class="app flex-row align-items-center">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-6 p-3">
                            <h1 class="text-center text-md-left">
                                <i class="fa fa-warning fa-2x"></i>
                            </h1>
                            <h4 class="pt-3">Trình duyệt không được hỗ trợ hoặc bạn chưa bật Javascript</h4>
                            <p class="text-muted">
                                Thử một trình duyệt có hỗ trợ Javascript:
                                <a
                                    href="https://www.google.com/chrome/?brand=CHBD&gclid=CjwKCAjw6-_eBRBXEiwA-5zHaa78eJ_HfOScWr1D4PzHFZY2k2zRHc9pcHZ9gvAaHbljCsSC1gv0jBoCKIUQAvD_BwE&gclsrc=aw.ds">
                                    Google Chrome
                                </a>
                                hoặc
                                <a href="https://www.mozilla.org/en-US/">
                                    Mozilla Firefox
                                </a> hoặc kiểm tra cài đặt để chắc chắn bạn đã bật cho phép chạy Javascript
                                <br>
                                <a class="btn btn-primary mt-3" href="{{ url()->current() }}">
                                    Tải lại trang
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </noscript>
    </div>
    <script defer src="{{ asset(mix('js/app.js')) }}"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.5/MathJax.js?config=TeX-MML-AM_CHTML' async>
    </script>
</body>

</html>