
<?php
    include("includes/header.php");
?>

    <div id = "depthead_search_bar" >
            <input type="text" name="search_text" id="search_text" placeholder="Search subject here"/>
            <button type="button" id="search_button">Search</button>
    </div>

    <div id="gradesheets_container"></div>

    <script>
        $(function(){
            console.log("ASDF");
            $('#search_button').on('click',search_gradesheet);
        });

        function search_gradesheet(){
            console.log("ASDF");
            $.post("/logic/depthead.php/",{'method':'get_gradesheets'},function(data){

                data = JSON.parse(data);
                console.log(data);

                $("#gradesheets_container").html(
                    "<table border = 1>" +
                        "<tr>" +
                            "<td>" +
                            "<h3" +
                        "> SUBJECT </h3>" +
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
                        "</tr>"
                    );

                $("#gradesheets_container > table").append("</table>");



//add grades to the gradesheet table
                //make it hidden at first and could be shown when clicked like in toggleable asdfasdf
            });
        }

    </script>

<?php
    include("includes/footer.php");
?>