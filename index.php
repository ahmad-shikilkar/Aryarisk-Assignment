<?php

$input_file = fopen("input.txt", "r") or die("Unable to open file!");

$input = array();
echo "INPUT - <br>";
while(!feof($input_file)) {
    $text = fgets($input_file);
    $input[] = $text;
    echo $text."<br>";
}


fclose($input_file);

$test_cases = 0;
$friends_arr = array();
$friend_output = array();

if(isset($input) && !empty($input)){
    $test_cases = $input[0];
    unset($input[0]);
    $input = array_values($input);
    if($test_cases<1 || $test_cases>1000){
        die("No. of test cases - $test_cases (Test cases should be greater 0 and less than equal to 1000)");
    }else{
        $j=0;
        for($i=0; $i<=sizeof($input)-1; $i+=2){
            $temp = explode(' ', $input[$i]);
            if(isset($temp) && !empty($temp)){
                $friend_cnt = (int)trim($temp[0]);
                if($friend_cnt<1 || $friend_cnt>100000){
                    die("No. of friends - $friend_cnt (Test cases should be greater 0 and less than equal to 100000)");
                }


                $friend_del_count = (int)trim($temp[1]);
                
                $friends_arr[$j]['friend_cnt'] = $friend_cnt;
                $friends_arr[$j]['friend_del_count'] = $friend_del_count;
                
                $popularity = explode(' ', $input[$i+1]);
                $popularity = array_filter ($popularity, "check_popularity");
                if(isset($popularity) && !empty($popularity)){
                    $friends_arr[$j]['popularity'] = $popularity;
                }else{
                    die("Error in input file!");    
                }
                $j++;

                if($friend_cnt!=count($popularity)){
                    //die("Error in input file! - Friends and popularity count does not match!");    
                }

            }else{
                die("Error in input file!");
            }
        }

        if(isset($friends_arr) && !empty($friends_arr)){
            foreach($friends_arr as $fri){
                
                $friendDelCnt = $fri['friend_del_count'];
                $friendDeletedCnt = 0;
                
                while ($friendDelCnt!=$friendDeletedCnt){
                    $deleteFriend = false;
                    for($i=0; $i<=$fri['friend_cnt']-1; $i++){
                        if(isset($fri['popularity'][$i+1]) && (int)trim($fri['popularity'][$i]) < (int)trim($fri['popularity'][$i+1])){
                            array_splice($fri['popularity'], $i,1);
                            $deleteFriend = true;
                            break;
                        }
                    }
                    $friendDeletedCnt++;
                }
                if($deleteFriend==false){
                    array_pop($fri['popularity']);
                }
                $friend_output[] = implode(" ",$fri['popularity']);
            }
        }else{
            die("Error in input file!");
        }

    }
}

if(isset($friend_output) && !empty($friend_output)){
    echo "<br><br>OUTPUT - <br>";
    $text = "";
    foreach($friend_output as $op){
        $text .= $op;
        echo $op."<br>";
    }
    /*
    $outputFile = fopen("output.txt", "w") or die("Unable to open file!");
    fwrite($outputFile, $text);
    fclose($outputFile);
    */
}

function check_popularity($popularity=0){
    $input = (float)(trim($popularity));
    if($input<0 || $input>100){
        die("Popularity should be greater than 0 and less than equal to 100.");
    }
    return true;
}
