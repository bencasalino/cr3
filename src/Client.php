<?php
    class Client
    {
        private $name;
        private $id;

        function __construct ($new_name, $new_id = null)
        {
            $this->name = (string) $new_name;
            $this->id = $new_id;
        }

        //getters
        function getName()
        {
            return $this->name;
        }

        //referes to the stylist Id NOT the cliet Id
        function getId()
        {
            return $this->id;
        }

        // Setter
        function setName()
        {
              $this->name = (string) $new_name;
        }

        //Database storage methods
        //CRUD Create
        function save()
        {
            $GLOBALS['DB']->exec(
                "INSERT INTO stylists (name) VALUES (
                    '{$this->getName()}',
                    {$this->getId()}
                );"
            );
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        //CRUD Read
        static function getAll()
        {
            $db_stylists = $GLOBALS['DB']->query("SELECT * FROM stylists;");
            $all_stylists = array();
            foreach ($db_stylists as $stylist) {
                $name = $stylist['name'];
                $id = $client['id'];

                $new_client = new Client ($name, $id);
                array_push($all_stylists, $new_stylist);
            }
            return $all_clients;
        }


        function getStylists()
        {
            $matching_stylists = array();
            $db_stylists = $GLOBALS['DB']->query(
                "SELECT * FROM stylists WHERE client_id = {$this->getId()};"
            );

            foreach ($db_stylists as $stylist) {
                $name = $stylist['name'];
                $client_id = $stylist['client_id'];
                $id = $stylist['id'];
                $new_stylists = new Stylist (
                    $name, $client_id, $id
                );
                array_push($matching_stylists, $new_stylist);
            }
            return $matching_stylists;
        }

        //CRUD Update
        // update not needed??????

        //CRUD Delete
        function delete()
        {
          $GLOBALS ['DB']->exec ("DELETE FROM clients WHERE id = {$this->getId()};");

        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM clients;");
        }

        //CRUD Read
        static function find($search_id)
        {
            $found_client = null;
            $clients = Client::getAll();
            foreach($clients as $client) {
                if ($client->getId() == $search_id) {
                    $found_client = $client;
                }
            }
            return $found_client;
        }

    }


 ?>
