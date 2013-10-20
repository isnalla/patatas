<?php
include "../db/db.php";
include("includes/header.php");
?>
<?php
if(isset($_POST['submit'])){

    $grades = null;

    if($_FILES["file"]["tmp_name"] != ""){
        $csv = fopen($_FILES["file"]["tmp_name"],"r");

        for($i=0; !feof($csv); $i++){
            $grade = explode(",",fgets($csv));
            $grades[$i]["student_no"] = $grade[0];
            $grades[$i]["grade"] = $grade[1];
            $grades[$i]["remarks"] = $grade[2];
        }
        fclose($csv);
    }
    $course_code = $_POST['course_code'];
    $section = $_POST['section'];

    //parse grades from csv file into array of grades[student_no,grade,remarks]"

    $db->insert_gradesheet($course_code,$section,$grades);
}
?>

<div id="logged">
    <div id="left_nav">
        <div id="gradesheets_container_header"><img src="/img/GRADESHEETS.png"/></div>
        <div id="gradesheets_container"></div>

        <!-- yung enctype para yan mapunta sa $_FILES ung info ng gustong iupload na file -->
        <div id="gradesheets_container_header"><img src="/img/GRADESHEETS.png"/></div>
        <div id="create_gs">
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
                <button type="submit" class = "submit-button" id="submit" name="submit">Submit to Department Head</button>
            </form>
        </div>
    </div>


    <div id="right_nav">
        <div id="grades_info">
        <h3 id="subject"></h3>
        <h3 id="section_head"></h3>
        </div>
        <div id="grades_container"></div>
    </div>
