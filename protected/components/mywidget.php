<?php
    class mywidget extends CWidget
    {
        public $cid = 0;
        public function init()
        {
            $criteria = new CDbCriteria;
            $criteria->condition='`id`=$cid';
            $data=CustomersContact::model()->findAll($criteria);
        }
        public function run()
        {
            $this->render('viewcontact');
        }
    }
?>