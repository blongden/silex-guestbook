<?php
namespace Blongden\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Silex\Application;
use Blongden\Form\GuestbookType;

class Index
{
    public function indexAction(Application $app, Request $req)
    {
        $form = $app['form.factory']->create(new GuestbookType());

        if ($req->getMethod() == 'POST') {
            $form->bind($req);
            if ($form->isValid()) {
                $data = $form->getData();
                $app['guestbook']->add(
                    $data['name'],
                    $data['message'],
                    $app['request_time']
                )->save();
                return $app->redirect($app->url('homepage'), 303);
            }
        }

        $response = new Response();
        $response->headers->set('Surrogate-Control', 'content="ESI/1.0"');

        return $app->render(
            'guestbook.twig',
            [ 'guestbook' => $form->createView() ],
            $response->setTtl(300)
        );
    }

    public function messagesAction(Application $app)
    {
        $response = new Response();

        return $app->render(
            'messages.twig',
            [ 'guestbook' => $app['guestbook']->get() ],
            $response->setTtl(10)
        );
    }
}
