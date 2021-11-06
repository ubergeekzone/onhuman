<?php

$action = "";
$action = $_GET['action'];

class Airtable {
   
    protected  $baseID;
    protected  $apiKey;

    function __construct($baseID, $apiKey) {
        $this->airtableAPIURL = "https://api.airtable.com/v0/";
        $this->baseID = $baseID;
        $this->apiKey = $apiKey;
    }

    function companies($prefix) {

        try {
            
            return  Requests::get(
                $this->airtableAPIURL.$this->baseID.'/Companies?api_key='.$this->apiKey.'&filterByFormula=({Domain Prefix} = "'.$prefix.'")',
                array(
                    'User-Agent' => 'On Human (onhuman@test.com)'
                )
            );

        } catch (Throwable $e) {
            // Handle error
            echo json_encode(array("error" => true));
        }
 
    }

    function projects($id) {

        try {
            
            return  Requests::get(
                $this->airtableAPIURL.$this->baseID.'/Projects?api_key='.$this->apiKey.'&filterByFormula=({Harvest Project ID} = "'.$id.'")',
                array(
                    'User-Agent' => 'On Human (onhuman@test.com)'
                )
            ); 

        } catch (Throwable $e) {
            // Handle error
            echo json_encode(array("error" => true));
        }


    }

    function teamMembers($id) {

        try {
            
            return  Requests::get(
                $this->airtableAPIURL.$this->baseID.'/Team%20Members?api_key='.$this->apiKey.'&filterByFormula=({Harvest Team Member ID} = "'.$id.'")',
                array(
                    'User-Agent' => 'On Human (onhuman@test.com)'
                )
            ); 

        } catch (Throwable $e) {
            // Handle error
            echo json_encode(array("error" => true));
        }


    }


}

if(isset($action)) {
   
    $airtable = new Airtable("", "");
    $id = "";
    $id = $_GET['id'];

    $prefix = "";
    $prefix = $_GET['prefix'];
    
    if($action === "companies") {
        $response = $airtable->companies($prefix);
        if($response->body) {
            echo $response->body;
            die();
        }
    }

    if($action === "projects") {
        $response = $airtable->projects($id);
        if($response->body) {
            echo $response->body;
            die();
        }
    }

    
    if($action === "team-members") {
        $response = $airtable->teamMembers($id);
        if($response->body) {
            echo $response->body;
            die();
        }
    }

}