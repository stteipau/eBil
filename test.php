<html>
    <head>

    </head>

    <body>

        <form name="form1" action="" method="post">

            <input id="in1" name="user" type="text">
        </form>
    </body>

    <?php
        if(isset($_POST['user'])){
            echo 'Post:'.$_POST['user'];
        }else{
            echo 'Kein Post!';
        }
    ?>
</html>