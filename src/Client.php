<?php
    class Client
    {
        private $client_name;
        private $id;
        private $stylist_id;
        function __construct($client_name, $id = null, $stylist_id)
        {
            $this->client_name = $client_name;
            $this->id = $id;
            $this->stylist_id = $stylist_id;
        }


        //Setter
        function setClientName($new_name)
        {
            $this->client_name = (string) $new_name;
        }

        function getId()
        {
            return $this->id;
        }

        //Getters
        function getClientName()
        {
            return $this->client_name;
        }

        function getStylistId()
        {
            return $this->stylist_id;
        }

        //METHODS //

        //Save Method
        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO clients (client_name, stylist_id) VALUES ('{$this->getClientName()}', {$this->getStylistId()})");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        //Static getAll Method
        static function getAll()
        {
            $returned_clients = $GLOBALS['DB']->query("SELECT * FROM clients;");
            $clients = array();
            foreach ($returned_clients as $client) {
                $client_name = $client['client_name'];
                $id = $client['id'];
                $stylist_id = $client['stylist_id'];
                $new_client = new Client($client_name, $id, $stylist_id);
                array_push($clients, $new_client);
            }
            return $clients;
        }

        //Static deleteAll Method
        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM clients");
        }

        //Static Find Method
        static function find($search_id)
        {
            $found_client = null;
            $clients = Client::getALL();
            foreach($clients as $client) {
                $client_id = $client->getId();
                if ($client_id == $search_id) {
                    $found_client = $client;
                }
            }
            return $found_client;
        }

        //Update Method
        function update($new_name)
        {
            $GLOBALS['DB']->exec("UPDATE clients SET client_name = '{$new_name}' WHERE id = {$this->getId()};");
            $this->setClientName($new_name);
        }

        //Delete Method
        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM clients WHERE id = {$this->getId()};");
        }
    }
 ?>
