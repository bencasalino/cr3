<?php

    class Stylist
    {
      //class properties
        private $name;
        private $client_id;
        private $id;

        // 
        function __construct ($new_name, $new_client_id, $new_id = null)
        {
            $this->name = (string) $new_name;
            //Id' s
            $this->client_id = $new_client_id;
            $this->id = $new_id;
        }


        // Getters and Setters
        function getId()
        {
            return $this->id;
        }

        function getName()
        {
            return $this->name;
        }

        function setName($new_name)
        {
            $this->name = (string) $new_name;
        }

        function getClientId()
        {
            return $this->client_id;
        }


        // Database storage methods????
        //CRUD Create
        function save()
        {
            $GLOBALS['DB']->exec(
                "INSERT INTO stylists (name, client_id) VALUES (
                    '{$this->getName()}',
                    {$this->getClientId()}
                );"
            );
            $this->id = $GLOBALS['DB']->lastInsertId();

        }
        // CRUD Update
        // only needed if clients or stylists needed to change thier name?


        // CRUD Delete
        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM restaurants WHERE id = {$this->getId()};");
        }


        // CRUD Read
        static function getAll()
        {
            $db_stylists = $GLOBALS['DB']->query("SELECT * FROM stylists;");
            $all_s = array();
            foreach ($db_stylists as $stylist) {
                $name = $stylist['name'];
                $client_id = $stylist['client_id'];
                $id = $stylist['id'];

                $new_stylist = new Stylist(
                    $name, $client_id, $id
                );
                array_push($all_stylist, $new_stylist);
            }
            return $all_stylists;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM stylists; ");
        }

        static function find($search_id)
        {
            $db_stylists = $GLOBALS['DB']->query(
                "SELECT * FROM stylists WHERE id = {$search_id};"
            );
            $found_stylists = array();
            foreach ($db_stylists as $stylists) {
                $name = $stylist['name'];
                $client_id = $stylist['client_id'];
                $id = $stylist['id'];

                $new_stylist = new Stylist(
                    $name, $client_id, $id
                );
                array_push($found_stylists, $new_stylist);
            }

            // might have multiple results-- just return the first one for now.
            return $found_stylist[0];
        }

    }
?>
