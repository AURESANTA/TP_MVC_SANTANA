<?php
        session_start();
        require('model/postManager.php');

function showPosts() {


    $posts = getPosts();
    require('view/indexView.php');

}

function showPost() {

    
        $post = getPost($_GET['id']);
        $comments = getComments($_GET['id']);
        require('view/postView.php');

}

function addPost($title, $author, $content, $imagePath, $idUser ,$idCategory) {

    $newPost = newPost($title, $author, $content, $imagePath, $idUser, $idCategory);

    if ($newPost === false) {
        die('Action impossible, désolé.');   
    }
    else {
        header('Location: index.php?action=showPosts');
    }

}

function addComment($idPost, $author, $content) {

    require('model/commentsManager.php');
    $newComment = postComment($idPost, $author, $content);

    if ($newComment === false) {
        die('Action impossible, désolé.');   
    }
    else {
        header('Location: index.php?action=showPost&id=' . $idPost);
    }
}

function showLogin() {
    require('view/loginView.php');
}

function showUser() {

    $categories = getCategories();
    require('view/userView.php');
}

function newUser($username, $password) {

    require('model/userManager.php');

    $hashpassword = password_hash($password, PASSWORD_DEFAULT);
    $newUser = addUser($username, $hashpassword);

    header('Location: index.php?action=showLogin');

}

function verifyUser($username, $password) {

    require('model/userManager.php');
    $resultat = logUser($username);

    $correctPassword = (password_verify($password, $resultat['password']));

    if($correctPassword) {
        $_SESSION['username'] = $username;
        $_SESSION['id'] = $resultat['id'];
        header('Location: index.php?action=showPosts');
    }
    elseif(!$correctPassword) {
        header('Location: index.php?action=showLogin');
    }
}

function disconnectUser() {

    session_destroy();
    
    header('Location: index.php?action=showPosts');
}

function getImgUrl()
{
    $target_dir = "SRC/IMG/";
    $target_file = $target_dir . basename($_FILES['imagePath']['name']);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if($imageFileType == "jpg" OR $imageFileType == "png" OR $imageFileType == "jpeg"
    OR $imageFileType == "gif" ){
        if ($_FILES["imagePath"]["size"] <= 4000000){
            move_uploaded_file($_FILES['imagePath']['tmp_name'], $target_file);
        }
        else{
            echo 'Fichier trop volumineux, 4Mo maximum';
        }
    }
    else{
        echo 'Extension d\'image incompatible, veuillez charger une image .jpg, .png, .jpeg, .gif';
    }
    return $target_file;
}
