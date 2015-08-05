<?php

/**
 * This is the model class for table "tbl_money_paid".
 *
 * The followings are the available columns in table 'tbl_money_paid':
 * @property integer $id
 * @property string $paid_date
 * @property integer $purchases_invoice_id
 * @property integer $supplier_id
 * @property double $amount
 * @property boolean $status
 *
 * The followings are the available model relations:
 * @property Suppliers $supplier
 * @property PurchasesInvoices $purchasesInvoice
 */
class MoneyPaid extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_money_paid';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('purchases_invoice_id, supplier_id', 'numerical', 'integerOnly'=>true),
			array('amount', 'numerical'),
			array('paid_date, status', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, paid_date, purchases_invoice_id, supplier_id, amount, status', 'safe', 'on'=>'search'),
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
			'purchasesInvoice' => array(self::BELONGS_TO, 'PurchasesInvoices', 'purchases_invoice_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'paid_date' => 'Paid Date',
			'purchases_invoice_id' => 'Purchases Invoice',
			'supplier_id' => 'Supplier',
			'amount' => 'Amount',
			'status' => 'Status',
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
		$criteria->compare('paid_date',$this->paid_date,true);
		$criteria->compare('purchases_invoice_id',$this->purchases_invoice_id);
		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MoneyPaid the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
