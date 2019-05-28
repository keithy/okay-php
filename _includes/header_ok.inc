<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <!-- If IE use the latest rendering engine -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- Set the page to the width of the device and set the zoon level -->
    <meta name="viewport" content="width = device-width, initial-scale = 1">
    <title><?= $title ?></title>

    <style>
        .suite {
            margin: 7px;
            border: 1px solid black;
            padding: 5px
        }

        .output {
            margin-top: 7px;
            white-space: pre;
            font-family: monospace;
        }

        .test {
            margin: 7px;
            border: 1px dotted green;
            padding: 5px
        }

        .result {
            text-align: right;
            /*      float: right; */
        }

        .success em {
            background-color: LightGreen
        }

        .fail em {
            background-color: OrangeRed
        }

    </style>
</head>
<body>