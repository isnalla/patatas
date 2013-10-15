
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
            $.post("/db/db.php", {'method':'get_department'},function(data){

                console.log(data);
                data = JSON.parse(data);

                $("#gradesheets_container").html(
                    data[0].Department_name
                );

            });
        }

    </script>

<?php
    include("includes/footer.php");
?>