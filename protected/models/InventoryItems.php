<?php

/**
 * This is the model class for table "tbl_inventory_items".
 *
 * The followings are the available columns in table 'tbl_inventory_items':
 * @property integer $id
 * @property string $item_name
 * @property string $item_identifier
 * @property integer $sp
 * @property integer $cp
 * @property integer $qty
 * @property integer $total_cost
 *
 * The followings are the available model relations:
 * @property SalesInfo[] $salesInfos
 */
class InventoryItems extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_inventory_items';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('sp, cp, qty, total_cost', 'numerical', 'integerOnly'=>true),
			array('item_name', 'length', 'max'=>50),
			array('item_identifier', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, item_name, item_identifier, sp, cp, qty, total_cost', 'safe', 'on'=>'search'),
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
			'salesInfos' => array(self::HAS_MANY, 'SalesInfo', 'item_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'item_name' => 'Item Name',
			'item_identifier' => 'Item Identifier',
			'sp' => 'Sp',
			'cp' => 'Cp',
			'qty' => 'Qty',
			'total_cost' => 'Total Cost',
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
		$criteria->compare('item_name',$this->item_name,true);
		$criteria->compare('item_identifier',$this->item_identifier,true);
		$criteria->compare('sp',$this->sp);
		$criteria->compare('cp',$this->cp);
		$criteria->compare('qty',$this->qty);
		$criteria->compare('total_cost',$this->total_cost);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return InventoryItems the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
