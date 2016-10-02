<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;                    // Get response class
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;      // Routing annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;    // Method annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template; // Twig smart templating annotation
use Symfony\Bundle\FrameworkBundle\Controller\Controller;     // Get class Controller
use Symfony\Component\HttpFoundation\Request;                // Get class request
use Symfony\Component\HttpFoundation\Session\Session;       // Get session class
                                                           //
use AppBundle\Entity\Referal;                             // Get class of Referal Entity

class DefaultController extends Controller
{
    /**
     * @Route("/", name="home")
     * @Template("default/index.html.twig")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $this->get('app.referalsystem')->checkRefLink($request, $em); // Проверка на реферальную ссылку

        // dev mode
        $flashes = $request->getSession()->getFlashBag()->get('notice');
        foreach($flashes as $flash){
            dump($flash);
        }
        // end dev mode

        $casesRepo = $em->getRepository('AppBundle:Cases');
        $cases = $casesRepo->findAll();

        $dql = "SELECT COUNT(1) FROM AppBundle\Entity\User";
        $numberOfUsers = $em->createQuery($dql)
                      ->getSingleScalarResult();

        $dql = "SELECT COUNT(1) FROM AppBundle\Entity\WinHistory";
        $numberOfWins = $em->createQuery($dql)
                      ->getSingleScalarResult();

        $numberOfOnlineUsers = $this->get('app.usersystem')->getOnline($em);

        $dql = "SELECT u FROM AppBundle\Entity\User u ORDER BY u.winamount DESC";
        $topLuckies = $em->createQuery($dql)
                         ->setMaxResults(10)
                         ->getResult();

        foreach($topLuckies as $lucky){
            $dql = "SELECT COUNT(w.id) FROM AppBundle\Entity\WinHistory w WHERE w.winnerid=".$lucky->getId();
            $data = $em->createQuery($dql)
                       ->getResult()[0];
            $lucky->totalCasesOpened = empty($data[1]) ? 0 : $data[1];
        }

        $dql = "SELECT SUM(w.value) FROM AppBundle\Entity\WinHistory w";
        $summaryWon = $em->createQuery($dql)
                         ->getSingleScalarResult();

        // $this->get('app.usersystem')->setOnline(14, $em);
        // $this->get('app.usersystem')->getOnlineUsers($em);

        $itemRepo = $em->getRepository('AppBundle:Item');

        $query = $em->createQuery("SELECT c FROM AppBundle\Entity\WinHistory c ORDER BY c.id DESC");
        $ribbon = $query->setMaxResults(12)->getResult();
        foreach($ribbon as $item){
            $item->setIsshowed(true);
            $image = $itemRepo->findOneById($item->getItemId())->getImage();
            $item->image = $image;
        }
        $em->flush();
        dump($ribbon);

        return ['cases' => $cases, 'usersNumber' => $numberOfUsers, 'winsNumber' => $numberOfWins, 'online' => $numberOfOnlineUsers, 'ribbon' => $ribbon, 'luckies' => $topLuckies, 'summaryWon' => $summaryWon];
    }

    /**
     * @Route("/case/", defaults={"caseid":-1})
     * @Route("/case/{caseid}", name="case", defaults={"caseid":-1})
     * @Template("default/case.html.twig")
     */
    public function casePageAction($caseid)
    {
        $em = $this->getDoctrine()->getManager();
        $itemsRepo = $em->getRepository('AppBundle:Item');
        $casesRepo = $em->getRepository('AppBundle:Cases');

        $items = $itemsRepo->findByCaseid($caseid);
        $case = $casesRepo->findOneById($caseid);

        return [
            'items' => $items,
            'case' => $case
        ];
    }

