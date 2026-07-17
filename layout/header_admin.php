<?php
if(session_status()==PHP_SESSION_NONE){
    session_start();
}
?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>E-Warung Admin</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins',sans-serif;
}

body{
background:#f4f6f9;
}

::-webkit-scrollbar{
width:7px;
}

::-webkit-scrollbar-thumb{
background:#ef4b2f;
border-radius:10px;
}

.container{

width:100%;
max-width:430px;
margin:auto;
background:white;
min-height:100vh;
box-shadow:0 0 15px rgba(0,0,0,.08);
overflow:hidden;

}

.topbar{

height:65px;
background:#ef4b2f;
display:flex;
justify-content:space-between;
align-items:center;
padding:0 18px;
color:white;
position:sticky;
top:0;
z-index:999;

}

.topbar-left{

display:flex;
align-items:center;
gap:12px;

}

.topbar-left a{

color:white;
font-size:20px;
text-decoration:none;
transition:.3s;

}

.topbar-left a:hover{

transform:translateX(-3px);

}

.topbar-title{

font-size:18px;
font-weight:600;

}

.page-content{

padding:18px;
padding-bottom:50px;

}

.card{

background:white;
padding:18px;
margin-bottom:18px;
border-radius:18px;
border:none;
box-shadow:0 3px 12px rgba(0,0,0,.08);
transition:.25s;

}

.card:hover{

transform:translateY(-3px);
box-shadow:0 6px 20px rgba(0,0,0,.12);

}

.btn-primary,
.btn-success,
.btn-warning,
.btn-danger{

display:block;
width:100%;
padding:13px;
border:none;
border-radius:12px;
text-decoration:none;
text-align:center;
font-weight:600;
color:white;
cursor:pointer;
transition:.3s;

}

.btn-primary{

background:#ef4b2f;

}

.btn-success{

background:#16a34a;

}

.btn-warning{

background:#f59e0b;

}

.btn-danger{

background:#dc2626;

}

.btn-primary:hover,
.btn-success:hover,
.btn-warning:hover,
.btn-danger:hover{

opacity:.9;
transform:scale(1.02);

}

input,
textarea,
select{

width:100%;
padding:12px;
margin-top:5px;
margin-bottom:15px;
border:1px solid #ddd;
border-radius:12px;
outline:none;
transition:.2s;

}

input:focus,
textarea:focus,
select:focus{

border-color:#ef4b2f;
box-shadow:0 0 5px rgba(239,75,47,.25);

}

img{

max-width:100%;
display:block;

}

.badge-success{

background:#16a34a;
color:white;
padding:6px 12px;
border-radius:20px;
font-size:13px;

}

.badge-warning{

background:#f59e0b;
color:white;
padding:6px 12px;
border-radius:20px;
font-size:13px;

}

.badge-danger{

background:#dc2626;
color:white;
padding:6px 12px;
border-radius:20px;
font-size:13px;

}

.progress{

height:10px;
background:#e5e7eb;
border-radius:20px;
overflow:hidden;

}

.progress-bar{

height:10px;

}

table{

width:100%;
border-collapse:collapse;

}

table th{

background:#ef4b2f;
color:white;
padding:12px;

}

table td{

padding:12px;
border-bottom:1px solid #eee;

}

canvas{

margin-top:15px;

}

.text-center{

text-align:center;

}

.text-right{

text-align:right;

}

.text-success{

color:#16a34a;

}

.text-danger{

color:#dc2626;

}

.text-warning{

color:#f59e0b;

}

.text-primary{

color:#ef4b2f;

}

.mt-1{margin-top:10px;}
.mt-2{margin-top:20px;}
.mt-3{margin-top:30px;}

.mb-1{margin-bottom:10px;}
.mb-2{margin-bottom:20px;}
.mb-3{margin-bottom:30px;}

</style>

</head>

<body>