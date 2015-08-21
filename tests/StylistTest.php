<?php

    /**
    * @backupGlobals disabled
    * @backupStatic Attributes disabled
    */

    require_once "src/stylist.php";
    require_once "src/client.php";

    $server = 'mysql:host=localhost;dbname=food_finder_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class StylistTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Stylist::deleteAll();
            Client::deleteAll();
        }

        function test_getName()
        {
            //Arrange
            $test_name = "Bob";

            $test_client = new Client("Bob", 1);
            $test_client->save();

            $test_stylist = new Stylist(
              $test_name, $test_client->getId()
            );
            $test_stylist->save();

            //Act
            $result = $test_stylist->getName();


            //Assert
            $this->assertEquals($test_name, $result);
        }


        function test_save()
        {
            //Arrange
            $test_name = "Tom ";
            $test_client = new client("Tom", 3);
            $test_client->save();

            $test_stylist = new stylist(
              $test_name, $test_client->getId()
            );
            $test_stylist->save();

            //Act
            $result = stylist::getAll();

            //Assert
            $this->assertEquals($test_stylist, $result[0]);
        }

        function test_getAll()
        {

            //Arrange
            //client 1
            $test_name = " Fred ";
            $test_client = new Client("Fred", 4);
            $test_client->save();

            $test_stylist = new Stylist(
            $test_name, $test_client->getId()

            );
            $test_stylist->save();

            //r 2
            $test_name2 = " Jay ";
            $test_client2 = new Client("Jay", 5);
            $test_client2->save();

            $test_stylist2 = new Stylist(
              $test_name2,  $test_client2->getId()
            );
            $test_stylist2->save();


            //Act
            $result = stylist::getAll();

            //Assert
            $this->assertEquals([$test_stylist, $test_stylist2], $result);
        }

        function test_delete()
        {
            //Arrange
            //r 1
            $test_name = " Ben";
            $test_client = new Client("Ben", 6);
            $test_client->save();

            $test_stylist = new Stylist(
              $test_name, $test_client->getId()
            );
            $test_stylist->save();

            //r 2
            $test_name2 = " Frank ";
            $test_client2 = new Client("Frank", 7);
            $test_client2->save();

            $test_stylist2 = new Stylist(
              $test_name2,  $test_client2->getId()

            );
            $test_stylist2->save();


            //Act
            $test_stylist2->delete();

            //Assert
            $this->assertEquals([$test_stylist], Stylist::getAll());

        }

        function test_find()
        {
            //Arrange
            $test_name = "Jerry ";
            $test_client = new client("Jerry", 9);
            $test_client->save();

            $test_stylist = new Stylist(
              $test_name, $test_client->getId()
            );
            $test_stylist->save();

            //Act
            $result = Stylist::find($test_stylist->getId());

            //Assert
            $this->assertEquals($test_stylist, $result);
        }

    }

?>
