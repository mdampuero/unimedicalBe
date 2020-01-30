<?php

//
//  Created by Mauricio Ampuero <mdampuero@gmail.com> on 2019.
//  Copyright © 2019 Inamika S.A. All rights reserved.
//

namespace Inamika\BackOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Form\FormInterface;

class BaseController extends Controller
{
	protected $serializer;
	protected $response;
	protected $encoders;
	protected $normalizers;

	public function __construct(){
		$this->encoders = array(new JsonEncoder());
        $this->normalizers = array(new ObjectNormalizer());
		$this->serializer = new Serializer($this->normalizers, $this->encoders);
		$this->response=new Response();
        $this->response->headers->set('Content-Type', 'application/json');
	}
	
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
	
	public function generateForm($type,$entity,$pathBase){
		$action=$this->generateUrl($pathBase.'_create');
		if($entity->getId()){
			$method='PUT';
			$action=$this->generateUrl($pathBase.'_update',array('id' => $entity->getId()));
		}
		return $this->createForm($type,$entity,array('action' => $action, 'method' => $method));
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
	
	/* GET ALL ROUTES */
	// public function routeAction(){
    //     $router = $this->get('router');
    //         $routes = $router->getRouteCollection();

    //         dump($routes);
    //         // foreach ($routes as $route) {
    //         //     $this->convertController($route);
    //         // }
	// 	exit("dsadsa");
	// }
    // private function convertController(\Symfony\Component\Routing\Route $route)
    //     {
    //         $nameParser = $this->get('controller_name_converter');
    //         if ($route->hasDefault('_controller')) {
    //             try {
    //                 $route->setDefault('_controller', $nameParser->build($route->getDefault('_controller')));
    //             } catch (\InvalidArgumentException $e) {
    //             }
    //         }
    //     }
}
