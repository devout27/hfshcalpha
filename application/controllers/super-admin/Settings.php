<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends Admin_Controller
{
	public $class_name='';
	function __construct()
	{
		parent::__construct();
		$this->class_name='super-admin/'.ucfirst(strtolower($this->router->fetch_class())).'/';
		$this->data['class_name']= $this->class_name;
		$this->load->model('Setting_Model');
	}
	function clearCard($cardType)
	{		
		if($cardType==1)
		{					
			$dir = dirname(__FILE__, 4);
			$dir = $dir.'/uploads/card_rotations/first/';
			deleteAll($dir);
			$this->session->set_flashdata('success_msg','All Images Removed Successfully.');
		}elseif($cardType==2)
		{					
			$dir = dirname(__FILE__, 4);
			$dir = $dir.'/uploads/card_rotations/second/';
			deleteAll($dir);
			$this->session->set_flashdata('success_msg','All Images Removed Successfully.');
		}else
		{
			$this->load->library('user_agent');			
			$this->session->set_flashdata('error_msg','Missing Informations.');
		}		
		return redirect('admin/Settings/cards');		
	}
	function storeCard($cardNum)
	{		
		if ( !empty($_FILES['file']['name']) ) {		
			$config['upload_path'] = FILE_UPLOAD_BASE_PATH.'card_rotations'; 
			$config['allowed_types'] = 'zip';
			$config['file_name'] = time().rand().time().rand().'.zip';
			$config['max_size'] = CARD_ZIP_FILE_MAX_SIZE;
			$this->load->library('upload', $config);
			$this->upload->initialize($config);
			if ($this->upload->do_upload('file')) {								
				$uploadData = $this->upload->data();				 
				$filePath=$cardNum == 1 ? $uploadData['file_path'].'first/' : $uploadData['file_path'].'second/';
				array_map('unlink', glob($filePath."*"));
				$zip = new ZipArchive;
				if ($zip->open($uploadData['full_path'],ZipArchive::CHECKCONS) === TRUE) {
					for ($i = 0; $i < $zip->numFiles; $i++) {
						$onlyFileName = $zip->getNameIndex($i);						
						$temp = explode('.',$onlyFileName);
						$extension = end($temp);
						$folder = explode('/',$onlyFileName);						
						$filename = $folder[1];
						$folder = $folder[0];
						$zip->extractTo($filePath,array($zip->getNameIndex($i)));
					}					
					$zip->close();					
					unlink($uploadData['full_path']);					
					movefiles($filePath.$folder.'/',$filePath);
					rmdir($filePath.$folder);					
					rename($filePath.$folder.".xml",$filePath.'config.xml');
					rename($filePath.$folder.".pxrtcont",$filePath.'config.pxrtcont');
					echo 1;exit;
				} else {					
					echo 'Unzipped Process failed';exit;
				}						
			} else {												
				echo strip_tags($this->upload->display_errors());exit;
			}
		}
		echo "Please Upload a Zip File";exit;
	}
	public function cards()
	{		
		$this->data['page_title']='Card Rotations';
		$this->render($this->class_name.'cards');
	}
    public function index( $type ){       
		if($type=="cards")
		{
			return $this->cards();
		} 
		$this->load->helper('new_helper');
		$this->data['type'] = $type;
        $this->data['page_title'] = ucFirst(str_replace('_',' ',$type))." Settings";
		//get menu
		$this->load->model('Menu_Model');
        $this->data['menus'] = $this->Menu_Model->getActiveMenuList();
		//Currency
		$this->load->model('Currency_Model');
		$this->data['currency'] = $this->Currency_Model->getCurrencyList();
        //get pages
		$this->load->model('Page_Model');
		$this->data['pages'] = $this->Page_Model->getActivePages();		
		$c = $this->input->post('currentTab');
		if(!isset($c) || empty($c))
		{
			$this->data['currentTab'] = 's1-justify';
		}else {
			$this->data['currentTab'] = $c;
		}				
		$this->load->model('Card_Model');
		$this->data['cards']=$this->Card_Model->getCardList("active");		
		$this->data['faqs'] = setting('home_page_faq_ids') != null ? json_decode(setting('home_page_faq_ids')) : [];        
		$this->load->model('Faq_Model');
		$this->data['faqsList']=$this->Faq_Model->getFaqs();
		$this->render($this->class_name.'index');
    }

	public function store()
	{	
		//pr($_POST); pr($_FILES,1);			
		$type = $this->input->post('type');
		$result = $this->input->post();		

		$validation_errors = [];
		
		foreach($_FILES as $k=>$v){ 
			 
			if ( !empty($_FILES[$k]['name']) ) {
				$Filename = $_FILES[$k]['name'];
				if (!empty($Filename)) {
				    $config['upload_path'] = FILE_UPLOAD_BASE_PATH; 
					$config['allowed_types'] = FILE_ALLOWED_TYPES;
					$config['max_size'] = FILE_MAX_SIZE;

					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					if ($this->upload->do_upload($k)) {
						
						 $uploadData = $this->upload->data();
						 $result[$k] = $uploadData['file_name'];

					} else {
						
						 $error = array('error' => $this->upload->display_errors()); 
						
					     $validation_errors[$k] = strip_tags($error['error']);
					}
				}
		    }else{
				//  echo "ad"; die;
			}
			
		}		
		
		  if( empty($validation_errors) ){
                   
			 foreach( $result as $key=>$value ){
              
				if( $key!= 'type' && !empty($key)  ){ 
                  $saveData['plain_key'] = $key;
				  $saveData['plain_value'] = $value;
				  if($key=="home_page_faq_ids")
				  {
					$saveData['plain_value'] = json_encode($value);	  
				  }
				  
				  $res = $this->Setting_Model->save($saveData);	 
                 
				  if( $res ){
				  
					$this->session->set_flashdata("success_msg", "Settings saved successfully.");	
				 
				  }  
				
				}

			 }

		  }else{

              $this->session->set_flashdata('error_msg', $validation_errors);

		  }		  
		  return $this->index($type);
		  /* redirect(BASE_URL_ADMIN.'settings/'.$type); */
	}

	



}
