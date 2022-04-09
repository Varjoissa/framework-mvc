<?php

/*
    Class for setting up a PDO connection for 
        - MySQL
    This is a class in progress, which means that the functionality will be improved over time.

    Created: 2022-01-20
    Updated: 2022-02-13

    Varjoissa

    ***** TODO *****
    **1. Check whether a combination of data is true.
*/

namespace App\Models\Handlers;

use PDO;

class SQL_Handler
{
    protected $connection;                              // DOCS PDO: https://www.php.net/manual/en/book.pdo.php
    protected $dsn = '';
    
    protected $host;
    protected $database;
    protected $username;
    protected $password;

    protected $options = [];
    protected $prep_stmts = [];
    
    // CONSTRUCTOR
    function __construct(
        $host,
        $database,
        $username,
        $password, 
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    ) {
        // SETUP variables
        $this->host = $host;
        $this->database = $database;
        $this->username = $username;
        $this->password = $password;
        $this->options = $options;

        $this->setDSN();

        // INITIALIZE PDO        
        $this->initialize();
    }

    // SETTERS   
    function setAuth($username, $password)
    {
            $this->username = $username;
            $this->password = $password;
    }

    function setDSN($host = '', $database = '')
    {
        if ($host == '' or $host == null) {
            $host = $this->host;
        } else {
            $this->host = $host;
        }

        if ($database == '' or $database == null) {
            $database = $this->database;
        } else {
            $this->database = $database;
        }
        
        $this->dsn = "mysql:host=$host;dbname=$database;charset=utf8";
    }

    // Function to set the connection options.
    function setOptions($options = [])
    {
        if (isset($options)) {
            foreach ($options as $key => $value) {
                $this->options[$key] = $value;
            }
        }
    }

    // Function to add prepared statements to be executed.
    function setStatements($prep_stmts = [])
    {
        foreach ($prep_stmts as $id => $statement) {
            $this->prep_stmts[$id] = $statement;
        }
    }

    // GETTERS

    // Get a list of all columntitles in a certain table
    function getTitles($table)
    {
        $stmt = $this->connection->prepare("DESCRIBE $table");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
    

    // FUNDAMENTALS
    
    // Get an amount for a specific query
    function amount()
    {
    }

    // Push info into database, either update or creates new
    function push($table, $id = [], $data = [])
    {
        try {
            // Get existing table
            $dbData = $this->query("SELECT * FROM $table WHERE $id[0] = ?", [$id[1]]);

            // If the entry exists
            if (isset($dbData)) {
                // Get all columntitles
                $titles = $this->getTitles($table);
                $existingID = false;

                if (count($dbData) > 0) {
                    $existingID = true;
                }
                
                $columns = '';
                $prepval = '';
                $values = [];
                $updatestring = '';

                foreach ($data as $title => $value) {
                    if ($title !== $id[0]) {
                        if (in_array($title, $titles)) {
                            if ($columns !== '') {
                                $columns .= ', ';
                                $prepval .= ', ';
                                $updatestring .= ', ';
                            }
                            $columns .= $title;
                            $prepval .= '?';
                            $values[] = $value;

                            if ($existingID === true) {
                                $updatestring .= $title . ' = ?';
                            }
                        }
                    }
                }

                if ($existingID === true) {
                    $values[] = $id[1];
                    $this->query("UPDATE $table SET $updatestring WHERE $id[0] = ?", $values);
                } else {
                    $this->query("INSERT INTO $table ($columns) VALUES ($prepval)", $values);
                }
            }
        } catch (\PDOException $error) {
            echo $error->getMessage();
        }
    }

    // Get as specific value
    function check($table, $column, $value, $returncolumns = '*')
    {
        $statement = 'SELECT ' . $returncolumns . ' FROM ' . $table . ' WHERE ' . $column . ' = ?';
        return $this->query($statement, [$value]);
    }

    // Initialize the connection
    function initialize()
    {
        try {
            $this->connection = new \PDO($this->dsn, $this->username, $this->password, $this->options);
        } catch (\PDOException $error) {
            echo $error->getMessage();
        }
    }

    // Perform a query, based on a Prepared Statement.
    function query($query, $params = [], $singleValueUnnested = false)
    {
        
        $statement = '';
        if (isset($this->prep_stmts[$query])) {
            $statement = $this->prep_stmts[$query];
        } else {
            $statement = $query;
        }

        try {
            if (count($params) !== substr_count($statement, '?')) { 
                throw new \Exception('Not the right amount of query parameters given.');
            } else {
                try {
                    $stmt = $this->connection->prepare($statement);
                    for ($i = 1; $i <= count($params); $i++) {
                        $stmt->bindParam($i, $params[$i - 1]);
                    }
                    $stmt->execute();

                    if (substr($statement, 0, 7) == 'SELECT ') {
                        if ($singleValueUnnested === true) {
                            return $stmt->fetch();
                        } else {
                            return $stmt->fetchAll();
                        }
                    } 
                } catch (\PDOException $ex2) {
                    return $ex2;
                }
            }
        } catch (\Exception $error) {
                echo 'ERROR: SQL query incorrect: ' . $error->getMessage();
        }
    }

    // Remove item from database
    function remove($table, $id = [])
    {
        $this->query("DELETE FROM $table WHERE $id[0] = ?", [$id[1]]);
    }

    // Validate input for database
    function validate($table, $id, $column)
    {
    }
}
