<?php

include_once('dbManager.php');


function postComment($idPost, $author, $content)
{
    $db = dbConnect();
    $comments = $db->prepare('INSERT INTO comments(idPost, author, content) VALUES(?, ?, ?)');
    $newComment = $comments->execute(array($idPost, $author, $content));

    return $newComment;
}