<?php

$conn = mysqli_connect("localhost", "admin", "enti", "entihub");

$query = "SELECT * FROM users WHERE username='".$_GET["username"]."'";

echo $query;

$resultado = mysqli_query($conn, $query);

if (!$resultado){
    echo "Error: Query mal formada";
    exit();
}

while ($user = $resultado->fetch_assoc()){
    echo "<h2>".$user["name"]."</h2>";
    echo "<p>".$user["email"]."</p>";
    echo "<p>".$user["username"]."</p>";
    echo "<p>".$user["password"]."</p>";
}

#echo $_POST["username"];

?>