
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

            $.post("/logic/depthead.php/",{'method':'get_gradesheets', 'data':data},function(data){

            //    console.log(data);
                data = JSON.parse(data);


                $("#gradesheets_container").html(
                    "<table>" +
                        "<tr>" +
                            "<td>" +
                            "<h3> SUBJECT </h3>" +
                            "</td>" +
                            "<td>" +
                            "<h3> SECTION </h3>" +
                            "</td>" +
                            "<td>" +
                            "<h3> LECTURER</h3>" +
                            "</td>" +
                            "<td>" +
                            "<h3> STATUS</h3>" +
                            "</td>" +
                        "</tr>"
                );


                for(i = 0, j = data.length; i<j; i++)
                    $("#gradesheets_container > table").append(
                        "<tr>" +
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


    </script>

<?php
    include("includes/footer.php");
?>