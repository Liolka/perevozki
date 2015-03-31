<?php

class MyDocuments extends CFormModel
{
	public $file;
	public $file1;
	public $file2;
//	public $file3;
//	public $file4;

	public function rules()
	{
		return array(
			array('file', 'file', 'types'=>'ZIP,RAR,DOC,DOCX', 'minSize' => 1024,'maxSize' => 1048576, 'wrongType'=>'Не формат. Только {extensions}', 'tooLarge' => 'Допустимый вес 1Мб'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'file1'=>'Пример договора',
			'file2'=>'Свидетельство о постановке на налоговый учет (ИНН)',
		);
	}

	//загрузка фото
	public function uploadFile()
	{
		$app = Yii::app();
		if($this->userfile != null)	{
			$product_imagePath = Yii::getPathOfAlias($app->params->transport_imagePath);

			$file_extention = $this->getExtentionFromFileName($this->userfile->name);
			
			$filename = md5(strtotime('now')).$file_extention;
			
			$file_path = $product_imagePath . DIRECTORY_SEPARATOR . 'full_'.$filename;
			
			$this->userfile->saveAs($file_path);

			
			$img_width_config = $app->params->product_tmb_params['width'];
			$img_height_config = $app->params->product_tmb_params['height'];
			
			if($no_watermark == 0)	{
				if($file_extention == '.jpg' || $file_extention == '.jpeg'){
					$img = imagecreatefromjpeg($file_path);
				} elseif($file_extention == '.png'){
					$img = imagecreatefrompng($file_path);
				}

				$water = imagecreatefrompng(Yii::getPathOfAlias('webroot.img'). DIRECTORY_SEPARATOR ."watermark.png");
				$im = $this->create_watermark($img, $water);
				imagejpeg($im, $file_path);
			}
			
			$Image = $app->image->load($file_path);
			
			if(($Image->width/$Image->height) >= ($img_width_config/$img_height_config)){
				$Image -> resize($img_width_config, $img_height_config, Image::HEIGHT);
			}	else	{
				$Image -> resize($img_width_config, $img_height_config, Image::WIDTH);
			}
			//$Image->crop($img_width_config, $img_height_config, 'top', 'center')->quality(75);
			$Image->resize($img_width_config, $img_height_config)->quality(75);
			//echo'<pre>';print_r($app->params->product_tmb_params,0);echo'</pre>';die;
			$Image->save($product_imagePath . DIRECTORY_SEPARATOR . 'thumb_'.$filename);
			
			$this->filename = $filename;
		}
	}
	
	//получение расширения имени файла
	public function getExtentionFromFileName($filename)
	{
		//разбиваем имя загружаемого файла на части чтобы получить его расширение
		$file_name_arr = explode('.', strtolower($filename));
		return '.'.$file_name_arr[(count($file_name_arr)-1)];
	}
}
