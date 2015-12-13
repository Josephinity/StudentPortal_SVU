<!DOCTYPE html>
<html>
<head>
    <title>SVU</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css" rel="stylesheet">

    <link href="https://cdn.datatables.net/1.10.9/css/dataTables.bootstrap.min.css" rel="stylesheet">


    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>


    <![endif]-->

    <script src="https://code.jquery.com/jquery.js"></script>
    <script src="http://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
    <script src="bootbox.min.js"></script>
</head>
<body >


<script>




    var token='2074188';
    function addCalss(classId,fee){
        $.ajax({ type: "GET",
            url: "/svu/api.php?action=addClass&token="+token+"&classId="+classId+"&fee="+fee,
            async: false,
            success : function(text)
            {
                response = text;
            }
        });

       // alert(response);

    }

    function dropClass(classId){
        $.ajax({ type: "GET",
            url: "/svu/api.php?action=dropClass&token="+token+"&classId="+classId,
        async: false,
            success : function(text)
        {
            response = text;
        }
    });

   // alert(response);

    }



    function isSelected( obj){
        for(var i =0; i<selectedCourse.length;i++){
            if(selectedCourse[i][0]==obj.COURSE_NO
                && selectedCourse[i][1]==obj.COURSE_DAY
                && selectedCourse[i][2]==obj.COURSE_TIME
                && selectedCourse[i][3]==obj.COURSE_INSTR_NAME
            ){
                return true;

            }
        }
        return false;

    }





    //  get selected course and mark this course can been drop
    var selectedCourse ;
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
        for(i=0;i<data.length;i++) {
            array1[i] = new Array();
            array1[i][0] = data[i].COURSE_NO;
            array1[i][1] = data[i].COURSE_DAY;
            array1[i][2] = data[i].COURSE_TIME;
            array1[i][3] = data[i].COURSE_INSTR_NAME;
        }
        selectedCourse =array1;
    });



    var dataSet ;

    $(document).ready(function(){
        var response = '';
        var data='';
        $.ajax({ type: "GET",
            url: "/svu/api.php?action=getStudentClass&token="+token,
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

            if(isSelected(data[i])){
                array1[i][6] = "<a href='' id="+data[i].COURSE_ID+" class='editor_edit btn btn-primary'>Drop</a>";
            }else{
              //  if(same couse is not  been selected)
                array1[i][6] = "<a href='' id="+data[i].COURSE_ID+" class='editor_edit btn btn-primary'>Add</a>";

            }


        }
        dataSet =array1;
    });




    $(document).ready(function() {
        var table=$('#example').DataTable( {
            data: dataSet,
            columns: [
                { title: "COURSE_NO" },
                { title: "COURSE_TITLE" },
                { title: "COURSE_DAY" },
                { title: "COURSE_TIME" },
                { title: "COURSE_INSTR_NAME" },
                { title: "COURSE_FEE" },
                { title: "ACTION" }
            ],

        } );

      //  $('#monday, #saturday.,#tuesday,#wednesday,#thursday,#friday ,#sunday').click( function() {
        $('#monday,#tuesday,#wednesday,#thursday,#friday,#saturday,#sunday').click( function() {
            table.draw();
        } );

        $('#example tbody').on( 'click', 'a', function () {
            var data = table.row( $(this).parents('tr') ).data();
           var action=$(this).html();

            if(action=='Add'){
                alert( 'Are you sure you want to add COURSE_NO: '+data[0] +"  COURSE_TITLE: "+data[1] +"  COURSE_DAY:"+data[2]+"  COURSE_TIME: "+ data[3] + "  COURSE_INSTR_NAME: "+data[ 4 ]+ "  COURSE_FEE:  "+data[ 5] );
                addCalss($(this).attr('id'),data[ 5]);
            }
            if(action=='Drop'){
                alert( 'Are you sure you want to drop COURSE_NO: '+data[0] +"  COURSE_TITLE: "+data[1] +"  COURSE_DAY:"+data[2]+"  COURSE_TIME: "+ data[3] + "  COURSE_INSTR_NAME: "+data[ 4 ]+ "  COURSE_FEE:  "+data[ 5] );
                dropClass($(this).attr('id'));
            }
            e.preventDefault();
        } );



    } );


    $.fn.dataTable.ext.search.push(
        function( settings, data, dataIndex ) {
            var dayOfWeek = $('#dayOfWeek').val();
            if ( data[2]==dayOfWeek )
            {
                return true;
            }
            return false;
        }
    );


    bootbox.alert("Hello world!", function() {
        Example.show("Hello world callback");
    });


</script>

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

            <table border="0" cellspacing="5" cellpadding="5">
                <tbody><tr>

                    <td><input style="display: none"  type="text" id="dayOfWeek" value="Monday" ></td>
                </tr>
                <tr>

                    <td>
                        <a href='#' id="monday" class='editor_edit btn btn-primary'  onclick="$('#dayOfWeek').val('Monday')">Monday</a>
                        <a href='#' id="tuesday" class='editor_edit btn btn-primary'  onclick="$('#dayOfWeek').val('Tuesday')">Tuesday</a>
                        <a href='#' id="wednesday" class='editor_edit btn btn-primary'  onclick="$('#dayOfWeek').val('Wednesday')">Wednesday</a>
                        <a href='#' id="thursday" class='editor_edit btn btn-primary'  onclick="$('#dayOfWeek').val('Thursday')">Thursday</a>
                        <a href='#' id="friday" class='editor_edit btn btn-primary'  onclick="$('#dayOfWeek').val('Friday')">Friday</a>
                        <a href='#' id="saturday" class='editor_edit btn btn-primary'  onclick="$('#dayOfWeek').val('Saturday')">Saturday</a>
                        <a href='#' id="sunday" class='editor_edit btn btn-primary'  onclick="$('#dayOfWeek').val('Sunday') ">Sunday</a>

                 </td>
                </tr>
                </tbody>

                <table id="example" class="table table-striped table-bordered dataTable" width="100%" cellspacing="0" role="grid" aria-describedby="example_info" style="width: 100%;">


        </div>
        <div class="span4">
        </div>
    </div>
</div>



</body>
</html>