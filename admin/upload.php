<?php
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$exam=$_POST['name'];
$exam=trim($exam);
$instruction=$_POST['instruction'];
$exam_time=$_POST['time'];
$uploadOk = 1;
require '../db.php';
$qr=mysql_fetch_array( mysql_query("SELECT * FROM `exam` WHERE `name` LIKE '$exam';"));
if($qr['s.no']){
    echo "Same Exam name already exists";
    exit();
}
$FileType = pathinfo($target_file,PATHINFO_EXTENSION);
if($FileType != "txt") {
    echo "Sorry, only .txt file is allowed.\n$name\n";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} 
else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $exam_id=uniqid("exam");
        $target_file_new=$target_dir.$exam_id.".txt";
        rename ($target_file, $target_file_new);
        updatedb($exam_id,$target_file_new);

        } 
    else {
        echo "Sorry, there was an error uploading your file.";
    }

}
function updatedb($exam_id,$target_file)
{   
    global $exam,$exam_time,$instruction;
    $data = file_get_contents($target_file); //read the file
    $convert = explode("\n", $data); //create array separate by new line
    $length=count($convert);
    $j=0;
    $fileq=fopen("1.txt", "a");
    for ($i=0;$i<$length;$i++) 
    {      
        $t1=$convert[$i][0];
        $convert[$i]=urlencode(substr($convert[$i], 2));
        fwrite($fileq, "$convert[$i]\n");
        // echo "$k $t1 $convert[$i]\n<br>";
        switch ($t1) {
            case 'q':
                $question[$j]=$convert[$i];
                $temp="";
                $question_id[$j]=uniqid("ques");
                break;
            case 'a':
                $question[$j].=$temp;
                $temp="";
                fwrite($fileq, "q: $question[$j]"."\n");
                // echo "q : $question[$j] <br>";
                $k=($j*4)+0;
                $choice[$k]=$convert[$i];
                $choice_id[$k]=uniqid("choi");
                break;
            case 'b':
                $choice[$k].=$temp;
                $temp="";
                fwrite($fileq, "a: $choice[$k]"."\n");
                // echo "a : $choice[$k]<br>";
                $k=($j*4)+1;
                $choice[$k]=$convert[$i];
                $choice_id[$k]=uniqid("choi");
                break;
            case 'c':
                $choice[$k].=$temp;
                $temp="";
                fwrite($fileq, "b: $choice[$k]"."\n");
                // echo "b : $choice[$k]<br>";
                $k=($j*4)+2;
                $choice[$k]=$convert[$i];
                $choice_id[$k]=uniqid("choi");
                break;
            case 'd':
                $choice[$k].=$temp;
                $temp="";
                fwrite($fileq, "c: $choice[$k]"."\n");
                // echo "c : $choice[$k]<br>";
                $k=($j*4)+3;
                $choice[$k]=$convert[$i];
                $choice_id[$k]=uniqid("choi");
                break;
            case 'A':
                $choice[$k].=$temp;
                $temp="";
                fwrite($fileq, "d: $choice[$k]"."\n");
                // echo "d : $choice[$k]<br>";
                $answer[$j]=$convert[$i];
                $j++;
                break;
            case '':
                $answer[$j].=$temp;
                fwrite($fileq, "A: $answer[$j]"."\n\n");
                // echo "A : $answer[$j]<br>";
                $temp="";
                // echo urlencode("<br>");
                break;
            default:
                $temp.=urlencode("<br>")."\n".$convert[$i];
                break;
        }
    }
    fwrite($fileq, "tot : $j \n");
    $tot_ques=$j;

    $exam_table="INSERT INTO `exam`(`examid`, `name`, `questions`, `duration`,`instruction`) VALUES ('$exam_id','$exam','$tot_ques','$exam_time','$instruction')";
    $question_table= "INSERT INTO `question`(`examid`, `ques-id`, `question`, `choice`) VALUES ";
    $options_table="INSERT INTO `options`(`ques-id`, `option`, `option-id`) VALUES ";
    $answer_table="INSERT INTO `answer`(`ques-id`, `ans-id`) VALUES ";
    for ($i=0; $i <$tot_ques ; $i++) { 
        
        $question_table.="('$exam_id', '$question_id[$i]', '$question[$i]','4'), ";
        for ($j=0; $j <4 ; $j++) { 
            $k=($i*4)+$j;
            $options_table.="('$question_id[$i]', '$choice[$k]', '$choice_id[$k]'), ";
            }
            $k=($i*4)+$j;
            if (($answer[$i]==$choice[($k-4)])) {
                $answer_table.="('$question_id[$i]','".$choice_id[$k-4]."'), ";
            }
            elseif (($answer[$i]==$choice[$k-3])) {
                $answer_table.="('$question_id[$i]','".$choice_id[($k-3)]."'), ";
            }
            elseif (($answer[$i]==$choice[$k-2])) {
                $answer_table.="('$question_id[$i]','".$choice_id[($k-2)]."'), ";
            }
            elseif (($answer[$i]==$choice[$k-1])) {
                $answer_table.="('$question_id[$i]','".$choice_id[($k-1)]."'), ";
            }
        
    }
    $question_table=rtrim($question_table,", ");
    $options_table=rtrim($options_table,", ");
    $answer_table=rtrim($answer_table, ", ");
    $file=fopen("2.txt", "w");
    fwrite($file, "$question_table\n");
    fwrite($file, "$options_table\n");
    fwrite($file, "$answer_table\n");
    
    require '../db.php';
    mysql_query($exam_table);
    mysql_query($question_table);
    mysql_query($options_table);
    mysql_query($answer_table);
    echo "Exam created successfully";




}


 /* 
for ($i=0;$i<$length;$i++) 
{   
    $j=($i/7)+1;
    switch (($i)%7) {
        case '0':
            echo "<tr>";
            echo "<td>$j</td>";
            echo "<td>".uniqid("ques")."</td>";
            break;
        case '1':
            echo "<td>".uniqid("choi")."</td>";
            break;
        case '2':
            echo "<td>".uniqid("choi")."</td>";
            break;
        case '3':
            echo "<td>".uniqid("choi")."</td>";
            break;
        case '4':
            echo "<td>".uniqid("choi")."</td>";
            break;
        case '5':
            echo "<td>".uniqid("answ")."</td>";
            echo "</tr>";
            break;
        case '6':
            break;
    }
}
echo "</table>";

*/


?> 