</div>
    <script>
        var gradesheets;
        $(function(){
            show_gradesheets();
            $('#submit').on('click',show_gradesheets);
        });

        function show_gradesheets(){
            $.post("/logic/lecturer.php",{'method':'get_gradesheets'},function(data){

                data = JSON.parse(data);
                gradesheets = data;

                $("#gradesheets_container").html(
                    "<div class='slimscroll'>" +
                    "<table id=\"gradesheets_table\">" +
                        "<tr>" +
                            "<th>Subject</th>" +
                            "<th>Section</th>" +
                            "<th>Status</th>" +
                        "</tr>"
                );


                for(i = 0; i<data.length; i++)
                    $("#gradesheets_table").append(
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
                            "<td>" +
                                "<input class = 'submit-button' type=\"button\" value=\"Delete\" />"+
                            "</td>" +
                            "</tr>"
                    );

                $("#gradesheets_table").append("</table></div>");

                $('#gradesheets_table').find('input[type="button"]').on('click',function(event){
                    var subject = $(this).closest('tr').find('td').html();
                    var section = $(this).closest('tr').find('td').next().html();

                    var data = {
                      'Lecturer' : '<?php echo $_SESSION['name']?>',
                      'Course_code': subject,
                      'Section': section
                    };

                    $.post("/logic/lecturer.php",{'method':'delete_gradesheet','data':data},function(data){
                        show_gradesheets();
                        $('#grades_container').html('');
                    });

                    event.stopPropagation();
                });

                //show grades of gradesheets onclick
                $('#gradesheets_table').find('tr').next().on('click',function(){
                    $('#subject').html($(this).find('td').html());
                    $('#section_head').html($(this).find('td').next().html());
                    $(this).addClass("selected").siblings().removeClass("selected");
                    var subject = $(this).find('td').html();
                    var section = $(this).attr('value');
                    if($(this).find('td').next().next().html() == "APPROVED")
                        show_grades_noneditable(subject,section);
                    else show_grades(subject,section);
                });

                $("#gradesheets_container .slimscroll").slimscroll({
                    height:'100%'
                });

            });

        }

        function show_grades_noneditable(subject,section){
            $("#grades_container").html(
                "<div class='slimscroll'>" +
                "<table id='grades_table' border = 1>" +
                    "<tr>" +
                    "<th>Student No</th>" +
                    "<th>Grade</th>" +
                    "<th>Remarks</th>" +
                    "</tr>"+
                    "</table></div>"
            );

            var data = {'Course_code':subject,'Section':section,'Name':'<?php echo $_SESSION['name'];?>'};
            $.post("/logic/lecturer.php",{'method':'get_grades','data':data},function(data){

                data = JSON.parse(data);

                for(i = 0; i<data.length; i++){
                    $("#grades_table").append(
                        "<tr>" +
                            "<td>" + data[i].Student_no + "</td>" +
                            "<td>" + data[i].Grade + "</td>" +
                            "<td>" + data[i].Remarks + "</td>" +
                        "</tr>"
                    );
                }
            });
            $("#grades_container .slimscroll").slimscroll({
                height:'100%'
            });
        }

        function show_grades(subject,section){
            //highlight row on click
            var originalData;
            var gradeDropdown =
                "<select class=\"grade_dropdown\">" +
                    "<option>1.0</option><option>1.25</option><option>1.5</option><option>1.75</option>" +
                    "<option>2.0</option><option>2.25</option><option>2.5</option><option>2.75</option>" +
                    "<option>3.0</option><option>4.0</option><option>5.0</option>" +
                "</select>";

            //initialize grades table
            $("#grades_container").html(
                "<div class='slimscroll'>" +
                "<table id='grades_table' border = 1>" +
                    "<tr>" +
                    "<th>Student No</th>" +
                    "<th>Grade</th>" +
                    "<th>Remarks</th>" +
                    "<td><input class = 'submit-button'type=\"button\" id=\"add_row_button\" value=\"Add Grade\" /></td>"+
                    "<th></th>" +
                    "</tr>"+
                "</table>" +
                "</div>"
            );

            //add new table row on click of a button
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
                        "<input class = 'submit-button' type=\"button\" id=\"add_grade_button\" value=\"Add Grade\" />"+
                        "<input class = 'submit-button' type=\"button\" id=\"cancel_button\" value=\"X\" />"+
                        "</td>"+
                        "</tr>"
                );
                $('#add_grade_button').on('click',function(){
                    var data = {
                        'Lecturer': $.trim($('#user-name').text()),
                        'Student_no':$('#new_student_no').val(),
                        'Course_code':$('#subject').text(),
                        'Section':$('#section').text(),
                        'Grade':$("#new_grade").val(),
                        'Remarks':$('#new_remarks').val()
                    };
                    $.post("/logic/lecturer.php",{'method':'insert_grade','data':data});
                    $('#grades_table tr')[1].remove();
                    show_grades(data.Course_code,data.Section);
                });
                $('#cancel_button').on('click',function(){
                    $('#grades_table tr')[1].remove();
                });
            });

            var data = {'Course_code':subject,'Section':section,'Name':'<?php echo $_SESSION['name'];?>'};
            $.post("/logic/lecturer.php",{'method':'get_grades','data':data},function(data){

                data = JSON.parse(data);

                for(i = 0; i<data.length; i++){
                    $("#grades_table").append(
                        "<tr>" +
                            "<td>" +
                            "<input type=\"text\"  value=\""+data[i].Student_no+"\" maxlength=\"10\" />" +
                            "</td>" +
                            "<td>" +gradeDropdown.replace("<option>"+data[i].Grade,"<option selected=\"true\">"+data[i].Grade)+"</td>" +
                            "<td>" +
                            "<input type=\"text\" value=\""+ data[i].Remarks+"\" maxlength=\"50\" />" +
                            "</td>" +
                            "<td>" +
                                "<input class = 'submit-button' type=\"button\" id=\"save_button"+(i+1)+"\" class=\"save_button\" value=\"Save Changes\" hidden='true' />"+
                                "<input class = 'submit-button' type=\"button\" id=\"delete_button"+(i+1)+"\" class=\"delete_button\" value=\"Delete\" hidden='true' />"+
                            "</td>" +
                            "</tr>"
                    );
                }

                //event handler for save button
                $('.save_button').on('click',function(){
                    var buttonRow = $(this).closest('tr');
                    var data = {
                        'Lecturer': $.trim($('#user-name').text()),
                        'Old_student_no': originalData.Student_no,
                        'New_student_no': buttonRow.find('input').val(),
                        'Course_code':$('#subject').text(),
                        'Section':$('#section').text(),
                        'Grade': buttonRow.find('select').val(),
                        'Remarks': buttonRow.find('input')[1].value
                    };

                    $.post("/logic/lecturer.php",{'method':'update_grade','data':data},function(){
                        show_gradesheets();
                        show_grades(data.Course_code,data.Section);
                    });

                });

                //event handler for delete button
                $('.delete_button').on('click',function(){
                    var data = {
                        'Lecturer': $.trim($('#user-name').text()),
                        'Student_no':$(this).closest('tr').find('input').val(),
                        'Course_code':$('#subject').text(),
                        'Section':$('#section').text()
                    };
                    $.post("/logic/lecturer.php",{'method':'delete_grade','data':data},function(){
                        show_gradesheets();
                        show_grades(data.Course_code,data.Section);

                    });

                });

                //event for showing buttons onclick per row
                var rows = $('#grades_table').find('tr').next();
                rows.on('click',function(){
                    if($(this).attr('clicked') == undefined || $(this).attr('clicked') == "false"){
                        var previousRow = $('#grades_table').find('tr[clicked="true"]');
                        if(previousRow.length != 0){
                            var rowButtons = previousRow.find('input[type="button"]');
                            rowButtons.hide();
                            previousRow.attr('clicked',false);
                            cancelChanges(previousRow);
                        }
                        $(this).find('input[type="button"]').show();
                        $(this).attr('clicked',true);
                        var textInputs = $(this).find('input[type="text"]');
                        originalData = {
                            'Student_no':textInputs.val(),
                            'Grade':$(this).find('select').val(),
                            'Remarks':textInputs[1].value
                        }
                    }
                });
            });

            function cancelChanges(previousRow){
                var textInputs = previousRow.find('input[type="text"]');
                textInputs[0].value = originalData.Student_no;
                previousRow.find('select').val(originalData.Grade);
                textInputs[1].value = originalData.Remarks;
            }
            $("#grades_container .slimscroll").slimscroll({
                height:'100%'
            });
        }
    </script>
<?php
    include("/includes/footer.php");
?>