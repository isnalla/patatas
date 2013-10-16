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
        var gradesheets;
        $(function(){
            show_gradesheets();
            $('#submit_grade').on('click',add_grade);
            $('#submit').on('click',show_gradesheets);
        });

        function add_grade(){
            alert("hello");
        }

        function show_gradesheets(){
            $.post("/logic/lecturer.php",{'method':'get_gradesheets'},function(data){

                data = JSON.parse(data);
                gradesheets = data;

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
            var gradeDropdown =
                "<select class=\"grade_dropdown\">" +
                    "<option>1.0</option><option>1.25</option><option>1.5</option><option>1.75</option>" +
                    "<option>2.0</option><option>2.25</option><option>2.5</option><option>2.75</option>" +
                    "<option>3.0</option><option>4.0</option><option>5.0</option>" +
                "</select>";
            var data = {'section':section};

            var data = {'section':section,'name':'<?php echo $_SESSION['name'];?>'};
            $.post("/logic/lecturer.php",{'method':'get_grades','data':data},function(data){

                data = JSON.parse(data);
                console.log(data);
                $("#grades_info").html(data[0].Course_code + " " + data[0].Section);

                $("#subject").html(data[0].Course_code);
                $("#section").html(data[0].Section);

                $("#grades_container").html(
                    "<table id='grades_table' border = 1>" +
                        "<tr>" +
                        "<th>Student No</th>" +
                        "<th>Grade</th>" +
                        "<th>Remarks</th>" +
                        "<td><input type=\"button\" id=\"add_row_button\" value=\"Add Grade\" /></td>"+
                        "</tr>"
                );

                $("#add_row_button").on('click',function(){
                    $("#grades_table tr:first").after(
                        "<tr>" +
                                "<td>"+
                                "<input id=\"new_student_no\" type=\"text\" />" +
                                "</td>"+
                                "<td>"+ gradeDropdown.replace("<select","<select id=\"new_grade\"") + "</td>"+
                                "<td>"+
                                "<input id=\"new_remarks\" type=\"text\" />" +
                                "</td>"+
                                "<td>"+
                                "<input type=\"button\" id=\"add_grade_button\" value=\"Add Grade\" />"+
                                "<input type=\"button\" id=\"cancel_button\" value=\"X\" />"+
                            "</td>"+
                        "</tr>"
                    );
                    $('#add_grade_button').on('click',function(){
                        var data = {
                            'Lecturer': $('#lecturer_name').text(),
                            'Student_no':$('#new_student_no').val(),
                            'Course_code':$('#subject').text(),
                            'Section':$('#section').text(),
                            'Grade':$("#new_grade").val(),
                            'Remarks':$('#new_remarks').val()
                        };
                        $.post("/logic/lecturer.php",{'method':'insert_grade','data':data});
                        $('#grades_table tr')[1].remove();
                        show_grades(data['Section']);
                    });
                    $('.cancel_button').on('click',function(){
                        $('#grades_table tr')[1].remove();
                    });
                });

                for(i = 0; i<data.length; i++){
                    $("#grades_container > table").append(
                        "<tr>" +
                            "<td>" +
                            "<input type=\"text\" value=\""+data[i].Student_no+"\" />" +
                            "</td>" +
                            "<td>" +gradeDropdown.replace("<option>"+data[i].Grade,"<option selected=\"true\">"+data[i].Grade)+"</td>" +
                            "<td>" +
                            "<input type=\"text\" value=\""+ data[i].Remarks+"\" />" +
                            "</td>" +
                            "<td>" +
                                "<input type=\"button\" class=\"edit_button\" value=\"Save Changes\" />"+
                                "<input type=\"button\" class=\"delete_button\" value=\"X\" />"+
                            "</td>" +
                            "</tr>"
                    );
                }



                $("#gradesheets_container > table").append("</table>");

            });
        }
    </script>
<?php
    include("/includes/footer.php");
?>