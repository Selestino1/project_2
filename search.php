<?php
// setting a variable to store our search

mysql_connect("localhost", "root", "") or die("Error connecting to database: ".mysql_error());
    /*
        localhost - it's location of the mysql server, usually localhost
        root - your username
        third is your password
         
        if connection fails it will stop loading the page and display an error
    */
     
    mysql_select_db("resorts_africa") or die(mysql_error());
    /* tutorial_search is the name of database we've created */

    $query = $_GET['query']; 
    // gets value sent over search form
     
    $min_length = 3;
    // you can set minimum length of the query if you want
?>
 
<!DOCTYPE html>
<html>
  <head>
    
      <meta charset="utf-8">
      <title>RESORTS AFRICA | A Day in Paradise</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <meta name="description" content="Parallax Content Slider with CSS3 and jQuery" />
    <meta name="keywords" content="slider, animations, parallax, delayed, easing, jquery, css3, kendo UI" />
      <link rel="stylesheet" href="css/normalize.css">
      <link href='http://fonts.googleapis.com/css?family=Changa+One|Open+Sans:400,400italic,700,700italic,800' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/styles.css">
      <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/responsive.css">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="shortcut icon" href="<img/favicon.ico">
    <link rel="stylesheet" type="text/css" href="css/demo.css" />
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <script type="text/javascript" src="js/modernizr.custom.28468.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
    <script src="script.js"></script>

    
    
    </head>
    
   <header>
    <div id="page-logo">              
      <a <a href=  "{{ baseUrl()}}" id="logo" >
        <h1>RESORTS AFRICA</h1>
        <h2>A Day in Paradise</h2>
      </a>
      <nav>
        <li><a href= "{{ baseUrl()}}">Home</a></li>
        <li><a href="{{siteUrl('/search')}}">About</a></li> 
        <li><a href="{{siteUrl('/contact')}}">Contact</a></li>
        <li><a href="{{siteUrl('/search1')}}">Search</a></li>
                
       
      </nav>
    </header>
    <div id="wrapper">
    
      <!-- <div >

<form id="searchbox" method="GET" action=" ">
   
    <INPUT TYPE = "Text" VALUE ="" PLACEHOLDER= "your search input here" NAME = "query">
    <input id="submit" type="submit" value="Search">
</form>
</div> -->

          
      

    
 <?php   
     
    if(strlen($query) >= $min_length){ // if query length is more or equal minimum length then
         
        $query = htmlspecialchars($query); 
        // changes characters used in html to their equivalents, for example: < to &gt;
         
        $query = mysql_real_escape_string($query);
        // makes sure nobody uses SQL injection
         
        $raw_results = mysql_query("SELECT * FROM tourismsitesinzimbabwe
            WHERE (`tourismSiteName` LIKE '%".$query."%') OR (`imageLink` LIKE '%".$query."%') OR (`description` LIKE '%".$query."%') ") or die(mysql_error());
             
        // * means that it selects all fields, you can also write: `id`, `title`, `text`
        // articles is the name of our table
         
        // '%$query%' is what we're looking for, % means anything, for example if $query is Hello
        // it will match "hello", "Hello man", "gogohello", if you want exact match use `title`='$query'
        // or if you want to match just full word so "gogohello" is out use '% $query %' ...OR ... '$query %' ... OR ... '% $query'
         
        if(mysql_num_rows($raw_results) > 0){ // if one or more rows are returned do following
             
            while($results = mysql_fetch_array($raw_results)){
            // $results = mysql_fetch_array($raw_results) puts data from database into array, while it's valid it does the loop
             
                echo "<p><h3>".$results['tourismSiteName']."</h3>".$results['description']."</p>";
                // posts results gotten from database(title and text) you can also show id ($results['id'])
            ?>
            echo "<script>
            window.location.href='/project_2/search';
            alert('Wala!!, We have found what your searching for. How ever you cant use it for the momemt. Click ok and go back to search page for more fun');
            </script>";
            <?php
            }
             
        }
        else{ // if there is no matching rows do following
            // echo "No results fro your search";
            ?>
            echo "<script>
            window.location.href='/project_2/search';
            alert('No results found! Click ok and try again');
            </script>";
            <?php

        }
         
    }
    else{ // if the is no search input say search input  needed
        // echo "Search input is expected! Please inset input and try again ";
        ?>
            echo "<script>
            window.location.href='/project_2/search';
            alert('No search term in the input search box. Input your search and try again');
            </script>";
        <?php
        }

?>
<!-- creating a back buton for easy use by site visitor -->
<div id= 'back'>

            <a href="http://localhost/project_2/"><img border="0">
              <input id="submit" type="submit" value="Back">
            </a>
</div>
          
<footer>S
        
        <a href="http//:gmail.com/selesgama@gmail.com"><img src="img/mail.png" alt="Gmail Logo" class="social-icon"></a>
        <a href="http//:twitter.com/Selestino01"><img src="img/twitter.png" alt="Twitter Logo"class="social-icon"></a>
        <p>&copy; 2015 Resorts Africa.</p>
        
      </footer>
    </div>
  </body>
 </html>






