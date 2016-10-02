<?php

namespace AppBundle\Util;

use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Referal;
use AppBundle\Entity\ReferalHistory;
use Symfony\Component\HttpFoundation\Session\Session;

class ReferalSystem {

	public function addReferal($inviterId, $visitorId, $finSystem, $em){
		$referal = new Referal;
		$referal->setInviter($inviterId)
				->setVisitor($visitorId)
				->setDatetime(new \Datetime);

		$em->persist($referal);
		$em->flush();

        $userInvitings = count($em->getRepository('AppBundle:Referal')->findByInviter($inviterId));

        global $percentage;
        $percentage = $em->getRepository('AppBundle:User')->findOneById($inviterId)->getPercentage();

        switch($userInvitings){
        	case 10:
        		global $percentage;
        		$percentage = 15;
        		break;
        	case 25:
        		global $percentage;
        		$percentage = 20;
        		break;
        	case 50:
        		global $percentage;
        		$percentage = 30;
        		break;
        }

        $inviter = $em->getRepository('AppBundle:User')->findOneById($inviterId);
        $inviter->setPercentage($percentage);
        $em->persist($inviter);

        $visitor = $em->getRepository('AppBundle:User')->findOneById($visitorId);
        $visitor->setIsrefered(true)->setRefererRefCode($inviter->getRefcode());
        $finSystem->increaseBalance(10, $visitorId, 'started referal', $em);
        $finSystem->increaseBalance(1, $inviterId, 'refered the user', $em);
        $em->persist($visitor);

        $em->flush();

        $session = new Session();
        $session->set('user', $visitor);

	}

	public function checkRefLink(Request $request, $em){
		$repo = $em->getRepository('AppBundle:User');
		if($ref = $request->query->get('ref')){
			$session = $request->getSession();
			if(!$session->has('ref') && $repo->findOneByRefcode($ref)){
				$session->set('ref', $ref);
			}
		}
	}

	public function generateRefCode($em){
		$charset = 'AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz';
		$code = '';
		while(strlen($code) < 8){
			$code .= $charset[mt_rand(0, strlen($charset) - 1)];
		}
		if($em->getRepository('AppBundle:User')->findOneByRefcode($code))
			$code = $this->generateRefCode($em);

		return $code;
	}

	public function referalMargin($referedUserId, $amount, $em, $finSystem){
		$referalRepo = $em->getRepository('AppBundle:Referal');
		$userRepo = $em->getRepository('AppBundle:User');

		$refererId = $referalRepo->findOneByVisitor($referedUserId)->getInviter();
		$referer = $userRepo->findOneById($refererId);
		
		if($referer == null){
			return;
		}

		$percentage = $referer->getPercentage();

		$refLog = new ReferalHistory;
		$refLog->setAmount($amount)
			   ->setVisitorid($referedUserId)
			   ->setInviterId($refererId)
			   ->setPercentage($percentage)
			   ->setDatetime(new \Datetime);

		$em->persist($refLog);
		$em->flush();

		$marginAmount = ceil(($amount / 100) * $percentage);
		$finSystem->increaseBalance($marginAmount, $refererId, 'referal margin', $em);
	}

}

// $container = new ContainerBuilder();
// $container->register('app.referaller', 'Referaller'); 