<?php

namespace App\Controllers;

require_once APPPATH.'ThirdParty/vendor/autoload.php';
require_once APPPATH.'ThirdParty/vendor/jeroendesloovere/vcard/src/VCard.php';

use App\Models\UsersModel;
use App\Libraries\Hash;
use CodeIgniter\Controller;
use JeroenDesloovere\VCard\VCard;

class Users extends Controller
{
	public function __construct(){
		
		helper(['url', 'form']);

		
	}
	
	public function profile(){
		
		$loggeduser = session()->get('users_id');
		if(empty($loggeduser)) return redirect()->to('users/login');
			
		$model = new UsersModel();
		$users_info = $model->find($loggeduser);
		
		$data = [
			'first_name' => $users_info['users_first_name'],
			'last_name' => $users_info['users_last_name'],
			'email' => $users_info['users_email'],
			'contact_number' => $users_info['users_phone_number'],
			'business_name' => $users_info['users_business_name'],
			'business_address' => $users_info['users_business_address'],
			'website_url' => $users_info['users_website_url'],
			'logo' => $users_info['users_logo']
		];
		
		echo view('templates/header', $data);
        echo view('users/profile', $data);
		echo view('templates/footer', $data);
	}
	
	public function register()
    {
		if(session()->has('users_id')){
			return redirect()->to('users/profile');
		}
		
		$model = new UsersModel();
		
		if($this->request->getMethod() === 'post'){
			
			$validation = $this->validate([
		 'users_first_name' => [
			'rules' => 'required',
			'errors' => [
				'required' => 'Please enter your first name'
			]
		 ],
		 'users_last_name' => [
			'rules' => 'required',
			'errors' => [
				'required' => 'Please enter your last name'
			]
		 ],
		 'users_email' => [
			'rules' => 'required|valid_email|is_unique[users.users_email]',
			'errors' => [
				'required' => 'Please enter your Email Address',
				'valid_email' => 'Please provide a valid Email Address',
				'is_unique' => 'This Email Address already exists'
			]
		 ],
		 'users_country_code' => [
			'rules' => 'required|max_length[3]|is_natural',
			'errors' => [
				'required' => 'Please enter your country code',
				'max_length' => 'Your country code should not be greater than 3 digits',
				'is_natural' => 'Country Code should only contain numbers'
			],
		 ],
		 'users_phone_number' => [
			'rules' => 'required|min_length[10]|is_natural',
			'errors' => [
				'required' => 'Please enter your contact number',
				'min_length' => 'Your contact number must contain atleast 10 digits',
				'is_natural' => 'Phone Number should only contain numbers'
			],
		 ],
		 'users_business_name' => [
			'rules' => 'required',
			'errors' => [
				'required' => 'Please enter your business\'s name'
			]
		 ],
		 'users_business_address' => [
			'rules' => 'required|min_length[10]',
			'errors' => [
				'required' => 'Please enter your business\'s name',
				'min_length' => 'Your business address must atleast be 10 characters long'
			]
		 ],
		 'users_website_url' => [
			'rules' => 'required|valid_url',
			'errors' => [
				'required' => 'Please enter your website url',
				'valid_url' => 'Please enter a valid url'
			]
		 ],
		 'users_logo' => [
			'rules' => 'is_image[users_logo]',
			'errors' => [
				'is_image' => 'Please enter a valid image file'
			]
		 ],
		 'users_password' => [
			'rules' => 'required|min_length[5]',
			'errors' => [
				'required' => 'Please enter your password',
				'min_length' => 'Your password should atleast be 5 characters long'
			]
		 ],
		 'users_re_password' => [
			'rules' => 'required|min_length[5]|matches[users_password]',
			'errors' => [
				'required' => 'Please re-enter your password',
				'min_length' => 'The re-entered password should atleast be 5 characters long',
				'matches' => 'The re-entered password does not match the entered password'
			],
		 ]
		]);
		
		
		
			if($validation){
				
				$file = $this->request->getFile('users_logo');
				if($file->isValid() && !$file->hasMoved()){
					$newName = $file->getRandomName();
					$file->move('uploads/', $newName);
					
					$model->save([
					'users_first_name' => $this->request->getPost('users_first_name'),
					'users_last_name' => $this->request->getPost('users_last_name'),
					'users_email' => $this->request->getPost('users_email'),
					'users_phone_number' => "+".$this->request->getPost('users_country_code').$this->request->getPost('users_phone_number'),
					'users_business_name' => $this->request->getPost('users_business_name'),
					'users_business_address' => $this->request->getPost('users_business_address'),
					'users_website_url' => $this->request->getPost('users_website_url'),
					'users_logo' => $newName,
					'users_password' => Hash::create($this->request->getPost('users_password'))
				]);
					session()->set('users_id', $model->insertID);
					return redirect()->to('users/profile');
				}else{
					$added_img_err = $file->getErrorString();
					return redirect()->back()->with('fail', $added_img_err);
				}
				
				
			
			}
		}
		
		echo view('templates/header');
        echo view('users/register');
		echo view('templates/footer');
    }
	
