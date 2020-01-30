<?php

//
//  Created by Mauricio Ampuero <mdampuero@gmail.com> on 2019.
//  Copyright © 2019 Inamika S.A. All rights reserved.
//

namespace Inamika\ApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use JMS\Serializer\SerializationContext;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Config\Definition\Exception\Exception;


abstract class  BaseController extends FOSRestController{

	protected $context;

	public function __construct() {
		$this->context = new SerializationContext();
        $this->context->setSerializeNull(true);
	}

    // public function addContact(){

    // }

    protected function uploadPicture($file,$exception=null){
        if ($file) {
            $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
            $file->move($this->getParameter('uploads_directory')['path'], $fileName);
            $resizes=$this->getParameter('uploads_directory')['resize'];
            foreach($resizes as $resize){
                $this->get('image.handling')->open($this->getParameter('uploads_directory')['path'].$fileName)
                ->resize($resize['width'],$resize['height'])
                ->save($resize['path'].$fileName);
            }
            return $fileName;
        }else{
            return $exception;
        }
    }
    protected function createDeleteFromAjaxForm($path) {
		return $this->createFormBuilder()
		->setAction($this->generateUrl($path, array('id' => ':ENTITY_ID')))
		->setMethod('DELETE')
		->getForm();
	}
    protected function generateUniqueFileName(){
        return md5(uniqid());
	}
	protected function ifErrors($form){
        if (!$form->isSubmitted()) {
            return $this->responseFail(
				array(array('property'=>null,'code'=>'required_parameters','message'=>'No se recibieron parámetros','data'=>null)),
				200
            );
        }else{
            $errors=$this->get('validator')->validate($form);
            if (count($errors)) {
                $errorsArray=array();
                foreach ($errors as $err) {
                    $property=str_replace('children[', '', str_replace(']', '', str_replace('data', '', str_replace('.', '', $err->getPropertyPath()))));
                    $errorMessage=$err->getMessage();
                    switch ($property) {
                        case 'plainPasswordfirst':
                            $property='plainPassword_first';
                            break;
                        case 'plainPasswordsecond':
                            $property='plainPassword_second';
                            break;
                        case 'plainPassword':
                            $property='plainPassword_second';
                            break;
                        case 'acceptTermsAndConditions':
                            $errorMessage=$this->get('translator')->trans('accept.terms.and.conditions');
                            break;
                    }

                    $errorsArray[]=array('property'=>$property,'message'=>$errorMessage,'code'=>$err->getCode(),'data'=>null);
                }
                return $this->responseFail(
                    $errorsArray,
                    200
                );
            }
        }
        return null;
	}
	protected function getErrors($form){
        if (!$form->isSubmitted()) {
            return array(array('property'=>null,'code'=>'required_parameters','message'=>'No se recibieron parámetros','data'=>null));
        }else{
            $errors=$this->get('validator')->validate($form);
            if (count($errors)) {
                $errorsArray=array();
                foreach ($errors as $err) {
                    $property=str_replace('children[', '', str_replace(']', '', str_replace('data', '', str_replace('.', '', $err->getPropertyPath()))));
                    switch ($property) {
                        case 'plainPasswordfirst':
                            $property='plainPassword_first';
                            break;
                        case 'plainPasswordsecond':
                            $property='plainPassword_second';
                            break;
                        case 'plainPassword':
                            $property='plainPassword_second';
                            break;
                    }
                    $errorsArray[]=array('property'=>$property,'message'=>$err->getMessage(),'code'=>$err->getCode(),'data'=>null);
                }
                return $errorsArray;
            }
        }
        return null;
	}
	public function parseErrors($form){
        $errors=$this->get('validator')->validate($form);
            if (count($errors)) {
                $errorsArray=array();
                foreach ($errors as $err) {
                    $property=str_replace('children[', '', str_replace(']', '', str_replace('data', '', str_replace('.', '', $err->getPropertyPath()))));
                    $errorsArray[]=array('property'=>$property,'message'=>$err->getMessage(),'code'=>$err->getCode(),'data'=>null);
                }
                return $this->responseFail(
                    $errorsArray,
                    200
                );
            } 
    }
	public function responseOk($data=array(),$code=200){
		try{
			// if(!$data)
            //     throw new Exception('No se encontró el registro',200);
			return new Response($this->get('jms_serializer')->serialize(
				array('response'=>true,'data'=>$data),
			'json',$this->context),$code);
		}catch (Exception $excepcion) {
			return $this->responseFail(array(array(
				'property'=>null,
				'message'=>$excepcion->getMessage(),
				'code'=>'not_found',
				'data'=>null
			)),$excepcion->getCode());
		}
    }
    
    public function responseMock($data=array()){
		try{
			return new Response($this->get('jms_serializer')->serialize($data,'json',$this->context),200);
		}catch (Exception $excepcion) {
			return $this->responseFail(array(array(
				'property'=>null,
				'message'=>$excepcion->getMessage(),
				'code'=>'not_found',
				'data'=>null
			)),$excepcion->getCode());
		}
    }
	
	public function responseFail($errors,$code=200){
		return new Response($this->get('jms_serializer')->serialize(
            array('response'=>false,'errors'=>$errors),
        'json',$this->context),$code);
    }
}