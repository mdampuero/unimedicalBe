<?php

//
//  Created by Mauricio Ampuero <mdampuero@gmail.com> on 2019.
//  Copyright © 2019 Inamika S.A. All rights reserved.
//

namespace Inamika\BackOfficeBundle\Controller;

use Inamika\BackOfficeBundle\Form\User\UserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\FormError;

class AccountController extends BaseController{

	protected $pathBase="inamika_backoffice_account";

	public function indexAction(){
        $entity=$this->get('security.token_storage')->getToken()->getUser();
		return $this->render('InamikaBackOfficeBundle:Account:index.html.twig',array(
            'entity'=>$entity,
			'form' => $this->createForm(UserType::class, $entity,array(
                'method' => 'POST',
                'action' => $this->generateUrl('inamika_api_admin_users_edit',array('id'=>$entity->getId()))
            ))->createView()
            )
        );
	}

	// public function updateAction(Request $request,UserPasswordEncoderInterface $passwordEncoder) {
    //     $entity=$this->get('security.token_storage')->getToken()->getUser();
    //     $entityPicture=$entity->getPicture();
    //     $form = $this->generateForm(UserType::class,$entity,$this->pathBase);
    //     $form->handleRequest($request);
    //     if ($form->isSubmitted()) {
	// 		if($form->isValid()){
    //             /* UPLOAD FILE */
    //             $entity->setPicture($this->uploadPicture($entity->getPicture(),$entityPicture));
    //             if(!empty($form->get('plainPassword')->getData())){
	// 				$password = $passwordEncoder->encodePassword($entity, $entity->getPlainPassword());
	// 				$entity->setPassword($password);
	// 			}
    //             $em=$this->getDoctrine()->getManager();
    //             $em->persist($entity);
    //             $em->flush();
    //             $this->addFlash('success', $this->container->getParameter('messages')['result']['edit']['text']);
    //             return $this->redirectToRoute($this->pathBase);
    //         }else{
    //             $entity->setPicture($entityPicture);
    //             $this->addFlash("danger", $this->container->getParameter('messages')['result']['error']['text']);
    //         }
    //     }            
    //     return $this->render('InamikaBackOfficeBundle:Account:index.html.twig', array('form' => $form->createView(),'entity'=>$entity,'pathBase'=>$this->pathBase));
    // }

}
