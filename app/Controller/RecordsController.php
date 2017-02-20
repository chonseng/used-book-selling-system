<?php

App::uses('AppController', 'Controller');


class RecordsController extends AppController {
	public $components = array('Paginator');

	public function index() {
		$this->loadModel("Book");
		$this->loadModel("Place");
		// $books = $this->Book->find("all");
		//get params
		if (isset($_GET["book_id"])) $book_id = $_GET["book_id"]; else $book_id="";
		if (isset($_GET["code"])) $code = $_GET["code"]; else $code="";
		if (isset($_GET["form"])) $form = $_GET["form"]; else $form="";
		if (isset($_GET["subject"])) $subject = $_GET["subject"]; else $subject="";

		// $filter = array();
		// $bookid = array();
		// $hasbook = false;
		// $hascodeform = true;
		// if ($book_id!="") {
		// 	$filter += array('Book.id' => $book_id);
		// }
		// else {
		// 	if ($code!="" && $form!="") {
		// 		$places = $this->Place->findAllByCodeAndForm($code,$form);
				
		// 		if (count($places)>0) {
		// 			$hasbook = true;
		// 			foreach ($places as $place) {
		// 				if ($place["Place"]["book_id"] != NULL)
		// 					array_push($bookid, $place["Place"]["book_id"]);	
		// 			}
		// 		}
		// 	}
		// 	else {
		// 		if ($code!="") {
		// 			$places = $this->Place->findAllByCode($code);
					
		// 			if (count($places)>0) {
		// 				$hasbook = true;
		// 				foreach ($places as $place) {
		// 					if ($place["Place"]["book_id"] != NULL)
		// 						array_push($bookid, $place["Place"]["book_id"]);	
		// 				}
		// 			}
		// 		}
		// 		else if ($form!="") {
		// 			$places = $this->Place->findAllByForm($form);
					
		// 			if (count($places)>0) {
		// 				$hasbook = true;
		// 				foreach ($places as $place) {
		// 					if ($place["Place"]["book_id"] != NULL)
		// 						array_push($bookid, $place["Place"]["book_id"]);	
		// 				}
		// 			}
		// 		}
		// 		else $hascodeform = false;
		// 	}
		// 	if ($subject!="" && ($hasbook || !$hascodeform)) {
		// 		$filter += array('Book.subject' => $subject);
		// 	}
		// }
		// if ($hasbook)
		// 	$filter += array('Book.id'=>$bookid);
		

		// $filter += array('Record.brought_at' => NULL);

		$order = 'Record.selled_at DESC';
		if ($code!="" || $form!="" ||  $subject!="") $order ='Record.diff DESC';

		// $this->Paginator->settings = array(
	 //        'conditions' => $filter,
	 //        'limit' => 10,
	 //        'order' => $order
	 //    );

		$filter = array();
		$filter += array('Record.book_id=Place.book_id');
		$filter += array('Record.brought_at'=>NULL);
		if ($book_id!="") $filter += array('Record.book_id'=>intval($book_id));
		if ($form!="") $filter += array('Place.form'=>intval($form));
		if ($code!="") $filter += array('Place.code'=>intval($code));
		if ($subject!="") $filter += array('Book.subject'=>$subject);

	    $this->Paginator->settings = array(
	        'limit' => 10,
	        'order' => $order,
	        'group' => 'Record.id',
	        'joins' => array(
	        	array(
	        		'table' => 'places',
	        		'alias' => 'Place',
	        		'type' => 'inner',
	        		'foreignKey' => false,
	        		'conditions' => $filter
	        	)
	        )
	    );

		   // similar to findAll(), but fetches paged results
		   $data = $this->Paginator->paginate('Record');
		   $this->set('data', $data);
		   // var_dump($data);
		// echo "<pre>";
		// var_dump($records);

		// $records = $this->Record->find("all");
		
		// $this->set("records",$records);
		// $this->set("books",$books);

		$this->set("code",$code);
		$this->set("form",$form);
		$this->set("subject",$subject);

		
		// $book = $this->Book->findById($book_id);
		// if (count($book)>0) $book_name = $book["Book"]["name"];
		// else $book_name = "";
		if ($book_id!="" && count($data)>0)
			$book_name = $data[0]["Book"]["name"];
		else
			$book_name = "";
		$this->set("book_name",$book_name);



		$subject_array = array(
			"Bible" => "聖經",
			"English" => "英文",
			"Chinese" => "國文",
			"Maths" => "數學",
			"Physics" => "物理",
			"Chemistry" => "化學",
			"Science" => "科學",
			"Biology" => "生物",
			"History" => "歷史",
			"Geography" => "地理",
			"IT" => "資訊",
			"Economics" => "經濟",
			"Accounting" => "會計",
		);
		$this->set("subject_array",$subject_array);

	}

	public function add() {

			
		
	}

	public function show() {
		
	}

	public function receipt()
	{
		if ($this->request->is('post')) {
			$this->loadModel("Seller");
			$receipt = $this->request->data["Record"]["receipt"];
			$phone = $this->request->data["Seller"]["phone"];
			$records = $this->Record->find("all",array(
				'order' => 'Record.receipt_num',
				'group' => 'Record.id',
				'joins' => array(
					        	array(
					        		'table' => 'sellers',
					        		'alias' => 'Seller1',
					        		'type' => 'inner',
					        		'foreignKey' => false,
					        		'conditions' => array(
					        			'Record.receipt' => $receipt,
					        			'Seller.phone' => $phone
					        		)
					        	)
					        )
				)
			);

			if (count($records)>0) {
				$total = 0;
				foreach ($records as $key => $record) {
					if ($record["Record"]["brought_at"]!=NULL) $total += $record["Record"]["price"];
				}
				$this->set("total",$total);
				$this->set("records",$records);
			}
			else {
				$this->Session->setFlash(__('沒有找到你的帳單'), 'default', array(), 'bad');
			}
		}
	}

	
}
