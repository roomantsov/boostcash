<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;                    // Get response class
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;      // Routing annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;    // Routing annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template; // Twig smart templating annotation
use Symfony\Bundle\FrameworkBundle\Controller\Controller;     // Get class Controller
use Symfony\Component\HttpFoundation\Request;                // Get class request
                                                            //
use AppBundle\Entity\Referal;                              // Get class of Referal Entity

class DefaultController extends Controller
{
    /**
     * @Route("/", name="home")
     * @Template("default/index.html.twig")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $this->get('app.referalsystem')->checkRefLink($request, $em);
        $flashes = $request->getSession()->getFlashBag()->get('notice');

        foreach($flashes as $flash){
            dump($flash);
        }

        return ['a' => 'mainpage'];
    }

    /**
     * @Route("/drop/{case}", name="drop")
     * @Template("default/index.html.twig")
     */
    public function dropAction($case)
    {
        return ['a' => $case];
    }

    /**
     * @Route("/profile/{userid}", name="profile")
     * @Template("default/index.html.twig")
     */
    public function profileAction($userid)
    {
        return ['a' => $userid];
    }

    /**
     * @Route("/faq", name="faq")
     * @Template("default/index.html.twig")
     */
    public function faqAction()
    {
        return ['a' => 'FAQ'];
    }

    /**
     * @Route("/login", name="login")
     * @Template("default/login.html.twig")
     */
    public function loginAction(Request $request){
        $client_id = '5630393'; // ID приложения
        $client_secret = 'jrS0ObxbFOOyp5iHkPXm'; // Защищённый ключ
        $redirect_uri = 'http://localhost:8000/login'; // Адрес сайта

        $url = 'http://oauth.vk.com/authorize';

        $params = array(
            'client_id'     => $client_id,
            'redirect_uri'  => $redirect_uri,
            'response_type' => 'code'
        );

        $link = $url . '?' . urldecode(http_build_query($params));

        if($request->query->get('code')){

            $params = array(
                'client_id' => $client_id,
                'client_secret' => $client_secret,
                'code' => $_GET['code'],
                'redirect_uri' => $redirect_uri
            );

            try{
                $token = json_decode(file_get_contents('https://oauth.vk.com/access_token' . '?' . urldecode(http_build_query($params))), true);
            } catch (\Exception $e) {
                $request->getSession()->getFlashBag()->add('notice', 'Error with token, used or unexisting Code');
                return $this->redirectToRoute('login');
            }

            
            $params = array(
                'uids'         => $token['user_id'],
                'fields'       => 'uid,first_name,last_name,bdate,photo_big',
                'access_token' => $token['access_token']
            );

            try{
                $userInfo = json_decode(file_get_contents('https://api.vk.com/method/users.get' . '?' . urldecode(http_build_query($params))), true);
            } catch (\Exception $e) {
                $request->getSession()->getFlashBag()->add('notice', 'Error with vk authorization');
                return $this->redirectToRoute('home');
            }

            $em = $this->getDoctrine()->getManager();
            $this->get('app.usersystem')->login($userInfo['response'][0], $em);

            //return $this->redirectToRoute('login');
        }

        return [
            'page' => 'loginpage',
            'link' => $link
        ];
    }






    // DEVELOMENT SIDE

    /**
     * @Route("/tasks")
     * @Template("default/tasks.html.twig")
     */
    public function showTasksAction(){
        return ['tasks' => [
                'Настроить репозитории',
                'Настроить время',
                'Написать аутентификацию',
                'Разобраться с куки в Реферал сервисе'
            ]];
    }

    /**
     * @Route("/database/test")
     * @Template("default/index.html.twig")
     */
    public function dbTestAction(){

        $test = new Referal;
        $test ->setVisitor(141245)
              ->setInviter(214521)
              ->setDatetime(new \Datetime());

        $em = $this->getDoctrine()->getManager();
        $em->persist($test);
        $em->flush();

        // $repo = $em->getRepository('AppBundle:Referal');
        // $repo->method();
        
        // $repo = $this->getDoctrine()->getRepository('AppBundle:Referal');
        // $obt = $repo->findOneByInviter(333);

        return ['a' => 'Database test'];
    }

    /**
     * @Route("/service/test")
     * @Template("default/index.html.twig")
     */
    public function serviceTest(){
        $test_service = $this->get('referaller');
        $test_service->test();
        return ['a' => 'Service Test'];
    }
}