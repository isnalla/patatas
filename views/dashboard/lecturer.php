<?php
include "../db/db.php";
include("includes/header.php");
?>
<?php
    if(isset($_POST['submit'])){
        $csv = fopen($_FILES["file"]["tmp_name"],"r");

        $course_code = $_POST['course_code'];
        $section = $_POST['section'];

        //parse grades from csv file into array of grades[student_no,grade,remarks]"
        $grades;
        for($i=0; !feof($csv); $i++){
           $grade = explode(",",fgets($csv));
           $grades[$i]["student_no"] = $grade[0];
           $grades[$i]["grade"] = $grade[1];
           $grades[$i]["remarks"] = $grade[2];
        }
        fclose($csv);

        //var_dump($grades);
        $db->insert_gradesheet($course_code,$section,$grades);
    }
?>

    <br />
    <p>Hello, <?php echo $_SESSION['name']?>!</p>
    <br />

    <h3>Gradesheets submitted</h3>
    <table id="gradesheet_table" name="gradesheet_table" border = "1">
        <tr>
            <th>COURSE CODE</th>
            <th>SECTION</th>
            <th>STATUS</th>
        </tr>
        <?php
        $gradesheets = $db->get_gradesheets_by_lecturer($_SESSION['name']);

        for($i = 0; $i < count($gradesheets); $i++){
            echo "<tr>\n";
            echo "\t\t\t\t\t<td>{$gradesheets[$i]['Course_code']}</td>\n";
            echo "\t\t\t\t\t<td>{$gradesheets[$i]['Section']}</td>\n";
            echo "\t\t\t\t\t<td>{$gradesheets[$i]['Status']}</td>\n";
            echo "\t\t\t\t</tr>\n";
        }

        ?>
    </table>

    <!-- yung enctype para yan mapunta sa $_FILES ung info ng gustong iupload na file -->
    <h3> Create a Grade Sheet</h3>
    <form action="" method="post" enctype="multipart/form-data">

        <label for="course_code">Course Code</label> <br/>
        <select name="course_code">
            <?php //fill drop-down list with course codes
            //$db = new Database();

            $subjects = $db->get_subjects();

            for($i = 0; $i < count($subjects); $i++){
                echo "\t\t\t\t<option value=\"{$subjects[$i]}\">".$subjects[$i]."</option>\n";
            }
            ?>
        </select>
        <br />

        <label for="section">Section</label><br/>
        <input type="text" name="section" id="section" required = 'true'/><br/>
        <label for="upload">Upload grades (csv): </label>
        <input type="file" id="file" name="file" /><br />
        <button type="submit" id="submit" name="submit">Submit to Department Head</button>
    </form>

<?php
include("includes/footer.php");
?>