<?php
    // Report the error message
    ob_start(); //start output buffering
    error_reporting(-1);
    ini_set('display_errors', 1);
?>
<html>
    <head>
        <title>Fitness & Gym Chain Management System</title>
        <script type="text/javascript">
            // Make the Data Editing Panel responsive to user's selection of the turple
            function fillForm(workshopID, workshopName, workshopDuration, coachID, workshopDate, branchID) {
                document.getElementById('selectedWorkshopID').value = workshopID;
                document.getElementById('selectedWorkshopName').value = workshopName;
                document.getElementById('selectedWorkshopDuration').value = workshopDuration;
                document.getElementById('selectedCoachID').value = coachID;
                document.getElementById('selectedWorkshopDate').value = workshopDate;
                document.getElementById('selectedBranchID').value = branchID;
                // Remove the BG color of previous selected row
                var rows = document.querySelectorAll("table tr");
                rows.forEach(row => {
                    row.classList.remove("selected");
                });
                // Add BG color to the current selected row
                var currentRow = event.currentTarget;
                currentRow.classList.add("selected");
            }
        </script>
        <style>
        .selected {
                background-color: #DDEEFF; /* BG Color of the selected row */
        }

        .form-row {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            margin-left: 10px;
        }

        .form-label {
            width: 180px; 
            text-align: right;
            margin-right: 10px;
        }

        .form-input {
            flex-grow: 0;
            width: 400px; 
        }

        table tr td {
            padding: 5px 20px; 
            padding-top: 2px;
            padding-bottom: 2px; 
            text-align: center; 
            vertical-align: middle; 
        }

        input[type="submit"] {
            font-size: 14px; 
            padding: 5px 10px; 
            border: 1px solid #000; 
            border-radius: 5px; /* Make the button round */
            cursor: pointer; /* Change the pointer into a hand */
            background-color: #f2f2f2; 
            color: #000; /* font color */
            margin-top: 5px;
            margin-right: 0px;
            margin-left: 20px;
        }

        form {
            margin-bottom: 20px; 
        }

        .centered-container {
            display: flex;
            flex-direction: column; /* make its elements align vertically */
            align-items: center; 
            justify-content: center; /* vertical align center */
        }

        h1 {
            background-color: #333; /* BG-black */
            color: white; 
            margin: 0; 
            padding: 10px 0; 
            width: 100%; 
            text-align: center; 
        }

        .navbar {
            background-color: #333; /* BG-black */
            width: 100%; 
            text-align: center; 
        }

        .navbar a {
            display: inline-block; /* make it looks like a block */
            color: white; 
            padding: 14px 16px; 
            text-decoration: none; /* remove underline */
        }

        .navbar a.active {
            background-color: #ddd; 
            color: black; 
        }

        .navbar a:hover {
            background-color: #ddd; /* change color when pointer point over */
            color: black; /* change color when pointer point over */
        }
        </style>
    </head>

    <body>
        <div class="centered-container">
            <h1>Fitness & Gym Chain Management System</h1>
            <nav class="navbar">
                <a href="dashboard.php">Dashboard</a>
                <a href="members.php">Members</a>
                <a href="gymbranches.php">GymBranches</a>
                <a href="coach.php">Coach</a>
                <a href="regularmemberbranches.php">RegularMemberBranches</a>
                <a href="premiummemberbranches.php">PremiumMemberBranches</a> 
                <a href="workshopschedulesub.php" class="active">WorkshopScheduleSub</a>
                <a href="paymentshistory.php">PaymentsHistory</a>
                <a href="locker.php">Locker</a>
                <a href="attendances.php">Attendances</a>
                <a href="guestpass.php">GuestPass</a>
                <a href="registersfor.php">RegistersFor</a>
            </nav>
        </div>
        <!-- This form can reflect the info of the row selected by the user and also be used to carry out SQL queries -->
        <h2 style="margin-left: 20px">Data Editing Panel</h2>
        <form method="POST" action="workshopschedulesub.php">
            <div class="form-row">
                <label class="form-label">Current WorkshopID:</label>
                <input type="number" id="selectedWorkshopID" name="selectedWorkshopID" class="form-input" readonly>
            </div>
            <div class="form-row">
                <label class="form-label">New WorkshopID:</label>
                <input type="number" id="newWorkshopID" name="newWorkshopID" class="form-input">
            </div>
            <div class="form-row">
                <label class="form-label">Workshop Name:</label>
                <input type="text" id="selectedWorkshopName" name="selectedWorkshopName" class="form-input">
            </div>
            <div class="form-row">
                <label class="form-label">Workshop Duration:</label>
                <input type="text" id="selectedWorkshopDuration" name="selectedWorkshopDuration" class="form-input">
            </div>
            <div class="form-row">
                <label class="form-label">CoachID:</label>
                <input type="number" id="selectedCoachID" name="selectedCoachID" class="form-input">
            </div>
            <div class="form-row">
                <label class="form-label">Workshop Date:</label>
                <input type="text" id="selectedWorkshopDate" name="selectedWorkshopDate" class="form-input">
            </div>
            <div class="form-row">
                <label class="form-label">BranchID:</label>
                <input type="number" id="selectedBranchID" name="selectedBranchID" class="form-input">
            </div>
            <p><input type="submit" value="Insert" name="insertSubmit">
            <input type="submit" value="Delete" name="deleteSubmit">
            <input type="submit" value="Clear" onclick="location.reload();"></p>
        </form>
        <hr />
        <h2 style="margin-left: 20px">Additional Queries</h2>
        <form method="POST" action="workshopschedulesub.php" id="avgAgeWorkshop">
            <p style="margin-left: 20px;">
                <label class="form-label" style="text-align: right; width: 240px; ">Calculate the average age of members registered for WorkshopID </label>
                <input type="number" id="targetWorkshop" name="targetWorkshop" class="form-input" style="width: 10%;">
                <input type="submit" value="Calculate" name="nestedSubmit">
            </p>
        </form>
        <hr />
        <h2 style="margin-left: 20px">Table - WorkshopScheduleSub</h2>
        <?php
        $success = True; //keep track of errors so it redirects the page only if there are no errors
        $db_conn = NULL; // edit the login credentials in connectToDB()
        $show_debug_alert_messages = False; // set to True to show which methods are being triggered

        function debugAlertMessage($message) {
            global $show_debug_alert_messages;

            if ($show_debug_alert_messages) {
                echo "<script type='text/javascript'>alert('" . $message . "');</script>";
            }
        }

        function executePlainSQL($cmdstr) { 
            global $db_conn, $success;

            $statement = oci_parse($db_conn, $cmdstr);
            //There are a set of comments at the end of the file that describe some of the OCI specific functions and how they work

            if (!$statement) {
                echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
                $e = oci_error($db_conn); // For oci_parse errors pass the connection handle
                echo htmlentities($e['message']);
                $success = False;
            }

            $r = oci_execute($statement, OCI_DEFAULT);
            if (!$r) {
                echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
                $e = oci_error($statement); // For oci_execute errors pass the statementhandle
                echo htmlentities($e['message']);
                $success = False;
            }

			return $statement;
		}

        function executeBoundSQL($cmdstr, $list) {

			global $db_conn, $success;
			$statement = oci_parse($db_conn, $cmdstr);

            if (!$statement) {
                echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
                $e = OCI_Error($db_conn);
                echo htmlentities($e['message']);
                $success = False;
            }

            foreach ($list as $tuple) {
                foreach ($tuple as $bind => $val) {
                    //echo $val;
                    //echo "<br>".$bind."<br>";
                    oci_bind_by_name($statement, $bind, $val);
                    unset ($val); //make sure you do not remove this. Otherwise $val will remain in an array object wrapper which will not be recognized by Oracle as a proper datatype
				}

                $r = oci_execute($statement, OCI_DEFAULT);
                if (!$r) {
                    echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
                    $e = oci_error($statement); // For oci_execute errors, pass the statementhandle
                    echo htmlentities($e['message']);
                    echo "<br>";
                    $success = False;
                }
            }
        }

        function connectToDB() {
            global $db_conn;

            $db_conn = oci_connect("ora_yhuan110", "a63255665", "dbhost.students.cs.ubc.ca:1522/stu");

            if ($db_conn) {
                debugAlertMessage("Database is Connected");
                return true;
            } else {
                debugAlertMessage("Cannot connect to Database");
                $e = oci_error(); // For oci_connect errors pass no handle
                echo htmlentities($e['message']);
                return false;
            }
        }

        function disconnectFromDB() {
            global $db_conn;

            debugAlertMessage("Disconnect from Database");
            oci_close($db_conn);
        }

        function handleInsertRequest() {
            if (connectToDB()) {
                global $db_conn;             
                // Test whether the WorkshopID exist in the WorkshopScheduleSub table
                $newWorkshopID = $_POST['newWorkshopID'];
                $checkResult1 = executePlainSQL("SELECT COUNT(*) FROM WorkshopScheduleSub WHERE WorkshopID = '$newWorkshopID'");
                $row1 = oci_fetch_array($checkResult1, OCI_BOTH);
                // Test whether the CoachID exist in the Coach table
                $coachID = $_POST['selectedCoachID'];
                $checkResult2 = executePlainSQL("SELECT COUNT(*) FROM Coach WHERE CoachID = '$coachID'");
                $row2 = oci_fetch_array($checkResult2, OCI_BOTH);
                // Test whether the BranchID exist in the GymBranches table
                $branchID = $_POST['selectedBranchID'];
                $checkResult3 = executePlainSQL("SELECT COUNT(*) FROM GymBranches WHERE BranchID = '$branchID'");
                $row3 = oci_fetch_array($checkResult3, OCI_BOTH);
                if ($row1[0] > 0 || $row2[0] == 0 || $row3[0] == 0) {
                    // If the WorkshopID already exists, report the error
                    if ($row1[0] > 0) {
                        echo "<p style='margin-left: 20px'>Error: WorkshopID has already been taken. Please choose a different WorkshopID.</p>";}
                    // If the CoachID does not exist, report the error
                    if ($row2[0] == 0) {echo "<p style='margin-left: 20px'>Error: CoachID does not exist.</p>";}
                    // If the BranchID does not exist, report the error
                    if ($row3[0] == 0) {echo "<p style='margin-left: 20px'>Error: BranchID does not exist.</p>";}
                    disconnectFromDB();
                    exit();
                } else {
                    // Getting the values from user and insert data into the table
                    $tuple = array (
                        ":bind1" => $_POST['newWorkshopID'],
                        ":bind2" => $_POST['selectedWorkshopName'],
                        ":bind3" => $_POST['selectedWorkshopDuration'],
                        ":bind4" => $_POST['selectedCoachID'],
                        ":bind5" => $_POST['selectedWorkshopDate'],
                        ":bind6" => $_POST['selectedBranchID']
                    );
                    $alltuples = array ($tuple);

                    executeBoundSQL("insert into WorkshopScheduleSub (WorkshopID, WorkshopName, WorkshopDuration, CoachID, WorkshopDate, BranchID) 
                    values (:bind1, :bind2, :bind3, :bind4, :bind5, :bind6)", $alltuples);  

                    oci_commit($db_conn);
                    disconnectFromDB();
                    header("Location: " . $_SERVER['PHP_SELF']); // Refresh the page
                    exit();
                }
            }

        }

        function handleDeleteRequest() {
            if (connectToDB()) {
                global $db_conn;

                $tuple = array (
                    ":bind1" => $_POST['selectedWorkshopID'],
                );

                $alltuples = array (
                    $tuple
                );

                executeBoundSQL("delete from WorkshopScheduleSub where WorkshopID = :bind1", $alltuples);
                oci_commit($db_conn);
            }

            disconnectFromDB();

            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }

        function displayWorkshopSchedule() {
            global $db_conn;

            $result = executePlainSQL("SELECT * FROM WorkshopScheduleSub");
            echo "<table border='1' style='margin-left: 20px'>";
            echo "<tr><th>WorkshopID</th><th>Workshop Name</th><th>Workshop Duration</th><th>CoachID</th><th>Workshop Date</th><th>BranchID</th></tr>";

            while ($row = oci_fetch_array($result, OCI_BOTH)) {
                echo "<tr onclick='fillForm(\"" . $row["WORKSHOPID"] . "\", \"" . $row["WORKSHOPNAME"] . "\", \"" . $row["WORKSHOPDURATION"] . "\", \"" . $row["COACHID"] . "\", \"" . $row["WORKSHOPDATE"] . "\", \"" . $row["BRANCHID"] . "\")'>";
                echo "<td>" . $row["WORKSHOPID"] . "</td>";
                echo "<td>" . $row["WORKSHOPNAME"] . "</td>";
                echo "<td>" . $row["WORKSHOPDURATION"] . "</td>";
                echo "<td>" . $row["COACHID"] . "</td>";
                echo "<td>" . $row["WORKSHOPDATE"] . "</td>";
                echo "<td>" . $row["BRANCHID"] . "</td>";
                echo "</tr>";
            }

            echo "</table>";
            echo "<p style='margin-left: 20px'>Click the workshop that you want to edit.</p>";
        }

        function displayNested() {
            if (connectToDB()) {
                global $db_conn;
                // Test whether the WorkshopID exist in the WorkshopScheduleSub table
                $targetWorkShopID = $_POST['targetWorkshop'];
                $checkResult = executePlainSQL("SELECT COUNT(*) FROM WorkshopScheduleSub WHERE WorkshopID = '$targetWorkShopID'");
                $row = oci_fetch_array($checkResult, OCI_BOTH);
                // If the WorkshopID does not exist, report the error
                if ($row[0] == 0) {
                    echo "<hr />";
                    echo "<h2 style='margin-left: 20px'>Average age of members in the selected workshop</h2>";
                    echo "<p style='margin-left: 20px'>Error: WorkshopID does not exist.</p>";
                } else if (isset($_POST['targetWorkshop']) && $_POST['targetWorkshop'] !== '') {
                    $query = "  SELECT AVG(M.Age) AS AverageAge
                                FROM Members M
                                WHERE M.MemberID IN (
                                    SELECT R.MemberID
	                                FROM RegistersFor R
	                                WHERE R.WorkshopID = ". $targetWorkShopID .")";
                    $attributesTitle = ["AverageAge"];
                    $attributes = ["AVERAGEAGE"];
                    $result = executePlainSQL($query);

                    echo "<hr />";
                    echo "<h2 style='margin-left: 20px'>Average age of members in the selected workshop</h2>";
                    echo "<table border='1' style='margin-left: 20px'>";
                    echo "<tr>";
                    foreach ($attributesTitle as $attr) {
                        echo "<th>$attr</th>";
                    }
                    echo "</tr>";
    
                    // Traverse the result and render the table
                    while ($row = oci_fetch_array($result, OCI_ASSOC+OCI_RETURN_NULLS)) {
                        echo "<tr>";
                        foreach ($attributes as $attr) {
                            echo "<td>" . ($row[$attr] !== null ? htmlentities($row[$attr], ENT_QUOTES) : " ") . "</td>";
                        }
                        echo "</tr>";
                    }
                    echo "</table>";
                } 
            }
        }

        
        // Main part of the PHP
        if (connectToDB()) {
            displayWorkshopSchedule();
            disconnectFromDB();
            if (isset($_POST['insertSubmit'])) {
                handleInsertRequest();
            } else if (isset($_POST['deleteSubmit'])) {
                handleDeleteRequest();
            } else if (isset($_POST['nestedSubmit'])) {
                displayNested();
            }
        }
		?>
	</body>
</html>