    /**
     * @Route("/drop/", defaults={"caseid":-1})
     * @Route("/drop/{caseid}", name="drop", defaults={"caseid":-1})
     * @Method({"POST"})
     */
    public function dropCaseAction($caseid, Request $request)
    {
        $session = $request->getSession();
        if($caseid == -1 || !$session->has('user')){
            return $this->redirectToRoute("home");
        }

        $em = $this->getDoctrine()->getManager();
        $casesRepo = $em->getRepository('AppBundle:Cases');
        $userRepo = $em->getRepository('AppBundle:User');

        $case = $casesRepo->findOneById($caseid);
        $user = $userRepo->findOneById($session->get('user')->getId());

        if(!$case || !$user){
            return $this->redirectToRoute("home");
        }

        $caseprice = $case->getPrice();
        if($user->getBalance() < $caseprice){
            return new Response('error');
        }

        $this->get('app.financesystem')->decreaseBalance($caseprice, $user->getId(), 'case opened:'.$caseid, $em);

        $prize = $this->get('app.winsystem')->drop($user, $case, $em);
        $this->get('app.financesystem')->increaseBalance($prize->getValue(), $user->getId(), 'prize:'.$prize->getId(), $em);

        return new Response($prize->getValue());
    }

    /**
     * @Route("/profile/me/", name="myprofile")
     * @Template("default/profile.html.twig")
     */
    public function profileMeAction()
    {
        $session = new Session;
        $em = $this->getDoctrine()->getManager();

        if(!$session->has('user')){
            return $this->redirectToRoute('home');
        }

        $user = $session->get('user');

        if($user->getIsrefered()){
            $repo = $em->getRepository('AppBundle:Referal');
        }

        $financeRepo = $em->getRepository('AppBundle:FinanceHistory');
        $financeHistory = array_reverse($financeRepo->findByUserid($user->getId()));
        $financeHistoryOutput = [];

        for($i = 0; $i < count($financeHistory) && $i < 30; $i++){
            $row = $financeHistory[$i];
            switch($row->getCause()){
                case 'balance refilled':
                    $finHistoryRow['description'] = "Пополнение баланса на " . $row->getAmount() . '₽';
                    $finHistoryRow['date'] = $row->getDatetime();
                    break;

                case 'started referal':
                    $finHistoryRow['description'] = "Введен реферальный код " . $row->getAmount() . '₽';
                    $finHistoryRow['date'] = $row->getDatetime();
                    break;

                case 'refered the user':
                    $finHistoryRow['description'] = "Приглашен пользователь " . $row->getAmount() . '₽';
                    $finHistoryRow['date'] = $row->getDatetime();
                    break;

                case 'referal margin':
                    $finHistoryRow['description'] = "Начислен девиденд по партнерской системе " . $row->getAmount() . '₽';
                    $finHistoryRow['date'] = $row->getDatetime();
                    break;

                default:
                    $finHistoryRow['description'] = $row->getCause() . ' | ' . $row->getAmount();
                    $finHistoryRow['date'] = $row->getDatetime();
                    break;
            }
            array_push($financeHistoryOutput, $finHistoryRow);
        }

        $winRepo = $em->getRepository('AppBundle:WinHistory');
        $casesRepo = $em->getRepository('AppBundle:Cases');
        $itemRepo = $em->getRepository('AppBundle:Item');
        
        $winHistory = $winRepo->findByWinnerid($user->getId());
        $winHistory = array_slice(array_reverse($winHistory), 0, 40);

        $dql = "SELECT COUNT(1) FROM AppBundle\Entity\WinHistory wh WHERE wh.winnerid =".$user->getId();
        $numberOfOpenedCases = $em->createQuery($dql)
                      ->getSingleScalarResult();

        foreach($winHistory as $elem){
            $case = $casesRepo->findOneById($elem->getCaseid());
            $item = $itemRepo->findOneById($elem->getItemid());

            $elem->case = $case;
            $elem->item = $item;
        }

        return [
            'page' => 'myprofile',
            'user' => $session->get('user'),
            'financeHistory' => $financeHistoryOutput,
            'winHistory' => $winHistory,
            'openedcases' => $numberOfOpenedCases
        ];
    }

    /**
     * @Route("/profile/", defaults={"userid":-1})
     * @Route("/profile/{userid}", name="profile")
     * @Template("default/profile.html.twig")
     */

    public function profileAction($userid)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('AppBundle:User');
        $user = $repo->findOneById($userid);

        if(!$user){
            return $this->redirectToRoute('home');
        }

        $session = new Session;
        if($session->has('user') && $session->get('user')->getId() == $userid){
            return $this->redirectToRoute('myprofile');
        }

