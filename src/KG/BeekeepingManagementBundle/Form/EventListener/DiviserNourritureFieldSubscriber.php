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

namespace KG\BeekeepingManagementBundle\Form\EventListener;

use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Doctrine\ORM\EntityRepository;


class DiviserNourritureFieldSubscriber implements EventSubscriberInterface
{
    private $nbmax;
    
    /**
     * Constructor
     */
    public function __construct($nbmax)
    {
        $this->nbmax = $nbmax;
    }
    
    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SET_DATA  => 'preSetData',
            FormEvents::PRE_SUBMIT    => 'preSubmit'
        );
    }
 
    private function addNbMielForm($form)
    {       
        $form->add('nbnourriture', 'integer');
    }
 
    public function preSetData(FormEvent $event)
    {;
        $form = $event->getForm();
        $this->addNbMielForm($form);
    }
 
    public function preSubmit(FormEvent $event)
    {
        $data = $event->getData();
        $form = $event->getForm();
 
        $nbmiel = array_key_exists('nbnourriture', $data) ? $data['nbnourriture'] : null;
        
        if($nbmiel >= $this->nbmax){
            $form->addError(new FormError('Le nombre de cadres de nourriture importé doit être inférieur à celui de la colonie mère'));
        }
        
        $this->addNbmielForm($form);
    }
}