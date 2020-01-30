<?php

//
//  Created by Mauricio Ampuero <mdampuero@gmail.com> on 2019.
//  Copyright © 2019 Inamika S.A. All rights reserved.
//

namespace Inamika\ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Config\Definition\Exception\Exception;

use Inamika\BackEndBundle\Entity\Setting;
use Inamika\BackOfficeBundle\Form\Setting\SettingType;

class SettingsController extends BaseController
{
    public function editAction(Request $request){
        $entity=$this->getDoctrine()->getRepository('InamikaBackEndBundle:Setting')->find('setting');
        $form = $this->createForm(SettingType::class,$entity,array('method' => 'POST'));
        $form->handleRequest($request);
        if($errors=$this->ifErrors($form)) return $errors;
        try {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            return $this->responseOk();
        }catch (Exception $exc) {
            return $this->responseFail(array(array('property'=>null,'code'=>$exc->getCode(),'message'=>$exc->getMessage(),'data'=>null)),200);
        }
    }

}