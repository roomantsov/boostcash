<?php

namespace AppBundle\Util;

use AppBundle\Entity\WinHistory;

class WinSystem {
	public function drop($user, $case, $em){
		$bankRepo = $em->getRepository('AppBundle:Bank');
		$itemRepo = $em->getRepository('AppBundle:Item');
		$caserange = $case->getCaserange();
		$bank = $bankRepo->findOneByCaserange($caserange);
		$random = $bank->getRandom();
		$wintime = $bank->getWintime();

		
		$prizeRange = 'cheap';
		if($bank->getCollected() >= $random){
			if($wintime >= 5){
				$bank->setWintime(0);
				$prizeRange = 'expensive';
			} else {
				$bank->setWintime($wintime + 1);
				$prizeRange = 'medium';
			}
			$bank->setCollected(0);
			$random = mt_rand($bank->getMin(), $bank->getMax());
			$bank->setRandom($random);
		}

		$prizesInPrizeRange = $itemRepo->findBy(['itemrange' => $prizeRange, 'caseid' => $case->getId()]);
		$prize = $prizesInPrizeRange[array_rand($prizesInPrizeRange)];

		$bankAddition = $case->getPrice() - $prize->getValue();
		if($bankAddition < 0) $bankAddition = 0;
		$bank->setCollected($bank->getCollected() + $bankAddition);

		$user->setWinamount($user->getwinamount() + $prize->getValue());
		
		$winLog = new WinHistory;
		$winLog->setWinnerid($user->getId())
			   ->setCaseid($case->getId())
			   ->setIsshowed(0)
			   ->setValue($prize->getValue())
			   ->setItemid($prize->getId());
		$em->persist($winLog);
		$em->flush();
		
		return $prize;
	}
}