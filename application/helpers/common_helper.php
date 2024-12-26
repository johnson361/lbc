<?php
if (!function_exists('convertToMySQLDate')) {
    function convertToMySQLDate($dateString) {
        // Convert the input date to a DateTime object
        $date = DateTime::createFromFormat('d/m/Y', $dateString);
        
        // Check if the date is valid
        if ($date && $date->format('d/m/Y') === $dateString) {
            // Return the date in MySQL format (yyyy-mm-dd)
            return $date->format('Y-m-d');
        } else {
            // Return false if the date format is invalid
            return false;
        }
    }
}