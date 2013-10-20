<?php
include("includes/header.php");
?>

<html>
	<head>
		<title>Student Dashboard</title>
	</head>
	<body>
        <h3>Plan of Study</h3>

		<br />
		<div id="plan-of-study-container">
            <div id="inner-div">
            <table id="plan-of-study-table">
                <?php
                    include "../db/db.php";

                    $db = new Database();

                    for($i = 0; $i < 4; $i++){
                        echo "<tr>";
                        for($j = 0; $j < 2; $j++){
                            //table for each year and sem
                            echo "<td>";
                                generate_semplan_table($i,$j,$db);
                            echo "</td>";
                        }
                        echo "</tr>";
                        //new table if there student plans to take summer classes for the school year
                        $semplan = $db->get_plan($i+1,'SUMMER');
                        if($semplan){
                            echo "<tr>";
                                echo "<td>";
                                    generate_semplan_table($i,'SUMMER',$db);
                                echo "</td>";
                            echo "</tr>";
                        }
                    }

                    function generate_semplan_table($i,$j,$db){
                        $numbers = array('FIRST','SECOND','THIRD','FOURTH');

                        echo "<table class=\"semester\" >";
                            echo "<tr>";
                                echo "<th>".$numbers[$i]." Year, ";
                                if((string) $j == "SUMMER"){
                                    echo "SUMMER";
                                    $sem = $j;
                                }
                                else {
                                    echo $numbers[$j]." Semester"."</th>";
                                    $sem = $j+1;
                                }

                                echo "</tr>";

                                $semplan = $db->get_plan($i+1,$sem);
                                for($r = 0; $r < count($semplan); $r++){
                                    echo "<tr>";
                                        echo "<td>";
                                            echo $semplan[$r]['Course_code'];
                                        echo "</td>";
                                        echo "<td>";
                                            echo $semplan[$r]['Units'];
                                        echo "</td>";
                                        echo "<td>";
                                            if( $semplan[$r]['Grade'] == null )
                                                echo "_____";
                                            else echo $semplan[$r]['Grade'];
                                        echo "</td>";
                                    echo "</tr>";
                                }
                        echo "</table>";
                    }
                ?>
            </table>
        </div>

		</div>
	</body>
</html>

<?php
include("includes/footer.php");
?>