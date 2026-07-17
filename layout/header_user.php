<?php
if(session_status() == PHP_SESSION_NONE){
session_start();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>E-Warung</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;
}

body{
background:#f4f4f4;
}

.container{
width:100%;
max-width:430px;
margin:auto;
background:white;
min-height:100vh;
position:relative;
overflow:hidden;
}

.topbar{
height:60px;
background:#ef4b2f;
display:flex;
align-items:center;
justify-content:space-between;
padding:0 18px;
color:white;
}

.topbar-left{
display:flex;
align-items:center;
gap:12px;
}

.topbar-left a{
color:white;
text-decoration:none;
font-size:18px;
}

.topbar-title{
font-size:17px;
font-weight:600;
}

.page-content{
padding:20px;
padding-bottom:90px;
}

.card{
background:white;
padding:15px;
border-radius:15px;
margin-bottom:15px;
box-shadow:0 2px 8px rgba(0,0,0,.08);
}

.btn-primary{
width:100%;
display:block;
padding:14px;
background:#ef4b2f;
color:white;
text-decoration:none;
border:none;
border-radius:12px;
text-align:center;
font-weight:600;
cursor:pointer;
}

.btn-danger{
width:100%;
display:block;
padding:14px;
background:red;
color:white;
text-decoration:none;
border:none;
border-radius:12px;
text-align:center;
font-weight:600;
cursor:pointer;
}

input,
textarea,
select{
width:100%;
padding:12px;
border:1px solid #ddd;
border-radius:12px;
margin-top:5px;
margin-bottom:15px;
font-size:14px;
}

img{
max-width:100%;
display:block;
}

</style>

</head>

<body>