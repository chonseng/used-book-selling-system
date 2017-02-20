<?php

class AdminsController extends AppController {
	public $components = array('Paginator','RequestHandler');
	public $subject_array = array(
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
	public $form_array = array(
			"7"=>"初一",
			"8"=>"初二",
			"9"=>"初三",
			"10"=>"高一",
			"11"=>"高二",
			"12"=>"高三",
		);
	public $book_type = array(
			0 => "非國內書",
			1 => "國內書"
		);
	public $members = array("addbook","addmanybooks","oldbook","addmanyoldbooks","book", "reset");

	public function beforeFilter() {
		$this->layout = 'admin';
		if ($this->request->action != "login") {
			if (!$this->Session->read("is_logged")) {
				$this->redirect("/admins/login");
			}
		}
		if ($this->Session->read("authority") == 1) {
			$canAccess = true;
			$action = $this->request->action;
			foreach ($this->members as $member) {
				if ($action == $member) $canAccess = false;
			}
			if (!$canAccess) {
				$this->Session->setFlash(__('沒有權限進入！'), 'default', array(), 'bad');
				$this->redirect($this->referer());
			}
		}
	}

	public function login() {
		$this->layout = 'default';
		if ($this->request->is('post')) {
			$username = $this->request->data("Admin.login");
			$password = $this->request->data("Admin.password");
			$user = $this->Admin->findByUsernameAndPassword($username,md5($password));
			if (count($user) > 0) {
				$this->Session->write("is_logged", true);
				$this->Session->write("authority", $user["Admin"]["authority"]);
				$this->redirect("/admins");
			}
			else {
				$this->Session->setFlash(__('登入失敗'), 'default', array(), 'bad');
				$this->redirect("/admins/login");
			}
		}
	}

	public function logout() {
		$this->Session->write("is_logged", false);
		$this->redirect("/admins");
	}

	public function index() {
		$this->set('title_for_layout', '首頁');
	}

	public function delete($id) {
		$this->loadModel("Record");
		$this->Record->delete($id);
		$this->Session->setFlash('已刪除', 'default', array(), 'good');
		// $this->redirect("/admins/allrecord");
		$this->redirect($this->referer());
	}

	public function add() {
		$this->set('title_for_layout','輸入紀錄');

		if ($this->request->is('post')) {

			$this->loadModel("Record");
			// $this->Record->create();
			// $this->loadModel("Place");
			// $code = $this->request->data["Record"]["code"];
			// $form = $this->request->data["Record"]["form"];
			// $type = $this->request->data["Record"]["type"];
			// $place = $this->Place->findByFormAndCodeAndType($form, $code, $type);
			// if (count($place)==0) {
			// 	$this->Session->setFlash(__('輸入錯誤'), 'default', array(), 'bad');
			// 	$this->redirect(array('controller' => 'admins', 'action' => 'add'));
			// }
			// $book_id = $place["Place"]["book_id"];

			$receipt = intval($this->request->data["Record"]["receipt"]);
			$receipt_num = intval($this->request->data["Record"]["receipt_num"]);
			$book_id = $this->request->data["Book"]["id"];


			$name = $this->request->data["Record"]["seller"];
			$phone = $this->request->data["Record"]["phone"];
			$this->loadModel("Seller");
			$seller = $this->Seller->findByName($name);
			if (count($seller)==0) {
				$this->Seller->create();
				$data = array('name'=>$name,'phone'=>$phone);
				$this->Seller->save($data);
			}

			$this_seller = $this->Seller->findByName($name);
			$this->request->data["Record"]["seller_id"] = $this_seller["Seller"]["id"];

			if ($book_id != 0) {
				$this->request->data["Record"]["selled_at"] = date('Y-m-d H:i:s');
				$this->request->data["Record"]["book_id"] = $book_id;

				$this->loadModel("Book");
				$book = $this->Book->findById($book_id);
				$this->request->data["Record"]["diff"] = $book["Book"]["price"] - $this->request->data["Record"]["price"];

				$record = $this->Record->findByReceiptAndReceiptNum($receipt,$receipt_num);
				if (count($record)){
					$this->Session->setFlash(__('輪入失敗，重複的序號'), 'default', array(), 'bad');
				}
				else if ($this->Record->save($this->request->data)) {
					$this->Session->setFlash(__('成功輸入'), 'default', array(), 'good');
					$record = $this->Record->findByReceiptAndReceiptNum($receipt,$receipt_num);
					$this->set("record",$record);
					// $this->redirect(array('controller' => 'admins', 'action' => 'add'));
				} else {
					$this->Session->setFlash(__('輪入失敗，請重新嘗試'), 'default', array(), 'bad');
				}
			}
			else {
				$this->Session->setFlash(__('沒有找到此書'), 'default', array(), 'bad');
				$this->redirect(array('controller' => 'admins', 'action' => 'add'));
			}
			
		}

	}


	public function receipt() {
		$this->set("title_for_layout","賣家帳單");
		if (isset($_GET["receipt"])) {
			$findreceipt = $_GET["receipt"]; 
			// $this->loadModel("Seller");
			$this->loadModel("Record");
			// $seller = $this->Seller->findByName($findseller);
			// $records = $this->Record->findAllBySellerId($seller["Seller"]["id"]);
			// $this->set("seller", $seller);
			// $this->set("records", $records);
			$records = $this->Record->findAllByReceipt($findreceipt);
			$this->set("records",$records);
		}
	}

	public function buy() {
		$this->set("title_for_layout","購買書本");
		if ($this->request->is('post')) {
			$this->loadModel("Record");
			$booknum = $this->request->data["booknum"];
			$receipt = intval(substr($booknum, 0,-2));
			$receipt_num = intval(substr($booknum, -2,2));
			var_dump($receipt);
			var_dump($receipt_num);
			$record = $this->Record->findByReceiptAndReceiptNum($receipt,$receipt_num);
			if (count($record)==0) {
				$this->Session->setFlash(__('沒有此書'), 'default', array(), 'bad');
				$this->redirect("/admins/buy");
			}

			$brought_at = $record["Record"]["brought_at"];
			// var_dump($brought_at==NULL);
			// exit;
			if ($brought_at == NULL) {
				$this->request->data["Record"]["id"] = $record["Record"]["id"];
				$this->request->data["Record"]["brought_at"] = date('Y-m-d H:i:s');
				if ($this->Record->save($this->request->data)) {
					$this->Session->setFlash(__('成功賣出'), 'default', array(), 'good');
				} else {
					$this->Session->setFlash(__('失敗'), 'default', array(), 'bad');
				}
				
			}
			else {
				$this->Session->setFlash(__('此書已賣出'), 'default', array(), 'bad');
			}

			$record = $this->Record->findByReceiptAndReceiptNum($receipt,$receipt_num);
			$this->set("selled",$record);

		}
	}

	public function notbuy($id)
	{
		$this->loadModel("Record");
		$record = $this->Record->findById($id);
		$this->Record->create();
		$record["Record"]["brought_at"] = NULL;
		$this->Record->save($record);
		$this->Session->setFlash('成功復原', 'default', array(), 'good');
		// $this->redirect("/admins/buy");
		$this->redirect($this->referer());
	}

	public function addbook() {
		$this->set("title_for_layout","新增書單書目");
		

		if ($this->request->is('post')) {
			// $data = $this->request->data["SmallExp"]["content"];
			// $this->request->data["SmallExp"]["content"] = $this->process_data($data);




			$this->loadModel("Book");
			$this->Book->create();
			// var_dump($this->request->data);
			// exit;
			if ($this->Book->save($this->request->data)) {
				$book = $this->Book->find("first",array('order'=>'Book.id desc'));
				$book_id = $book["Book"]["id"];
				$this->request->data["Place"]["book_id"] = $book_id;

				$this->loadModel("Place");
				$this->Place->create();
				$newForm = $this->request->data["Place"]["form"];
				$newCode = $this->request->data["Place"]["code"];
				$newType = $this->request->data["Place"]["type"];
				$newPlace = $this->Place->find("first",array('conditions'=>array(
					'Place.form'=>$newForm,
					'Place.code'=>$newCode,
					'Place.type'=>$newType,
				)));
				$id = $newPlace["Place"]["id"];
				$this->request->data["Place"]["id"] = $id;

				if ($this->Place->save($this->request->data)) {
					$this->Session->setFlash(__('成功輸入'), 'default', array(), 'good');
					$this->redirect(array('controller' => 'admins', 'action' => 'addbook'));
				}
			} else {
				$this->Session->setFlash(__('輪入失敗，請重新嘗試'), 'default', array(), 'bad');
			}

		}
	}

	public function allseller() {
		// if (!isset($_GET["page"])) $page=1;
		// else $page = $_GET["page"];

		// $this->loadModel("Seller");
		// $this->loadModel("Record");
		// $start = ($page-1)*5;
		// $length = 5;
		// $sellers = $this->Seller->find("all",array(
		// 	'limit'=> 5,
		// 	'offset'=> $start
		// 	));

		// $records = array();
		// foreach ($sellers as $seller) {

		// 	$allrecords = $this->Record->findAllBySellerId($seller["Seller"]["id"]);

		// 	if (!isset($records[$seller["Seller"]["id"]])) {
		// 		$records[$seller["Seller"]["id"]]["total"] = 0;
		// 		$records[$seller["Seller"]["id"]]["name"] = $seller["Seller"]["name"];
		// 		$records[$seller["Seller"]["id"]]["phone"] = $seller["Seller"]["phone"];
		// 		$records[$seller["Seller"]["id"]]["receipt"] = array();
		// 	}

		// 	foreach ($allrecords as $record) {
		// 		if (!in_array($record["Record"]["receipt"], $records[$seller["Seller"]["id"]]["receipt"])) array_push($records[$seller["Seller"]["id"]]["receipt"], $record["Record"]["receipt"]);
		// 		if ($record["Record"]["brought_at"] != NULL) $records[$seller["Seller"]["id"]]["total"] += $record["Record"]["price"];
		// 	}
		// }

		// $this->set("records",$records);
		// $this->set("current",$page);

		// $allsellers = $this->Seller->find("all");
		// $seller_count = count($allsellers);

		// $total_page = ceil($seller_count/5);
		// if (($page-1) > 0) $this->set("pre",$page-1);
		// if (($page+1) <= $total_page) $this->set("next",$page+1);
		$this->set("title_for_layout","賣家資料");
		$this->loadModel("Seller");
			$this->Paginator->settings = array(
		        'limit' => 5,
		        'order' => 'Seller.id'
		    );

	   // similar to findAll(), but fetches paged results
	   $data = $this->Paginator->paginate('Seller');

	   foreach ($data as $key => $seller) {
   			$init = array("Total" => 0,"Receipt" => array());
   			array_push($data[$key], $init);
   			// var_dump($seller);

	   		foreach ($seller["Record"] as $record) {
	   			if ($record["brought_at"]!=NULL)
	   				$data[$key][0]["Total"] += $record["price"];
	   			if (!in_array($record["receipt"], $data[$key][0]["Receipt"]))
	   				array_push($data[$key][0]["Receipt"], $record["receipt"]);
	   		}
	   }

	   $this->set('data', $data);
	}

	public function allrecord() {
		// if (!isset($_GET["page"])) $page=1;
		// else $page = $_GET["page"];
		$this->set("title_for_layout","所有紀錄");
		$this->loadModel("Record");
		// $start = ($page-1)*5;
		// $length = 10;
		// $records = $this->Record->find("all",array(
		// 	'limit'=> 5,
		// 	'offset'=> $start,
		// 	'order' => 'Record.selled_at'
		// 	));

			$this->Paginator->settings = array(
		        'limit' => 10,
		        'order' => 'Record.selled_at desc'
		    );

			   // similar to findAll(), but fetches paged results
			   $data = $this->Paginator->paginate('Record');
			   $this->set('data', $data);
		
		// var_dump($records);
		// $this->set("records",$records);
		// $this->set("current",$page);

		// $allrecords = $this->Record->find("all");
		// $record_count = count($allrecords);

		// $resource = mysql_query("SELECT COUNT(*) FROM seller");
		// $record_count = mysql_result($resource,0);
		// var_dump($record_count);
		// $total_page = ceil($record_count/$length);
		// if (($page-1) > 0) $this->set("pre",$page-1);
		// if (($page+1) <= $total_page) $this->set("next",$page+1);
	}

	public function book() {
		
		$this->set("form_array",$this->form_array);
		$this->set("book_type",$this->book_type);

		$this->set("title_for_layout","書單");
		$this->loadModel("Book");
		$this->Paginator->settings = array(
				        'limit' => 10,
				        'order' => 'Book.id desc'
				    );

					   // similar to findAll(), but fetches paged results
					   $data = $this->Paginator->paginate('Book');
					   $this->set('data', $data);
					   // var_dump($data);
	}

	public function deletebook($id)
	{
		$this->loadModel("Book");
		$this->Book->delete($id);
		$this->Session->setFlash('已刪除', 'default', array(), 'good');
		$this->redirect("/admins/book");
	}

	public function oldbook()
	{		
		$this->set("title_for_layout","舊書重用");
		if ($this->request->is('post')) {
			


			$this->loadModel("Place");
			$this->Place->create();
			$prevForm = $this->request->data["Prev"]["form"];
			$prevCode = $this->request->data["Prev"]["code"];
			$prevPlace = $this->Place->find("first",array('conditions'=>array(
				'Place.form'=>$prevForm,
				'Place.code'=>$prevCode
			)));
			// var_dump($prevPlace);
			$book_id = $prevPlace["Place"]["book_id"];

			$newForm = $this->request->data["Place"]["form"];
			$newCode = $this->request->data["Place"]["code"];
			$newPlace = $this->Place->find("first",array('conditions'=>array(
				'Place.form'=>$newForm,
				'Place.code'=>$newCode
			)));
			$id = $newPlace["Place"]["id"];
			$this->request->data["Place"]["id"] = $id;
			$this->request->data["Place"]["book_id"] = $book_id;

			// var_dump($this->request->data);
			// exit;
			
			// var_dump($this->request->data);
			// exit;
			if ($this->Place->save($this->request->data)) {
				$this->Session->setFlash(__('成功輸入'), 'default', array(), 'good');
				$this->redirect(array('controller' => 'admins', 'action' => 'oldbook'));
			} else {
				$this->Session->setFlash(__('輪入失敗，請重新嘗試'), 'default', array(), 'bad');
			}

		}
	}
	public function addmanybooks()
	{
		$this->set("title_for_layout","新增書目 Excel");
		if ($this->request->is('post')) {
			$input = $this->request->data["allbooks"];

			$this->loadModel("Book");
			$this->loadModel("Place");
			$rows = explode("\n", $input);
			foreach ($rows as $key => $value) {
				$strTr = "";
				$this->Book->create();
				
				$columns = explode("	", $rows[$key]);

				$data["Book"] = array(
					"name" => $columns[2],
					"subject" => $columns[3],
					"price" => floatval($columns[4])
				);
				$this->Book->save($data);

				$this->Place->create();
				$book = $this->Book->find("first",array('order'=>'Book.id desc'));
				$book_id = $book["Book"]["id"];
				$place = $this->Place->findByFormAndCodeAndType($columns[0],$columns[1],$columns[5]);
				$id = $place["Place"]["id"];
				$data["Place"] = array(
					"id" => intval($id),
					"book_id" => intval($book_id),
					"form" => intval($columns[0]),
					"code" => intval($columns[1]),
					"type" => intval($columns[5]),
				);

				// var_dump($data);
				// exit;
				$this->Place->save($data);

			}
			

		}
		
	}

	public function addmanyoldbooks()
	{
		$this->set("title_for_layout","舊書重用 Excel");
		if ($this->request->is('post')) {
			$input = $this->request->data["allbooks"];


			$this->loadModel("Place");
			$rows = explode("\n", $input);
			foreach ($rows as $key => $value) {
				$columns = explode("	", $rows[$key]);
				if ($columns[0]!="") {
					$this->Place->create();
					$place = $this->Place->findByFormAndCodeAndType($columns[0],$columns[1],$columns[4]);

					$book_id = $place["Place"]["book_id"];
					$place = $this->Place->findByFormAndCodeAndType($columns[2],$columns[3],$columns[4]);
					$id = $place["Place"]["id"];
					$data["Place"] = array(
						"id" => intval($id),
						"book_id" => intval($book_id),
						"form" => intval($columns[2]),
						"code" => intval($columns[3]),
						"type" => intval($columns[4]),
					);

					// var_dump($data);
					// exit;
					$this->Place->save($data);
				}

			}
			

		}
		
	}

	public function resetbook()
	{
		$this->loadModel("Place");
		$this->Place->query('TRUNCATE book_places;');
		
		// non-China Book
		$this->Place->create();
		$id=1;
		for ($i=7; $i < 13; $i++) { 
			for ($j=1; $j < 38; $j++) { 
				$datas1["Place"] = array("id"=>$id,"form"=>$i,"code"=>$j,"type"=>0,"book_id"=>NULL);
				$this->Place->save($datas1);
				$id++;
			}
		}

		// China Book
		$this->Place->create();
		$id=223;
		for ($i=7; $i < 13; $i++) { 
			for ($j=1; $j < 19; $j++) { 
				$datas2["Place"] = array("id"=>$id,"form"=>$i,"code"=>$j,"type"=>1,"book_id"=>NULL);
				$this->Place->save($datas2);
				$id++;
			}
		}

		$this->loadModel("Book");
		$this->Book->query('TRUNCATE book_books;');
		$this->Session->setFlash(__('成功重設書單'), 'default', array(), 'good');
		$this->redirect("/admins/reset");
	}

	public function resetrecord()
	{
		$this->loadModel("Record");
		$this->Record->query('TRUNCATE book_records;');
		$this->Session->setFlash(__('成功重設紀錄'), 'default', array(), 'good');
		$this->redirect("/admins/reset");
	}

	public function resetseller()
	{
		$this->loadModel("Seller");
		$this->Seller->query('TRUNCATE book_sellers;');
		$this->Session->setFlash(__('成功賣家資料'), 'default', array(), 'good');
		$this->redirect("/admins/reset");
	}

	public function reset()
	{
		$this->set("title_for_layout","重設");
	}

	public function books()
	{
			$this->loadModel("Book");
			$this->loadModel("Place");

			if (isset($_GET["form"])) $form = $_GET["form"]; else $form="";
			if (isset($_GET["subject"])) $subject = $_GET["subject"]; else $subject="";
			if (isset($_GET["type"])) $type = $_GET["type"]; else $type="";



			$filter = array();
			$filter += array('Book.id=Place.book_id');
			if ($form!="") $filter += array('Place.form'=>intval($form));
			if ($type!="") $filter += array('Place.type'=>intval($type));
			if ($subject!="") $filter += array('Book.subject'=>$subject);

			$books = $this->Book->find("all",array(
				'order' => 'Place.code',
				'group' => 'Book.id',
				'joins' => array(
					        	array(
					        		'table' => 'places',
					        		'alias' => 'Place',
					        		'type' => 'inner',
					        		'foreignKey' => false,
					        		'conditions' => $filter
					        	)
					        )
				)
			);

			$data = array();
			foreach ($books as $book) {
				$data += array($book["Book"]["id"] => array("name"=>$book["Book"]["name"],"price"=>$book["Book"]["price"]));
			}

			   $this->set('data', $data);
			   $this->set('_serialize', 'data');
	
	}
}

