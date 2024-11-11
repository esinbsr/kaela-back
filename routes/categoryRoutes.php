<?php

use Controllers\CategoriesManagement\AddCategoryController;
use Controllers\CategoriesManagement\CategoryController;
use Controllers\CategoriesManagement\DeleteCategoryController;
use Controllers\CategoriesManagement\UpdateCategoryController;

// Function to handle category-related routes based on the provided action
function categoryRoutes($adminAction, $authMiddleware)
{

    // Instantiate controllers for each category management action
    $productCategory = new CategoryController();
    $updateCategory = new UpdateCategoryController();
    $addCategory = new AddCategoryController();
    $deleteCategory = new DeleteCategoryController();

    // Switch statement to determine the action to be taken based on the value of $adminAction
    switch ($adminAction) {
            // Retrieve all product categories
        case "getProductCategory":
            return $productCategory->getCategories();

            // Retrieve a specific category by ID
        case "getCategoryById":
            return $updateCategory->getCategoryById();

            // Add a new category
        case "addCategory":
            // Check if the user has admin access
            $authResult = $authMiddleware->verifyAccess('admin');
            if ($authResult !== null) {
                // If access is not granted, return the auth result
                return $authResult;
            } else {
                // If access is granted, proceed with adding the category
                return $addCategory->addCategory();
            }

            // Update an existing category
        case "updateCategory":
            // Verify admin access before proceeding with the update
            $authResult = $authMiddleware->verifyAccess('admin');
            if ($authResult !== null) {
                // Return the auth result if access is not granted
                return $authResult;
            } else {
                // Proceed with updating the category if access is granted
                return $updateCategory->updateCategory();
            }

            // Delete an existing category
        case "deleteCategory":
            // Check for admin access before deletion
            $authResult = $authMiddleware->verifyAccess('admin');
            if ($authResult !== null) {
                // If access is not granted, return the auth result
                return $authResult;
            } else {
                // Proceed with category deletion if access is granted
                return $deleteCategory->deleteCategory();
            }

            // Default case if no valid action is provided
        default:
            return null;
    }
}
