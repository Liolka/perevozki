<?php

/**
 * This is the model class for table "{{shop_products}}".
 *
 * The followings are the available columns in table '{{shop_products}}':
 * @property string $product_id
 * @property string $product_s_desc
 * @property string $product_desc
 * @property string $product_name
 * @property string $product_sku
 * @property integer $published
 * @property string $metadesc
 * @property string $metakey
 * @property string $customtitle
 * @property string $slug
 * @property string $product_video
 * @property string $product_charact
 * @property integer $firm_id
 * @property integer $type_id
 * @property integer $protect_copy
 * @property integer $product_ordered
 * @property string $product_availability
 * @property string $manuf
 * @property string $material
 * @property string $code
 * @property string $in_stock
 * @property string $delivery
 * @property string $prepayment
 *
 * The followings are the available model relations:
 * @property ShopProductPrices[] $shopProductPrices
 * @property ShopProductsCategories[] $shopProductsCategories
 * @property ShopProductsMedias[] $shopProductsMediases
 */
class ShopProducts extends CActiveRecord implements IECartPosition
{
    const SCENARIO_UPLOADING_FOTO = 'uploading_foto';
	
	public $file_url_thumb;
    public $product_price;
    public $product_override_price;
    public $product_currency;
    public $uploading_foto;
    
	public $operate_method;
	
    public $DropDownListCategories;
    public $SelectedCategories;
    public $category_ids;
	
    public $DropDownListModels;
    public $SelectedModels;
    public $model_ids;
	
    public $DropDownListBodies;
    public $SelectedBodies;
    public $body_ids;
	
	public $DropDownListManufacturers;
	public $SelectedManufacturerId;
	
	public $DropDownListFirms;
	public $SelectedFirmId;
	
	public $DropDownListTypes;
	public $SelectedTypeId;
	
