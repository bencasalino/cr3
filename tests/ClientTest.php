<?php
    /**
    * @backupGlobals disabled
    * @backupStatic Attributes disabled
    */

    require_once "src/client.php";
    require_once "src/stylist.php";

    $server = 'mysql:host=localhost;dbname=food_finder_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class ClientTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Stylist::deleteAll();
            Client::deleteAll();
        }

        function test_getName()
        {
            //Arrange
            $test_name = "Sara";
            $test_client = new Client( $test_name);

            //Act
            $result = $test_client->getName();

            //Assert
            $this->assertEquals($test_name, $result);


        }


        function test_getId()

        {
            //Arrange
            $test_name = "Bobby";
            $test_client = new Client ($test_name) ;
            $test_client->save();

            //Act
            $result = Client::getAll()[0]->getId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_save()

        {
            //Arrange
            $test_name = " Sue ";
            $test_client = new Client ($test_name) ;
            $test_client->save();

            //Act
            $result = client::getAll();

            //Assert
            $this->assertEquals($test_client, $result[0]);
        }

        function test_getAll()
        {
            //c1
            //Arrange
            $test_name = " Jack ";
            $test_client = new Client ($test_name) ;
            $test_client->save();

            $test_name2 = " Jill ";
            $test_client2 = new Client ($test_name2) ;
            $test_client2->save();

            //Act
            $result = client::getAll();

            //Assert
            $this->assertEquals([$test_client, $test_client2], $result);
        }

        function test_getStylists()
        {
            //Arrange
            $test_client = new Client("Newman");
            $test_client->save();
            $test_client_id = $test_client->getId();

            $test_stylist1 = new Stylist("George ", $test_client_id);
            $test_stylist1->save();
            //var_dump($test_stylist1);

            $test_stylist2 = new Stylist(" Kramer ", $test_client_id);
            $test_stylist2->save();

            //Act
            $result = $test_client->getstylists();

            //Assert
            $this->assertEquals([$test_stylist1, $test_stylist2], $result);
            //$this->assertEquals([], $result);
        }


        function test_delete()
        {
            //Arrange
            $test_client = new Client("Bob", 4);
            $test_client->save();

            //Act
            $test_client->delete();
            $result = Client::getAll();

            //Assert
            $this->assertEquals([], $result);
        }



    }
 ?>
