<?php
class image
{
    public $upload_dir = '';

    private $ext_type = array('gif', 'jpg', 'jpeg', 'png', 'bmp');

    public function __construct()
    {
        $this->upload_dir = ROOT_PATH . 'uploads/'.date('Ym').'/';
    }

    public function upload($file)
    {
        if(empty($file)) return false;

        if(!is_dir($this->upload_dir) && !makeDir($this->upload_dir)) return false;

        $org_name = $file['name'];
        $ext_name = substr($org_name, strrpos($org_name, '.')+1);

        $tag_file = $this->upload_dir . $this->getFileName($ext_name);

        if(moveUploadFile($file['tmp_name'], $tag_file))
        {
            return str_replace(ROOT_PATH, '', $tag_file);
        }

        return false;
    }
	
	
		//自己改造的
	
	    public function myupload($file)
    {
        if(empty($file)) return false;

        if(!is_dir($this->upload_dir) && !mkdir($this->upload_dir)) return false;

        $org_name = $file['name'];
        $ext_name = substr($org_name, strrpos($org_name, '.')+1);

        $tag_file = $this->upload_dir . $this->getFileName($ext_name);

        if(move_uploaded_file($file['tmp_name'], $tag_file))
        {
            return str_replace(ROOT_PATH, '', $tag_file);
        }

        return false;
    }

    public function getFileName($ext)
    {
        $filename = time().mt_rand(100, 999) . '.' . $ext;

        while(is_file($this->upload_dir . $file_name))
        {
            $filename = time().mt_rand(100, 999) . '.' . $ext;
        }

        return $filename;
    }
}
?>