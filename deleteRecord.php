<?php
    require "reqUser.php";
    /*if($_SESSION['delete']==1||$_SESSION['change']==1){
        //...
    }
    else if($_SESSION['delete']==0||$_SESSION['change']==0){
        echo "You do not have either delete and change privileges.";
        exit();
    }else{
        echo "There is something wrong with your privileges, ask the Admin for assistance.";
        exit();
    }*/
	require 'connection.php';
//Gets the id for the record the admin wishes to delete.
if(isset($_POST['deleteRecord'])&&isset($_POST['ID'])&&!isset($_POST['Col']))/*&&$_SESSION['delete']==1*/{
    $deleteID=mysqli_real_escape_string($connection, $_POST['ID']);
    $user=$_SESSION['userUid'];
    $result =mysqli_query($connection,"SELECT * FROM cateringdata WHERE `ID` = $deleteID");
    $all =mysqli_fetch_assoc($result);
    if($all['ID']!=null){
	    if($all['Date']>=date('Y-m-d',time())){
	        $before=implode("|", $all);
	        $dblog = "INSERT INTO log (User,BeforeChange,Type) VALUES ('$user','$before', 'Delete');";
	        mysqli_query( $connection, $dblog );

	        $dbDelete = "DELETE FROM `cateringdata` WHERE `cateringdata`.`ID` = ?";//DO NOT CHANGE QUOTATION MARKS.
	        $stmt = mysqli_stmt_init($connection);
	        if(!mysqli_stmt_prepare($stmt,$dbDelete)){
	            echo "SQL FAIL";
	        }else{
	            mysqli_stmt_bind_param($stmt,"i",$deleteID);
	            mysqli_stmt_execute($stmt);
	            mysqli_stmt_close($stmt);   
	            header("Location:../deleteRecord.php");
	        }   
		}else{
			header("Location:../deleteRecord.php?error=RecPast");
		}
    }else{
    	header("Location:../deleteRecord.php?error=404&id=".$_POST['ID']);
    }
}else if(isset($_POST['ID'])&&isset($_POST['Col'])&&isset($_POST['Change'])&&isset($_POST['updateRecord'])/*&&$_SESSION['change']==1*/){
    $user=$_SESSION['userUid'];
    $changeID=mysqli_real_escape_string($connection, $_POST['ID']);
    $changeCol=$_POST['Col'];
    $changeTo=$_POST['Change'];
    $result=mysqli_query($connection, "SELECT * FROM cateringdata WHERE ID = $changeID");
    $all =mysqli_fetch_assoc($result);
    if($all['ID']!=null){
    	if(($changeCol=='StartTime'&&$changeTo>$all['EndTime'])||($changeCol=='EndTime'&&($changeTo<$all['StartTime']||$changeTo<$all['DeliveryTime']))||($changeCol=='DeliveryTime'&&$changeTo>$all['EndTime'])){
            header("Location:../deleteRecord.php?error=InvalidTimes");
        }else{
            if(($all['Date']>=date('Y-m-d',time())||$changeCol=='Cost'||$changeCol=='Comments')&&$changeCol!='Room'){
                $before=implode("|", $all);
                $dbChange="UPDATE cateringdata SET $changeCol = ? WHERE cateringdata. ID = $changeID";//DO NOT CHANGE QUOTATION MARKS.
                $stmt1 = mysqli_stmt_init($connection);
                if(!mysqli_stmt_prepare($stmt1,$dbChange)){
                    echo "SQL FAIL";
                }else{
                    mysqli_stmt_bind_param($stmt1,"s",$changeTo);
                    mysqli_stmt_execute($stmt1);
                    mysqli_stmt_close($stmt1); 
                }

                $result=mysqli_query( $connection, "SELECT * FROM cateringdata WHERE ID = $changeID");
                $all =mysqli_fetch_assoc($result);

                $after=implode("|", $all);
                $dblog = "INSERT INTO log (User,BeforeChange,AfterChange,Type) VALUES ('$user','$before','$after','Edit');";
                mysqli_query( $connection, $dblog );
                header("Location:../deleteRecord.php");
            }else if ($changeCol=='Room'&&$all['Date']>=date('Y-m-d',time())){
                $before=implode("|", $all);
                $floor = '0';
                if ($changeTo=='Agincourt'||$changeTo=='Bayview Village'||$changeTo=='Downsview'||$changeTo=='Guildwood'||$changeTo=='Hoggs Hollow'||$changeTo=='Port Union'||$changeTo=='Rouge'||$changeTo=='York Mills'){
                    $floor = '18';
                }else if ($changeTo=='Black Creek'||$changeTo=='Bridle Path'||$changeTo=='High Park'||$changeTo=='Kingsway'||$changeTo=='Lawrence Heights'||$changeTo=='Little Italy'||$changeTo=='Mimico'||$changeTo=='Parkdale'){
                    $floor = '19';
                }else{
                    $floor = '20';
                }
                $dbChange="UPDATE cateringdata SET $changeCol = ?,Floor= '$floor' WHERE cateringdata. ID = $changeID";//DO NOT CHANGE QUOTATION MARKS.
                $stmt1 = mysqli_stmt_init($connection);
                if(!mysqli_stmt_prepare($stmt1,$dbChange)){
                    echo "SQL FAIL";
                }else{
                    mysqli_stmt_bind_param($stmt1,"s",$changeTo);
                    mysqli_stmt_execute($stmt1);
                    mysqli_stmt_close($stmt1); 
                }

                $result=mysqli_query( $connection, "SELECT * FROM cateringdata WHERE ID = $changeID");
                $all =mysqli_fetch_assoc($result);

                $after=implode("|", $all);
                $dblog = "INSERT INTO log (User,BeforeChange,AfterChange,Type) VALUES ('$user','$before','$after','Edit');";
                mysqli_query( $connection, $dblog );
                header("Location:../deleteRecord.php");
            }else{
               header("Location:../deleteRecord.php?error=RecPast");
            }
        }
    }else{
    	header("Location:../deleteRecord.php?error=404&id=".$_POST['ID']);
    }   
}/*else if(isset($_POST['ID'])&&isset($_POST['Col'])&&isset($_POST['Change'])&&isset($_POST['updateRecord'])&&$_SESSION['change']==0){
    echo "You do not have permission to change.";
}*/
?>
<!-- Beneath is html-->
<html>
<title>Change/Delete Records</title>
<header>
    <link rel="stylesheet" href="globalStyle.css">
    <link rel="stylesheet" href="styletable.css">
