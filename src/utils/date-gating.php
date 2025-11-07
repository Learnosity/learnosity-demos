<?php

/**
 * Check if content should be displayed based on a date gate
 * 
 * @param string $dateString Date string in format 'YYYY-MM-DD' (e.g., '2025-02-02')
 * @return bool True if content should be shown, false otherwise
 */
function show_date_gated_content($dateString)
{
    // Check if date gates are disabled via GET parameter
    if (isset($_GET['date-gates-off'])) {
        return true;
    }

    // Parse the target date
    $targetDate = strtotime($dateString);

    // If date parsing failed, hide content by default (fail closed)
    if ($targetDate === false) {
        return false;
    }

    // Get current date (midnight today)
    $currentDate = strtotime(date('Y-m-d'));

    // Show content if current date is equal to or after target date
    return $currentDate >= $targetDate;
}

