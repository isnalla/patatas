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
    <div id="gradesheets_container"></div>
    <h3 id="grades_info"></h3>
    <div id="grades_container"></div>



    <!-- yung enctype para yan mapunta sa $_FILES ung info ng gustong iupload na file -->
    <h3> Create a Grade Sheet</h3>
    <form action="" method="post" enctype="multipart/form-data">

        <label for="course_code">Course Code</label> <br/>
        <select name="course_code">
            <?php //fill drop-down list with course codes
                $db = new Database();

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

    <script>
        $(function(){
            show_gradesheets();
            $('#submit').on('click',show_gradesheets);
        });

        function show_gradesheets(){
            $.post("/logic/lecturer.php",{'method':'get_gradesheets'},function(data){

                data = JSON.parse(data);

                $("#gradesheets_container").html(
                    "<table id=\"gradesheets_table\" border = 1>" +
                        "<tr>" +
                            "<th>Subject</th>" +
                            "<th>Section</th>" +
                            "<th>Status</th>" +
                        "</tr>"
                );


                for(i = 0; i<data.length; i++)
                    $("#gradesheets_container > table").append(
                        "<tr value = '"+data[i].Section+"'>" +
                            "<td>" +
                                data[i].Course_code +
                            "</td>" +
                            "<td>" +
                                data[i].Section +
                            "</td>" +
                            "<td>" +
                                data[i].Status +
                            "</td>" +
                            "</tr>"
                    );

                $("#gradesheets_container > table").append("</table>");

                $('#gradesheets_table').find('tr').next().on('click',function(){
                    show_grades($(this).attr('value'));
                });
            });
        }

        function show_grades(section){
            //highlight row on click

            var data = {'section':section,'name':'<?php echo $_SESSION['name'];?>'};
            $.post("/logic/lecturer.php",{'method':'get_grades','data':data},function(data){

                data = JSON.parse(data);
                console.log(data);

                $("#grades_info").html(data[0].Course_code + " " + data[0].Section);

                $("#grades_container").html(
                    "<table id='grades_table' border = 1>" +
                        "<tr>" +
                        "<th>Student No</th>" +
                        "<th>Grade</th>" +
                        "<th>Remarks</th>" +
                        "<td><input type=\"button\" id=\"add_button\" value=\"Add Grade\" /></td>"+
                        "</tr>"
                );


                for(i = 0; i<data.length; i++)
                    $("#grades_container > table").append(
                        "<tr>" +
                            "<td>" +
                            "<input type=\"text\" value=\""+data[i].Student_no+"\" />" +
                            "</td>" +
                            "<td>" +
                            "<input type=\"text\" value=\""+ data[i].Grade+"\" />" +
                            "</td>" +
                            "<td>" +
                            "<input type=\"text\" value=\""+ data[i].Remarks+"\" />" +
                            "</td>" +
                            "<td>" +
                                "<input type=\"button\" id=\"edit_button\" value=\"Save Changes\" />"+
                                "<input type=\"button\" id=\"delete_button\" value=\"X\" />"+
                            "</td>" +
                            "</tr>"
                    );

                $("#gradesheets_container > table").append("</table>");

            });
        }
    </script>
<?php
    include("/includes/footer.php");
?>