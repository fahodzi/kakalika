<html>
    <head>
    <title>Welcome to Ntentan</title>
        <style type="text/css">
            body{
                background-color:#a0a0a0;
                font-family:Droid Sans, Helvetica, Arial, Sans-Serif;
            }

            #wrapper {
                width: 700px;
                margin:30px;
                margin-left: auto;
                margin-right: auto;
                font-family: sans;
                font-size:small;
                background-color:#fff;
            }

            h1{
                margin:0px;
                background-color:#c0c0c0;
                padding:10px;
            }

            h2{
                margin:0px;
                padding:10px;
                padding-bottom: 0px;
                color:#808080;
            }

            p{
                padding:10px;
                padding-top:0px;
                margin:0px;
            }
            code
            {
                font-family:monospace;
                color:white;
                background-color: black;
                padding:5px;
                display:block;
                width:80%;
            }
        </style>
</head>
<body>
    <div id="wrapper">
        <h1>Ntentan PHP</h1>
        <h2>Congratulations!</h2>
        <p>
        If you are seeing this page then you have successfully setup your
        ntentan application. Next you might want to import or create your
        database schema.
        </p>

        <h2>Importing your database schema</h2>
        <p>
        You can execute the following command to import your database schema. 
        </p>
        <code>
        dev/ntentan schema import
        </code>
    </div>
</body>
</html>