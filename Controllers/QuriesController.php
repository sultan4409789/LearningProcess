<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuriesController extends Controller
{
    //

    public function GenerateQuriesFile()
    {
        $filename = "Hgs 404.csv";
        $QueriesfileName = "404_HGS.txt";
        
        $row = 1;
        if (($handle = fopen(base_path()."/".$filename, "r")) !== FALSE) {

            $Queriesfile = fopen(base_path()."/".$QueriesfileName, "w");

            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                     $num = count($data);
                    //  echo "<p> $num fields in line $row: <br /></p>\n";exit;
                    // $row++;

                    
                    $request_path = "";
                    $target_path = "";
                    if($row != 1)
                    {
                        for ($c=0; $c < $num; $c++) {
                            // echo $data[$c] . "<br />\n";

                            if($c == 0)
                            {
                                $request_path = $data[$c];

                            }
                            elseif($c == 1)
                            {
                                $target_path = $data[$c];
                                // $target_path = " ";
                            }
                            else
                            {

                            }
                        }

                        // if($request_path == $target_path)
                        // {
                        //     echo $request_path." -----".$target_path;
                        // }
                        
                        $query_text = "INSERT INTO `rfglive`.`core_url_rewrite` (`store_id`, `id_path`, `request_path`, `target_path`, `is_system`, `options`) VALUES ('3', '".$request_path."','".$request_path."','".$target_path."','0','RP');";

                        fwrite($Queriesfile, $query_text . "\n");
                    }
                    else
                    {
                        $row++;
                    }
                        
                }

            fclose($handle);
            }

            echo "finished";
    }

    public function add($num1, $num2)
    {
        return $num1 + $num2;
    }
}
