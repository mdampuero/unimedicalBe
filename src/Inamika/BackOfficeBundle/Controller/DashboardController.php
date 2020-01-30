<?php

//
//  Created by Mauricio Ampuero <mdampuero@gmail.com> on 2019.
//  Copyright © 2019 Inamika S.A. All rights reserved.
//

namespace Inamika\BackOfficeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DashboardController extends Controller
{
    public function indexAction()
    {
        return $this->render('InamikaBackOfficeBundle:Dashboard:index.html.twig');
    }
    public function changeLocaleAction(request $request){
        return $this->redirect($request->headers->get('referer'));
    }
}
