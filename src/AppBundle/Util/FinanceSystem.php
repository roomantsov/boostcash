<?php

namespace AppBundle\Util;

use AppBundle\Entity\FinanceHistory;
use Symfony\Component\HttpFoundation\Session\Session;

class FinanceSystem {

	public function increaseBalance($amount, $userId, $cause, $em){
		$repo = $em->getRepository('AppBundle:User');
		$user = $repo->findOneById($userId);
		$user->setBalance($user->getBalance() + $amount);
		$em->persist($user);

		$finHistoryElem = new FinanceHistory();
		$finHistoryElem->setAmount($amount)
					   ->setUserid($userId)
					   ->setCause($cause)
					   ->setDatetime(new \Datetime);
		$em->persist($finHistoryElem);
		$em->flush();

		$session = new Session();
		if($session->get('user')->getId() === $userId){
			$session->set('user', $user);
		}
	}

	public function decreaseBalance($amount, $userId, $cause, $em){
		$repo = $em->getRepository('AppBundle:User');
		$user = $repo->findOneById($userId);
		$user->setBalance($user->getBalance() - $amount);
		$em->persist($user);

		$finHistoryElem = new FinanceHistory();
		$finHistoryElem->setAmount(-$amount)
					   ->setUserid($userId)
					   ->setCause($cause)
					   ->setDatetime(new \Datetime);
		$em->persist($finHistoryElem);
		$em->flush();

		$session = new Session();
		if($session->get('user')->getId() === $userId){
			$session->set('user', $user);
		}
	}

}