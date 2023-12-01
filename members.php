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
            function fillForm(memberID, name, email, age, startDate, memberType) {
                document.getElementById('selectedMemberID').value = memberID;
                document.getElementById('selectedName').value = name;
                document.getElementById('selectedEmail').value = email;
                document.getElementById('selectedAge').value = age;
                document.getElementById('selectedStartDate').value = startDate;
                document.getElementById('selectedMemberType').value = memberType;
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

        .large-text-select {
            font-size: 16px; 
        }
        </style>
    </head>

    <body>
        <div class="centered-container">
            <h1>Fitness & Gym Chain Management System</h1>
            <nav class="navbar">
                <a href="dashboard.php">Dashboard</a>
                <a href="members.php" class="active">Members</a>
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
        <!-- This form can reflect the info of the row selected by the user and also be used to carry out SQL queries -->
        <h2 style="margin-left: 20px">Data Editing Panel</h2>
        <form method="POST" action="members.php" id="memberForm">
            <div class="form-row">
                <label class="form-label">Current MemberID:</label>
                <input type="number" id="selectedMemberID" name="selectedMemberID" class="form-input" readonly>
            </div>
            <div class="form-row">
                <label class="form-label">New MemberID:</label>
                <input type="number" id="newMemberID" name="newMemberID" class="form-input">
            </div>
            <div class="form-row">
                <label class="form-label">Name:</label>
                <input type="text" id="selectedName" name="selectedName" class="form-input">
            </div>
            <div class="form-row">
                <label class="form-label">Email:</label>
                <input type="email" id="selectedEmail" name="selectedEmail" class="form-input">
            </div>
            <div class="form-row">
                <label class="form-label">Age:</label>
                <input type="number" id="selectedAge" name="selectedAge" class="form-input">
            </div>
            <div class="form-row">
                <label class="form-label">Membership Start Date:</label>
                <input type="text" id="selectedStartDate" name="selectedStartDate" class="form-input">
            </div>
            <div class="form-row">
                <label class="form-label">Membership Type:</label>
                <select id="selectedMemberType" name="selectedMemberType" class="large-text-select">
                    <option value="regular">regular</option>
                    <option value="premium">premium</option>
                </select>
            </div>
            <p><input type="submit" value="Insert" name="insertSubmit">
            <input type="submit" value="Update" name="updateSubmit">
            <input type="submit" value="Delete" name="deleteSubmit">
            <input type="submit" value="Clear" onclick="location.reload();"></p>
            <hr />
            <h2 style="margin-left: 20px">Additional Queries</h2>
            <p>
            <select name="showMemberType" id="memberTypeView" class="large-text-select" onchange="document.getElementById('memberForm').submit();" style="margin-left: 20px">
                <option value="showAll" <?php echo (isset($_POST['showMemberType']) && $_POST['showMemberType'] == "showAll") ? 'selected' : ''; ?>>Show All Members</option>
                <option value="showRegular" <?php echo (isset($_POST['showMemberType']) && $_POST['showMemberType'] == "showRegular") ? 'selected' : ''; ?>>Show Regular Members</option>
                <option value="showPremium" <?php echo (isset($_POST['showMemberType']) && $_POST['showMemberType'] == "showPremium") ? 'selected' : ''; ?>>Show Premium Members</option>
            </select>
            <input type="submit" value="Show All Enrolled Workshops of the Selected Member" name="showWorkshops"></p>
        </form>
        <form method="POST" action="members.php" id="branchForm">
            <select name="showMemberWithBranches" id="memberBranchView" class="large-text-select" onchange="document.getElementById('branchForm').submit();" style="margin-left: 20px">
                <option value="showAll" <?php echo (isset($_POST['showMemberWithBranches']) && $_POST['showMemberWithBranches'] == "showAll") ? 'selected' : ''; ?>>Show All Members with Branches</option>
                <option value="showRegular" <?php echo (isset($_POST['showMemberWithBranches']) && $_POST['showMemberWithBranches'] == "showRegular") ? 'selected' : ''; ?>>Show Regular Members with Branches</option>
                <option value="showPremium" <?php echo (isset($_POST['showMemberWithBranches']) && $_POST['showMemberWithBranches'] == "showPremium") ? 'selected' : ''; ?>>Show Premium Members with Branches</option>
            </select>
        </form>
        <form method="POST" action="members.php" id="statisticForm1">
            <input type="submit" value="Calculate the average member age of each member type" name="avgMemberType">
        </form>
        <form method="POST" action="members.php" id="statisticForm2">
            <p style="margin-left: 20px;">
                <label class="form-label" style="text-align: right; width: 240px; ">Find the age of the youngest member for each member type with more than </label>
                <input type="number" id="moreThan" name="moreThan" class="form-input" style="width: 10%;">
                <label class="form-label" style="text-align: left; margin-left: 10px; margin-right: 0;">members.</label>
                <input type="submit" value="Render" name="havingSubmit">
            </p>
        </form>
        <form method="POST" action="members.php" id="statisticForm3">
            <input type="submit" value="Find members who have attended all branches" name="allBranches">
        </form>
        <hr />
        <h2 style="margin-left: 20px">Table - Members</h2>
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

                //Getting the values from user and insert data into the table
                $tuple = array (
                    ":bind1" => $_POST['newMemberID'],
                    ":bind2" => $_POST['selectedEmail'],
                    ":bind3" => $_POST['selectedName'],
                    ":bind4" => $_POST['selectedAge'],
                    ":bind5" => $_POST['selectedStartDate'],
                    ":bind6" => $_POST['selectedMemberType']
                );

                $alltuples = array (
                    $tuple
                );

                executeBoundSQL("insert into Members (MemberID, Email, Name, Age, StartDate, MemberType) values (:bind1, :bind2, :bind3, :bind4, :bind5, :bind6)", $alltuples);
                oci_commit($db_conn);
            }

            disconnectFromDB();

            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }

        function handleUpdateRequest() {
            if (connectToDB()) {
                global $db_conn;

                $member_ID = $_POST['selectedMemberID'];
                $new_email = $_POST['selectedEmail'];
                $new_name = $_POST['selectedName'];
                $new_Age = $_POST['selectedAge'];
                $new_start_date = $_POST['selectedStartDate'];
                $new_member_type = $_POST['selectedMemberType'];

                // you need the wrap the old name and new name values with single quotations
                executePlainSQL("UPDATE Members SET Email='" . $new_email . 
                     "', Name='" . $new_name . 
                     "', Age='" . $new_Age . 
                     "', StartDate='" . $new_start_date . 
                     "', MemberType='" . $new_member_type . 
                     "' WHERE MemberID='" . $member_ID . "'");
                oci_commit($db_conn);
            }

            disconnectFromDB();

            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }

        function handleDeleteRequest() {
            if (connectToDB()) {
                global $db_conn;

                $tuple = array (
                    ":bind1" => $_POST['selectedMemberID'],
                );

                $alltuples = array (
                    $tuple
                );

                executeBoundSQL("delete from Members where MemberID = :bind1", $alltuples);
                oci_commit($db_conn);
            }

            disconnectFromDB();

            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }

        function displayMembers() {
            global $db_conn;

            $query = "SELECT * FROM Members";

            if (isset($_POST['showMemberType'])) {
                if ($_POST['showMemberType'] == "showRegular") {
                    $query = "SELECT * FROM Members WHERE MemberType = 'regular'";
                } else if ($_POST['showMemberType'] == "showPremium") {
                    $query = "SELECT * FROM Members WHERE MemberType = 'premium'";
                } 
            }

            $result = executePlainSQL($query);
            
            echo "<table border='1' style='margin-left: 20px'>";
            echo "<tr><th>MemberID</th><th>Name</th><th>Email</th><th>Age</th><th>Start Date</th><th>Member Type</th></tr>";

            while ($row = oci_fetch_array($result, OCI_BOTH)) {
                echo "<tr onclick='fillForm(\"" . $row["MEMBERID"] . "\", \"" . $row["NAME"] . "\", \"" . $row["EMAIL"] . "\", \"" . $row["AGE"] . "\", \"" . $row["STARTDATE"] . "\", \"" . $row["MEMBERTYPE"] . "\")'>";
                echo "<td>" . $row["MEMBERID"] . "</td>";
                echo "<td>" . $row["NAME"] . "</td>";
                echo "<td>" . $row["EMAIL"] . "</td>";
                echo "<td>" . $row["AGE"] . "</td>";
                echo "<td>" . $row["STARTDATE"] . "</td>";
                echo "<td>" . $row["MEMBERTYPE"] . "</td>";
                echo "</tr>";
            }

            echo "</table>";
            echo "<p style='margin-left: 20px'>Click the member that you want to edit or investigate.</p>";
        }

        function displayWorkshops() {
            if (isset($_POST['selectedMemberID']) && !empty($_POST['selectedMemberID'])) {
                $member_ID = $_POST['selectedMemberID'];
                if (connectToDB()) {
                    global $db_conn;
                    $result = executePlainSQL("SELECT W.WorkshopName, W.WorkshopDuration
                    FROM WorkshopScheduleSub W, RegistersFor R
                    WHERE W.WorkshopID = R.WorkshopID AND R.MemberID = '" . $member_ID . "'");
                    echo "<hr />";
                    echo "<h2 style='margin-left: 20px'>Enrolled Workshops of the Selected Member</h2>";
                    echo "<table border='1' style='margin-left: 20px; margin-bottom: 60px;'>";
                    echo "<tr><th>Workshop Name</th><th>Workshop Duration</th></tr>";
                    while ($row = oci_fetch_array($result, OCI_BOTH)) {
                        echo "<tr>";
                        echo "<td>" . $row["WORKSHOPNAME"] . "</td>";
                        echo "<td>" . $row["WORKSHOPDURATION"] . "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                }
                disconnectFromDB();
                exit();
            } else {
                echo "<hr />";
                echo "<h2 style='margin-left: 20px'>Enrolled Workshops of the Selected Member</h2>";
                echo "<p style='margin-left: 20px'>Please select a member!</p>";
            }
        }

        function displayBranches() {
            if (connectToDB()) {
                global $db_conn;
                $query = "  SELECT M.MemberID, M.Name, M.Email, G.BranchID, G.Address
                            FROM Members M, RegularMemberBranches R, GymBranches G
                            WHERE M.MemberID = R.MemberID AND R.BranchID = G.BranchID AND MemberType = 'regular'
                            UNION
                            SELECT M.MemberID, M.Name, M.Email, G.BranchID, G.Address
                            FROM Members M, PremiumMemberBranches P, GymBranches G
                            WHERE M.MemberID = P.MemberID AND P.BranchID = G.BranchID AND MemberType = 'premium'";

                if (isset($_POST['showMemberWithBranches'])) {
                    if ($_POST['showMemberWithBranches'] == "showRegular") {
                        $query = "  SELECT M.MemberID, M.Name, M.Email, G.BranchID, G.Address
                                    FROM Members M, RegularMemberBranches R, GymBranches G
                                    WHERE M.MemberID = R.MemberID AND R.BranchID = G.BranchID AND MemberType = 'regular'";
                    } else if ($_POST['showMemberWithBranches'] == "showPremium") {
                        $query = "  SELECT M.MemberID, M.Name, M.Email, G.BranchID, G.Address
                                    FROM Members M, PremiumMemberBranches P, GymBranches G
                                    WHERE M.MemberID = P.MemberID AND P.BranchID = G.BranchID AND MemberType = 'premium'";
                    } 
                }

                $attributesTitle = ["MemberID", "Name", "Email", "BranchID", "Address"];
                $attributes = ["MEMBERID", "NAME", "EMAIL", "BRANCHID", "ADDRESS"];
                $result = executePlainSQL($query);
                
                echo "<hr />";
                echo "<h2 style='margin-left: 20px'>Branch Information of the Selected MemberType</h2>";
                echo "<table border='1' style='margin-left: 20px'>";
                echo "<tr>";
                tableRenderHelper($attributes, $attributesTitle, $result);
            }
        }

        function displayAvgAge() {
            if (connectToDB()) {
                global $db_conn;
                $query = "  SELECT MemberType, AVG(Age) AS AverageAge
                            FROM Members
                            GROUP BY MemberType";
                $attributesTitle = ["MemberType", "Average Age"];
                $attributes = ["MEMBERTYPE", "AVERAGEAGE"];
                $result = executePlainSQL($query);

                echo "<hr />";
                echo "<h2 style='margin-left: 20px'>Average Member Age of each MemberType</h2>";
                echo "<table border='1' style='margin-left: 20px'>";
                echo "<tr>";
                tableRenderHelper($attributes, $attributesTitle, $result);
            }
        }

        function displayHaving() {
            if (connectToDB()) {
                global $db_conn;

                if (isset($_POST['moreThan']) && $_POST['moreThan'] !== '') {
                    $num = $_POST['moreThan'];
                    $query = "  SELECT MemberType, MIN(Age) AS YoungestAge
                                FROM Members
                                GROUP BY MemberType
                                HAVING COUNT(*) > " . $num;
                    $attributesTitle = ["MemberType", "Youngest Age"];
                    $attributes = ["MEMBERTYPE", "YOUNGESTAGE"];
                    $result = executePlainSQL($query);
                    echo "<hr />";
                    echo "<h2 style='margin-left: 20px'>Youngest Member of each MemberType</h2>";
                    echo "<table border='1' style='margin-left: 20px'>";
                    echo "<tr>";
                    tableRenderHelper($attributes, $attributesTitle, $result);
                } else {
                    echo "<hr />";
                    echo "<h2 style='margin-left: 20px'>Youngest Member of each MemberType</h2>";
                    echo "<p style='margin-left: 20px'>Please provide a valid number.</p>";
                } 
            }
        }

        function displayDivision() {
            if (connectToDB()) {
                global $db_conn;
                $query = "  SELECT M.MemberID, M.Name, M.Email, M.Age, M.StartDate, M.MemberType
                            FROM Members M
                            WHERE NOT EXISTS
                            (  SELECT *
                            FROM GymBranches G
	                        WHERE NOT EXISTS
	                        (   SELECT *
	                            FROM Attendances A
	                            WHERE A.MemberID = M.MemberID AND A.BranchID = G.BranchID))";
                $attributesTitle = ["MemberID", "Name", "Email", "Age", "Start Date", "Member Type"];
                $attributes = ["MEMBERID", "NAME", "EMAIL", "AGE", "STARTDATE", "MEMBERTYPE"];
                $result = executePlainSQL($query);

                echo "<hr />";
                echo "<h2 style='margin-left: 20px'>Members who have attended all branches</h2>";
                echo "<table border='1' style='margin-left: 20px'>";
                echo "<tr>";
                tableRenderHelper($attributes, $attributesTitle, $result);
            }
        }

        function tableRenderHelper($attributes, $attributesTitle, $result) {
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

        // Main part of the PHP
        if (connectToDB()) {
            displayMembers();
            disconnectFromDB();
            if (isset($_POST['insertSubmit'])) {
                handleInsertRequest();
            } else if (isset($_POST['updateSubmit'])) {
                handleUpdateRequest();
            } else if (isset($_POST['deleteSubmit'])) {
                handleDeleteRequest();
            } else if (isset($_POST['showWorkshops'])) {
                displayWorkshops();
            } else if (isset($_POST['showMemberWithBranches'])) {
                displayBranches();
            } else if (isset($_POST['avgMemberType'])) {
                displayAvgAge();
            } else if (isset($_POST['havingSubmit']) && isset($_POST['moreThan'])) {
                displayHaving();
            } else if (isset($_POST['allBranches'])) {
                displayDivision();
            }
        }
		?>
        <p style="margin-bottom: 20px;">&nbsp</p>
	</body>
</html>
