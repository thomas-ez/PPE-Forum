<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <link rel="Stylesheet" type="text/css" 
    <?php
    if (!empty($_GET["dark"])) 
    {
    	echo 'href="StyleDark.css"';
    }
    else
	{
		echo 'href="StyleSite.css"'; 
	} 
	?>
	href="StyleSite.css" media="all"/>
    <link href="https://fonts.googleapis.com/css?family=Bitter&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://kit.fontawesome.com/92920db574.js" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	<script src="https://kit.fontawesome.com/92920db574.js" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="styleFooter.css">
    <title>Forum</title>
</head>
<body>
