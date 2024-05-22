<?php
session_start();
if (ISSET ($_SESSION['nume']))
{
}
else
die("Nu sunteti autentificat");
// Verificare ocolire tip utilizator
//if ($_SESSION['tip'] != "Administrator")
//  die("Nu sunteti autentificat corespunzator");
  echo "
Server adress:  |localhost|
User:           |atermro8_atermro8_parteneri-test|
Password:       |}f,+ypP0sZLR|
Database:       |atermro8_parteneri-test|
Nume firma:		|SC Aterm SRL|
dbMaxSize:	    |1073741824|
A nu se folosi "bara verticala" in vreunul din campuri!!!
  ";
?>