<?php

namespace AppBundle\Util;

use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;

class UserSystem {

	public function login($user, $em){
		$repo = $em->getRepository('AppBundle:User');
		if(!$repo->findOneByVkid($user['uid'])){
			$this->register($user, $em);
		}
	}

	public function register($user, $em){
		dump($user);
	}

}