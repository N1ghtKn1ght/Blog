<?php 
    include($_SERVER['DOCUMENT_ROOT']."\db\Models\post.php");
    include($_SERVER['DOCUMENT_ROOT']."\db\Models\comment.php");

    $postJSON = file_get_contents('https://jsonplaceholder.typicode.com/posts');
    $commentJSON = file_get_contents('https://jsonplaceholder.typicode.com/comments');

    $posts = WriteInArray($postJSON, new post);
    $comments = WriteInArray($commentJSON, new comment);

    $QueryAddPostsInDB = CreateQueryDB('post', $posts, new post);
    $QueryAddCommentInDB = CreateQueryDB('comment', $comments, new comment);

    echo "Загружено ".count($posts)." записей и ".count($comments)." комментариев";
    
    function WriteInArray($JSON, $Model){
        $arr =array();
        foreach(json_decode($JSON) as $value){
            $model = new $Model;
            foreach($value as $key=> $value){
                $model->$key = $value;
            }  
            $arr[] = $model;
        }
        return $arr;
    }

    function CreateQueryDB(string $NameDB, array $Arr, $Model){
        $query = "INSERT INTO ".$NameDB." (";
        foreach($Model as $key => $value)
        {
            $query .= $key.",";
        }
        $query = substr($query,0,-1).") VALUES ";
        foreach($Arr as $values){
            $query .= "(";
            foreach($values as $value)
                $query .= "'".$value."',";
            $query = substr($query,0,-1)."), ";
        }
        $query = substr($query,0,-2)."; ";
        return $query;
    }

?>