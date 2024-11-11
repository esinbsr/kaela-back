<?php

use Controllers\SocialNetworksManagement\AddSocialNetworkController;
use Controllers\SocialNetworksManagement\DeleteSocialNetworkController;
use Controllers\SocialNetworksManagement\SocialNetworkController;
use Controllers\SocialNetworksManagement\UpdateSocialNetworkController;

// Function to handle social network-related routes based on the provided action
function socialNetworkRoutes($adminAction, $authMiddleware)
{

    // Instantiate controllers for each social network management action
    $getSocialNetwork = new SocialNetworkController();
    $addSocialNetwork = new AddSocialNetworkController();
    $updateSocialNetwork = new UpdateSocialNetworkController();
    $deleteSocialNetwork = new DeleteSocialNetworkController();

    // Switch statement to determine the action to be taken based on the value of $adminAction
    switch ($adminAction) {
            // Retrieve all social networks
        case "getSocialNetwork":
            return $getSocialNetwork->getSocialNetworks();

            // Retrieve a specific social network by ID
        case "getSocialNetworkById":
            return $updateSocialNetwork->getSocialNetworkById();

            // Add a new social network
        case "addSocialNetwork":
            // Check if the user has admin access
            $authResult = $authMiddleware->verifyAccess('admin');
            if ($authResult !== null) {
                // If access is not granted, return the auth result
                return $authResult;
            } else {
                // If access is granted, proceed with adding the social network
                return $addSocialNetwork->addSocialNetwork();
            }

            // Update an existing social network
        case "updateSocialNetwork":
            // Verify admin access before proceeding with the update
            $authResult = $authMiddleware->verifyAccess('admin');
            if ($authResult !== null) {
                // Return the auth result if access is not granted
                return $authResult;
            } else {
                // Proceed with updating the social network if access is granted
                return $updateSocialNetwork->updateSocialNetwork();
            }

            // Delete an existing social network
        case "deleteSocialNetwork":
            // Check for admin access before deletion
            $authResult = $authMiddleware->verifyAccess('admin');
            if ($authResult !== null) {
                // If access is not granted, return the auth result
                return $authResult;
            } else {
                // Proceed with social network deletion if access is granted
                return $deleteSocialNetwork->deleteSocialNetwork();
            }

            // Default case if no valid action is provided
        default:
            return null;
    }
}
