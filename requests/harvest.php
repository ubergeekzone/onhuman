<?php

$action = "";
$action = $_GET['action'];

class Harvest {
   
    protected  $accessToken;
    protected  $harvestAccountId;

    function __construct($accessToken,  $harvestAccountId) {
        $this->harvestAPIURL = "https://api.harvestapp.com/v2/";
        $this->accessToken = $accessToken;
        $this->harvestAccountId = $harvestAccountId;

    }

    function getClient($id) {
        return  Requests::get(
            $this->harvestAPIURL."/clients/".$id,
            array(
                'Authorization' => 'Bearer '.$this->accessToken,
                'Harvest-Account-Id' => $this->harvestAccountId,
                'User-Agent' => 'On Human (onhuman@test.com)'
            )
        ); 
    }

    function getContact($id) {
        return  Requests::get(
            $this->harvestAPIURL."/contacts/".$id,
            array(
                'Authorization' => 'Bearer '.$this->accessToken,
                'Harvest-Account-Id' => $this->harvestAccountId,
                'User-Agent' => 'On Human (onhuman@test.com)'
            )
        ); 
    }

    function getUser($id) {
        return  Requests::get(
            $this->harvestAPIURL."/users/".$id,
            array(
                'Authorization' => 'Bearer '.$this->accessToken,
                'Harvest-Account-Id' => $this->harvestAccountId,
                'User-Agent' => 'On Human (onhuman@test.com)'
            )
        ); 
    }

    function listClientContacts($id) {
        return  Requests::get(
            $this->harvestAPIURL."/contacts?client_id=".$id,
            array(
                'Authorization' => 'Bearer '.$this->accessToken,
                'Harvest-Account-Id' => $this->harvestAccountId,
                'User-Agent' => 'On Human (onhuman@test.com)'
            )
        ); 
    }

    function listProjects($id) {
        return  Requests::get(
            $this->harvestAPIURL."/projects?client_id=".$id,
            array(
                'Authorization' => 'Bearer '.$this->accessToken,
                'Harvest-Account-Id' => $this->harvestAccountId,
                'User-Agent' => 'On Human (onhuman@test.com)'
            )
        ); 
    }

    function listEstimates($id) {
        return  Requests::get(
            $this->harvestAPIURL."/estimates?client_id=".$id,
            array(
                'Authorization' => 'Bearer '.$this->accessToken,
                'Harvest-Account-Id' => $this->harvestAccountId,
                'User-Agent' => 'On Human (onhuman@test.com)'
            )
        ); 
    }

    function listInvoices($id, $projectID) {
        $appendURL = "";
        if($projectID !== null) {
            $appendURL .= "&project_id=".$projectID;
        }
        return  Requests::get(
            $this->harvestAPIURL."/invoices?client_id=".$id.$appendURL,
            array(
                'Authorization' => 'Bearer '.$this->accessToken,
                'Harvest-Account-Id' => $this->harvestAccountId,
                'User-Agent' => 'On Human (onhuman@test.com)'
            )
        ); 
    }

    function listExpenses($id, $projectID) {
        $appendURL = "";
        if($projectID !== null) {
            $appendURL .= "&project_id=".$projectID;
        }
        return  Requests::get(
            $this->harvestAPIURL."/expenses?client_id=".$id.$appendURL,
            array(
                'Authorization' => 'Bearer '.$this->accessToken,
                'Harvest-Account-Id' => $this->harvestAccountId,
                'User-Agent' => 'On Human (onhuman@test.com)'
            )
        ); 
    }

    function getProject($id) {
        return  Requests::get(
            $this->harvestAPIURL."/projects/".$id,
            array(
                'Authorization' => 'Bearer '.$this->accessToken,
                'Harvest-Account-Id' => $this->harvestAccountId,
                'User-Agent' => 'On Human (onhuman@test.com)'
            )
        ); 
    }

    function getProjectTaskAssignments($id) {
        return  Requests::get(
            $this->harvestAPIURL."/projects/".$id."/task_assignments",
            array(
                'Authorization' => 'Bearer '.$this->accessToken,
                'Harvest-Account-Id' => $this->harvestAccountId,
                'User-Agent' => 'On Human (onhuman@test.com)'
            )
        ); 
    }

