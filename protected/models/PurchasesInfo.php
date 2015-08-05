<?php

/**
 * This is the model class for table "tbl_purchases_info".
 *
 * The followings are the available columns in table 'tbl_purchases_info':
 * @property integer $id
 * @property integer $item_id
 * @property double $unit_price
 * @property integer $qty
 * @property double $discount
 * @property double $total_amount
 * @property integer $purchases_invoice_id
 *
 * The followings are the available model relations:
 * @property PurchasesInvoices $purchasesInvoice
 * @property InventoryItems $item
 */
class PurchasesInfo extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_purchases_info';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('item_id, qty, purchases_invoice_id', 'numerical', 'integerOnly'=>true),
			array('unit_price, discount, total_amount', 'numerical'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, item_id, unit_price, qty, discount, total_amount, purchases_invoice_id', 'safe', 'on'=>'search'),
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
			'purchasesInvoice' => array(self::BELONGS_TO, 'PurchasesInvoices', 'purchases_invoice_id'),
			'item' => array(self::BELONGS_TO, 'InventoryItems', 'item_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'item_id' => 'Item',
			'unit_price' => 'Unit Price',
			'qty' => 'Qty',
			'discount' => 'Discount',
			'total_amount' => 'Total Amount',
			'purchases_invoice_id' => 'Purchases Invoice',
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
		$criteria->compare('item_id',$this->item_id);
		$criteria->compare('unit_price',$this->unit_price);
		$criteria->compare('qty',$this->qty);
		$criteria->compare('discount',$this->discount);
		$criteria->compare('total_amount',$this->total_amount);
		$criteria->compare('purchases_invoice_id',$this->purchases_invoice_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function beforeDelete()
    {
        $item=InventoryItems::model()->findByPk($this->item_id);
        $item->qty-=$this->qty;
        $item->save();
        return parent::beforeDelete();
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PurchasesInfo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
