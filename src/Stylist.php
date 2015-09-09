<?php
    class Stylist
    {
        private $name;
        private $id;

        function __construct($name, $id = null)
        {
            $this->name = $name;
            $this->id = $id;
        }
//////////////////////////////// getters and setters //
        function getName()
        {
            return $this->name;
        }

        function setName($new_name)
        {
            $this->name = (string) $new_name;
        }

        function getId()
        {
            return $this->id;
        }



///////////////////////// save /////////////////////////
        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO stylists (name) VALUES ('{$this->getName()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        function getClients()
        {
            $clients = Array();
            $db_clients = $GLOBALS['DB']->query("SELECT * FROM clients WHERE stylist_id = {$this->getId()};");
            // for each loop with all properties!
            foreach ($db_clients as $client) {
                $name = $client['name'];
                $phone = $client['phone'];
                $style_choice = $client['style_choice'];
                $stylist_id = $client['stylist_id'];
                $id = $client['id'];
                $new_client = new Client($name, $phone, $style_choice, $stylist_id, $id);
                array_push($clients, $new_client);
            }
            return $clients;
        }
/////////////////////// need a get all! ////////////////
        static function getAll()
        {
            $db_stylists = $GLOBALS['DB']->query("SELECT * FROM stylists;");
            $stylists = array();
            foreach ($db_stylists as $stylist) {
                $name = $stylist['name'];
                $id = $stylist['id'];
                $new_stylist = new Stylist($name, $id);
                array_push($stylists, $new_stylist);
            }
            return $stylists;
        }
//////////////// delete all and find /////////////////
        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM stylists;");
        }

        static function find($search_id)
        {
            $found_stylist = null;
            $stylists = Stylist::getAll();
            foreach($stylists as $stylist) {
                $stylist_id = $stylist->getId();
                if ($stylist_id == $search_id) {
                    $found_stylist = $stylist;
                }
            }
            return $found_stylist;
        }
////////////////// update and delete individual ////////
        function update($new_name)
        {
            $GLOBALS['DB']->exec("UPDATE stylists SET = '{$new_name}' WHERE id = {$this->getId()};");
            $this->setName($new_name);
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM stylists WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM clients WHERE stylist_id = {$this->getId()};");
        }

    }

 ?>
