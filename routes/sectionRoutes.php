<?php

use Controllers\SectionsManagement\SectionController;

// Function to handle section-related routes based on the provided action
function sectionRoutes($adminAction)
{
    // Instantiate the controller for section management
    $getSection = new SectionController();

    // Switch statement to determine the action to be taken based on the value of $adminAction
    switch ($adminAction) {
            // Retrieve all sections
        case 'getSection':
            return $getSection->getSections();

            // Default case if no valid action is provided
        default:
            return null;
    }
}
