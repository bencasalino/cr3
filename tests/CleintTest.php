<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Stylist.php";
    require_once "src/Client.php";
    // must add 8889 to work in sql!!
    $server = 'mysql:host=localhost:8889;dbname=hair_salon_test';
    $username = 'root';
    $password = 'root';

    $DB = new PDO($server, $username, $password);
    class ClientTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            // Stylist::deleteAll();
            Client::deleteAll();
        }

        //get cleint name
        function test_getName()
        {
            //Arrange
            $name = "ben";
            $phone = "542-123-1234";
            $style_choice = " shave 1";
            $stylist_id = 1;
            $id = null;
            $test_client = new Client($name, $phone, $style_choice, $stylist_id, $id);

            //Act
            $result = $test_client->getName();

            //Assert
            $this->assertEquals($name, $result);
        }

        function test_getPhone()
        {
            //Arrange
            $name = "joe";
            $phone = "123-456-7890";
            $style_choice = "cut";
            $stylist_id = 1;
            $id = null;
            $test_client = new Client($name, $phone, $style_choice, $stylist_id, $id);

            //Act
            $result = $test_client->getPhone();

            //Assert
            $this->assertEquals($phone, $result);
        }

        function test_getStyleChoice()
        {
            //Arrange
            $name = "joe";
            $phone = "123-456-7890";
            $style_choice = "cut";
            $stylist_id = 1;
            $id = null;
            $test_client = new Client($name, $phone, $style_choice, $stylist_id, $id);

            //Act
            $result = $test_client->getStyleChoice();

            //Assert
            $this->assertEquals($style_choice, $result);
        }

        function test_getStylistId()
        {
            //Arrange
            $name = "ben";
            $id = null;
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();

            $name = "joe";
            $phone = "123-456-7890";
            $style_choice = "cut";
            $stylist_id = 1;
            $id = null;
            $test_client = new Client($name, $phone, $style_choice, $stylist_id, $id);

            //Act
            $result = $test_client->getStylistId();

            //Assert
            $this->assertEquals(true, is_numeric($result));
        }

        function test_getId()
        {
            //Arrange
            $name = "joe";
            $phone = "123-456-7890";
            $style_choice = "cut";
            $stylist_id = 1;
            $id = null;
            $test_client = new Client($name, $phone, $style_choice, $stylist_id, $id);

            //Act
            $result = $test_client->getId();

            //Assert
            $this->assertEquals($id, $result);
        }

        function test_save()
        {
            //Arrange
            $name = "george";
            $id = null;
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();

            $name = "joe";
            $phone = "123-456-7890";
            $style_choice = "cut";
            $stylist_id = $test_stylist->getId();
            $id = null;
            $test_client = new Client($name, $phone, $style_choice, $stylist_id, $id);

            //Act
            $test_client->save();

            //Assert
            $result = Client::getAll();
            $this->assertEquals($test_client, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $name = "jack";
            $id = 1;
            $test_stylist = new Stylist($name, $id);
            $test_stylist->save();

            $name = "johnny";
            $phone = "542-334-1234";
            $style_choice = "shave";
            $stylist_id = $test_stylist->getId();
            $test_client = new Client($name, $phone, $style_choice, $stylist_id);
            $test_client->save();

            $name2 = "booby";
            $phone2 = "123-456-7890";
            $style_choice2 = "trim";
            $stylist_id = $test_stylist->getId();
            $test_client2 = new Client($name2, $phone2, $style_choice2, $stylist_id);
            $test_client2->save();

            //Act
            $result = Client::getAll();

            //Assert
            $this->assertEquals([$test_client, $test_client2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $name = "elaine";
            $test_stylist = new Stylist($name);
            $test_stylist->save();

            $name = "joe";
            $phone = "123-456-7890";
            $style_choice = "cut";
            $stylist_id = $test_stylist->getId();
            $test_client = new Client($name, $phone, $style_choice, $stylist_id);
            $test_client->save();

            $name2 = "jerry";
            $phone2 = "123-456-7890";
            $style_choice2 = "trim";
            $test_client2 = new Client($name2, $phone2, $style_choice2, $stylist_id);
            $test_client2->save();

            //Act
            Client::deleteAll();

            //Assert
            $result = Client::getAll();
            $this->assertEquals([], $result);
        }

        function test_find()
        {
            //Arrange
            $name = "sue";
            $test_stylist = new Stylist($name);
            $test_stylist->save();

            $name = "sarah";
            $phone = "542-334-1234";
            $style_choice = "trim";
            $stylist_id = $test_stylist->getId();
            $test_client = new Client($name, $phone, $style_choice, $stylist_id);
            $test_client->save();

            $name2 = "Jordy Duran";
            $phone2 = "123-456-7890";
            $style_choice2 = "shave";
            $test_client2 = new Client($name2, $phone2, $style_choice2, $stylist_id);
            $test_client2->save();

            //Act
            $result = Client::find($test_client->getId());

            //Assert
            $this->assertEquals($test_client, $result);

        }

        function testUpdate()
        {
            //Arrange
            $name = "jerry";
            $test_stylist = new Stylist($name);
            $test_stylist->save();

            $name = "bob ";
            $phone = "123-456-7890";
            $style_choice = "long cut";
            $stylist_id = $test_stylist->getId();
            $test_client = new Client($name, $phone, $style_choice, $stylist_id);
            $test_client->save();

            $column_to_update = "style_choice";
            $new_information = "long cut";

            //Act
            $test_client->update($column_to_update, $new_information);

            //Assert
            $result = Client::getAll();
            $this->assertEquals("long cut", $result[0]->getStyleChoice());

        }

        function testDelete()
        {
            //Arrange
            $name = "jill";
            $test_stylist = new Stylist($name);
            $test_stylist->save();

            $name = "joe";
            $phone = "123-456-7890";
            $style_choice = "shave";
            $stylist_id = $test_stylist->getId();
            $test_client = new Client($name, $phone, $style_choice, $stylist_id);
            $test_client->save();

            $name2 = "kramer";
            $phone2 = "123-456-7890";
            $style_choice2 = "bowl cut";
            $test_client2 = new Client($name2, $phone2, $style_choice2, $stylist_id);
            $test_client2->save();

            //Act
            $test_client->delete();

            //Assert
            $this->assertEquals([$test_client2], Client::getAll());



        }



    }


 ?>
