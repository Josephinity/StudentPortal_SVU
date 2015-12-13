<!DOCTYPE html>
<html>
<head>
    <title>SVU</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css" rel="stylesheet">



    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>


    <![endif]-->

    <script src="https://code.jquery.com/jquery.js"></script>
    <script src="http://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
    <script src="bootbox.min.js"></script>
</head>
<body >

<!-- Include bootbox.js -->
<script src="https://oss.maxcdn.com/bootbox/4.2.0/bootbox.min.js"></script>

<button class="btn btn-default" id="loginButton">Login</button>

<!-- The login modal. Don't display it initially -->
<form id="loginForm" method="post" class="form-horizontal" style="display: none;">
    <div class="form-group">
        <label class="col-xs-3 control-label">Username</label>
        <div class="col-xs-5">
            <input type="text" class="form-control" name="username" />
        </div>
    </div>

    <div class="form-group">
        <label class="col-xs-3 control-label">Password</label>
        <div class="col-xs-5">
            <input type="password" class="form-control" name="password" />
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-5 col-xs-offset-3">
            <button type="submit" class="btn btn-default">Login</button>
        </div>
    </div>
</form>





<script>














    $(document).ready(function() {


        // Login button click handler
        $('#loginButton').on('click', function() {
            bootbox
                .dialog({
                    title: 'Login',
                    message:'aa',
                    show: false // We will show it manually later
                })

                .modal('show');
        });
    });
</script>

</body>
</html>