</header>
<body>
<!--Burger icon that shows a dropdown to redirect to other pages-->
<div class="burgerTOP">
<div class="wrap">
<div class="burger">
    <button onclick="dropFunction()" class="dropbtn"></button>
    <div id="dropMenu" class="menuContent">
        <a href="form.php">Form</a>
        <a href="showTable.php">Show Table</a>
        <a href="deleteRecord.php">Delete/Change</a>
    </div>
</div>
<div class="burger"></div>
<div class="burger"></div> </div> 
<!--JS function that show/hide the dropdown menu form the burger icon-->
<script>function dropFunction(){document.getElementById("dropMenu").classList.toggle("show");}</script>
</div>

<!--Input box for deleting+changing records-->
<form action="" method="POST">
    <input type="number" name="ID" placeholder="ID" min = '0'>
    <select name="Col" id="fields" onchange="change()">
        <option value="" disabled selected>Select Column</option>
        <option value="Purpose">Purpose(Internal/External)</option>
        <option value="Date">Date</option>
        <option value="Room">Room</option>
        <option value="Attendees">Number of Attendees</option>
        <option value="Food">Food</option>
        <option value="DeliveryTime">Delivery Time</option>
        <option value="StartTime">Start Time</option>
        <option value="EndTime">End Time</option>
        <option value="MorningBreak">Morning Break</option>
        <option value="AfternoonBreak">Afternoon Break</option>
        <option value="Restrictions">Notes/Dietary Restrictions</option>
        <option value="Meal">Meal</option>
        <option value="HotCold">Hot or Cold</option>
        <option value="Drinks">Drinks</option>
        <option value="Vendor">Vendor</option> 
        <option value="LoBCostCenter">Lob Cost Center</option>>
        <option value="Cost">Cost</option>  
        <option value="Comments">Comments</option>
    </select>
    <input type="text" name="Change" id="changeInput" placeholder="Change To">

    <select name="Change" id="purpose" style="display:none;">
		<option value="" disabled selected>Select Purpose</option>
        <option value="External">External</option>
        <option value="Internal">Internal</option>
    </select>

	<select name="Change" id="meal" style="display:none;">
		<option value="" disabled selected>Select Meal</option>
		<option value="Breakfast">Breakfast</option>
		<option value="Lunch">Lunch</option>
		<option value="Dinner">Dinner</option>
	</select>

	<select name="Change" id="hotcold" style="display:none;">
		<option value="" disabled selected>Select Hot/Cold</option>
		<option value="Cold">Cold</option>
		<option value="Hot">Hot</option>
	</select>
	<select name="Change" id="vendor" style="display:none;">
		<option value="" disabled selected>Select Vendor</option>
		<option value="Aroma">Aroma</option>
		<option value="Burger King">Burger King</option>
		<option value="Druxys">Druxys</option>
		<option value="Eggsmart">Eggsmart</option>
		<option value="IQ Restaurants">IQ Restaurants</option>
		<option value="Jimmy the Greek">Jimmy the Greek</option>
		<option value="La Prep">La Prep</option>
		<option value="Longos">Longos</option>
		<option value="McDonalds">McDonalds</option>
		<option value="McEwans">McEwans</option>
		<option value="Nofrills">Nofrills</option>
		<option value="Soup Nutsy">Soup Nutsy</option>
		<option value="Tim Hortons">Tim Hortons</option>
	</select>
    <select name="Change" id="room" style="display:none;"><!--If new rooms are added go to the js function on the bottom-->
            <option value="" disabled selected>Select Room</option>
            <option value="Agincourt">Agincourt</option>
            <option value="Bayview Village">Bayview Village</option>
            <option value="Black Creek">Black Creek</option>
            <option value="Bridle Path">Bridle Path</option>
            <option value="Distillery District">Distillery District</option>
            <option value="Downsview">Downsview</option>
            <option value="Guildwood">Guildwood</option>
            <option value="High Park">High Park</option>
            <option value="Hoggs Hollow">Hoggs Hollow</option>
            <option value="Kingsway">Kingsway</option>
            <option value="Lawrence Heights">Lawrence Heights</option>
            <option value="Leslieville">Leslieville</option>
            <option value="Liberty Village">Liberty Village</option>   
            <option value="Little Italy">Little Italy</option>
            <option value="Mimico">Mimico</option>
            <option value="Parkdale">Parkdale</option>
            <option value="Port Union">Port Union</option>
            <option value="Rouge">Rouge</option>
            <option value="The Annex">The Annex</option>
            <option value="The Beaches">The Beaches</option>
            <option value="York Mills">York Mills</option>
        </select>
    <input type="submit" name="deleteRecord" onclick="return confirm('Are you sure you want to delete order?');" value="Delete">
    <input type="submit" name="updateRecord" onclick="return confirm('Are you sure you want to make changes?');" value="Update">
