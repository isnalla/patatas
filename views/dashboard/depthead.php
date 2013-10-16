
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
            $.post("/db/db.php", {'method':'get_gradesheets'},function(data){

                console.log(data);
                data = JSON.parse(data);
                $("#gradesheets_container").html(
                    data[0].Department_name
                );

                $("#gradesheets_container").html("");

                for(i = 0, j = data.length; i<j; i++)
                $("#gradesheets_container").append(
                    "<tr>" +
                        "<td>" +
                        data[i].Course_code +
                        "<td>" +
                        "<td>" +
                        data[i].Section +
                        "<td>" +
                        "<td>" +
                        data[i].Lecturer +
                        "<td>" +
                        "<td>" +
                        data[i].Status +
                        "<td>" +
                    "<tr>"
                );

//add grades to the gradesheet table
                //make it hidden at first and could be shown when clicked like in toggleable asdfasdf
            });
        }

    </script>

<?php
    include("includes/footer.php");
?>