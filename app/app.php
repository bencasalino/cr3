<?php
    //set up
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Client.php";
    require_once __DIR__."/../src/Stylist.php";

    // enables PATCH and DELETE methods to be overridder????
    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    // needed for installing silex
    $app = new Silex\Application();

    // mysql login information??
    $server = 'mysql:host=localhost;dbname=food_finder';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    // needed for installing twig?????
    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    // Landing page. [R]ead
    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig', array(
            'clients' => Client::getAll()
        ));
    });

    // Delete all
    $app->delete("/", function() use ($app) {
        Client::deleteAll();
        Stylist::deleteAll();

        return $app['twig']->render('index.html.twig', array(
            'clients' => Client::getAll()
        ));
    });

    // [C]reate client, display all clients
    $app->post("/clients", function() use ($app) {
        $client = new Client(
            $_POST['name'],
        );
        $client->save();
        return $app['twig']->render('index.html.twig', array(
            'clients' => Client::getAll()
        ));
    });


    // [R]ead one particular client
    $app->get("/clients/{id}", function($id) use ($app) {
        $client = Client::find($id);
        return $app['twig']->render('client.html.twig', array(
            'client' => $client,
            'stylists' => $client->getstylists()
        ));
    });

    //[U]pdate a particular client /clients/{id}
    $app->patch("/clients/{id}", function($id) use ($app) {
        $client = Client::find($id);
        $client->updatePrice($_POST['price']);
        return $app ['twig']->render('client.html.twig', array(
            'client'=> $client,
            'stylists' => $client->getstylists()
        ));

    });


    // Form for editing a client
    $app->get("/clients/{id}/edit", function($id) use ($app) {
        $client = Client::find($id);
        return $app['twig']->render('client_edit.html.twig', array('client' => $client));

    });

    //[D]elete a particular client and or  client {id}
    $app->delete("/clients/{id}", function($id) use ($app) {
        $client = Client::find($id);
        $client->delete();
        return $app['twig']->render('index.html.twig', array('clients' => Client::getAll()));
    });

    //[C]reate a particular stylist associated with a client
    // Also display other stylists associated with this client
    $app->post("/stylists", function() use ($app) {
        $stylist = new Stylist(
            $_POST['name'],
            $_POST['client_id']
        );
        $stylist->save();
        $client = Client::find($_POST['client_id']);
        return $app['twig']->render('client.html.twig', array(
            'client' => $client,
            'stylists' => $client->getstylists()
        ));
    });

    //[U]pdate a particular stylist
    $app->patch("/stylists/{id}", function($id) use ($app) {
        $stylist = Stylist::find($id);
        $stylist->updateName($_POST['name']);

        // get client to display on feedback page
        $client_id = $stylist->getclientId();
        $client = Client::find($client_id);

        return $app['twig']->render('client.html.twig', array(
            'client'=> $client,
            'stylists' => $client->getstylists()
        ));

    });

    //[Delete] a particular stylist
    $app->delete("/stylists/{id}", function($id) use ($app) {
        $stylist = Stylist::find($id);
        $client_id = $stylist->getclientId();
        $stylist->delete();

        $client = Client::find($client_id);

        return $app['twig']->render('client.html.twig', array(
            'client' => $client,
            'stylists' => $client->getstylists()
        ));
    });

    //Display stylist edit form
    $app->get("/stylists/{id}", function($id) use ($app) {
        $stylist = Stylist::find($id);

        return $app['twig']->render('stylist_edit.html.twig', array(
            'stylist' => $stylist
        ));

    });

    return $app;


?>
