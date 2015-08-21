<?php
    class Cuisine
    {
        private $name;
        private $spicy;
        private $price;
        private $id;

        function __construct ($new_name, $new_spicy, $new_price, $new_id = null)
        {
            $this->name = (string) $new_name;
            $this->spicy = (int) $new_spicy;
            $this->price = (int) $new_price;
            $this->id = $new_id;
        }

        //getters and setters
        function getName()
        {
            return $this->name;
        }

        function getSpicy()
        {
            return $this->spicy;
        }

        function getPrice()
        {
            return $this->price;
        }

        //set
        function setPrice($new_price)
        {
            $this->price = (int) $new_price;
        }

        //referes to the restaurant Id NOT the cuisine Id
        function getId()
        {
            return $this->id;
        }

        //Database storage methods
        //CRUD Create
        function save()
        {
            $GLOBALS['DB']->exec(
                "INSERT INTO cuisines (name, spicy, price) VALUES (
                    '{$this->getName()}',
                    {$this->getSpicy()},
                    {$this->getPrice()}
                );"
            );
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        //CRUD Read
        static function getAll()
        {
            $db_cuisines = $GLOBALS['DB']->query("SELECT * FROM cuisines;");
            $all_cuisines = array();
            //var_dump($all_cuisines);
            foreach ($db_cuisines as $cuisine) {
                $name = $cuisine['name'];
                $spicy = $cuisine['spicy'];
                $price = $cuisine['price'];
                $id = $cuisine['id'];

                $new_cuisine = new Cuisine($name, $spicy, $price, $id);
                array_push($all_cuisines, $new_cuisine);
            }
            return $all_cuisines;
        }


        function getRestaurants()
        {
            $matching_restaurants = array();
            $db_restaurants = $GLOBALS['DB']->query(
                "SELECT * FROM restaurants WHERE cuisine_id = {$this->getId()};"
            );

            foreach ($db_restaurants as $restaurant) {
                $name = $restaurant['name'];
                $seats = $restaurant['seats'];
                $location = $restaurant['location'];
                $evenings = $restaurant['evenings'];
                $cuisine_id = $restaurant['cuisine_id'];
                $id = $restaurant['id'];
                $new_restaurant = new Restaurant(
                    $name, $seats, $location, $evenings, $cuisine_id, $id
                );
                array_push($matching_restaurants, $new_restaurant);
            }
            return $matching_restaurants;
        }

        //CRUD Update
        // used if owners wanted to change the price of food in the future
        function updatePrice($new_price)
        {

          $GLOBALS ['DB']->exec("UPDATE cuisines SET price = '{$new_price}' WHERE id = {$this->getId()};");
          $this->setPrice($new_price);
        }

        //CRUD Delete
        function delete()
        {
          $GLOBALS ['DB']->exec ("DELETE FROM cuisines WHERE id = {$this->getId()};");

        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM cuisines;");
        }

        //CRUD Read
        static function find($search_id)
        {
            $found_cuisine = null;
            $cuisines = Cuisine::getAll();
            foreach($cuisines as $cuisine) {
                if ($cuisine->getId() == $search_id) {
                    $found_cuisine = $cuisine;
                }
            }
            return $found_cuisine;
        }

    }


 ?>
