<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        body{
            background-color: #f1f1f1;
        }
        .row.content {
            background-color: #f1f1f1;
        }
        /* Remove the navbar\'s default margin-bottom and rounded borders */
        .navbar {
            margin-bottom: 0;
            border-radius: 0;
        }
        .text-left{
            background-color: #fff;
            border-top: solid #636b6f 2px;
            padding-top: 15px;
            padding-bottom: 10px;
        }
        .result{
            background-color: #f1f1f1;
            border-bottom: dotted #495053 2px;
            padding-top: 10px;
            padding-bottom: 10px;
        }

        /* Set gray background color and 100% height */
        .sidenav {
            padding-top: 20px;
            height: 100%;
        }

        /* Set black background color, white text and some padding */
        footer {
            background-color: #555;
            color: white;
            padding: 15px;
        }

        /* On small screens, set height to \'auto\' for sidenav and grid */
        @media screen and (max-width: 767px) {
            .sidenav {
                height: auto;
                padding: 15px;
            }
            .row.content {height:auto;}
        }
    </style>
</head>
<body>
<div class="container-fluid text-center">