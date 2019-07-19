<?php
    require "reqUser.php";
/*if($_SESSION['view']==1){
    //...
}
else if($_SESSION['view']==0){
    echo "You do not have permission to view this page. Ask the Admin for view privileges.";
    exit();
}else{
    echo "There is something wrong with your privileges, ask the Admin for assistance.";
    exit();
}*/
?>
<html>
<title>Table</title>
<header>
    <link rel="stylesheet" href="styletable.css">
</header>

<body>
<!--Burger icon that shows a dropdown to redirect to other pages-->
<div class="burgerTOP">
<div class="burger">
    <button onclick="dropFunction()" class="dropbtn"></button>
    <div id="dropMenu" class="menuContent">
        <a href="form.php">Form</a>
        <a href="showTable.php">Show Table</a>
        <a href="deleteRecord.php">Delete/Change</a>
    </div>
</div>
<div class="burger"></div>
<div class="burger"></div>
</div>
<!--JS function that show/hide the dropdown menu form the burger icon-->
<script>function dropFunction(){document.getElementById("dropMenu").classList.toggle("show");}</script>
</div>

<?php
//Prints out table for record viewing.
    require 'connection.php';
    $sql = "SELECT * FROM cateringdata;";
    $result = mysqli_query( $connection, $sql );
    echo "<table id='datatable'>";
    $resultCheck = mysqli_num_rows($result);
    if($resultCheck>0){
        echo "  <tr><th>Purpose</th><th>Date\n(yyyy-mm-dd)</th><th>Floor</th><th>Room</th><th>Number of Attendees</th><th>Food</th><th>Delivery Time</th><th>Start Time\n(hh:mm:ss)</th><th>End Time</th><th>Morning Break</th><th>Afternoon Break</th><th>Notes/ Dietary Restrictions</th><th>Meal</th><th>Hot or Cold</th><th>Drinks</th><th>Vendor</th><th>LoB CostCenter</th><th>Cost</th><th>Comments</th></tr>";
        while($all =mysqli_fetch_assoc($result) ){
            echo "<tr><td>".$all['Purpose']. "</td><td>" .  $all['Date'] . "</td><td>".$all['Floor']. "</td><td>". $all['Room']. "</td><td>".$all['Attendees']. "</td><td>". $all['Food']. "</td><td>". $all['DeliveryTime']. "</td><td>" . $all['StartTime'] . "</td><td>". $all['EndTime']   . "</td><td>". $all['MorningBreak'] . "</td><td>" .$all['AfternoonBreak']    . "</td><td>".$all['Restrictions']. "</td><td>".$all['Meal'] . "</td><td>".$all['HotCold'] . "</td><td>".$all['Drinks'] . "</td><td>". $all['Vendor']  . "</td><td>".$all['LoBCostCenter']."</td><td>".$all['Cost']."</td><td>".$all['Comments']."</td></tr>"; 
 }
    echo "</table>";
    }
?>

</body>
</html>
