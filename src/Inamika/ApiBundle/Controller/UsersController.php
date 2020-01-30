<?php

//
//  Created by Mauricio Ampuero <mdampuero@gmail.com> on 2019.
//  Copyright © 2019 Inamika S.A. All rights reserved.
//

namespace Inamika\ApiBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Config\Definition\Exception\Exception;

use Inamika\BackEndBundle\Entity\User;
use Inamika\BackOfficeBundle\Form\User\UserAddType;
use Inamika\BackOfficeBundle\Form\User\UserType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UsersController extends BaseController
{
    public function indexAction(){
        return $this->responseOk($this->getDoctrine()->getRepository('InamikaBackEndBundle:User')->getAll()->getQuery()->getResult());
    }

    public function addAction(Request $request,UserPasswordEncoderInterface $passwordEncoder){
        $entity=new User();
        $form = $this->createForm(UserAddType::class,$entity,array('method' => 'POST'));
        $form->handleRequest($request);
        if($errors=$this->ifErrors($form)) return $errors;
        try {
            $password = $passwordEncoder->encodePassword($entity, $entity->getPlainPassword());
            $entity->setPassword($password);
            /* UPLOAD FILE */
            $entity->setPicture($this->uploadPicture($entity->getPicture()));
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            return $this->responseOk();
        }catch (Exception $exc) {
            return $this->responseFail(array(array('property'=>null,'code'=>$exc->getCode(),'message'=>$exc->getMessage(),'data'=>null)),200);
        }
    }
    
    public function editAction(Request $request,$id,UserPasswordEncoderInterface $passwordEncoder){
        $entity=$this->getDoctrine()->getRepository('InamikaBackEndBundle:User')->find($id);
        $entityPicture=$entity->getPicture();
        $form = $this->createForm(UserType::class,$entity,array('method' => 'POST'));
        $form->handleRequest($request);
        if($errors=$this->ifErrors($form)) return $errors;
        try {
            /* UPLOAD FILE */
            $entity->setPicture($this->uploadPicture($entity->getPicture(),$entityPicture));
            if(!empty($form->get('plainPassword')->getData())){
                $password = $passwordEncoder->encodePassword($entity, $entity->getPlainPassword());
                $entity->setPassword($password);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            return $this->responseOk();
        }catch (Exception $exc) {
            return $this->responseFail(array(array('property'=>null,'code'=>$exc->getCode(),'message'=>$exc->getMessage(),'data'=>null)),200);
        }
    }
    
    public function deleteAction(Request $request,$id){
        try {
            if($this->get('security.token_storage')->getToken()->getUser()->getId()==$id)
                throw new Exception('No puede eliminarse a si mismo',200);
            $entity = $this->getDoctrine()->getRepository('InamikaBackEndBundle:User')->find($id);
            $form = $this->createFormBuilder()->setMethod('DELETE')->getForm();
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()){
                $entity->setIsDelete(true);
                $this->getDoctrine()->getManager()->flush();
                return $this->responseOk();
            }
        }catch (Exception $exc) {
            return $this->responseFail(array(array('property'=>null,'code'=>$exc->getCode(),'message'=>$exc->getMessage(),'data'=>null)),200);
        }
    }

}