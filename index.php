<?php
	require_once __DIR__.'/vendor/autoload.php';

	
	use Symfony\Component\HttpClient\HttpClient;
	//use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
	use FOS\RestBundle\Controller\AbstractFOSRestController;
	use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
	use Symfony\Component\Routing\Annotation\Route;
	use Symfony\Component\HttpFoundation\Request;
	use Symfony\Component\HttpFoundation\Response;
	use Symfony\Component\HttpFoundation\JsonResponse;
	use Symfony\Component\HttpFoundation\AcceptHeader;

	class APIStudent extends AbstractFOSRestController
	{
		
		public function getAll(Request $request)
		{
			header('Content-Type: application/json');
			$datajson='{
						"rslt": "FAIL",
						"sndTime": “20200424111625”}';
		
			//echo $request->query->get('pwd');		
			//echo (int)$request->getParameter('id');
			//dd($request->getRequest()->get('id'));
			
			//echo 'error ' . $request->headers->get('APIkey') ;
			echo AcceptHeader::fromString($request->headers->get('Accept'));

			if ($request->getContent()) {
				//echo $request->getContent();
				//print_r($request->getHeaders());

				// Get method 
				echo $request->getMethod();

				//echo !empty($request->headers->get('APIkey')) ? $request->headers->get('APIkey') : '';

				//echo $request->getPathInfo();
				
				//dd($request);
				

				//dd($request->getClientIps());

				
			   //print_r($request->getHeaders()['content-type'][0]);
				
				$datajson='{
					"rslt": "SUCCESS",
					"sndTime": “20200424111625”,
					}';
			}
			echo $datajson;

		}

	}

	$a = new APIStudent();
	$request = new Request();
	$a->getAll($request);
 	
