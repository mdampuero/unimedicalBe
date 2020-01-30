<?php

//
//  Created by Mauricio Ampuero <mdampuero@gmail.com> on 2019.
//  Copyright © 2019 Inamika S.A. All rights reserved.
//

namespace Inamika\BackOfficeBundle\Controller;

use Inamika\BackEndBundle\Entity\Setting;
use Inamika\BackOfficeBundle\Form\Setting\SettingType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SettingsController extends BaseController{

	public function indexAction(){
        $entity=$this->getDoctrine()->getRepository('InamikaBackEndBundle:Setting')->find('setting');
        return $this->render('InamikaBackOfficeBundle:Settings:form.html.twig',array(
            'entity'=>$entity,
			'form' => $this->createForm(SettingType::class, $entity,array(
                'method' => 'POST',
                'action' => $this->generateUrl('inamika_api_admin_settings')
            ))->createView()
        ));
	}
}
