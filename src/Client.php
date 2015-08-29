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
