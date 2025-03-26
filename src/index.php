<?php

/**
 * Family History Checks
 * 
 * A series of small scripts to highlight data issues in a RootsMagic database.
 *
 * @author  Neil Thompson <hi@nei.lt>
 * @see     https://nei.lt/fhc
 * @license GNU Lesser General Public License, version 3
 *
 * 
 **/

class FHChecksException extends Exception {}

// set error handling
error_reporting(E_NOTICE);
ini_set('display_errors', 0);
error_reporting(E_ALL);
ini_set('display_errors', 1);

// have we got a config file?
try {
    require __DIR__ . '/config.php';
} catch (\Throwable $th) {
    throw new FHChecksException("config.php file not found. Have you renamed from config_dummy.php?.");
}

session_start();

// connect to the SQLite database
try {
    // Specify the path and filename for the SQLite database
    $databasePath = $db;

    if (!file_exists($databasePath)) {
        throw new FHChecksException($db . " file not found.");
    } else {
        // Connect to an existing database
        $pdo = new PDO('sqlite:' . $databasePath);

        // Set error mode to exceptions
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
} catch (PDOException $e) {
    throw new FHChecksException("Error: " . $e->getMessage());
}


// display and process the relevant page
if (isset($_GET['page']) && $_GET['page'] != 'recache') {
    $page = $_GET['page'];
} else {
    $page = '';
}
if ($page == '') {
    // display the selection pages
    $h2 = "What do you want to check?";
    $grid = "<div class=\"box\" onclick=\"selectBox(this, 'option1')\">People without surnames</div>
                    <input type=\"checkbox\" name=\"option1\" id=\"option1\" class=\"d-none\">
                <div class=\"box\" onclick=\"selectBox(this, 'option2')\">People without forenames</div>
                    <input type=\"checkbox\" name=\"option2\" id=\"option2\" class=\"d-none\">
                <div class=\"box\" onclick=\"selectBox(this, 'option3')\">People without birth date</div>
                    <input type=\"checkbox\" name=\"option3\" id=\"option3\" class=\"d-none\">
                <div class=\"box\" onclick=\"selectBox(this, 'option4')\">People without date of death</div>
                    <input type=\"checkbox\" name=\"option4\" id=\"option4\" class=\"d-none\">
                <div class=\"box\" onclick=\"selectBox(this, 'option5')\">Missing citation for person</div>
                    <input type=\"checkbox\" name=\"option5\" id=\"option5\" class=\"d-none\">
                <div class=\"box\" onclick=\"selectBox(this, 'option6')\">Orphaned People</div>
                    <input type=\"checkbox\" name=\"option6\" id=\"option6\" class=\"d-none\">
                <div class=\"box\" onclick=\"selectBox(this, 'option7')\">Anniversaries</div>
                    <input type=\"checkbox\" name=\"option7\" id=\"option7\" class=\"d-none\">
                <div class=\"box\" onclick=\"selectBox(this, 'option8')\">Free Text Search</div>
                    <input type=\"checkbox\" name=\"option8\" id=\"option8\" class=\"d-none\">";
    $output = file_get_contents('./index.html');
    $output = str_replace('<!-- grid -->', $grid, $output);
    $output = str_replace('<!-- h2 -->', $h2, $output);
    $output = str_replace('<!-- action -->', './index.php?page=1', $output);
} elseif ($page == 1) {
    // process options and store
    if (isset($_POST['option1'])) {
        // select people without surnames
        $sql = "SELECT  nt.Given AS 'name', IIF(nt.BirthYear=0,'',nt.BirthYear) AS 'birth', IIF(nt.DeathYear=0, '', nt.DeathYear) AS 'death'
                    FROM  NameTable nt
                    WHERE nt.isPrimary = 1
                    AND nt.Surname = '' COLLATE NOCASE
                ORDER BY nt.Given COLLATE NOCASE";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $people = $stmt->fetchAll();
        $h2 = "People without Surnames";
        $grid = "                                    <table class=\"table table-striped table-bordered\" width=\"100%\">
                                        <thead class=\"table-dark\">
                                            <tr>
                                                <th>Category</th>
                                                <th>Birth Year</th>
                                                <th>Death Year</th>
                                            </tr>
                                        </thead>
                                        <tbody>";
        foreach ($people as $person) {
            $grid .= "                      <tr>
                                                    <td>" . $person['name'] . "</td>
                                                    <td>" . $person['birth'] . "</td>
                                                    <td>" . $person['death'] . "</td>
                                                </tr>";
        }
        $grid .= "                                        </tbody>
                                    </table>";
        $output = file_get_contents('./index2.html');
        $output = str_replace('<!-- grid -->', $grid, $output);
        $output = str_replace('<!-- h2 -->', $h2, $output);
        $output = str_replace('<!-- action -->', './index.php?page=2', $output);
    } elseif (isset($_POST['option2'])) {
        // select people without forenames
        $sql = "SELECT  nt.Surname AS 'name', IIF(nt.BirthYear=0,'',nt.BirthYear) AS 'birth', IIF(nt.DeathYear=0, '', nt.DeathYear) AS 'death'
                    FROM  NameTable nt
                    WHERE nt.isPrimary = 1
                    AND nt.Given = '' COLLATE NOCASE
                ORDER BY nt.Surname COLLATE NOCASE";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $people = $stmt->fetchAll();
        $h2 = "People without Forenames";
        $grid = "                                    <table class=\"table table-striped table-bordered\" width=\"100%\">
                                        <thead class=\"table-dark\">
                                            <tr>
                                                <th>Category</th>
                                                <th>Birth Year</th>
                                                <th>Death Year</th>
                                            </tr>
                                        </thead>
                                        <tbody>";
        foreach ($people as $person) {
            $grid .= "                      <tr>
                                                    <td>" . $person['name'] . "</td>
                                                    <td>" . $person['birth'] . "</td>
                                                    <td>" . $person['death'] . "</td>
                                                </tr>";
        }
        $grid .= "                                        </tbody>
                                    </table>";
        $output = file_get_contents('./index2.html');
        $output = str_replace('<!-- grid -->', $grid, $output);
        $output = str_replace('<!-- h2 -->', $h2, $output);
        $output = str_replace('<!-- action -->', './index.php?page=2', $output);
    } elseif (isset($_POST['option3'])) {
        // select people without birth dates
        $sql = "SELECT  CONCAT(nt.Given, ' ', nt.Surname) AS 'name', IIF(nt.DeathYear=0, '', nt.DeathYear) AS 'death'
                    FROM  NameTable nt
                    WHERE nt.isPrimary = 1
                    AND nt.BirthYear = 0
                ORDER BY nt.Surname COLLATE NOCASE, nt.Given COLLATE NOCASE";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $people = $stmt->fetchAll();

        $h2 = "People without Birth Date";
        $grid = "                                    <table class=\"table table-striped table-bordered\" width=\"100%\">
                                        <thead class=\"table-dark\">
                                            <tr>
                                                <th>Category</th>
                                                <th>Death Year</th>
                                            </tr>
                                        </thead>
                                        <tbody>";
        foreach ($people as $person) {
            $grid .= "                      <tr>
                                                    <td>" . $person['name'] . "</td>
                                                    <td>" . $person['death'] . "</td>
                                                </tr>";
        }
        $grid .= "                                        </tbody>
                                    </table>";
        $output = file_get_contents('./index2.html');
        $output = str_replace('<!-- grid -->', $grid, $output);
        $output = str_replace('<!-- h2 -->', $h2, $output);
        $output = str_replace('<!-- action -->', './index.php?page=2', $output);
    } elseif (isset($_POST['option4'])) {
        // select people without death dates
        $sql = "SELECT  CONCAT(nt.Given, ' ', nt.Surname) AS 'name', IIF(nt.BirthYear=0, '', nt.BirthYear) AS 'birth'
                    FROM  NameTable nt
                    WHERE nt.isPrimary = 1
                    AND nt.DeathYear = 0
                ORDER BY nt.Surname COLLATE NOCASE, nt.Given COLLATE NOCASE";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $people = $stmt->fetchAll();

        $h2 = "People without Death Date";
        $grid = "                                    <table class=\"table table-striped table-bordered\" width=\"100%\">
                                        <thead class=\"table-dark\">
                                            <tr>
                                                <th>Category</th>
                                                <th>Birth Year</th>
                                            </tr>
                                        </thead>
                                        <tbody>";
        foreach ($people as $person) {
            $grid .= "                      <tr>
                                                    <td>" . $person['name'] . "</td>
                                                    <td>" . $person['birth'] . "</td>
                                                </tr>";
        }
        $grid .= "                                        </tbody>
                                    </table>";
        $output = file_get_contents('./index2.html');
        $output = str_replace('<!-- grid -->', $grid, $output);
        $output = str_replace('<!-- h2 -->', $h2, $output);
        $output = str_replace('<!-- action -->', './index.php?page=2', $output);
    } elseif (isset($_POST['option5'])) {
        // get list of people
        $sql = "SELECT  nt.NameId, 
                       CASE nt.birthyear
                        WHEN 0 THEN concat(nt.Surname,',  ',nt.Given,' (Unknown)')
                        ELSE concat(nt.Surname,',  ',nt.Given,' (',nt.birthyear,')')
                       END AS 'Name'
                        FROM NameTable nt
                       WHERE nt.isPrimary = 1
                         AND EXISTS (SELECT 1 FROM EventTable et WHERE et.OwnerId = nt.OwnerId)
                    ORDER BY nt.Surname COLLATE NOCASE, nt.Given COLLATE NOCASE";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $people = $stmt->fetchAll();

        $h2 = "Select individual to check";
        $grid = "<select class=\"form-select\" id=\"person\" name=\"person\">
                        <option value=\"\">Select a person</option>";
        foreach ($people as $person) {
            $grid .= "<option value=\"" . $person['NameID'] . "\">" . $person['Name'] . "</option>";
        }
        $grid .= "</select>";
        $grid .= "<p style=\"margin: 10px 0 0 5px;\">" . count($people) . " people found with events.</p>";
        $output = file_get_contents('./index2.html');
        $output = str_replace('<!-- grid -->', $grid, $output);
        $output = str_replace('<!-- h2 -->', $h2, $output);
        $output = str_replace('<!-- action -->', './index.php?page=2', $output);
    } elseif (isset($_POST['option6'])) {
        // select people without mothers or fathers
        $sql = "SELECT  CONCAT(nt.Given, ' ', nt.Surname) AS 'name', IIF(nt.BirthYear=0, '', nt.BirthYear) AS 'birth',  IIF(nt.DeathYear=0, '', nt.DeathYear) AS 'death'
                      FROM  NameTable nt
				INNER JOIN ChildTable ct ON ct.ChildID = nt.OwnerID
				INNER JOIN FamilyTable ft ON ft.FamilyID = ct.FamilyID   
		             WHERE nt.isPrimary = 1
                       AND ft.FatherID = 0 OR ft.MotherID=0
		          ORDER BY nt.Surname COLLATE NOCASE, nt.Given COLLATE NOCASE";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $people = $stmt->fetchAll();

        $h2 = "People without a mother or father";
        $grid = "                                    <table class=\"table table-striped table-bordered\" width=\"100%\">
                                        <thead class=\"table-dark\">
                                            <tr>
                                                <th>Name</th>
                                                <th>Birth Year</th>
                                                <th>Death Year</th>
                                            </tr>
                                        </thead>
                                        <tbody>";
        foreach ($people as $person) {
            $grid .= "                      <tr>
                                                    <td>" . $person['name'] . "</td>
                                                    <td>" . $person['birth'] . "</td>
                                                    <td>" . $person['death'] . "</td>
                                                </tr>";
        }
        $grid .= "                                        </tbody>
                                    </table>";
        $output = file_get_contents('./index2.html');
        $output = str_replace('<!-- grid -->', $grid, $output);
        $output = str_replace('<!-- h2 -->', $h2, $output);
        $output = str_replace('<!-- action -->', './index.php?page=2', $output);
    } elseif (isset($_POST['option7'])) {
        // select people with upcoming aniversaries
        $sql = "SELECT  nt.Given, 
                            nt.Surname,
                            ftt.Name AS 'Event', 
                            CASE 
                                WHEN et.Date = '.' THEN ''
                                ELSE 
                                    substr(et.Date, 4, 4) || '/' || substr(et.Date, 8, 2) || '/' || substr(et.Date, 10, 2) 
                            END AS 'Date',
                            
                            -- Calculate age or years difference
                            CAST(ROUND(
                                (JULIANDAY('now') - JULIANDAY(
                                    substr(et.Date, 4, 4) || '-' || substr(et.Date, 8, 2) || '-' || substr(et.Date, 10, 2)
                                )) / 365.25
                            ) AS INTEGER) AS years_diff,

                            -- Get the same date but in the current year
                            strftime('%Y', 'now') || '-' || substr(et.Date, 8, 2) || '-' || substr(et.Date, 10, 2) AS this_year_date,

                            -- Calculate days until the event this year
                            CAST(ROUND(
                                JULIANDAY(strftime('%Y', 'now') || '-' || substr(et.Date, 8, 2) || '-' || substr(et.Date, 10, 2))
                                - JULIANDAY('now')
                            ) AS INTEGER) AS days_from

                        FROM NameTable nt
                        INNER JOIN EventTable et ON et.OwnerId = nt.OwnerId 
                        INNER JOIN FactTypeTable ftt ON ftt.FactTypeID = et.EventType 
                            AND ftt.GedcomTag IN ('BIRT', 'DEAT', 'MARR')

                        WHERE nt.IsPrimary = 1
                        AND years_diff IS NOT NULL
                        AND days_from BETWEEN 1 AND 10  -- Only upcoming events within the next 10 days
                        ORDER BY this_year_date;";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $people = $stmt->fetchAll();

        $h2 = "Upcoming Anniversaries";
        $grid = "                                    <table class=\"table table-striped table-bordered\" width=\"100%\">
                                        <thead class=\"table-dark\">
                                            <tr>
                                                <th>Anniversary</th>
                                            </tr>
                                        </thead>
                                        <tbody>";
        foreach ($people as $person) {
            $grid .= "                      <tr>
                                                    <td>" . addOrdinalSuffix($person['years_diff']) . " anniversary of the " . $person['Event'] . " of " . $person['Given'] . " " . $person['Surname'] . " in " . $person['days_from'] . " days time (" . $person['Date'] . ").</td>
                                                </tr>";
        }
        $grid .= "                                        </tbody>
                                    </table>";
        $output = file_get_contents('./index2.html');
        $output = str_replace('<!-- grid -->', $grid, $output);
        $output = str_replace('<!-- h2 -->', $h2, $output);
        $output = str_replace('<!-- action -->', './index.php?page=2', $output);
    } elseif (isset($_POST['option8'])) {

        $h2 = "Enter text to search for:";
        $grid = "<input type=\"text\" class=\"form-control\" id=\"search\" name=\"search\">";
        $output = file_get_contents('./index2.html');
        $output = str_replace('<!-- grid -->', $grid, $output);
        $output = str_replace('<!-- h2 -->', $h2, $output);
        $output = str_replace('<!-- action -->', './index.php?page=2', $output);
    } else {
    }
}

// display the page
echo $output;

// close the database connection
$pdo = null;

function addOrdinalSuffix($number)
{
    // Handle special cases: 11th, 12th, 13th
    if ($number % 100 >= 11 && $number % 100 <= 13) {
        return $number . 'th';
    }

    // Determine suffix based on last digit
    switch ($number % 10) {
        case 1:
            return $number . 'st';
        case 2:
            return $number . 'nd';
        case 3:
            return $number . 'rd';
        default:
            return $number . 'th';
    }
}
