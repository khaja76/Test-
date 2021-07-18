<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>404 Page Not Found</title>
    <script src="https://use.fontawesome.com/5d8239ef1b.js"></script>
    <style type="text/css">

        ::selection {
            background-color: #E13300;
            color: white;
        }

        ::-moz-selection {
            background-color: #E13300;
            color: white;
        }

        body {
            background-color: #f3f0f0;
            margin: 0;
            padding: 0;
            /*margin: 40px;
            font: 13px/20px normal Helvetica, Arial, sans-serif;
            color: #4F5155;*/
        }

        #container {
            text-align: center;
            position: absolute;
            width: 100%;
            top: 50%;
            margin-top: -18%;
            font-family: cursive;
            font-weight: bold;
            letter-spacing: 0.2em;
        }

        h1 {
            font-size: 200px;
            margin: 20px 0;
            /*color: #fe7902;*/
            color: #FFF;
            font-weight: 500;
        }

        h1 span {
            background: #dd3030;
            padding: 0 50px;
            border-radius: 2rem;
        }

        p {
            font-size: 35px;
            /*color: #b3aaa0;*/
            color: #dd3030;
            margin: 20px 0;
        }

        /*a {
            color: #003399;
            background-color: transparent;
            font-weight: normal;
        }

        h1 {
            color: #444;
            background-color: transparent;
            border-bottom: 1px solid #D0D0D0;
            font-size: 19px;
            font-weight: normal;
            margin: 0 0 14px 0;
            padding: 14px 15px 10px 15px;
        }

        code {
            font-family: Consolas, Monaco, Courier New, Courier, monospace;
            font-size: 12px;
            background-color: #f9f9f9;
            border: 1px solid #D0D0D0;
            color: #002166;
            display: block;
            margin: 14px 0 14px 0;
            padding: 12px 10px 12px 10px;
        }

        #container {
            margin: 10px;
            border: 1px solid #D0D0D0;
            box-shadow: 0 0 8px #D0D0D0;
        }

        p {
            margin: 12px 15px 12px 15px;
        }*/
    </style>
</head>
<body>
<div id="container">
    <div>
        <h1><span> <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> 404</span></h1>
        <p>Sorry - File not Found!</p>
    </div>
    <!--<h1><?php /*echo $heading; */ ?></h1>
		--><?php /*echo $message; */ ?>
</div>
</body>
</html>