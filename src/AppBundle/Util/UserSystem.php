<?php

namespace AppBundle\Util;

use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\Session\Session;
use AppBundle\Entity\Visitor;

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
			 ->setWinamount(0)
			 ->setPercentage(5)
			 ->setAvatar($userInfo['photo_big'])
			 ->setRefererRefCode('')
			 ->setBdate($userInfo['bdate']);

		$session = new Session;
		if($session->has('ref')){
			// Put into referal databases
			if($inviter = $em->getRepository('AppBundle:User')->findOneByRefcode($session->get('ref'))){
				// Add according to inviter Referal level
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

	public function getOnline($em){
		$visitRepo = $em->getRepository('AppBundle:Visitor');
		$visitor = $visitRepo->findAll();

		$numberOfOnlineUsers = $visitRepo->createQueryBuilder('AppBundle\Entity\Visitor')
			->select('COUNT(1)')
	        ->where('AppBundle\Entity\Visitor.lastseen >= :end')
	        ->setParameter('end', new \DateTime('-3 minutes'))
	        ->getQuery()
	        ->execute();

        return intval($numberOfOnlineUsers[0][1]);
	}

	public function setOnline($ip, $em){
		$visitRepo = $em->getRepository('AppBundle:Visitor');
		if(!$visitor = $visitRepo->findOneByIp($ip)){
			$visitor = new Visitor;
			$visitor->setIp($ip);
		}

		$visitor->setLastseen(new \Datetime);

		$em->persist($visitor);
		$em->flush();
	}

}