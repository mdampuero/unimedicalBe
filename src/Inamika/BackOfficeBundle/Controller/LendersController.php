<?php

//
//  Created by Mauricio Ampuero <mdampuero@gmail.com> on 2019.
//  Copyright © 2019 Inamika S.A. All rights reserved.
//

namespace Inamika\BackOfficeBundle\Controller;

use Inamika\BackEndBundle\Entity\Lender;
use Inamika\BackOfficeBundle\Form\Lender\LenderType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LendersController extends Controller{

	public function indexAction(){
		return $this->render('InamikaBackOfficeBundle:Lenders:index.html.twig',array(
            'formDelete'=>$this->createFormBuilder()
            ->setAction($this->generateUrl('api_lenders_delete', array('id' => ':ENTITY_ID')))
            ->setMethod('DELETE')
            ->getForm()->createView()
        ));
    }

    public function addAction(){
        return $this->render('InamikaBackOfficeBundle:Lenders:form.html.twig',array(
            'form' => $this->createForm(LenderType::class, new Lender(),array(
                'method' => 'POST',
                'action' => $this->generateUrl('api_lenders_post')
            ))->createView()
        ));
    }	

    public function editAction($id){
        $entity=$this->getDoctrine()->getRepository('InamikaBackEndBundle:Lender')->find($id);
        return $this->render('InamikaBackOfficeBundle:Lenders:form.html.twig',array(
            'entity'=>$entity,
            'form' => $this->createForm(LenderType::class, $entity,array(
                'method' => 'PUT',
                'action' => $this->generateUrl('api_lenders_put',array('id'=>$id))
            ))->createView()
        ));
    }
}
