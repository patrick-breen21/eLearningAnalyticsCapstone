<?php
session_start();
$site_url = "http://{$_SERVER['HTTP_HOST']}/capstone/";
$root     = "{$_SERVER['DOCUMENT_ROOT']}/capstone";

$dev = false;
//Start the Session
?>

<html class="no-js webkit safari safari0 js gr__smallprojects_info" dir="ltr" lang="en"><!--<![endif]-->
<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
    <link href="./qut-home_files/css" rel="stylesheet" type="text/css"/>
    <style type="text/css">
        .gm-style .gm-style-cc span,.gm-style .gm-style-cc a,.gm-style .gm-style-mtc div{font-size:10px}
    </style>
    <style type="text/css">
        @media print {  .gm-style .gmnoprint, .gmnoprint {    display:none  }}@media screen {  .gm-style .gmnoscreen, .gmnoscreen {    display:none  }}
    </style>
    <style type="text/css">
        .gm-style-pbc{transition:opacity ease-in-out;background-color:rgba(0,0,0,0.45);text-align:center}.gm-style-pbt{font-size:22px;color:white;font-family:Roboto,Arial,sans-serif;position:relative;margin:0;top:50%;-webkit-transform:translateY(-50%);-ms-transform:translateY(-50%);transform:translateY(-50%);}
    </style>
    <meta content="IE=edge" http-equiv="X-UA-Compatible"/>
    <title>
        Home - Learning Analytics
    </title>
    <meta content="minimum-scale=1.0, maximum-scale=1.0, user-scalable=no, initial-scale=1.0" name="viewport"/>
    <!-- Start Cache Control -->
    <!-- Metadata Cache Control-->
    <meta content="max-age=0" http-equiv="cache-control"/>
    <meta content="no-cache, no-store, must-revalidate" http-equiv="cache-control"/>
    <meta content="-1" http-equiv="expires"/>
    <meta content="no-cache" http-equiv="pragma"/>
    <!-- End Cache Control -->
    <!-- Don't allow search engines to index -->
    <meta content="ALL" name="robots"/>
    <!-- Start Global Metadata -->
    <meta content="EIS Intranet Services" name="DC.Creator.corporateName" scheme="qut-orgname"/>
    <meta content="HiQ" name="DC.Relation.isPartOf" scheme="qut-website"/>
    <meta content="general" name="DC.Type" scheme="qut-model"/>
    <meta content="educational" name="DC.Type.documentType" scheme="agls-document"/>
    <meta content="Queensland University of Technology" name="DC.Publisher"/>
    <meta content="https://qutvirtual.qut.edu.au'" name="DC.Identifier" scheme="URI"/>
    <meta content="en" name="DC.Language"/>
    <!-- End Global Metadata -->
    <!-- Start Custom Metadata -->
    <meta content="EIS Intranet Services" name="DC.Creator.corporateName" scheme="qut-orgname"/>
    <meta content="HiQ" name="DC.Relation.isPartOf" scheme="qut-website"/>
    <meta content="general" name="DC.Type" scheme="qut-model"/>
    <meta content="educational" name="DC.Type.documentType" scheme="agls-document"/>
    <meta content="Queensland University of Technology" name="DC.Publisher"/>
    <meta content="https://qutvirtual4plt.qut.edu.au'" name="DC.Identifier" scheme="URI"/>
    <meta content="en" name="DC.Language"/>
    <meta content="Copyright Queensland University of Technology 2016" name="DC.Rights"/>
    <meta content="http://www.student.qut.edu.au/about/copyright" name="DC.Rights" scheme="URI"/>
    <meta content="HiQ" name="DC.Subject" scheme="qut-subject"/>
    <meta content="assetID=3824; mediaID=;" name="DC.Relation.requires" scheme="DCSV"/>
    <!-- End Custom Metadata -->
    <!-- Start Favicon and Homescreen Icons -->
    <!-- For iPhone 4 with high-resolution Retina display: -->
    <link href="https://qutvirtual4.qut.edu.au/looking-glass-student-theme/images/custom/template/qv-homescreen-logo-high.png" rel="apple-touch-icon-precomposed" sizes="114x114"/>
    <!-- For first-generation iPad: -->
    <link href="https://qutvirtual4.qut.edu.au/looking-glass-student-theme/images/custom/template/qv-homescreen-logo-med.png" rel="apple-touch-icon-precomposed" sizes="72x72"/>
    <!-- For non-Retina iPhone, iPod Touch, and Android 2.1+ devices: -->
    <link href="https://qutvirtual4.qut.edu.au/looking-glass-student-theme/images/custom/template/qv-homescreen-logo.png" rel="apple-touch-icon-precomposed"/>
    <!-- For desktop and all other devices -->
    <link href="https://qutvirtual4.qut.edu.au/looking-glass-student-theme/images/custom/template/favicon.ico" rel="Shortcut Icon"/>

    <script src="./qut-home_files/jquery-2.1.4.min.js" type="text/javascript">
    </script>
    <!--[if lt IE 9]>
