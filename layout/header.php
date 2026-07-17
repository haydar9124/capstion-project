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
background:#f7f7f7;
}

.container{
width:100%;
max-width:430px;
margin:auto;
min-height:100vh;
background:white;
position:relative;
overflow:hidden;
}

.auth-header{
height:250px;
background:#ef4b2f;
border-bottom-left-radius:80px;
border-bottom-right-radius:80px;
display:flex;
justify-content:center;
align-items:center;
flex-direction:column;
}

.auth-header img{
width:120px;
}

.auth-header h2{
color:white;
margin-top:15px;
font-size:28px;
}

.form-box{
padding:25px;
}

.input-group{
margin-bottom:18px;
}

.input-group label{
display:block;
font-size:14px;
margin-bottom:5px;
}

.input-group input{
width:100%;
padding:13px;
border:1px solid #ddd;
border-radius:12px;
font-size:14px;
}

.btn{
width:100%;
border:none;
padding:14px;
background:#f4b64d;
color:black;
font-weight:bold;
border-radius:12px;
cursor:pointer;
font-size:16px;
}

.btn:hover{
opacity:0.9;
}

.text-center{
text-align:center;
}

.link{
color:#ef4b2f;
font-weight:600;
text-decoration:none;
}

.alert{
padding:12px;
margin-bottom:15px;
border-radius:10px;
}

.alert-danger{
background:#ffd7d7;
color:#b30000;
}

.alert-success{
background:#d7ffe0;
color:#006600;
}

</style>

</head>
<body>