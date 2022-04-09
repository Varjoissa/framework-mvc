<?php

/*
    Error and Exception Handler

    Created: 2022-04-09
    Updated: 2022-04-09

    Varjoissa

*/

namespace Core;

class Error
{
    // Error handler
    /**
     * Converts all errors to Exceptions
     *      $level = Error level
     *      $message = Error message
     *      $file = Filename where the error was raised
     *      $line = Linenumber in the $file where the error was raised
     */
    public static function errorHandler($level, $message, $file, $line)
    {
        if (error_reporting() !== 0) {
            throw new \ErrorException($message, 0, $level, $file, $line);
        }
    }

    // Exception handler
    public static function exceptionHandler($exception)
    {
        // Generalize the exception codes to just 404 or other (500)
        $code = $exception->getCode();
        if ($code != 404) {
            $code = 500;
        }
        http_response_code($code);

        // Get settings for showing errors
        $showErrors = false;
        $showErrors = (new Config())->getSettings('errors')['show_errors'];

        // Show errors
        if ($showErrors) {
            echo "<h1>An error occured</h1>";
            echo "<p><b>Uncaught exception:</b> '" . get_class($exception) . "'</p>";
            echo "<p><b>Message:</b> [#$code] '" . $exception->getMessage() . "'</p>";
            echo "<p><b>Stack trace:</b> '" . $exception->getTraceAsString() . "'</p>";
            echo "<p><b>Thrown in:</b> '" . $exception->getFile() . "' on line " . $exception->getLine() . "</p>";
        // Log errors
        } else {
            // Define Log directory and file; and create it if it doesnt exist yet.
            $logdir = dirname(__DIR__, 1) . "/Env/Logs/";
            if (!file_exists($logdir) && !is_dir($logdir)) {
                mkdir($logdir, 0777);       
            } 
            $log = $logdir . "errorlog_" . date('Y-m-d') . " . txt";
            
            // Create log and save it to the logfile
            ini_set('error_log' , $log);
            $message = "Uncaught exception: '" . get_class($exception) . "'";
            $message .= "\nMessage: [#$code] '" . $exception->getMessage() . "'";
            $message .= "\nStack trace: '" . $exception->getTraceAsString() . "'";
            $message .= "\nThrown in: '" . $exception->getFile() . "' on line " . $exception->getLine() . "\n\n";
            error_log($message);
            
            // Show the error page
            if (file_exists("../App/Views/Errors/$code.html")) {
                // Designated view
                View::render("Errors/$code.html");
            } else {
                // Plain text message
                echo "<h1>An error occured.</h1>";
            }
        }
    }
}
