<?php

/**
 * This is the model class for table "tbl_automated_transaction_customers".
 *
 * The followings are the available columns in table 'tbl_automated_transaction_customers':
 * @property integer $id
 * @property string $received_date
 * @property integer $from_sales_invoice_id
 * @property integer $customer_id
 * @property double $amount
 * @property integer $to_sales_invoice_id
 *
 * The followings are the available model relations:
 * @property SalesInvoices $toSalesInvoice
 * @property Customers $customer
 * @property SalesInvoices $fromSalesInvoice
 */
class AutomatedTransactionCustomers extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_automated_transaction_customers';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('from_sales_invoice_id, customer_id, to_sales_invoice_id', 'numerical', 'integerOnly'=>true),
			array('amount', 'numerical'),
			array('received_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, received_date, from_sales_invoice_id, customer_id, amount, to_sales_invoice_id', 'safe', 'on'=>'search'),
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
			'toSalesInvoice' => array(self::BELONGS_TO, 'SalesInvoices', 'to_sales_invoice_id'),
			'customer' => array(self::BELONGS_TO, 'Customers', 'customer_id'),
			'fromSalesInvoice' => array(self::BELONGS_TO, 'SalesInvoices', 'from_sales_invoice_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'received_date' => 'Received Date',
			'from_sales_invoice_id' => 'From Sales Invoice',
			'customer_id' => 'Customer',
			'amount' => 'Amount',
			'to_sales_invoice_id' => 'To Sales Invoice',
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
		$criteria->compare('received_date',$this->received_date,true);
		$criteria->compare('from_sales_invoice_id',$this->from_sales_invoice_id);
		$criteria->compare('customer_id',$this->customer_id);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('to_sales_invoice_id',$this->to_sales_invoice_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AutomatedTransactionCustomers the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
