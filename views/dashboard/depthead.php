
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
    <div id="gradesheets_container_approved"></div>
    <div id="gradesheets_container_disapproved"></div>
    <h3 id="grades_info"></h3>
    <div id="grades_container"></div>

    <script>
        var gradesheets = [];

        $(function(){
            search_gradesheet("gradesheets_container", "PENDING",1);
            search_gradesheet("gradesheets_container_approved", "APPROVED",2);
            search_gradesheet("gradesheets_container_disapproved","DISAPPROVED",3);
            $('#search_button').click(function(e){
                search_gradesheet("gradesheets_container", "PENDING",1);
                search_gradesheet("gradesheets_container_approved", "APPROVED",2);
                search_gradesheet("gradesheets_container_disapproved","DISAPPROVED",3);
                e.preventDefault();
            });
        });

        function search_gradesheet(container,status,index){

            data = {'course_code':$('#search_text').val(),'status':status};

            $.post("/logic/depthead.php",{'method':'get_gradesheets', 'data':data},function(data){

                data = JSON.parse(data);
                gradesheets[index]= data;
                show_gradesheets(container,index);
            });

        }

        function show_gradesheets(container,index){
            $("#"+container).html(
                "<table id=\"gradesheets_table\">" +
                    "<tr>" +
                    "<th>Subject</th>" +
                    "<th>Section</th>" +
                    "<th>Lecturer</th>" +
                    "<th>Status</th>" +
                    "</tr>"
            );

            for(i = 0, j = gradesheets[index].length; i<j; i++){
                $("#"+container+" > table").append(
                    "<tr value = '"+gradesheets[index][i].Section+"'>" +
                        "<td>" +
                        gradesheets[index][i].Course_code +
                        "</td>" +
                        "<td>" +
                        gradesheets[index][i].Section +
                        "</td>" +
                        "<td>" +
                        gradesheets[index][i].Lecturer +
                        "</td>" +
                        "<td>" +
                        gradesheets[index][i].Status +
                        "</td>"
//                    "</tr>"
                );

                if(container == "gradesheets_container"){
                    $("#"+container+" > table > tbody >tr:nth-child(" + (i+1) + ")").next().append(
                        "<td>" +
                        "<button onclick = 'update_gradesheet("+'"'+gradesheets[index][i].Section+'"'+","+'"'+gradesheets[index][i].Course_code+'"'+","+'"'+"APPROVED"+'"'+")'>Approve</button>" +
                        "</td>" +
                        "<td>" +
                        "<button onclick = 'update_gradesheet("+'"'+gradesheets[index][i].Section+'"'+","+'"'+gradesheets[index][i].Course_code+'"'+","+'"'+"DISAPPROVED"+'"'+")'>Disapprove</button>" +
                        "</td>"
                    );
                }

               $("#"+container+" > table > tbody").append();
            }

                $("#"+container).append("</table>");

                $("#"+container+" > table").find('tr').next().on('click',function(){
                    show_grades($(this).find('td').html() ,$(this).attr('value'),$(this).children("td").next().next().html());
                    $("#gradesheets_container > table").find("tr").siblings().addBack().removeClass("selected");
                    $("#gradesheets_container_approved > table").find("tr").siblings().addBack().removeClass("selected");
                    $("#gradesheets_container_disapproved > table").find("tr").siblings().addBack().removeClass("selected");
                    $(this).addClass("selected");
                });

                $("#"+container+" > table").find('tr').find('th').on('click', function(){
                    arrange_gradesheets($(this).html(),$(this).parent().parent().parent().parent().attr('id'),index);
                });



            //add grades to the gradesheet table
                //make it hidden at first and could be shown when clicked like in toggleable asdfasdf
        }

        function arrange_gradesheets(arrange_by, parent_id,index){
            gradesheet = gradesheets[index].sort(function(a,b){
                if(arrange_by.toLowerCase() == 'lecturer'){
                    return a.Lecturer > b.Lecturer;
                }
                else if(arrange_by.toLowerCase() == 'subject'){
                    return a.Course_code > b.Course_code;
                }
                else if(arrange_by.toLowerCase() == 'status'){
                    return a.Status > b.Status;
                }
            });

            show_gradesheets(parent_id,index);
        }

        function update_gradesheet(section, course_code, status){
            var data = {'course_code':course_code, 'section':section, 'status':status};

            $.post("/logic/depthead.php/",{'method':'update_gradesheet', 'data':data},function(data){
                search_gradesheet("gradesheets_container", "PENDING",1);
                search_gradesheet("gradesheets_container_approved", "APPROVED",2);
                search_gradesheet("gradesheets_container_disapproved","DISAPPROVED",3);

                //    console.log(data);
//                data = JSON.parse(data);
            });
        }

        function show_grades(subject, section, lecturer){
            //highlight row on click
//            console.log(lecturer);
            var data = {'Course_code':subject ,'Section':section, 'Name':lecturer};

            $.post("/logic/lecturer.php",{'method':'get_grades','data':data},function(data){
                data = JSON.parse(data);

                $("#grades_info").html(data[0].Course_code + " " + data[0].Section);

                $("#grades_container").html(
                    "<table id='grades_table' border = 1>" +
                        "<tr>" +
                        "<th>Student No</th>" +
                        "<th>Grade</th>" +
                        "<th>Remarks</th>" +
                        "</tr>"
                );


                for(i = 0; i<data.length; i++)
                    $("#grades_container > table").append(
                        "<tr>" +
                            "<td>" +
                            data[i].Student_no +
                            "</td>" +
                            "<td>" +
                            data[i].Grade+
                            "</td>" +
                            "<td>" +
                            data[i].Remarks+
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