</form>
<?php  //If the record is edited...
echo "<h5>Fill out only ID if you wish to delete. Fill out all fields if you wish to update.";
if(isset($_GET['error'])){
    if($_GET['error']=='RecPast'){
        echo "<br><b>You cannot edit any records that have past (except for Cost & Comments).</b></br>";
    }else if($_GET['error']=='404'){
        echo "<br><b>ID ";
        echo $_GET['id'];
        echo " not found.</b></br>";
    }else if($_GET['error']=='InvalidTimes'){
        echo "<br><b>Invalid Times</b></br>";
    }
}
echo "</h5>";
?>
</div>
<?php
	require 'connection.php';
    $sql = "SELECT * FROM cateringdata  ORDER BY ID ASC;";//WHERE Date>CURDATE() //Add this after cateringdata to make table only show records that didn't past yet.
    $result = mysqli_query( $connection, $sql );
    echo "<table id='datatable'>";
    $resultCheck = mysqli_num_rows($result);
    if($resultCheck>0){
	    echo "  <tr><th>ID</th><th>Purpose</th><th>Date\n(yyyy-mm-dd)</th><th>Floor</th><th>Room</th><th>Number of Attendees</th><th>Food</th><th>Delivery Time</th><th>Start Time\n(hh:mm:ss)</th><th>End Time</th><th>Morning Break</th><th>Afternoon Break</th><th>Notes/ Dietary Restrictions</th><th>Meal</th><th>Hot or Cold</th><th>Drinks</th><th>Vendor</th><th>LoB CostCenter</th><th>Cost</th><th>Comments</th></tr>";
	    while($all =mysqli_fetch_assoc($result) ){
	        echo "<tr><td>" .$all['ID'] . "</td><td>".$all['Purpose']. "</td><td>" .  $all['Date'] . "</td><td>".$all['Floor']. "</td><td>". $all['Room']. "</td><td>".$all['Attendees']. "</td><td>". $all['Food']. "</td><td>". $all['DeliveryTime']. "</td><td>" . $all['StartTime'] . "</td><td>". $all['EndTime']   . "</td><td>". $all['MorningBreak'] . "</td><td>" .$all['AfternoonBreak']    . "</td><td>".$all['Restrictions']. "</td><td>".$all['Meal'] . "</td><td>".$all['HotCold'] . "</td><td>".$all['Drinks'] . "</td><td>". $all['Vendor']. "</td><td>".$all['LoBCostCenter']."</td><td>". $all['Cost']  . "</td><td>".$all['Comments']."</td></tr>"; 
}
echo "</table>"; 
	}
