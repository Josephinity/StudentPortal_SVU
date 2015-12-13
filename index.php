<!DOCTYPE html>
<html>
<head>
    <title>SVU</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="http://apps.bdimg.com/libs/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet">


    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>


    <![endif]-->
</head>
<body >




<script src= "https://ajax.googleapis.com/ajax/libs/angularjs/1.4.7/angular.min.js"></script>
<script src="https://code.jquery.com/jquery.js"></script>
<script src="smart-table.min.js"></script>

<table st-safe-src="rowCollection" st-table="displayCollection" st-set-filter="myStrictFilter" class="table table-striped" ng-app="myApp" ng-controller="filterCtrl">
    <thead>
    <tr>
        <th st-sort="firstName">first name</th>
        <th st-sort="lastName">last name</th>
        <th st-sort="strictSearchValue">strict search</th>
        <th st-sort="strictSelectValue">strict select</th>
    </tr>
    <tr>
        <th>
            <input st-search="firstName" placeholder="search for firstname" class="input-sm form-control" type="search"/>
        </th>
        <th>
            <input st-search="lastName" placeholder="search for lastname" class="input-sm form-control" type="search"/>
        </th>
        <th>
            <input st-search="strictSearchValue" placeholder="search for equal match" class="input-sm form-control" type="search"/>
        </th>
        <th>
            <select st-search="strictSelectValue">
                <option value="">All</option>
                <option ng-repeat="row in rowCollection | unique:'strictSelectValue'" value="{{row.strictSelectValue}}">{{row.strictSelectValue}}</option>
            </select>
        </th>
    </tr>
    </thead>
    <tbody>
    <tr ng-repeat="row in displayCollection">
        <td>{{row.firstName | uppercase}}</td>
        <td>{{row.lastName}}</td>
        <td>{{row.strictSearchValue}}</td>
        <td>{{row.strictSelectValue}}</td>
    </tr>
    </tbody>
</table>








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

            <?php
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "http://connect.svuca.edu/services/registration/student_class.php?studentID=A0229&token=2074188");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            $output = curl_exec($ch);
            curl_close($ch);
            $coursesInfo= json_decode($output,true,512);
            $courses=$coursesInfo['Data']['CLASS_DATA'];
            ?>
            <table style="width:100%" border="1">
                <tr>
                    <th>COURSE_NO</th>
                    <th>COURSE_TITLE</th>
                    <th>INSTR_NAME</th>
                    <th>AVAILABLE</th>
                    <th>DAY</th>
                    <th>TIME</th>
                    <th>FEE</th>
                </tr>
                <?php
                for($i=0;$i<count($courses);$i++){
                    echo '<tr><td>'.($courses[$i]['COURSE_NO']).'</td>';
                    echo '<td>'.($courses[$i]['COURSE_TITLE']).'</td>';
                    echo '<td>'.($courses[$i]['COURSE_INSTR']).'</td>';
                    echo '<td>'.($courses[$i]['COURSE_AVAILABLE']).'</td>';
                    echo '<td>'.($courses[$i]['COURSE_DAY']).'</td>';
                    echo '<td>'.($courses[$i]['COURSE_TIME']).'</td>';
                    echo '<td>'.($courses[$i]['COURSE_FEE']).'</td></tr>';
                }


                ?>
            </table>



        </div>
        <div class="span4">
        </div>
    </div>
</div>

<script>




    var app = angular.module('myApp', []);
    app.controller('filterCtrl', ['$scope', '$filter', function (scope, filter) {
        scope.rowCollection = [
            {firstName: 'Laurent', lastName: 'Renard', birthDate: new Date('1987-05-21'), balance: 102, email: 'whatever@gmail.com', strictSearchValue: "abc", strictSelectValue: "ab"},
            {firstName: 'Blandine', lastName: 'Faivre', birthDate: new Date('1987-04-25'), balance: -2323.22, email: 'oufblandou@gmail.com', strictSearchValue: "ab", strictSelectValue: "abc"},
            {firstName: 'Francoise', lastName: 'Frere', birthDate: new Date('1955-08-27'), balance: 42343, email: 'raymondef@gmail.com', strictSearchValue: "abc", strictSelectValue: "abc"}
        ];

        scope.displayCollection = [].concat(scope.rowCollection);

        scope.predicates = ['firstName', 'lastName', 'birthDate', 'balance', 'email'];
        scope.selectedPredicate = scope.predicates[0];
    } ]);

        app.filter('myStrictFilter', function($filter){
            alert('aa');
            return function(input, predicate){
                return $filter('filter')(input, predicate, true);
            }
        });

        app.filter('unique', function() {
            return function (arr, field) {
                var o = {}, i, l = arr.length, r = [];
                for(i=0; i<l;i+=1) {
                    o[arr[i][field]] = arr[i];
                }
                for(i in o) {
                    r.push(o[i]);
                }
                return r;
            };
        })

</script>

</body>
</html>