        $winRepo = $em->getRepository('AppBundle:WinHistory');
        $casesRepo = $em->getRepository('AppBundle:Cases');
        $itemRepo = $em->getRepository('AppBundle:Item');
        
        $winHistory = $winRepo->findByWinnerid($user->getId());
        $winHistory = array_slice(array_reverse($winHistory), 0, 40);

        $dql = "SELECT COUNT(1) FROM AppBundle\Entity\WinHistory wh WHERE wh.winnerid =".$user->getId();
        $numberOfOpenedCases = $em->createQuery($dql)
                      ->getSingleScalarResult();

        foreach($winHistory as $elem){
            $case = $casesRepo->findOneById($elem->getCaseid());
            $item = $itemRepo->findOneById($elem->getItemid());

            $elem->case = $case;
            $elem->item = $item;
        }

        return [
            'page' => 'profile',
            'user' => $user,
            'winHistory' => $winHistory,
            'openedcases' => $numberOfOpenedCases
        ];
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

        if($request->getSession()->has('user')){
            $request->getSession()->getFlashBag()->add('notice', 'You\'ve already authorized');
            return $this->redirectToRoute('home');
        }

        // generating link for VK authorization

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

        // end of generating link fr VK authorization

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
            $refSystem = $this->get('app.referalsystem');
            $finSystem = $this->get('app.financesystem');
            $this->get('app.usersystem')->login($userInfo['response'][0], $em, $refSystem, $finSystem);

            return $this->redirectToRoute("home");
        } else {
            $request->getSession()->getFlashBag()->add('notice', 'Error with vk authorization, no get parameter "code"');
            return $this->redirectToRoute('home'); // Когда вынесу кнопку, раскомментить
        }
    }

    /**
     * @Route("/addreferal", name="addreferal")
     */
    public function addReferalAction(Request $request){
        $session = $request->getSession();
        if(!$session->has('user') || $session->get('user')->getIsrefered() || !$refcode = $request->request->get('refcode')){
            return $this->redirectToRoute("home");
        }

        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('AppBundle:User');

        if(!$referer = $repo->findOneByRefcode($refcode)){
            return $this->redirectToRoute("home");
        }

        $inviterId = $referer->getId();
        $visitorId = $session->get('user')->getId();
        $finSystem = $this->get('app.financesystem');
        $this->get('app.referalsystem')->addReferal($inviterId, $visitorId, $finSystem, $em);

        return $this->redirectToRoute("home");
    }

    /**
     * @Route("/pay", name="paypageget")
     * @Template("default/payment.html.twig")
     * @Method({"GET"})
     */
    public function paymentPageAction(){
        return [];
    }

    /**
     * @Route("/pay", name="paypagepost")
     * @Method({"POST"})
     */
    public function paymentAction(Request $request){
        if(!$amount = $request->request->get('amount')){
            return $this->redirectToRoute("home");
        }

        if(!$user = $request->getSession()->get('user')){
            return $this->redirectToRoute("home");
        }

        if($amount < 10){
            return $this->redirectToRoute("home");
        }

        $userId = $user->getId();
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('AppBundle:User');

        $finSystem = $this->get('app.financesystem');

        if($user->getIsrefered()){
            $this->get('app.referalsystem')->referalMargin($userId, $amount, $em, $finSystem);
        }

        $finSystem->increaseBalance($amount, $userId, 'balance refilled', $em);

        //return new Response($userId);
        return $this->redirectToRoute('home');
    }



    // DEVELOMENT SIDE

    /**
     * @Route("/tasks")
     * @Template("default/tasks.html.twig")
     */
    public function showTasksAction(){
        return ['tasks' => [
                'Настроить время',
                'Доделать профили других пользователей',
                'Сделать добавление реферала из профиля',
                'Доработать вывод истории рефералов и пополнений баланса в "Историю Финансов"',
                'На продакшн дописать отдельный логаут, который будет обнулять только пользователя',
                'online, счетчик, лента',
                'логика выпадания и истории выпаданий, списание с баланса',
                'Красивый вывод историй'
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

    /**
     * @Route("/logout/{redirectUrl}", name="logout", defaults={"redirectUrl":"/"})
     */
    public function logoutAction($redirectUrl){
        session_destroy();
        return $this->redirect(urldecode($redirectUrl));
    }
}