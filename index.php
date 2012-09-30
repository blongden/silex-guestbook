<?php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Blongden\Form\GuestbookType;

$app = require "bootstrap.php";

$app->match("/", function(Request $req) use ($app) {
    $form = $app['form.factory']->create(new GuestbookType());    

    if ($req->getMethod() == 'POST') {
        $form->bind($req);
        if ($form->isValid()) {
            $data = $form->getData();
            $app['guestbook']->add(
                $data['name'],
                $data['message'],
                $_SERVER['REQUEST_TIME']
            )->save();
            return $app->redirect($app->url('homepage'), 303); // 303: See Other
        }
    }

    $response = new Response();
    $response->headers->set('Surrogate-Control', 'content="ESI/1.0"');
    return $app->render('index.twig', [
        'guestbook' => $form->createView()
    ], $response->setTtl(300));
})->method("GET|POST")->bind('homepage');

$app->get("/messages", function() use ($app) {
    $response = new Response();
    return $app->render('messages.twig', [
        'guestbook' => $app['guestbook']->get()
    ], $response->setTtl(10));
})->bind('messages');

$app['http_cache']->run();
