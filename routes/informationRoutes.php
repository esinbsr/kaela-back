<?php

use Controllers\InformationsManagement\AddInformationController;
use Controllers\InformationsManagement\DeleteInformationController;
use Controllers\InformationsManagement\InformationController;
use Controllers\InformationsManagement\UpdateInformationController;

// Function to handle information-related routes based on the provided action
function informationRoutes($adminAction, $authMiddleware)
{

    // Instantiate controllers for each information management action
    $getInformation = new InformationController();
    $addInformation = new AddInformationController();
    $updateInformation = new UpdateInformationController();
    $deleteInformation = new DeleteInformationController();

    // Switch statement to determine the action to be taken based on the value of $adminAction
    switch ($adminAction) {
            // Retrieve all information entries
        case "getInformation":
            return $getInformation->getInformations();

            // Retrieve a specific information entry by ID
        case "getInformationById":
            return $updateInformation->getInformationById();

            // Add a new information entry
        case "addInformation":
            // Check if the user has admin access
            $authResult = $authMiddleware->verifyAccess('admin');
            if ($authResult !== null) {
                // If access is not granted, return the auth result
                return $authResult;
            } else {
                // If access is granted, proceed with adding the information entry
                return $addInformation->addInformation();
            }

            // Update an existing information entry
        case "updateInformation":
            // Verify admin access before proceeding with the update
            $authResult = $authMiddleware->verifyAccess('admin');
            if ($authResult !== null) {
                // Return the auth result if access is not granted
                return $authResult;
            } else {
                // Proceed with updating the information entry if access is granted
                return $updateInformation->updateInformation();
            }

            // Delete an existing information entry
        case "deleteInformation":
            // Check for admin access before deletion
            $authResult = $authMiddleware->verifyAccess('admin');
            if ($authResult !== null) {
                // If access is not granted, return the auth result
                return $authResult;
            } else {
                // Proceed with information entry deletion if access is granted
                return $deleteInformation->deleteInformation();
            }

            // Default case if no valid action is provided
        default:
            return null;
    }
}
