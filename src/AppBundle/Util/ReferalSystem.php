<?php

namespace AppBundle\Util;

use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Referal;

class ReferalSystem {

	public function addReferal($inviterId, $visitorId, $finSystem, $em){
		echo 'into referal';
		$referal = new Referal;
		$referal->setInviter($inviterId)
				->setVisitor($visitorId)
				->setDatetime(new \Datetime);

		$em->persist($referal);
		$em->flush();

        $userInvitings = count($em->getRepository('AppBundle:Referal')->findByInviter($inviterId));

        global $percentage;

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
        $visitor->setIsrefered(true);
        $finSystem->increaseBalance(10, $visitorId, 'started referal', $em);
        $em->persist($visitor);

        $em->flush();
		// Log to pay history

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
		while(strlen($code) < 12){
			$code .= $charset[mt_rand(0, strlen($charset) - 1)];
		}
		if($em->getRepository('AppBundle:User')->findOneByRefcode($code))
			$code = $this->generateRefCode($em);

		return $code;
	}

}

// $container = new ContainerBuilder();
// $container->register('app.referaller', 'Referaller'); 