	public $DropDownProductAvailability;
	public $SelectedProductAvailabilityId;
	public $ProductAvailabilityArray = array(
		array('id' => 1, 'name' => 'Под заказ'),
		array('id' => 2, 'name' => 'В наличии'),
	);
	
	
	/**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{shop_products}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('product_name, product_sku', 'required'),
            array('published, firm_id, type_id, protect_copy, product_availability, product_ordered, manufacturer_id, override', 'numerical', 'integerOnly'=>true),
            array('product_s_desc, metatitle, manuf, material, code, in_stock, delivery, prepayment', 'length', 'max'=>255),
            array('product_desc, metadesc', 'length', 'max'=>17000),
            array('product_name', 'length', 'max'=>180),
            array('product_sku', 'length', 'max'=>64),
            array('metakey, slug', 'length', 'max'=>192),
			array('product_price, product_override_price', 'length', 'max'=>15),
			array('uploading_foto', 'file', 'types'=>'JPG,JPEG,PNG', 'minSize' => 1024,'maxSize' => 1048576, 'wrongType'=>'Не формат. Только {extensions}', 'tooLarge' => 'Допустимый вес 1Мб', 'tooSmall' => 'Не формат', 'on'=>self::SCENARIO_UPLOADING_FOTO),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('product_id, product_s_desc, product_desc, product_name, product_sku, published, metadesc, metakey, metatitle, slug, firm_id, type_id, protect_copy, product_availability, manuf, material, code, in_stock, delivery, prepayment, category_ids, manufacturer_id, product_price, override, product_override_price', 'safe', 'on'=>'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'shopProductPrices' => array(self::HAS_MANY, 'ShopProductPrices', 'product_id'),
            'manufacturer' => array(self::BELONGS_TO, 'ShopManufacturers', 'manufacturer_id'),
            'firm' => array(self::BELONGS_TO, 'ShopFirms', 'firm_id'),
            'type' => array(self::BELONGS_TO, 'ShopProductTypes', 'type_id'),
            'ProductsBodies' => array(self::HAS_MANY, 'ShopProductsBodies', 'product_id'),
            'ProductsCategories' => array(self::HAS_MANY, 'ShopProductsCategories', 'product_id'),
            'Images' => array(self::HAS_MANY, 'ShopProductsImages', 'product_id'),
            'shopProductsMediases' => array(self::HAS_MANY, 'ShopProductsMedias', 'product_id', 'with'=>'media'),
			'ProductsModelsAutos' => array(self::HAS_MANY, 'ShopProductsModelsAuto', 'product_id'),
		);
		
		
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'product_id' => 'id',
            'product_s_desc' => 'Краткое описание',
            'product_desc' => 'Описание',
            'product_name' => 'Название',
            'product_sku' => 'Код',
            'published' => 'Публикация',
            'metadesc' => 'meta description',
            'metakey' => 'meta keywords',
            'metatitle' => 'meta title',
            'slug' => 'Псевдоним',
            'manufacturer_id' => 'Производитель',
            'firm_id' => 'Фирма',
            'type_id' => 'Группа товаров',
            'protect_copy' => 'Защита от копирования',
            'product_availability' => 'Доступность',
            'manuf' => 'Производитель',
            'material' => 'Материал',
            'code' => 'Код товара',
            'in_stock' => 'Наличие',
            'delivery' => 'Доставка',
            'prepayment' => 'Предоплата',
            'DropDownListCategories' => 'DropDownListCategories',
            'category_ids' => 'Категории',
            'model_ids' => 'Модельный ряд',
            'body_ids' => 'Кузов',
            'product_price' => 'Цена',
            'override' => 'Выводить акционную цену',
            'product_override_price' => 'Акционная цена',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria;
		
		$sort = new CSort();

        $criteria->compare('product_id',$this->product_id,true);
        $criteria->compare('product_s_desc',$this->product_s_desc,true);
        $criteria->compare('product_desc',$this->product_desc,true);
        $criteria->compare('product_name',$this->product_name,true);
        $criteria->compare('product_sku',$this->product_sku,true);
        $criteria->compare('published',$this->published);
        $criteria->compare('metadesc',$this->metadesc,true);
        $criteria->compare('metakey',$this->metakey,true);
        $criteria->compare('metatitle',$this->metatitle,true);
        $criteria->compare('firm_id',$this->firm_id);
        $criteria->compare('type_id',$this->type_id);
        $criteria->compare('protect_copy',$this->protect_copy);
        $criteria->compare('product_availability',$this->product_availability,true);
        $criteria->compare('manuf',$this->manuf,true);
        $criteria->compare('material',$this->material,true);
        $criteria->compare('code',$this->code,true);
        $criteria->compare('in_stock',$this->in_stock,true);
        $criteria->compare('delivery',$this->delivery,true);
        $criteria->compare('prepayment',$this->prepayment,true);
		
		$sort->defaultOrder = '`product_id` DESC'; // устанавливаем сортировку по умолчанию
		
		

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
			'sort'=>$sort,
			
			'pagination'=>array(
				'pageSize'=>Yii::app()->params->pagination['per_page'],
			),		
			
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ShopProducts the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
	
	protected function beforeSave()
	{
		if(parent::beforeSave())	{
			$app = Yii::app();
			$delete_foto = $app->request->getParam('delete_foto', array());
			if(!count($delete_foto))	{
				$main_foto = $app->request->getParam('main_foto', 0);

				//echo'<pre>';var_dump($main_foto);echo'</pre>';

				if($main_foto)	{
					//ShopProductsImages::model()->setMainFoto($connection, $main_foto, $this->product_id);
					$this->product_image = ShopProductsImages::model()->findByPk($main_foto)->image_file;
				}
			}
			//echo'<pre>';print_r($this->product_image);echo'</pre>';
			//die;

			return true;			
		}
	}
	
	public function afterSave()
	{
		$app = Yii::app();
		$connection = $app->db;
		
		switch($this->operate_method)	{
			case 'insert':
				ShopProductsCategories::model()->insertItemCategories($this->SelectedCategories, $this->product_id, $connection);
				ShopProductsModelsAuto::model()->insertItemModels($this->SelectedModels, $this->product_id, $connection);
				ShopProductsBodies::model()->insertItemBodies($this->SelectedBodies, $this->product_id, $connection);
				break;
			
			case 'update':
				$this->checkProductCategories($connection);
				$this->checkProductsModels($connection);
				$this->checkProductsBodies($connection);
				$this->checkMainFoto($app, $connection);
				break;
		}
		
		//если нужно - загружаем и обрабатываем фото
		$this->uploadFoto();
		
	}
	
	//проверяем, не изменились ли категории...
	function checkProductCategories(&$connection)
	{
		$ProductsCategories = $this->ProductsCategories;
		if(count($ProductsCategories))	{
			$arrays_of_identical = true;
		}	else	{
			$arrays_of_identical = false;
		}

		//проверяем, не изменились ли категории...
		if(count($ProductsCategories) != count($this->SelectedCategories))	{
			$arrays_of_identical = false;
		}	else	{
			foreach($ProductsCategories as $cat_item)	{
				$cat_is_present = false;
				foreach($this->SelectedCategories as $key=>$val)	{
					if($cat_item['category']['id'] == $key)	{
						$cat_is_present = true;
					}
				}
				if($cat_is_present == false)	{
					$arrays_of_identical = false;
				}
			}
		}



		//echo'<pre>';var_dump($arrays_of_identical);echo'</pre>';
		//echo'<pre>';print_r($this->SelectedCategories);echo'</pre>';
		//die;



		if($arrays_of_identical == false)	{
			ShopProductsCategories::model()->clearItemCategories($this->product_id, $connection);
			ShopProductsCategories::model()->insertItemCategories($this->SelectedCategories, $this->product_id, $connection);
		}
	}
	
	//проверяем, не изменились ли модели авто...
	function checkProductsModels(&$connection)
	{
		$ProductsModels = $this->ProductsModelsAutos;

		if(count($ProductsModels))	{
			$arrays_of_identical = true;
		}	else	{
			$arrays_of_identical = false;
		}

		if(count($ProductsModels) != count($this->SelectedModels))	{
			$arrays_of_identical = false;
		}	else	{
			foreach($ProductsModels as $cat_item)	{
				$cat_is_present = false;

				foreach($this->SelectedModels as $key=>$val)	{
					if($cat_item['model']['id'] == $key)	{
						$cat_is_present = true;
					}
				}

				if($cat_is_present == false)	{
					$arrays_of_identical = false;
				}
			}
		}

		if($arrays_of_identical == false)	{
			ShopProductsModelsAuto::model()->clearItemModels($this->product_id, $connection);
			ShopProductsModelsAuto::model()->insertItemModels($this->SelectedModels, $this->product_id, $connection);
		}
		
	}
	
	//проверяем, не изменились ли кузова...
	function checkProductsBodies(&$connection)
	{
		$ProductsBodies = $this->ProductsBodies;

		if(count($ProductsBodies))	{
			$arrays_of_identical = true;
		}	else	{
			$arrays_of_identical = false;
		}

		if(count($ProductsBodies) != count($this->SelectedBodies))	{
			$arrays_of_identical = false;
		}	else	{
			foreach($ProductsBodies as $cat_item)	{
				$cat_is_present = false;

				foreach($this->SelectedBodies as $key=>$val)	{
					if($cat_item['body']['body_id'] == $key)	{
						$cat_is_present = true;
					}
				}

				if($cat_is_present == false)	{
					$arrays_of_identical = false;
				}
			}
		}
		//echo'<pre>';var_dump($arrays_of_identical);echo'</pre>';die;
		if($arrays_of_identical == false)	{
			ShopProductsBodies::model()->clearItemBodies($this->product_id, $connection);
			ShopProductsBodies::model()->insertItemBodies($this->SelectedBodies, $this->product_id, $connection);
		}
		
	}

	function checkMainFoto(&$app, &$connection)
	{
		$main_foto = $app->request->getParam('main_foto', 0);
		if($main_foto)	{
			ShopProductsImages::model()->setMainFoto($connection, $main_foto, $this->product_id);
			//$this->product_image = ShopProductsImages::model()->findByPk($main_foto)->image_file;
		}
	}
			
    function getId(){
        return 'ShopProducts'.$this->product_id;
    }

    function getPrice()	{
		$product_price = $this->shopProductPrices->product_price;
		
		if($this->shopProductPrices->product_override_price != 0)
        	$product_price = $this->shopProductPrices->product_override_price;
		
		return $product_price;
    }	
	
	public function findProductsInCat($category_id = 0)
	{		
		$criteria = new CDbCriteria();
		$criteria->select = "t.*, m.`file_url_thumb`, pp.`product_price`, pp.`product_override_price`, pp.`product_currency`";
		$criteria->join = 'inner join {{shop_products_categories}} AS pc USING (`product_id`) INNER JOIN {{shop_products_medias}} AS pm USING (`product_id`) INNER JOIN {{shop_medias}} AS m USING (`media_id`) INNER JOIN {{shop_product_prices}} AS pp USING (`product_id`)';
		
		
		$criteria->condition = "pc.`category_id` = $category_id AND t.`published` = 1";
		$criteria->order = "pc.`ordering`, t.`product_id`";
		//echo'<pre>';print_r($criteria,0);echo'</pre>';
		if ($ids !='') {
			$ids = explode(',',$ids);
			$criteria->addInCondition('u_id', $ids) ;
		}
		//$count = User::model()->count($criteria);
		$count = $this->count($criteria);
		$pages = new CPagination($count);
		$pages->pageSize = Yii::app()->params->pagination['products_per_page']; // элементов на страницу
		$pages->applyLimit($criteria);
		$rows = $this->findAll($criteria);
		//echo'<pre>';print_r($criteria,0);echo'</pre>';
		return array('rows' => $rows, 'pages' => $pages);
	}

	public function findBySlug($slug)
	{
		$criteria = new CDbCriteria;
		$criteria->with = array('shopProductPrices', 'shopProductsMediases');
		$criteria->condition = "`slug` = '$slug'";
		$row = $this->find($criteria);
		return $row;
	}
	
	// получает последние добавленные товары
	public function getLastAddedProducts()
	{		
		$criteria = new CDbCriteria();
		$criteria->select = "t.*, (SELECT m.`file_url_thumb` FROM `3hnspc_shop_medias` AS m INNER JOIN `3hnspc_shop_products_medias` AS pm USING (`media_id`) WHERE pm.`product_id` = t.`product_id` LIMIT 1) AS `file_url_thumb`, pp.`product_price`, pp.`product_override_price`, pp.`product_currency`";
		$criteria->join = 'INNER JOIN {{shop_product_prices}} AS pp USING (`product_id`)';

		
		
		$criteria->condition = "t.`published` = 1 AND (t.`product_id` IN (117,112,158,288,2026,7292,1102))";
		$criteria->order = "t.`product_id` DESC";
		$criteria->limit = 7;
		//echo'<pre>';print_r($criteria, 0);echo'</pre>';

		$rows = $this->findAll($criteria);
		//echo'<pre>';print_r($criteria,0);echo'</pre>';
		return $rows;
	}
	
	
	// получает последние просмотренные товары
	public function getLastViewedProducts()
	{		
		$criteria = new CDbCriteria();
		$criteria->select = "t.*, (SELECT m.`file_url_thumb` FROM `3hnspc_shop_medias` AS m INNER JOIN `3hnspc_shop_products_medias` AS pm USING (`media_id`) WHERE pm.`product_id` = t.`product_id` LIMIT 1) AS `file_url_thumb`, pp.`product_price`, pp.`product_override_price`, pp.`product_currency`";
		$criteria->join = 'INNER JOIN {{shop_product_prices}} AS pp USING (`product_id`)';
		
		
		//$criteria->condition = "t.`published` = 1";
		$criteria->condition = "t.`published` = 1 AND (t.`product_id` IN (117,112,158,288,2026,1102))";
		$criteria->order = "t.`product_id` DESC";
		$criteria->limit = 3;
		//echo'<pre>';print_r($criteria, 0);echo'</pre>';

		$rows = $this->findAll($criteria);
		//echo'<pre>';print_r($criteria,0);echo'</pre>';
		return $rows;
	}
	
	//загрузка фото
	public function uploadFoto()
	{
		$app = Yii::app();
		if($this->uploading_foto != null)	{
			$product_imagePath = Yii::getPathOfAlias($app->params->product_imagePath);

			$file_extention = $this->getExtentionFromFileName($this->uploading_foto->name);
			
			$filename = md5(strtotime('now')).$file_extention;
			
			$this->uploading_foto->saveAs($product_imagePath . DIRECTORY_SEPARATOR . 'full_'.$filename);

			
			$img_width_config = $app->params->product_tmb_params['width'];
			$img_height_config = $app->params->product_tmb_params['height'];
			
			$Image = $app->image->load($product_imagePath . DIRECTORY_SEPARATOR . 'full_'.$filename);
			
			if(($Image->width/$Image->height) >= ($img_width_config/$img_height_config)){
				$Image -> resize($img_width_config, $img_height_config, Image::HEIGHT);
			}	else	{
				$Image -> resize($img_width_config, $img_height_config, Image::WIDTH);
			}
			$Image->crop($img_width_config, $img_height_config, 'top', 'center')->quality(75);
			//echo'<pre>';print_r($app->params->product_tmb_params,0);echo'</pre>';die;
			$Image->save($product_imagePath . DIRECTORY_SEPARATOR . 'thumb_'.$filename);
			
			$foto = new ShopProductsImages;
			$foto->product_id = $this->product_id;
			$foto->image_file = $filename;
			$foto->save();
		}
	}
	
	//получение расширения имени файла
	public function getExtentionFromFileName($filename)
	{
		//разбиваем имя загружаемого файла на части чтобы получить его расширение
		$file_name_arr = explode('.',$filename);
		return '.'.$file_name_arr[(count($file_name_arr)-1)];
	}
	
	//получает выбранные категории для товара
	function getSelectedCategories()
	{
		$selectedValues = array();
		//echo'<pre>';print_r($this->ProductsCategories,0);echo'</pre>';die;
		
		foreach($this->ProductsCategories as $cat) {
			//echo'<pre>';print_r($cat,0);echo'</pre>';
			//echo'<pre>';print_r($cat['category']['id'],0);echo'</pre>';die;
			$selectedValues[$cat['category']['id']] = Array ( 'selected' => 'selected' );
		}
		$this->SelectedCategories = $selectedValues;		
	}
	
	//получает выбранные модели для товара
	function getSelectedModels()
	{
		$selectedValues = array();
		//echo'<pre>';print_r($this->ProductsModelsAutos,0);echo'</pre>';die;
		
		foreach($this->ProductsModelsAutos as $row) {
			//echo'<pre>';print_r($cat['category']['id'],0);echo'</pre>';
			$selectedValues[$row['model']['id']] = Array ( 'selected' => 'selected' );
		}
		$this->SelectedModels = $selectedValues;
	}
	
	//получает выбранные модели для товара
	function getSelectedBodies()
	{
		$selectedValues = array();
		//echo'<pre>';print_r($this->ProductsModelsAutos,0);echo'</pre>';die;
		
		foreach($this->ProductsBodies as $row) {
			//echo'<pre>';print_r($cat['category']['id'],0);echo'</pre>';
			$selectedValues[$row['body']['body_id']] = Array ( 'selected' => 'selected' );
		}
		$this->SelectedBodies = $selectedValues;
	}
	
	function getDropDownProductAvailability()
	{
		$result = CHtml::listData($this->ProductAvailabilityArray, 'id', 'name');
		return $result;
	}
	
	//копирование товара
	function copyProduct()
	{
		$app = Yii::app();
		$command = $app->db->createCommand();
		
		$command->insert('{{shop_products}}', array(
			'product_s_desc' => $this->product_s_desc,
			'product_desc' => $this->product_desc,
			'product_name' => 'Copy '.$this->product_name,
			'product_sku' => $this->product_sku,
			'manufacturer_id' => $this->manufacturer_id,
			'firm_id' => $this->firm_id,
			'type_id' => $this->type_id,
			'product_image' => $this->product_image,
			'metadesc' => $this->metadesc,
			'metakey' => $this->metakey,
			'metatitle' => $this->metatitle,
			'slug' => $this->slug,
			'product_type_id' => $this->product_type_id,
			'protect_copy' => $this->protect_copy,
			'product_ordered' => $this->product_ordered,
			'product_availability' => $this->product_availability,
			'manuf' => $this->manuf,
			'material' => $this->material,
			'code' => $this->code,
			'in_stock' => $this->in_stock,
			'delivery' => $this->delivery,
			'prepayment' => $this->prepayment,
			'product_price' => $this->product_price,
			'override' => $this->override,
			'product_override_price' => $this->product_override_price,
		));
		$new_product_id = $app->db->getLastInsertId();
		
		$command->reset();
		
		// дублируем изображения товара
		$Images = $this->Images;
		if(count($Images))	{
			foreach($Images as $row)	{
				$command->insert('{{shop_products_images}}', array(
					'product_id' => $new_product_id,
					'image_file' => $row['image_file'],
					'ordering' => $row['ordering'],
					'main_foto' => $row['main_foto'],
				));
				$command->reset();
			}
		}
		
		// дублируем категории товара
		$ProductsCategories = $this->ProductsCategories;
		if(count($ProductsCategories))	{
			foreach($ProductsCategories as $row)	{
				$command->insert('{{shop_products_categories}}', array(
					'product_id' => $new_product_id,
					'category_id' => $row['category_id'],
					'ordering' => $row['ordering'],
				));
				$command->reset();
			}
		}
		
		// дублируем модельный ряд товара
		$ProductsModelsAutos = $this->ProductsModelsAutos;
		if(count($ProductsModelsAutos))	{
			foreach($ProductsModelsAutos as $row)	{
				$command->insert('{{shop_products_models_auto}}', array(
					'product_id' => $new_product_id,
					'model_id' => $row['model_id'],
					'ordering' => $row['ordering'],
				));
				$command->reset();
			}
		}
		
		// дублируем кузова товара
		$ProductsBodies = $this->ProductsBodies;
		if(count($ProductsBodies))	{
			foreach($ProductsBodies as $row)	{
				$command->insert('{{shop_products_bodies}}', array(
					'product_id' => $new_product_id,
					'body_id' => $row['body_id'],
				));
				$command->reset();
			}
		}
		
		
		
		//echo'<pre>';print_r($Images[0]['image_file'],0);echo'</pre>';die;
	}
	
}