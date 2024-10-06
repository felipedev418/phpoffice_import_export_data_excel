<?php
session_start();
require_once('../classes/functions.class.php');
require_once('../classes/users.class.php');
require_once('../classes/admin.class.php');

$users = new Users();
$admin = new Admin();

if($users->user_auth() == false) {
    $location = base_url.'login.php';
    header("Location: $location");
    exit;
}

// Fetch voter list
$voterList = $admin->voterList();

// Set headers for CSV download
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="voters_list.csv"');

// Open output stream
$output = fopen('php://output', 'w');

// Add CSV headers
fputcsv($output, array('Voter', 'Email', 'Contact', 'Election', 'VoterCode', 'Status'));

// Add data to CSV
foreach ($voterList as $voter) {
    $electionID = $admin->getElectionEncryptedId($voter['ElectionId']);
    $encryptedId = $electionID[0]['encrypted_id'];
    
    $status = ($voter['isActive'] == 1) ? 'Active' : 'Inactive';
    
    fputcsv($output, array(
        $voter['FirstName'] . " " . $voter['LastName'],
        $voter['Email'],
        $voter['StudentId'],
        $admin->getElection($voter['ElectionId']),
        frontbase_url . 'login.php?electionId=' . $encryptedId . '&code=' . $voter['voterCode'],
        $status
    ));
}

// Close the output stream
fclose($output);
exit;
