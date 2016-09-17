<?php

namespace AppBundle\Util;

use Symfony\Component\HttpFoundation\Request;

class ReferalSystem {

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
			$code = generateRefCode($em);

		return $code;
	}

}

// $container = new ContainerBuilder();
// $container->register('app.referaller', 'Referaller'); 