	public function map()
    {
		if($this->request->getMethod() === 'post'){
			$address = $this->request->getPost('address');
			echo '<iframe width="100%" height="400" src="https://maps.google.com/maps?output=embed&q='.$address.'" id="bus_map"></iframe>';
		}
		
	}
	
	public function login()
    {
		if(session()->has('users_id')){
			return redirect()->to('users/profile');
		}
		
		$model = new UsersModel();
		
		if($this->request->getMethod() === 'post'){
			
			$validation = $this->validate([
		 'users_email' => [ 
		 
			'rules' => 'required|valid_email',
			'errors' => [
					'required' => 'Please enter your Email Address',
					'valid_email' => 'Please provide a valid Email Address'
			],
		 ],
		 'users_password' => [ 
			'rules' => 'required|min_length[5]',
			'errors' => [
				'required' => 'Please enter your password',
				'min_length' => 'Minimum password length must be 5'
			]
		 ]
		]);
		
		
		
			if($validation){
				$email = $this->request->getPost('users_email');
				$password = $this->request->getPost('users_password');
				$users_info = $model->where('users_email', $email)->first();
				$check_password = Hash::check($password, $users_info['users_password']);
				
				if(!$check_password){
					session()->setFlashdata('fail', 'Incorrect Email Address or Password');
					return redirect()->to('users/login')->withInput();
				}else{
					session()->set('users_id', $users_info['users_id']);
					return redirect()->to('users/profile');
				}
			}
		}
        echo view('templates/header');
        echo view('users/login');
		echo view('templates/footer');
    
		
	}
	
	public function logout(){
		if(session()->has('users_id')){
			session()->remove('users_id');
			return redirect()->to('users/login');
		}else{
			return redirect()->back();
		}
		
	}
	
	public function visiting_card(){
		
		if(!session()->has('users_id')){
			return redirect()->back();	
		}
		
		if($this->request->getMethod() === 'post'){
			

			$loggeduser = session()->get('users_id');
			
			
			$image = $this->request->getPost('image');
			$image = explode(";", $image)[1];
			$image = explode(",", $image)[1];
			$image = str_replace(" ",  "+", $image);
			
			$image = base64_decode($image);
			file_put_contents("uploads/".$loggeduser."_visitingcard.jpeg", $image);

		}
	}
	
	public function vcard(){
		
		if(!session()->has('users_id')){
			return redirect()->back();	
		}
			
		$loggeduser = session()->get('users_id');
		
		$model = new UsersModel();
		$users_info = $model->find($loggeduser);
		
		$data = [
			'first_name' => $users_info['users_first_name'],
			'last_name' => $users_info['users_last_name'],
			'email' => $users_info['users_email'],
			'contact_number' => $users_info['users_phone_number'],
			'business_name' => $users_info['users_business_name'],
			'business_address' => $users_info['users_business_address'],
			'website_url' => $users_info['users_website_url'],
			'logo' => $users_info['users_logo']
		];
		
		// define vcard
		$vcard = new VCard();

		// define variables
		$firstname = $users_info['users_first_name'];
		$lastname = $users_info['users_last_name'];
		$additional = '';
		$prefix = '';
		$suffix = '';

		// add personal data
		$vcard->addName($lastname, $firstname, $additional, $prefix, $suffix);

		// add work data
		$vcard->addCompany($users_info['users_business_name']);
		$vcard->addEmail($users_info['users_email']);
		$vcard->addPhoneNumber($users_info['users_phone_number'], 'WORK');
		$vcard->addAddress($users_info['users_business_address']);
		$vcard->addURL($users_info['users_website_url']);

		$vcard->addPhoto(ROOTPATH.'public/uploads/'.$users_info['users_logo']);
		return $vcard->download();
	}
	

}