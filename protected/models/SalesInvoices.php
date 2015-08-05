<?php

/**
 * This is the model class for table "tbl_sales_invoices".
 *
 * The followings are the available columns in table 'tbl_sales_invoices':
 * @property integer $id
 * @property string $issue_date
 * @property string $due_date
 * @property integer $customer_id
 * @property double $total_amount
 * @property double $balance
 * @property double $credited
 *
 * The followings are the available model relations:
 * @property SalesInfo[] $salesInfos
 * @property AutomatedTransactionCustomers[] $automatedTransactionCustomers
 * @property AutomatedTransactionCustomers[] $automatedTransactionCustomers1
 * @property MoneyReceived[] $moneyReceiveds
 * @property CustomersCredit[] $customersCredits
 * @property Customers $customer
 */
class SalesInvoices extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_sales_invoices';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('customer_id', 'numerical', 'integerOnly'=>true),
			array('total_amount, balance, credited', 'numerical'),
			array('issue_date, due_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, issue_date, due_date, customer_id, total_amount, balance, credited', 'safe', 'on'=>'search'),
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
			'salesInfos' => array(self::HAS_MANY, 'SalesInfo', 'sales_invoice_id'),
			'automatedTransactionCustomers' => array(self::HAS_MANY, 'AutomatedTransactionCustomers', 'to_sales_invoice_id'),
			'automatedTransactionCustomers1' => array(self::HAS_MANY, 'AutomatedTransactionCustomers', 'from_sales_invoice_id'),
			'moneyReceiveds' => array(self::HAS_MANY, 'MoneyReceived', 'sales_invoice_id'),
			'customersCredits' => array(self::HAS_MANY, 'CustomersCredit', 'credited_from'),
			'customer' => array(self::BELONGS_TO, 'Customers', 'customer_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'issue_date' => 'Issue Date',
			'due_date' => 'Due Date',
			'customer_id' => 'Customer',
			'total_amount' => 'Total Amount',
			'balance' => 'Balance',
			'credited' => 'Credited',
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
		$criteria->compare('issue_date',$this->issue_date,true);
		$criteria->compare('due_date',$this->due_date,true);
		$criteria->compare('customer_id',$this->customer_id);
		$criteria->compare('total_amount',$this->total_amount);
		$criteria->compare('balance',$this->balance);
		$criteria->compare('credited',$this->credited);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function beforeDelete(){
        foreach($this->automatedTransactionCustomers as $c)
            $c->delete();
        foreach($this->automatedTransactionCustomers1 as $c)
            $c->delete();
        foreach($this->moneyReceiveds as $c)
            $c->delete();
        foreach($this->customersCredits as $c)
            $c->delete();
        foreach($this->salesInfos as $c)
            $c->delete();
        return parent::beforeDelete();
    }


	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SalesInvoices the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
