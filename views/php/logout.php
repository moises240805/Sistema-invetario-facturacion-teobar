<?php
# Initialize the session
session_start();

# Unset all session variables

# Destroy the session
session_destroy();

# Redirect to login page
header('location:../../index.php');

?>