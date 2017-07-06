<?php

/* 
 * Copyright (C) 2015 Kévin Grenèche < kevin.greneche at openhivemanager.org >
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace KG\BeekeepingManagementBundle\Controller;
use KG\BeekeepingManagementBundle\Entity\Visite;
use KG\BeekeepingManagementBundle\Entity\HausseRuche;
use KG\BeekeepingManagementBundle\Entity\Colonie;
use KG\BeekeepingManagementBundle\Form\Type\VisiteType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    /**
    * @Security("has_role('ROLE_USER')")
    * @ParamConverter("visite", options={"mapping": {"ruche" : "id"}}) 
    */    
  
    public function postAction(string $ruche, string $pesee)
    {
                $rucheObj = $this->getDoctrine()->getRepository('KGBeekeepingManagementBundle:Ruche')->find(9 /*$ruche*/);


                $visite = new Visite($rucheObj->getColonie());
                $visite->setPoids($pesee);
                $visite->setActivite( $this->getDoctrine()->getRepository('KGBeekeepingManagementBundle:Activite')->find(1));
                $visite->setEtat( $this->getDoctrine()->getRepository('KGBeekeepingManagementBundle:Etat')->find(1));
                $visite->setAgressivite( $this->getDoctrine()->getRepository('KGBeekeepingManagementBundle:Agressivite')->find(1));

                $em = $this->getDoctrine()->getManager();       
                $em->persist($visite);
        $em->flush();

                return new Response("OK!",
                                                        Response::HTTP_OK,
                                                        array(
                                                                'Content-Type' => 'text/plain',
                                                        )
                                        );
    }
}
