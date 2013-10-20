<?php
include("includes/header.php");
?>

    <!-- Temporary css-->

    <div id="logged">
        <div id="left_nav">
            <div id="filters-container">
                <label for="filters-container">Filter by:</label><br/>
                <label for="filter-lecturer">Lecturer</label>
                <select id="filter-lecturer" class="filter" name="filter-lecturer">
                    <option></option>
                </select>
                <label for="filter-course">Course Code</label>
                <select id="filter-course" class="filter" name="filter-course" >
                    <option></option>
                </select>
                <label for="filter-department">Department</label>
                <select id="filter-department" class="filter" name="filter-department">
                    <option></option>
                </select>
            </div>

            <div id="gradesheets_container_header"><img src="/img/GRADESHEETS.png"/></div>
            <div id="gradesheets_container"></div>

        </div>
    </div>
    <script>
        $(document).ready(function(){
            document.title = 'College Secretary Dashboard'

            fill_filters();

            function fill_filters(){
                $.post("/logic/collegesec.php",{'method':'get_filters'},function(data){
                    var filters = JSON.parse(data);
                    var i;


                    //fill Lecturers filter
                    for(i=0; i < filters.Lecturers.length; i++){
                        $('#filter-lecturer').append(
                            "<option>"+filters.Lecturers[i]+"</option>"
                        );
                    }

                    //fill Subjects filter
                    for(i=0; i < filters.Subjects.length; i++){
                        $('#filter-course').append(
                            "<option>"+filters.Subjects[i]+"</option>"
                        );
                    }

                    //fill Departments filter
                    for(i=0; i < filters.Departments.length; i++){
                        $('#filter-department').append(
                            "<option>"+filters.Departments[i]+"</option>"
                        );
                    }

                    $('.filter option').on('click',function(data){show_gradesheets(data);});
                 });
            }

            var lecturerFilter = '';
            var subjectFilter = '';
            var departmentFilter = '';
            generate_gradesheet_table();

            function show_gradesheets(data){
                var filterName = data.target.parentElement.name;
                var option = data.target.value;

                if(filterName == 'filter-lecturer')
                    lecturerFilter = option;
                else if(filterName == 'filter-course')
                    subjectFilter = option;
                else departmentFilter = option;

                generate_gradesheet_table();
            }

            function generate_gradesheet_table(){
                var data = [lecturerFilter,subjectFilter,departmentFilter];
                $.post("/logic/collegesec.php",{'method':'get_gradesheets_filtered','data':data},function(data){
                    var info = JSON.parse(data);
                    var i;

                    $('#gradesheets_container').html(
                        "<table id=\"gradesheets_table\">" +
                            "<tr>" +
                            "<th>Department</th>" +
                            "<th>Course Code</th>" +
                            "<th>Section</th>" +
                            "<th>Lecturer</th>" +
                            "</tr>" +
                            "</table>"
                    );

                    $('#gradesheets_table th').on('click',function(data){ sortTable(data);})

                    for(i = 0; i < info.length; i++){
                        $("#gradesheets_table").append(
                            "<tr>" +
                                "<td>" +
                                info[i].Department +
                                "</td>" +
                                "<td>" +
                                info[i].Course_code +
                                "</td>" +
                                "<td>" +
                                info[i].Section +
                                "</td>" +
                                "<td>" +
                                info[i].Lecturer +
                                "</td>" +
                                "</tr>"
                        );
                    }
                });
            }

            function sortTable(data){
                var columnIndex = data.target.cellIndex;

                var rows = $('#gradesheets_table tr').next();
                //bubble sort
                for(var x=0; x< rows.length; x++){
                    for(var y=0; y< rows.length-1; y++){
                        var cell1 = $($(rows[y]).find('td')[columnIndex]);
                        var cell2 = $($(rows[y+1]).find('td')[columnIndex]);

                        //console.log("Y: "+y+" "+cell1.text()+" > "+cell2.text()+" "+(cell1.text()>cell2.text()));
                        if(cell1.text() > cell2.text()){
                            $(rows[y]).next().after($(rows[y]));
                            rows = $('#gradesheets_table tr').next();
                        }
                    }
                }
            }
        });
    </script>

<?php
include("includes/footer.php");
?>