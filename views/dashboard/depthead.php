
<?php
    include("includes/header.php");
?>

    <div id = "depthead_search_bar" >
        <form>
            <input type="text" name="search_text" id="search_text" placeholder="Search subject here"/>
            <input type="submit" id="search_button"/>
        </form>
    </div>

    <div id="gradesheets_container"></div>
    <h3 id="grades_info"></h3>
    <div id="grades_container"></div>

    <script>
        $(function(){
            search_gradesheet();
            $('#search_button').click(function(e){
                search_gradesheet();
                e.preventDefault();
            });
        });

        function search_gradesheet(){

            data = {'course_code':$('#search_text').val()};

            $.post("/logic/depthead.php",{'method':'get_gradesheets', 'data':data},function(data){

            //    console.log(data);
                data = JSON.parse(data);


                $("#gradesheets_container").html(
                    "<table id=\"gradesheets_table\">" +
                        "<tr>" +
                        "<th>Subject</th>" +
                        "<th>Section</th>" +
                        "<th>Lecturer</th>" +
                        "<th>Status</th>" +
                        "</tr>"
                );


                for(i = 0, j = data.length; i<j; i++)
                    $("#gradesheets_container > table").append(
                        "<tr value = '"+data[i].Section+"'>" +
                            "<td>" +
                            data[i].Course_code +
                            "</td>" +
                            "<td>" +
                            data[i].Section +
                            "</td>" +
                            "<td>" +
                            data[i].Lecturer +
                            "</td>" +
                            "<td>" +
                            data[i].Status +
                            "</td>" +
                            "<td>" +
                            "<button onclick = 'update_gradesheet("+'"'+data[i].Section+'"'+","+'"'+data[i].Course_code+'"'+","+'"'+"APPROVED"+'"'+")'>Approve</button>" +
                            "</td>" +
                            "<td>" +
                            "<button onclick = 'update_gradesheet("+'"'+data[i].Section+'"'+","+'"'+data[i].Course_code+'"'+","+'"'+"DISAPPROVED"+'"'+")'>Disapprove</button>" +
                            "</td>" +
                            "</form>" +
                        "</tr>"
                    );

                $("#gradesheets_container").append("</table>");

                $('#gradesheets_table').find('tr').next().on('click',function(){
                    show_grades($(this).attr('value'),$(this).children("td").next().next().html());
                });


//add grades to the gradesheet table
                //make it hidden at first and could be shown when clicked like in toggleable asdfasdf
            });
        }

        function update_gradesheet(section, course_code, status){
            data = {'course_code':course_code, 'section':section, 'status':status};

            $.post("/logic/depthead.php/",{'method':'update_gradesheet', 'data':data},function(data){
                search_gradesheet();

                //    console.log(data);
//                data = JSON.parse(data);
            });
        }

        function show_grades(section, lecturer){
            //highlight row on click

            var data = {'section':section, 'name':lecturer};
            $.post("/logic/lecturer.php",{'method':'get_grades','data':data},function(data){

                console.log(lecturer);
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
    include("includes/footer.php");
?>