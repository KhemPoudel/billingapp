<?php

/**
 * This is the model class for table "tbl_suppliers_credit".
 *
 * The followings are the available columns in table 'tbl_suppliers_credit':
 * @property integer $id
 * @property string $credited_date
 * @property integer $supplier_id
 * @property double $amount
 * @property integer $credited_from
 * @property double $credit_assigned
 *
 * The followings are the available model relations:
 * @property PurchasesInvoices $creditedFrom
 * @property Suppliers $supplier
 */
class SuppliersCredit extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tbl_suppliers_credit';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('supplier_id, credited_from', 'numerical', 'integerOnly'=>true),
			array('amount, credit_assigned', 'numerical'),
			array('credited_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, credited_date, supplier_id, amount, credited_from, credit_assigned', 'safe', 'on'=>'search'),
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
			'creditedFrom' => array(self::BELONGS_TO, 'PurchasesInvoices', 'credited_from'),
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
			'credited_date' => 'Credited Date',
			'supplier_id' => 'Supplier',
			'amount' => 'Amount',
			'credited_from' => 'Credited From',
			'credit_assigned' => 'Credit Assigned',
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
		$criteria->compare('credited_date',$this->credited_date,true);
		$criteria->compare('supplier_id',$this->supplier_id);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('credited_from',$this->credited_from);
		$criteria->compare('credit_assigned',$this->credit_assigned);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return SuppliersCredit the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
