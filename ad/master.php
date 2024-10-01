<?php

class Master {
    /**
     * Get All JSON Data
     */
    function get_all_data(){
        $json = (array) json_decode(file_get_contents('data.json'));
        $data = [];
        foreach($json as $row){
            $data[$row->id] = $row;
        }
        return $data;
    }

    /**
     * Get single JSON Data
     */
    function get_data($id = ''){
        if(!empty($id)){
            $data = $this->get_all_data();
            if(isset($data[$id])){
                return $data[$id];
            }
        }
        return (object) [];

    }

    /**
     * Insert Data into JSON File
     */
    function insert_to_json(){
        $name = addslashes($_POST['name']);
        $contact = addslashes($_POST['contact']);
        $address = addslashes($_POST['address']);
        $device = addslashes($_POST['device']);
        $days = addslashes($_POST['days']);
        
$curdate=date("d/m/Y");


$dates = mktime(0,0,0,date("m"),date("d")+$days,date("Y"));
$expiration_date = date("d/m/Y", $dates);

        $data = $this->get_all_data();
        $id = array_key_last($data) + 1;
        $data[$id] = (object) [
            "id" => $id,
            "name" => $name,
            "contact" => $contact,
            "address" => $address,
            "device" => $device,
            
  "curdate" => $curdate,
  
            "days" => $days,
            
 
            "expiration_date" => $expiration_date
        ];
        $json = json_encode(array_values($data), JSON_PRETTY_PRINT);
        $insert = file_put_contents('data.json', $json);
        if($insert){
            $resp['status'] = 'success';
        }else{
            $resp['failed'] = 'failed';
        }
        return $resp;
    }
    /**
     * Update JSON File Data
     */
    function update_json_data(){
        $id = $_POST['id'];
        $name = addslashes($_POST['name']);
        $contact = addslashes($_POST['contact']);
        $address = addslashes($_POST['address']);
        $device = addslashes($_POST['device']);
        
$curdate=date("d/m/Y");



           $days = addslashes($_POST['days']);
           
$dates = mktime(0,0,0,date("m"),date("d")+$days,date("Y"));
$expiration_date = date("d/m/Y", $dates);

        $data = $this->get_all_data();
        $data[$id] = (object) [
            "id" => $id,
            "name" => $name,
            "contact" => $contact,
            "address" => $address,
            "device" => $device,
  "curdate" => $curdate,
             "days" => $days,
            "expiration_date" => $expiration_date
        ];
        $json = json_encode(array_values($data), JSON_PRETTY_PRINT);
        $update = file_put_contents('data.json', $json);
        if($update){
            $resp['status'] = 'success';
        }else{
            $resp['failed'] = 'failed';
        }
        return $resp;
    }

    /**
     * Delete Data From JSON File
     */

     function delete_data($id = ''){
        if(empty($id)){
            $resp['status'] = 'failed';
            $resp['error'] = 'Given Member ID is empty.';
        }else{
            $data = $this->get_all_data();
            if(isset($data[$id])){
                unset($data[$id]);
                $json = json_encode(array_values($data), JSON_PRETTY_PRINT);
                $update = file_put_contents('data.json', $json);
                if($update){
                    $resp['status'] = 'success';
                }else{
                    $resp['failed'] = 'failed';
                }
            }else{
                $resp['status'] = 'failed';
                $resp['error'] = 'Given Member ID is not existing on the JSON File.';
            }
        }
        return $resp;
     }
}