<?php

/**
 * This is the model class for table "tbl_suppliers".
 *
 * The followings are the available columns in table 'tbl_suppliers':
 * @property integer $id
 * @property string $supplierName
 * @property string $PANNumber
 * @property string $BillingAddress
 * @property double $Accountspayables
 *
 * The followings are the available model relations:
 * @property SuppliersContact[] $suppliersContacts
 * @property PurchasesInvoices[] $purchasesInvoices
 * @property MoneyPaid[] $moneyPas
 * @property SuppliersCredit[] $suppliersCredits
 * @property AutomatedTransactionSuppliers[] $automatedTransactionSuppliers
 */
class Suppliers extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'tbl_suppliers';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('supplierName', 'required'),
            array('purchasesInvoices', 'numerical', 'integerOnly'=>true),
            array('Accountspayables', 'numerical'),
            array('supplierName, PANNumber', 'length', 'max'=>60),
            array('BillingAddress', 'length', 'max'=>100),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, supplierName, PANNumber, BillingAddress, purchasesInvoices, Accountspayables', 'safe', 'on'=>'search'),
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
            'suppliersContacts' => array(self::HAS_MANY, 'SuppliersContact', 'supplier_id'),
            'purchasesInvs' => array(self::HAS_MANY, 'PurchasesInvoices', 'supplier_id'),
            'moneyPas' => array(self::HAS_MANY, 'MoneyPaid', 'supplier_id'),
            'suppliersCredits' => array(self::HAS_MANY, 'SuppliersCredit', 'supplier_id'),
            'automatedTransactionSuppliers' => array(self::HAS_MANY, 'AutomatedTransactionSuppliers', 'supplier_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'supplierName' => 'Supplier Name',
            'PANNumber' => 'Pannumber',
            'BillingAddress' => 'Billing Address',
            'purchasesInvoices' => 'Purchases Invoices',
            'Accountspayables' => 'Accountspayables',
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
        $criteria->compare('supplierName',$this->supplierName,true);
        $criteria->compare('PANNumber',$this->PANNumber,true);
        $criteria->compare('BillingAddress',$this->BillingAddress,true);
        $criteria->compare('purchasesInvoices',$this->purchasesInvoices);
        $criteria->compare('Accountspayables',$this->Accountspayables);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Suppliers the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}
