<?php

namespace AppBundle\Util;

use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\Session\Session;

class UserSystem {

	public function login($userInfo, $em, $refSystem, $finSystem){
		$repo = $em->getRepository('AppBundle:User');
		if(!$repo->findOneByVkid($userInfo['uid'])){
			$user = $this->register($userInfo, $em, $refSystem, $finSystem);
		} else {
			$user = $repo->findOneByVkid($userInfo['uid']);
		}

		$session = new Session();
		$session->set('user', $user);
	}

	public function register($userInfo, $em, $refSystem, $finSystem){
		$user = new User;
		$user->setName($userInfo['first_name'] . ' ' . $userInfo['last_name'])
			 ->setVkid($userInfo['uid'])
			 ->setBalance(0)
			 ->setRefcode($refSystem->generateRefCode($em))
			 ->setIscheat(false)
			 ->setIsrefered(false)
			 ->setPercentage(10)
			 ->setAvatar($userInfo['photo_big'])
			 ->setBdate($userInfo['bdate']);

		$session = new Session;
		if($session->has('ref')){
			// Put into referal databases
			if($inviter = $em->getRepository('AppBundle:User')->findOneByRefcode($session->get('ref'))){
				// Add according to inviter Referal level
				echo 'has code';
				$em->persist($user);
				$em->flush();
				$visitorId = $user->getId();
				$inviterId = $inviter->getId();
				$refSystem->addReferal($inviterId, $visitorId, $finSystem, $em);

				return $user;
			}
		}

		$em->persist($user);
		$em->flush();

		return $user;
	}

}