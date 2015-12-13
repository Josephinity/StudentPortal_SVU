<!DOCTYPE html>
<html>
<head>
    <title>SVU</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://code.jquery.com/jquery.js"></script>

    <link href="http://cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>



    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

    <!-- Latest compiled and minified JavaScript -->


    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>


    <![endif]-->

    <script src="http://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
    <script src="bootbox.min.js"></script>

</head>
<body >

<div id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- dialog body -->
            <div class="modal-body">

                <div id="tokenDiv" class="form-group has-feedback">
                    <label for="token">Please give you token(Token is required) </label>
                    <input type="text" class="form-control" id="token" placeholder="">
                    <span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>
                    <span id="inputError2Status" class="sr-only">(error)</span>
                </div>




            </div>
            <!-- dialog buttons -->
            <div class="modal-footer"><button type="button"  onclick="getCourse()" id="getCourse" class="btn btn-primary">Get Courses</button></div>
        </div>
    </div>
</div>
<button type="button" data-toggle="modal" data-target="#myModal">Launch modal</button>
<script>

    function getCourse(){
        alert($("#token").val());
        $("#tokenDiv").addClass("has-error");

    }


    $("#myModal").on("show", function() {    // wire up the OK button to dismiss the modal when shown
        $("#myModal a.btn").on("click", function(e) {
            console.log("button pressed");   // just as an example...
            $("#myModal").modal('hide');     // dismiss the dialog
        });
    });
    $("#myModal").on("hide", function() {    // remove the event listeners when the dialog is dismissed
        $("#myModal a.btn").off("click");
    });

    $("#myModal").on("hidden", function() {  // remove the actual elements from the DOM when fully hidden
        $("#myModal").remove();
    });

    $("#myModal").modal({                    // wire up the actual modal functionality and show the dialog
        "backdrop"  : "static",
        "keyboard"  : true,
        "show"      : true                     // ensure the modal is shown immediately
    });
</script>



<script>
    var dataSet ;
    var token='2074188';
    $(document).ready(function(){
        var response = '';
        var data='';
        $.ajax({ type: "GET",
            url: "/svu/api.php?action=getStudentRecord&token="+token,
            async: false,
            success : function(text)
            {
                response = text;
            }
        });
        var obj = JSON.parse(response);
        response=obj.response;
        data=obj.Data.CLASS_DATA;
        var array1=new Array();
        for(i=0;i<data.length;i++){
            array1[i]=new Array();
            array1[i][0] = data[i].COURSE_NO;
            array1[i][1] = data[i].COURSE_TITLE;
            switch(data[i].COURSE_DAY)
            {
                case '01':
                array1[i][2] ='Monday'
                    break;
                case '02':
                array1[i][2] ='Tuesday'
                    break;
                case '03':
                    array1[i][2] ='Wednesday'
                    break;
                case '04':
                    array1[i][2] ='Thursday'
                    break;
                case '05':
                    array1[i][2] ='Friday'
                    break;
                case '06':
                    array1[i][2] ='Saturday'
                    break;
                case '07':
                    array1[i][2] ='Sunday'
                    break;
            }
            array1[i][3] = data[i].COURSE_TIME;
            array1[i][4] = data[i].COURSE_INSTR_NAME;
            array1[i][5] = data[i].COURSE_FEE;

        }
        dataSet =array1;
    });


    $(document).ready(function() {
        var table =$('#data').DataTable( {
            data: dataSet,
            columns: [
                { title: "COURSE_NO" },
                { title: "COURSE_TITLE" },
                { title: "COURSE_DAY" },
                { title: "COURSE_TIME" },
                { title: "COURSE_INSTR_NAME" },
                { title: "COURSE_FEE" }
            ]
        } );



        table.rows().every( function () {

            this.child( 'Row details for row: '+this.index() );
        } );

        $('#data tbody').on( 'click', 'tr', function () {
            var child = table.row( this ).child;

            if ( child.isShown() ) {
                child.hide();
            }
            else {
                child.show();
            }
        } );

    } );


    $(document).ready(function() {


        // Login button click handler
        $('#loginButton').on('click', function() {
            bootbox.alert("Hello world!", function() {
               // Example.show("Hello world callback");
            });
        });
    });



</script>
<button class="btn btn-default" id="loginButton">Login</button>
<div class="container">
    <div class="row">
        <div class="span4">
        </div>
        <div class="span4">
            <h2 class="text-error">
                Welcome Wenjun Ma
            </h2>
        </div>
        <div class="span4">
        </div>
    </div>
    <div class="row">
        <div class="span4">
        </div>
        <div class="span4">
            <ul class="nav nav-tabs">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="/main">Account</a></li>
                    <li><a href="#">Grade</a></li>
                    <li class="active"><a href="#">Registration</a></li>

                </ul>

            </ul>




            <table id="data" class="display" width="100%"></table>

        </div>
        <div class="span4">
        </div>
    </div>
</div>



</body>
</html>