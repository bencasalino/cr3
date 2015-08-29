<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Stylist.php";
    require_once "src/Client.php";


    $server = 'mysql:host=localhost;=hair_salon_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class StylistTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        }
            Stylist::deleteAll();
        }

        //get name
        function test_getStylistName()
        {
            //Arrange
            $stylist_name = "bob";
            $test_stylist = Stylist(stylist_name);

            //Act
            $result = $test_Stylist->getStylistName();

            //Assert
            $this->assertEquals($stylist_name, $result);

        }


        $this->assertEquals(true, is_numeric($result));
    }

    //test save
    function test_save()
    {
        //Arrange
        $stylist_name = "bob";
        $test_stylist = new Stylist($stylist_name);
        $test_stylist->save();

        //Act
        $result = Stylist::getAll();

        //Assert
        $this->assertEquals($test_stylist, $result[0]);

    }

    //get all
    function test_getAll()
    {
        //Arrange
        $stylist_name = "bob";
        $test_stylist = new Stylist($stylist_name);
        $test_stylist-> save();

        $stylist_name2 = "fred";
        $test_stylist2 = new Stylist($stylist_name2);
        $test_stylist2-> save();

        //Act
        $result = Stylist::getAll();

        //Assert
        $this->assertEquals([$test_stylist, $test_stylist2], $result);
    }

    //del all
    function test_deleteAll()
    {
        //Arrange
        $stylist_name = "bob";
        $test_stylist = new Stylist($stylist_name);
        $test_stylist-> save();

        $stylist_name2 = "jack";
        $test_stylist2 = new Stylist($stylist_name2);
        $test_stylist2-> save();

        //Act
        $result = Stylist::deleteAll();
        $result = Stylist::getAll();

        //Assert
        $this->assertEquals([], $result);
    }

    //get find
    function test_find()
    {
        //Arrange
        $stylist_name = "jerry";
        $test_stylist = new Stylist($stylist_name);
        $test_stylist-> save();
        $stylist_name2 = "kramer";
        $test_stylist2 = new Stylist($stylist_name2);
        $test_stylist2-> save();
        //Act
        $result = Stylist::find($test_stylist->getId());
        //Assert
        $this->assertEquals($test_stylist, $result);
    }

    //update name 
    function test_update()
    {
        //Arrange
        $stylist_name = "george";
        $id = null;
        $test_stylist = new Stylist($stylist_name, $id);
        $test_stylist->save();
        $new_name = "elaine";
        //Act
        $test_stylist->update($new_name);
        //Assert
        $this->assertEquals("elaine", $test_stylist->getStylistName());
    }

    //del
    function test_delete()
    {
         //Arrange
         $stylist_name = "jerry";
         $id = null;
         $test_stylist = new Stylist($stylist_name);
         $test_stylist-> save();
         $stylist_name2 = "newman";
         $test_stylist2 = new Stylist($stylist_name2);
         $test_stylist2-> save();
         //Act
         $test_stylist->delete();
         //Assert
         $this->assertEquals([$test_stylist2], Stylist::getAll());
    }

  }



?>
