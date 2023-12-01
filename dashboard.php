<?php
    // Report the error message
    ob_start(); //start output buffering
    error_reporting(-1);
    ini_set('display_errors', 1);
?>
<html>
    <head>
        <title>Fitness & Gym Chain Management System</title>
        <style>
        .selected {
                background-color: #DDEEFF; /* BG Color of the selected row */
        }

        .form-row {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            margin-left: 20px;
        }

        .form-label {
            width: 50px; 
            text-align: left;
            margin-right: 20px;
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

        .large-text-select {
            font-size: 16px; 
        }
        </style>
    </head>

    <body>
        <div class="centered-container">
            <h1>Fitness & Gym Chain Management System</h1>
            <nav class="navbar">
                <a href="dashboard.php" class="active">Dashboard</a>
                <a href="members.php">Members</a>
                <a href="gymbranches.php">GymBranches</a>
                <a href="coach.php">Coach</a>
                <a href="regularmemberbranches.php">RegularMemberBranches</a>
                <a href="premiummemberbranches.php">PremiumMemberBranches</a> 
                <a href="workshopschedulesub.php">WorkshopScheduleSub</a>
                <a href="paymentshistory.php">PaymentsHistory</a>
                <a href="locker.php">Locker</a>
                <a href="attendances.php">Attendances</a>
                <a href="guestpass.php">GuestPass</a>
                <a href="registersfor.php">RegistersFor</a>
            </nav>
        </div>
        <h2 style="margin-left: 20px">Projection Panel</h2>
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

        function getTables() {
            global $db_conn;
            $result = executePlainSQL("SELECT table_name FROM user_tables");
            $tables = array();
            while ($row = oci_fetch_array($result, OCI_BOTH)) {
                array_push($tables, $row[0]);
            }
            return $tables;
        }

        connectToDB()

		?>
        <form action="dashboard.php" method="post" id="tableForm" style="margin-left: 20px; margin-top: 20px;">
            <select name="selectedTable" id="tableSelect" class="large-text-select" onchange="document.getElementById('tableForm').submit();">
                <option value="">Select a table</option>
                <?php
                    $tables = getTables();
                    foreach ($tables as $table) {
                        echo "<option value='" . $table . "'>" . $table . "</option>";
                    }
                ?>
            </select>
        </form>
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $selectedTable = $_POST['selectedTable'];
                if ($selectedTable) {
                    $result = executePlainSQL("SELECT column_name FROM user_tab_columns WHERE table_name='" . $selectedTable . "'");
                    echo "<form method='POST' action='dashboard.php'>";
                    echo "<div class='form-row' style='margin-bottom: 15px;'>";
                    echo "<label class='form-label'>Table:</label>";
                    echo "<input type='text' id='selectedTable' name='selectedTable' class='form-input' value='" . $selectedTable . "' readonly>";
                    echo "</div>";
                    while ($row = oci_fetch_array($result, OCI_BOTH)) {
                        echo "<div class='form-row'>";
                        echo "<input type='checkbox' name='attribute[]' value='" . $row[0] . "'>" . $row[0] . "<br>";
                        echo "</div>";
                    }
                    echo "<p><input type='submit' value='Render' name='renderSubmit' style='margin-top: 15px;'>";
                    echo "<input type='submit' value='Clear' onclick='location.reload();'></p>";
                    echo "</form>";
                }
            }

            function displayTable() {
                global $db_conn;
            
                if (isset($_POST['selectedTable']) && !empty($_POST['selectedTable'])) {
                    $selectedTable = $_POST['selectedTable'];
                    $attributes = $_POST['attribute'];
            
                    if (empty($attributes)) {
                        echo "<p style='margin-left: 20px'>No columns selected. Please select at least one column.</p>";
                        return;
                    }

                    $query = "SELECT " . implode(", ", $attributes) . " FROM " . $selectedTable;
                    $result = executePlainSQL($query);
                    
                    echo "<hr />";
                    echo "<h2 style='margin-left: 20px'>Result</h2>";
                    echo "<table border='1' style='margin-left: 20px'>";
                    echo "<tr>";
                    foreach ($attributes as $attr) {
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
            

            if (connectToDB()) {
                if (isset($_POST['renderSubmit'])) {
                    displayTable();
                } 
            }
        ?>
	</body>
</html>
