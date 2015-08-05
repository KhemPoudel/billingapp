<?php

/**
 * This is the model class for table "tbl_suppliers_contact".
 *
 * The followings are the available columns in table 'tbl_suppliers_contact':
 * @property integer $id
 * @property string $Email
 * @property string $Fax
 * @property string $Telephone
 * @property string $Mobile
 * @property integer $supplier_id
 *
 * The followings are the available model relations:
 * @property Suppliers $supplier
 */
class SuppliersContact extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_suppliers_contact';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('supplier_id', 'numerical', 'integerOnly'=>true),
			array('Email, Fax, Telephone, Mobile', 'length', 'max'=>50),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, Email, Fax, Telephone, Mobile, supplier_id', 'safe', 'on'=>'search'),
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
			'supplier' => array(self::BELONGS_TO, 'Suppliers', 'supplier_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'Email' => 'Email',
			'Fax' => 'Fax',
			'Telephone' => 'Telephone',
			'Mobile' => 'Mobile',
			'supplier_id' => 'Supplier',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('Email',$this->Email,true);
		$criteria->compare('Fax',$this->Fax,true);
		$criteria->compare('Telephone',$this->Telephone,true);
		$criteria->compare('Mobile',$this->Mobile,true);
		$criteria->compare('supplier_id',$this->supplier_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SuppliersContact the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
