<?php

require_once("database.php");

class Photograph extends DatabaseObject {
	
	protected static $table_name = "photographs";
	protected static $db_fields = array('id', 'stop_id', 'bus_id', 'bus_personnel_id', 'commuter_id', 'admin_id', 'photo_type', 'filename', 'file_type', 'size');
	
	public $id;
	
	public $stop_id;
	public $bus_id;
	public $bus_personnel_id;
	public $commuter_id;
	public $admin_id;
	
	public $photo_type;
	public $filename;
	public $file_type;
	public $size;
	
	private $temp_path;
	protected $upload_dir="img/uploads";
	public $errors = array();
	
	protected $upload_errors = array(
			UPLOAD_ERR_OK 				=> "No errors.",
			UPLOAD_ERR_INI_SIZE  		=> "Larger than upload_max_filesize.",
		  	UPLOAD_ERR_FORM_SIZE 		=> "Larger than form MAX_FILE_SIZE.",
		  	UPLOAD_ERR_PARTIAL 			=> "Partial upload.",
		  	UPLOAD_ERR_NO_FILE 			=> "No file.",
		  	UPLOAD_ERR_NO_TMP_DIR 		=> "No temporary directory.",
		  	UPLOAD_ERR_CANT_WRITE 		=> "Can't write to disk.",
		  	UPLOAD_ERR_EXTENSION 		=> "File upload stopped by extension."
			);
	
	public function attach_file($file){
		if (!$file || empty($file) || !is_array($file)){
			$this->errors[] = "No file was uploaded";
			return false;
		} else if ($file['error'] != 0) {
			$this->errors[] = $this->upload_errors[$file['error']];
			return false;
		} else {
			$this->temp_path = $file['tmp_name'];
			$this->filename = basename($file['name']);
			$this->file_type = $file['type'];
			$this->size = $file['size'];
			
			return true;
		}
	}
	
	public function comment_count(){
		global $database;
		
		$sql = "SELECT COUNT(*) from comments WHERE photograph_id=". $database->escape_value($this->id);
		
		$result_set = $database->query($sql);
		$row = $database->fetch_array($result_set);
		
		return array_shift($row);
	}
	
	public function save(){
		if ($this->id){
			$this->update();
		} else {
			
			if ( !empty($this->errors) ){
				return false;
			}
			
			if (empty($this->filename) || empty($this->temp_path)){
				
				$this->errors[] = $this->filename;
				$this->errors[] = $this->temp_path;
				$this->errors[] = $file['tmp_name'];
				
				$this->errors[] = "The file location was not avaliable.";
				
				return false;
			}
			
			$target_path = SITE_ROOT.DS.$this->upload_dir.DS.$this->filename;
			
			if (file_exists($target_path)){
				$this->errors[] = "The file {$this->filename} already exists. ";
				return false;
			}
			
			if (move_uploaded_file($this->temp_path, $target_path)){
				
				if ($this->create()){
					unset($this->temp_path);
					return true;
				}
				
			} else {
				$this->errors[] = "The file upload failed. Possibly due to incorrect permissions on the upload folder. ";
				return false;
			}
		}
	}
	
	public function destroy(){
		if ($this->delete()){
			$target_path = SITE_ROOT.DS.$this->image_path();
			return unlink($target_path) ? true : false;
		} else {
			return false;
		} 
	}
	
	public function image_path(){
		return $this->upload_dir.DS.$this->filename;
	} 
	
	public function size_as_text(){
		if ($this->size < 1024) {
			return "{$this->size} bytes";
		} else if ($this->size < 1048576) {
			$size_kb = round($this->size/1024);
			return "{$size_kb} KB";
		} else {
			$size_mb = round($this->size/1048576, 1);
			return "{$size_mb} MB";
		}
	}
	
	public function get_profile_picture_of_admin_user($id=0) {
		global $database;
	
		$result_array = static::find_by_sql("SELECT * FROM " . static::$table_name . " WHERE admin_id = {$id} LIMIT 1");
		
		return !empty($result_array) ? array_shift($result_array) : false;
	
	}

	
}


?>