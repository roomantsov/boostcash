<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/API")
 * @Method({"POST","GET"})
 */
class APIController extends Controller
{

	/**
	 * @Route("/get/online", name="getOnline")
	 */
	public function getOnlineAction(){
		$em = $this->getDoctrine()->getManager();
		$response = $this->get('app.usersystem')->getOnline($em);

		return new Response($response);
	}

	/**
	 * @Route("/set/online", name="setOnline")
	 */
	public function setOnlineAction(Request $request){
		$em = $this->getDoctrine()->getManager();
		$this->get('app.usersystem')->setOnline($request->getClientIp(), $em);

		return new Response(1);
	}

	/**
	 * @Route("/get/dynamicdata", name="getDynData")
	 */
	public function getDynDataAction(){
		$em = $this->getDoctrine()->getManager();

		$dql = "SELECT COUNT(1) FROM AppBundle\Entity\User";
        $users = $em->createQuery($dql)
        					->getSingleScalarResult();

        $dql = "SELECT COUNT(1) FROM AppBundle\Entity\WinHistory";
        $cases = $em->createQuery($dql)
        				   ->getSingleScalarResult();

        $dql = "SELECT SUM(w.value) FROM AppBundle\Entity\WinHistory w";
        $won = $em->createQuery($dql)
                  ->getSingleScalarResult();

        $online = $this->get('app.usersystem')->getOnline($em);

        $arrayResult = ['online' => $online, 'users' => $users, 'cases' => $cases, 'won' => $won];
        $arrayResult['ribbon'] = $this->getRibbonAction();
        $jsonResult = json_encode($arrayResult);

        return new Response($jsonResult);
	}

	public function getRibbonAction(){
		$em = $this->getDoctrine()->getManager();
		$winRepo = $em->getRepository('AppBundle:WinHistory');
		$userRepo = $em->getRepository('AppBundle:User');
		$itemRepo = $em->getRepository('AppBundle:Item');
		$newElems = $winRepo->findByIsshowed(false);
		foreach($newElems as $elem){
			$elem->setIsshowed(true);
			$item = $itemRepo->findOneById($elem->getItemid());
			$user = $userRepo->findOneById($elem->getWinnerid());

			$elem->itemImage = $item->getImage();
			$elem->userImage = $user->getAvatar();
			$elem->userId = $user->getId();
		}
		$em->flush();
		//$json_response = json_encode($newElems);
		//$newElems = [];

		return $newElems;
	}

}
