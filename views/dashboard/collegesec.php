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
        <div id="right_nav" hidden>
            <h3 id="grades_info"></h3>
            <div id="grades_container"></div>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            document.title = 'College Secretary Dashboard'

            var lecturerFilter = '';
            var subjectFilter = '';
            var departmentFilter = '';
            var filterFilled = false;
            generate_gradesheet_table();

            function show_gradesheets(data){
                var filterName = data.target.name;
                var option = $(data.target[data.target.selectedIndex]).text();

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
                        "<div class='slimscroll'>" +
                        "<table id=\"gradesheets_table\">" +
                            "<tr>" +
                            "<th>Department</th>" +
                            "<th>Course Code</th>" +
                            "<th>Section</th>" +
                            "<th>Lecturer</th>" +
                            "</tr>" +
                            "</table>"+
                            "</div>"
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

                    $('#gradesheets_table tr').next().on('click',function(data){show_grades(data);});
                    $("#gradesheets_container .slimscroll").slimscroll({
                        height:'100%'
                    });


                    $("#gradesheets_container table").find('tr').next().on('click',function(){
                        $("#gradesheets_container  table").find("tr").siblings().addBack().removeClass("selected");
                        $(this).addClass("selected");
                    });

                    if(!filterFilled){
                        var lecturers = [];
                        var subjects = [];
                        var departments = [];

                        for(i=0; i < info.length; i++){
                            console.log(lecturers.indexOf(info[i]['Lecturer']));
                            if(lecturers.indexOf(info[i]['Lecturer']) == -1) //prevents duplicates
                                lecturers.push(info[i]['Lecturer']);
                            if(subjects.indexOf(info[i]['Course_code']) == -1)
                                subjects.push(info[i]['Course_code']);
                            if(departments.indexOf(info[i]['Department']) == -1)
                                departments.push(info[i]['Department']);
                        }
                        var filters = {
                            'Lecturers': lecturers,
                            'Subjects': subjects,
                            'Departments': departments
                        };

                        fill_filters(filters);
                        filterFilled = true;
                    }
                });
            }

            function show_grades(info){
                //console.log(i);
                $("#right_nav").hide("slide", { direction: "left" }, 300);
                var data = {'Course_code':$(info.currentTarget.cells[1]).text()
                    ,'Section':$(info.currentTarget.cells[2]).text()
                    , 'Name':$(info.currentTarget.cells[3]).text()};

                $("#grades_info").html(data['Course_code'] + " " + data['Section']);

                $.post("/logic/lecturer.php",{'method':'get_grades','data':data},function(data){
                    data = JSON.parse(data);

                    $("#grades_container").html(
                        "<div class='slimscroll'>" +
                            "<table id='grades_table' border = 1>" +
                            "<tr>" +
                            "<th>Student No</th>" +
                            "<th>Grade</th>" +
                            "<th>Remarks</th>" +
                            "</tr>"
                    );


                    for(i = 0; i<data.length; i++)
                        $("#grades_container  table").append(
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

                    $("#gradesheets_container  table").append("</table></div>");
                    $("#right_nav").show("slide", { direction: "left" }, 1000);

                });
            }

            function fill_filters(filters){
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
                $('.filter').on('change',function(data){show_gradesheets(data);});
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