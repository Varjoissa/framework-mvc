<?php

/*
    Config file
    Environment dependant

    Created: 2022-04-09
    Updated: 2022-04-09

    Varjoissa

*/

namespace Core;

class Config
{
    // Get specific settings from the Environment Settings file
    public function getSettings($category)
    {   
        // Get settings file
        $settings = parse_ini_file("../Env/settings.ini", true);

        // If the category exists in the settingsfile, return the settings. 
        if (array_key_exists($category, $settings)) {
            return $settings[$category];
        } else {
            // Else throw an error
            throw new \Exception("Setting $category requested, but not found.", 500);
        }
    }
}
