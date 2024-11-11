<?php

use Controllers\ProductsManagement\AddProductController;
use Controllers\ProductsManagement\DeleteProductController;
use Controllers\ProductsManagement\ProductController;
use Controllers\ProductsManagement\UpdateProductController;

// Function to handle product-related routes based on the provided action
function productRoutes($adminAction, $authMiddleware)
{

    // Instantiate controllers for each product management action
    $getProduct = new ProductController();
    $addProduct = new AddProductController();
    $updateProduct = new UpdateProductController();
    $deleteProduct = new DeleteProductController();

    // Switch statement to determine the action to be taken based on the value of $adminAction
    switch ($adminAction) {
            // Retrieve all products
        case "getProduct":
            return $getProduct->getProduct();

            // Retrieve a specific product by ID
        case "getProductById":
            return $updateProduct->getProductById();

            // Add a new product
        case "addProduct":
            // Check if the user has admin access
            $authResult = $authMiddleware->verifyAccess('admin');
            if ($authResult !== null) {
                // If access is not granted, return the auth result
                return $authResult;
            } else {
                // If access is granted, proceed with adding the product
                return $addProduct->addProduct();
            }

            // Update an existing product
        case "updateProduct":
            // Verify admin access before proceeding with the update
            $authResult = $authMiddleware->verifyAccess('admin');
            if ($authResult !== null) {
                // Return the auth result if access is not granted
                return $authResult;
            } else {
                // Proceed with updating the product if access is granted
                return $updateProduct->updateProduct();
            }

            // Delete an existing product
        case "deleteProduct":
            // Check for admin access before deletion
            $authResult = $authMiddleware->verifyAccess('admin');
            if ($authResult !== null) {
                // If access is not granted, return the auth result
                return $authResult;
            } else {
                // Proceed with product deletion if access is granted
                return $deleteProduct->deleteProduct();
            }

            // Default case if no valid action is provided
        default:
            return null;
    }
}
