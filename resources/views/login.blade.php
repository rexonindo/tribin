<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <link rel="icon" href="{{ url('assets/fiximgs/favicon.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors, Ana Suryana">
    <title>JAT Integrated Online System</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ url('assets/fontaw/css/all.css') }}" rel="stylesheet">
    <link href="{{ url('assets/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <script src="{{ url('assets/jquery/jquery.min.js') }} "></script>
    <script type="text/javascript" src="{{ url('assets/js/js.cookie.min.js') }}"></script>
    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>
    <!-- Custom styles for this template -->
    <link href=" {{ url('assets/bootstrap/ovrcss/signin.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col">
                @if(session('error'))
                <div class="alert alert-danger">
                    <b>duh</b> {{session('error')}}
                </div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col">
                <form action="{{route('actionlogin')}}" class="form-signin" method="post">
                    @csrf
                    <div class="row">
                        <div class="col mb-4">
                            <h1 class="display-4 text-primary mb-0"><a href="/">JOS</a></h1>
                            JAT Integrated Online System <i class="fas fa-link"></i>
                        </div>
                    </div>
                    <div class="row" id="lnwarning">
                        <div class="col">
                            <div class="alert alert-warning" role="alert">
                                Please fill <strong>UserID</strong> first
                            </div>
                        </div>
                    </div>
                    <div class="row" id="ln1">
                        <div class="col">
                            <input type="text" name="inputUserid" id="inputUserid" class="form-control" placeholder="UserID" required autocomplete="off" autofocus>
                            <div class="d-grid">
                                <button type="button" class="btn btn-primary" id="btnnext">Next</button>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="ln2">
                        <div class="col">
                            <a href="" id="btnback" title="back">Login as another account ?</a> <br><br>
                            <input type="password" name="inputPassword" id="inputPassword" class="form-control" placeholder="Password" required>
                            <div class="d-grid">
                                <button class="btn btn-primary btn-block" type="submit" onclick="btnLogin_eClick(event)">Sign in</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function btnLogin_eClick(e) {
            e.preventDefault()
            if (inputUserid.value.length <= 3) {
                inputUserid.focus()
                return
            }
            if (inputPassword.value.length <= 5) {
                inputPassword.focus()
                return
            }
            const data = {
                inputUserid: inputUserid.value,
                inputPassword: inputPassword.value,
                _token: '{{ csrf_token() }}',
            }
            e.target.disabled = true
            $.ajax({
                type: "POST",
                url: "{{route('actionlogin')}}",
                data: data,
                dataType: "json",
                success: function(response) {
                    e.target.disabled = false
                    if (!response.tokennya) {
                        alert(response.message)
                        inputUserid.value = ''
                        inputPassword.value = ''
                        $("#ln2").hide('slow', function() {
                            $("#ln1").show();
                            $("#inputUserid").focus();
                            $("#inputUserid").select();
                        });
                    } else {
                        console.log(response)
                        sessionStorage.setItem('tokenGue', response.tokennya)
                        Cookies.set('CGID', response.data.connection, {
                            expires: 365
                        });
                        Cookies.set('CGNM', response.data.name, {
                            expires: 365
                        });
                        location.href = '/home'
                    }
                },
                error: function(xhr, xopt, xthrow) {
                    alert(xthrow)
                    e.target.disabled = false
                }
            });
        }
        $("#lnwarning").hide();
        $("#ln2").hide();
        $("#inputUserid").keypress(function(e) {
            if (e.key === 'Enter') {
                if ($(this).val() != "") {
                    $("#ln1").slideUp('slow', function() {
                        $("#ln2").show();
                        $("#inputPassword").focus();
                    });
                } else {
                    $("#lnwarning").show();
                }
                e.preventDefault();
            }
        });
        $("#inputUserid").keydown(function(e) {
            $("#lnwarning").hide();
        });
        $("#btnback").click(function(e) {
            e.preventDefault();
            $("#ln2").hide('slow', function() {
                $("#ln1").show();
                $("#inputUserid").focus();
                $("#inputUserid").select();
            });
        });
        $("#btnnext").click(function(e) {
            if ($("#inputUserid").val() != "") {
                $("#ln1").slideUp('slow', function() {
                    $("#ln2").show();
                    $("#inputPassword").focus();
                });
            } else {
                $("#lnwarning").show();
            }
        });
    </script>
</body>

</html>