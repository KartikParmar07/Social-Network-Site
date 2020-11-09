<?php
// post retrieval code_______________________________________________________________________________________
session_start();
 $connect = new PDO('mysql:host=127.0.0.1; dbname=socialnetwork;','root','kartik');
		      $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
			   $username=$_SESSION["username"];
			   
$pid=$_POST['pid'];
$user=$_SESSION["username"];
$action=$_POST['action'];
if ($action=='like'){
 $sql=$dbh->prepare("SELECT * FROM likes WHERE pid=? and user=?");
 $sql->execute(array($pid,$user));
 $matches=$sql->rowCount();
 if($matches==0){
 $sql=$dbh->prepare("INSERT INTO likes (pid, user) VALUES(?, ?)");
 $sql->execute(array($pid,$user));
 $sql=$dbh->prepare("UPDATE posts SET likes=likes+1 WHERE id=?");
 $sql->execute(array($pid));
 }else{
 die("There is No Post With That ID");
 }
}
if ($action=='unlike'){
 $sql = $dbh->prepare("SELECT 1 FROM likes WHERE pid=? and user=?");
 $sql->execute(array($pid,$user));
 $matches = $sql->rowCount();
 if ($matches != 0){
 $sql=$dbh->prepare("DELETE FROM likes WHERE pid=? AND user=?");
 $sql->execute(array($pid,$user));
 $sql=$dbh->prepare("UPDATE posts SET likes=likes-1 WHERE id=?");
 $sql->execute(array($pid));
 }
}