    function getProjectUserAssignments($id) {
        return  Requests::get(
            $this->harvestAPIURL."/projects/".$id."/user_assignments",
            array(
                'Authorization' => 'Bearer '.$this->accessToken,
                'Harvest-Account-Id' => $this->harvestAccountId,
                'User-Agent' => 'On Human (onhuman@test.com)'
            )
        ); 
    }

    function getTimeEntries($clientID, $projectID, $userID, $taskID) {
        $appendURL = "";
        if($projectID !== null) {
            $appendURL .= "&project_id=".$projectID;
        }
        if($userID !== null) {
            $appendURL .= "&user_id=".$userID;
        }
        if($taskID !== null) {
            $appendURL .= "&task_id=".$taskID;
        }
        return  Requests::get(
            $this->harvestAPIURL."/time_entries/?client_id=".$clientID.$appendURL,
            array(
                'Authorization' => 'Bearer '.$this->accessToken,
                'Harvest-Account-Id' => $this->harvestAccountId,
                'User-Agent' => 'On Human (onhuman@test.com)'
            )
        ); 
    }
}

if(isset($action)) {
    $harvest = new Harvest("", "");
    $id = "";
    $id = $_GET['id'];

    $clientID = "";
    $clientID = $_GET['clientID'];
    
    $projectID = "";
    $projectID = $_GET['projectID'];

    $userID = "";
    $userID = $_GET['userID'];

    $userID = "";
    $userID = $_GET['taskID'];

    if($action === "getClient") {
        $response = $harvest->getClient($id);
        if($response->body) {
            echo $response->body;
            die();
        }
    }

    if($action === "getContact") {
        $response = $harvest->getContact($id);
        if($response->body) {
            echo $response->body;
            die();
        }
    }

    if($action === "getUser") {
        $response = $harvest->getUser($id);
        if($response->body) {
            echo $response->body;
            die();
        }
    }

    if($action === "listClientContacts") {
        $response = $harvest->listClientContacts($id);
        if($response->body) {
            echo $response->body;
            die();
        }
    }

    if($action === "listProjects") {
        $response = $harvest->listProjects($id);
        if($response->body) {
            echo $response->body;
            die();
        }
    }

    if($action === "listEstimates") {
        $response = $harvest->listEstimates($id);
        if($response->body) {
            echo $response->body;
            die();
        }
    }

    if($action === "listInvoices") {
        $response = $harvest->listInvoices($id, $projectID);
        if($response->body) {
            echo $response->body;
            die();
        }
    }

    if($action === "listExpenses") {
        $response = $harvest->listExpenses($id, $projectID);
        if($response->body) {
            echo $response->body;
            die();
        }
    }

    if($action === "getProject") {
        $userAssignmentsList = array();
        $userMetaList = array();
        $totalTaskHours = array();
        $getProject = $harvest->getProject($id);
        if($getProject->body) {
            $getProjectTaskAssignments = $harvest->getProjectTaskAssignments($id);
            if($getProjectTaskAssignments->body) {
                $getProjectUserAssignments = $harvest->getProjectUserAssignments($id);
                if($getProjectUserAssignments->body) {
                    $ProjectUserAssignments =  $getProjectUserAssignments->body;

                    $ProjectUserAssignmentsJSONDecode = json_decode( $ProjectUserAssignments, true);

                    foreach($ProjectUserAssignmentsJSONDecode['user_assignments'] as $key => $user) {
                        $getUser = $harvest->getUser($user['user']['id']);
                        $userAssignmentsList[$key] = $user;
                        if($getUser->body) {
                           $userAssignmentsList[$key]['meta'] = json_decode($getUser->body, true);                            
                        }
                    }

                    
                    $getTimeEntries = $harvest->getTimeEntries($clientID, $id, $userID, $taskID);
                    
                    if($getTimeEntries->body) {
                        $ProjectTimeEntries =  $getTimeEntries->body;

                        foreach(json_decode($ProjectTimeEntries, true)['time_entries'] as $time_key => $time) {
                            $totalTaskHours[$time['task']['id']] += $time['rounded_hours'];     
                        }
                    }
                }
                $ProjectTaskAssignments = $getProjectTaskAssignments->body;
            }
            $project = $getProject->body;
            echo json_encode(array("project" => json_decode($project), "ProjectUserAssignments" =>  $userAssignmentsList, 
            "ProjectTaskAssignments" =>  json_decode($ProjectTaskAssignments), "ProjectTimeEntries" =>  json_decode($ProjectTimeEntries), "totalTaskHours" => $totalTaskHours));
            die();
        }
    }
    

}

