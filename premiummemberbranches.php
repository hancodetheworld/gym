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
            function fillForm(memberID, branchID) {
                document.getElementById('selectedMemberID').value = memberID;
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
                <a href="premiummemberbranches.php" class="active">PremiumMemberBranches</a> 
                <a href="workshopschedulesub.php">WorkshopScheduleSub</a>
                <a href="paymentshistory.php">PaymentsHistory</a>
                <a href="locker.php">Locker</a>
                <a href="attendances.php">Attendances</a>
                <a href="guestpass.php">GuestPass</a>
                <a href="registersfor.php">RegistersFor</a>
            </nav>
        </div>
        <!-- This form can reflect the info of the row selected by the user and also be used to carry out SQL queries -->
        <h2 style="margin-left: 20px">Data Editing Panel</h2>
        <form method="POST" action="premiummemberbranches.php">
        <div class="form-row">
            <label class="form-label">MemberID:</label>
            <input type="number" id="selectedMemberID" name="selectedMemberID" class="form-input">
        </div>
        <div class="form-row">
            <label class="form-label">BranchID:</label>
            <input type="number" id="selectedBranchID" name="selectedBranchID" class="form-input">
        </div>
        </form>
        <hr />
        <h2 style="margin-left: 20px">Table - PremiumMemberBranches</h2>
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

        function displayPremiumMemberBranches() {
            global $db_conn;

            $result = executePlainSQL("SELECT * FROM PremiumMemberBranches");
            echo "<table border='1' style='margin-left: 20px'>";
            echo "<tr><th>MemberID</th><th>BranchID</th>";

            while ($row = oci_fetch_array($result, OCI_BOTH)) {
                echo "<tr onclick='fillForm(\"" . $row["MEMBERID"] . "\", \"" . $row["BRANCHID"] . "\")'>";
                echo "<td>" . $row["MEMBERID"] . "</td>";
                echo "<td>" . $row["BRANCHID"] . "</td>";
                echo "</tr>";
            }

            echo "</table>";
            echo "<p style='margin-left: 20px'>Click the record that you want to edit.</p>";
        }

        
        // Main part of the PHP
        if (connectToDB()) {
            displayPremiumMemberBranches();
            disconnectFromDB();
        }

		?>
	</body>
</html>
