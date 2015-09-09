<?php

    //dependencies
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Stylist.php";
    require_once __DIR__."/../src/Client.php";

    $app = new Silex\Application();
    // $app['debug'] = true;

    //Tells app how to access sql phpmyadmin database
    $server = 'mysql:host=localhost:8889;dbname=hair_salon';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    //Points app to twig templates
    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    //Patch/delete routes
    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();



    //landing page, displays any stylists listed! 
    $app->get("/", function() use($app) {
        return $app['twig']->render('index.html.twig', array('stylists' => Stylist::getAll()));
    });

    //lets the user to create new stylist, saves to the database and displays on homepage
    $app->post("/stylists", function() use($app) {
        $stylist = new Stylist($_POST['name']);
        $stylist->save();
        return $app['twig']->render('index.html.twig', array('stylists' =>Stylist::getAll()));
    });

    //goes to a specific stylist page
    $app->get("/stylists/{id}", function($id) use($app) {
        $stylist = Stylist::find($id);
        return $app['twig']->render('stylists.html.twig', array('stylists' => $stylist, 'clients' => $stylist->getClients()));
    });

    //mvoes user to the page to see the stylist
    $app->get("/stylists/{id}/edit", function($id) use($app) {
        $stylist = Stylist::find($id);
        return $app['twig']->render('stylists_edit.html.twig', array('stylists' => $stylist));
    });

    //Posts edited stylist data to database
    $app->patch("/stylists/{id}", function($id) use($app) {
        $name = $_POST['name'];
        $stylist = Stylist::find($id);
        $stylist->update($name);
        return $app['twig']->render('stylists.html.twig', array('stylists' => $stylist, 'clients' => $stylist->getClients()));
    });

    //Deletes one specific stylist from the list
    $app->delete("/stylists/{id}", function($id) use($app) {
        $stylist = Stylist::find($id);
        $stylist->delete();
        return $app['twig']->render('index.html.twig', array('stylists' =>Stylist::getAll()));
    });

    //Clears all stylists in the list
    $app->post("/delete_stylists", function() use($app) {
        Stylist::deleteAll();
        return $app['twig']->render('index.html.twig', array('stylists' =>Stylist::getAll()));
    });

    //Creates new clients and displays them
    $app->post("/clients", function() use($app) {
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $style_choice = $_POST['style_choice'];
        $stylist_id = $_POST['stylist_id'];
        $client = new Client($name, $phone, $style_choice, $stylist_id);
        $client->save();
        $stylist = Stylist::find($stylist_id);
        return $app['twig']->render('stylists.html.twig', array('stylists' => $stylist, 'clients' => $stylist->getClients()));
    });

    //Allows user to edit a specific clients details
    $app->get("/clients/{id}/edit", function($id) use($app) {
        $client = Client::find($id);
        return $app['twig']->render('clients_edit.html.twig', array('clients' => $client));
    });

    //Posted edited client data to the database
    $app->patch("/clients/{id}", function($id) use($app) {
        $client = Client::find($id);
        $stylist = Stylist::find($_POST['stylist_id']);
        foreach ($_POST as $key => $value) {
            if (!empty ($value)) {
                $client->update($key, $value);
            }
        }
        return $app['twig']->render('stylists.html.twig', array('stylists' => $stylist, 'clients' => $stylist->getClients()));
    });

    //deletes all clients that were part of a specific stylist
    $app->post("/delete_clients", function() use($app) {
        Client::deleteAll();
        return $app['twig']->render('index.html.twig', array('clients' => Client::getAll()));
    });

    //deletes specific client based on id
    $app->delete("/clients/{id}", function($id) use ($app) {
        $client = Client::find($id);
        $stylist = Stylist::find($_POST['stylist_id']);
        $client->delete();
        return $app['twig']->render('stylists.html.twig', array('stylists' => $stylist, 'clients' => $stylist->getClients()));
    });

    return $app;

    ?>
