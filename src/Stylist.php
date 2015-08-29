<?php
    class Stylist
    {
        private $stylist_name;
        private $id;

        //Constructor
        function __construct($stylist_name, $id = null)
        {
            $this->stylist_name = $stylist_name;
            $this->id = $id;
        }