<script type="text/javascript" src="/html/lg/js/jquery-1.11.3.min.js"></script><![endif]-->
    <script src="./qut-home_files/jquery-migrate-1.2.1.min.js" type="text/javascript">
    </script>
    <script src="./qut-home_files/jquery-ui.1.11.4.min.js" type="text/javascript">
    </script>
    <script src="./qut-home_files/bootstrap.3.3.5.min.js" type="text/javascript">
    </script>
    <script src="./qut-home_files/jquery.js" type="text/javascript">
    </script>
    <link crossorigin="anonymous" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" rel="stylesheet"/>
    <link href="./qut-home_files/main.css" rel="stylesheet" type="text/css"/>
    <style type="text/css">
        #banner .logo a{background:url(/image/company_logo?img_id=11144&amp;t=1526757130118) no-repeat;display:block;font-size:0;height:52px;text-indent:-9999em;width:300px;}
    </style>
    <!--[if IE 8]>  <link rel="stylesheet" media="all" type="text/css" href="/looking-glass-student-theme/css/ie.css" />    <![endif]-->
    <!--[if gte IE 9]>  <style type="text/css">#header-search form{filter:none!important;background:#fff!important;}</style><![endif]-->
    <link href="./qut-home_files/bootstrap.min.css" media="all" rel="stylesheet" type="text/css"/>
    <link href="./qut-home_files/exception.css" media="all" rel="stylesheet" type="text/css"/>
    <link href="./qut-home_files/469.min.css" media="screen and (max-width: 469px)" rel="stylesheet" type="text/css"/>
    <link href="./qut-home_files/470x529.min.css" media="screen and (min-width: 470px) and (max-width: 529px)" rel="stylesheet" type="text/css"/>
    <link href="./qut-home_files/530x699.min.css" media="screen and (min-width: 530px) and (max-width: 699px)" rel="stylesheet" type="text/css"/>
    <link href="./qut-home_files/700x949.min.css" media="screen and (min-width: 700px) and (max-width: 949px)" rel="stylesheet" type="text/css"/>
    <link href="./qut-home_files/950x1169.min.css" media="screen and (min-width: 950px) and (max-width: 1169px)" rel="stylesheet" type="text/css"/>
    <link href="./qut-home_files/1170x1189.min.css" media="screen and (min-width: 1170px) and (max-width: 1189px)" rel="stylesheet" type="text/css"/>
    <link href="./qut-home_files/1410-above.min.css" media="screen and (min-width: 1410px)" rel="stylesheet" type="text/css"/>
    <link href="./qut-home_files/qut.css" media="all" rel="stylesheet" type="text/css"/>
    <link href="./qut-home_files/print.css" media="print" rel="stylesheet" type="text/css"/>
    <style type="text/css">
        .gm-style {
    font: 400 11px Roboto, Arial, sans-serif;
    text-decoration: none;
  }
  .gm-style img { max-width: none; }
    </style>

    <!-- OUR HEAD STUFF -->
    <script src="//d3js.org/d3.v3.min.js"></script>
    <script type="text/javascript" src="_scripts/script.js"></script>
    <link href="https://fastcdn.org/Font-Awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet"                                                  href="_css/global.css"/><!-- global.css -->
    <link rel="stylesheet" media="(min-width: 0px) and (max-width: 640px)" href="_css/small.css" /><!-- small.css -->
    <link rel="stylesheet" media="(min-width: 641px) and (max-width: 979px)" href="_css/medium.css"/><!-- medium.css -->
    <link rel="stylesheet" media="(min-width: 980px)"                       href="_css/large.css" /><!-- large.css -->

</head>

<?php
include_once 'functions.php';
//var_dump($_SESSION['user']);
if (!isset($_SESSION['user'])) {
    include_once 'auth.php';
}
