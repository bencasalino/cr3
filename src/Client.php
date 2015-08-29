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