?>

<script type="text/javascript">
	    var changeInput = document.getElementById('changeInput');
        var room = document.getElementById('room');
        var purpose = document.getElementById('purpose');
        var floor = document.getElementById('floor');
        var meal = document.getElementById('meal');
        var hotcold = document.getElementById('hotcold');
        var vendor = document.getElementById('vendor');
    function change(){
        var fieldsSelected = document.getElementById('fields').selectedIndex;

        console.log(fieldsSelected);
        if(fieldsSelected=="2"){//date
        	clear();
            changeInput.type="date";
            changeInput.style.display="inline-block";
        }else if(fieldsSelected=="6"||fieldsSelected=="7"||fieldsSelected=="8"||fieldsSelected=="9"||fieldsSelected=="10"){//time
        	clear();
        	changeInput.step = "1";
            changeInput.type="time";
            changeInput.style.display="inline-block";
        }else if(fieldsSelected=="5"||fieldsSelected=="11"||fieldsSelected=="14"||fieldsSelected=="18"){//free text
            clear();
            changeInput.type="text";
            changeInput.style.display="inline-block";
        }else if(fieldsSelected=="4"){//attendees
        	clear();
        	changeInput.step = "1";
            changeInput.type="number";
            changeInput.min = "0";
            changeInput.style.display="inline-block";
        }else if (fieldsSelected=="3"){//Rooms
        	clear();
        	room.style.display="inline-block";
        }else if(fieldsSelected=="17"){//Cost
        	clear();
        	changeInput.type="number";
        	changeInput.step = "0.01";
            changeInput.min = "0";
            changeInput.style.display="inline-block";
        }else if(fieldsSelected=="1"){//purpose
        	clear();
        	purpose.style.display="inline-block";
        }else if(fieldsSelected=="12"){//meal
        	clear();
        	meal.style.display="inline-block";
        }else if(fieldsSelected=="13"){//hotcold
        	clear();
        	hotcold.style.display="inline-block";
        }else if(fieldsSelected=="15"){//vendor
        	clear();
        	vendor.style.display="inline-block";
        }else if (fieldsSelected=="16"){
        	clear();
        	changeInput.type="number";
        	changeInput.step = "1";
            changeInput.min = "0";
            changeInput.max = "999999999"
            changeInput.style.display="inline-block";
        }

    }
    	function clear(){
    		changeInput.value="";
    		room.value="";
    		purpose.value="";
    		meal.value="";
    		hotcold.value="";
    		vendor.value="";
    		changeInput.style.display="none";
    		room.style.display="none";
    		purpose.style.display="none";
    		meal.style.display="none";
    		hotcold.style.display="none";
    		vendor.style.display="none";
    	}
</script>

</body>
</html>
