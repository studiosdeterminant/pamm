<?php
   session_unset();     // unset $_SESSION variable for the run-time 
   session_destroy();   // destroy session data in storage
   echo true;
?>