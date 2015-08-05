<?php

/**
 * This is the model class for table "tbl_customers".
 *
 * The followings are the available columns in table 'tbl_customers':
 * @property integer $id
 * @property string $customerName
 * @property string $PANNumber
 * @property string $BillingAddress
 * @property integer $SalesInvoices
 * @property double $AccountsReceivables
 *
 * The followings are the available model relations:
 * @property CustomersContact[] $customersContacts
 * @property SalesInvoices[] $salesInvoices
 */
class Customers extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_customers';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('customerName', 'required'),
			array('SalesInvoices', 'numerical', 'integerOnly'=>true),
			array('AccountsReceivables', 'numerical'),
			array('customerName, PANNumber', 'length', 'max'=>60),
			array('BillingAddress', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, customerName, PANNumber, BillingAddress, SalesInvoices, AccountsReceivables', 'safe', 'on'=>'search'),
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
			'customersContacts' => array(self::HAS_MANY, 'CustomersContact', 'customer_id'),
			'salesInvoices' => array(self::HAS_MANY, 'SalesInvoices', 'customer_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'customerName' => 'Customer Name',
			'PANNumber' => 'Pannumber',
			'BillingAddress' => 'Billing Address',
			'SalesInvoices' => 'Sales Invoices',
			'AccountsReceivables' => 'Accounts Receivables',
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
		$criteria->compare('customerName',$this->customerName,true);
		$criteria->compare('PANNumber',$this->PANNumber,true);
		$criteria->compare('BillingAddress',$this->BillingAddress,true);
		$criteria->compare('SalesInvoices',$this->SalesInvoices);
		$criteria->compare('AccountsReceivables',$this->AccountsReceivables);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Customers the static model class
	 */
    public function beforeDelete(){
        foreach($this->customersContacts as $c)
            $c->delete();
        foreach($this->salesInvoices as $c)
            $c->delete();
        return parent::beforeDelete();
    }

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
