<?php
     if($_SERVER['REQUEST_METHOD'] == 'POST' )
     {
        $word = $_POST['word'];
        if(strlen($word) >= 3){
            $comments = json_decode(file_get_contents('https://jsonplaceholder.typicode.com/comments'));      
            $arr = array();
            foreach($comments as $comment){
            $words = explode(" ", $comment->{'body'});
                foreach($words as $value){
                    if(stripos($value, $word) !== false){
                        $arr[] = $comment;
                    }   
                } 
            }   
        }
        else echo "минимум 3 символа";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="POST">
        <input type="text" name='word'>
        <input type="submit" value="Найти" />
    </form>
</body>
</html>
<pre>
    <?php if($arr != null) print_r($arr) ?>
</pre>
