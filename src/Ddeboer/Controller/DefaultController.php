<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Ddeboer\DataImport\Reader\ArrayReader;
use Ddeboer\DataImport\Reader\OneToManyReader;
use Ddeboer\DataImport\Writer\ArrayWriter;
use Ddeboer\DataImport\Workflow;

class DefaultController extends Controller
{
    /**
     * @Route("/app/example", name="homepage")
     */
    public function indexAction()
    {
    	$arr1 = [
    		[ 
    			'label' => 'a',
    			'thing' => 'scissors',
			],
    		[ 
    			'label' => 'b',
    			'thing' => 'pie',
			],
    	];

    	$arr2 = [
    		[ 
    			'label' => 'b',
    			'thing' => 'giraffe',
			],
    		[ 
    			'label' => 'a',
    			'thing' => 'cloud',
			],
    	];
    	    	
    	$reader1 = new ArrayReader($arr1);
    	$reader2 = new ArrayReader($arr2);
    	
    	$oneToMany = new OneToManyReader($reader1, $reader2, 'nester', 'label');
    	$workflow = new Workflow($oneToMany);
    	
    	$results = [];
        $workflow->addWriter(new ArrayWriter($results));

        $workflow->process();
    	
        echo "<pre>";
        print_r($results);
        echo "</pre>";
        
    	
        return $this->render('default/index.html.twig');
    }
}
