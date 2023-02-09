<?php
include 'connection.php';
function schedule_meeting($meeting_name, $start_time, $end_time, $users)
{
 
    
    $conn = OpenCon();

    
    $ScheduleValidator = false;
    foreach ($users as $user) 
    {
        $query = "SELECT * FROM meetings WHERE user_id=$user AND (start_time BETWEEN '$start_time' AND '$end_time' OR end_time BETWEEN '$start_time' AND '$end_time')";
        $res = mysqli_query($conn, $query);

        
            
        for($i = 0;$i < count($users);$i++)    
        { 

            if (mysqli_num_rows($res) > 0)
            {
                $ScheduleValidator = true;
                $row = mysqli_fetch_assoc($res);
                echo "User $user has a conflicting meeting: ".$row['meeting_name']."<br><br>";
                break;
            }
        }
    }

   
    if (!$ScheduleValidator)
     {
        foreach ($users as $user) 
        {
            $query = "INSERT INTO meetings (user_id, start_time, end_time, meeting_name) VALUES ($user, '$start_time', '$end_time', '$meeting_name')";
            mysqli_query($conn, $query);
            echo "The meeting $meeting_name has been successfully booked for $user<br>";
        }
        
    }
    
    else

    {
        echo "The meeting has not been booked.\n";
    }

    
    mysqli_close($conn);
}
$name = "test7";
$start =  '2022-09-27 05:00:00'; 
$end = '2022-09-27 06:00:00';
$users = [1,2,3,4];

schedule_meeting($name, $start, $end, $users);
?>