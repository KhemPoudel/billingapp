<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="en" />

    <!-- blueprint CSS framework -->
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
    <!--[if lt IE 8]>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
    <![endif]-->

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/cssForHeaders.css" />
    <?php Yii::app()->bootstrap->init(); ?>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body style="">
<div class="" style="padding-top:1%;padding-bottom:1%;text-align:center;background-color:#acafcf;">
    <h2>Milijuli Copy Udhyog</h2>
    <h4 style="">Srijana Chowk,Pokhara</h4>
</div>

<div class="row" style="margin:0.2% 0.1% 0 0.1%; ">
    <div class="navbar">
        <div class="navbar-inner">
            <a class="brand" href="#">Milijuli</a>
            <ul class=" menu nav">
                <li><a href="<?php echo $this->createAbsoluteUrl('/salesInvoices')?>">Sales Invoices</a></li>
                <li><a href="<?php echo $this->createAbsoluteUrl('/customers')?>">Customers</a></li>
                <li><a href="<?php echo $this->createAbsoluteUrl('/inventoryItems')?>">Inventory Items</a></li>
                <li><a href="<?php echo $this->createAbsoluteUrl('/suppliers')?>">Suppliers</a></li>
                <li><a href="<?php echo $this->createAbsoluteUrl('/purchasesInvoices')?>">Purchase Invoices</a></li>
                <li><a href="<?php echo $this->createAbsoluteUrl('/inventoryItems')?>">Employees</a></li>
                <li><a href="<?php echo $this->createAbsoluteUrl('/reports')?>">Reports</a></li>
                <li><a href="<?php echo $this->createAbsoluteUrl('/inventoryItems')?>">Calculator</a></li>
            </ul>
        </div>
    </div>
    <div class="col-md-8" style="background-color: #ffffff;">
        <?php echo $content; ?>
    </div><!-- mainmenu -->






    <div class="clear"></div>

    <div id="footer">
        Copyright &copy; <?php echo date('Y'); ?> Khem Poudel<br/>
        All Rights Reserved.<br/>
        <?php echo "IT Pokhara"; ?>
    </div><!-- footer -->

</div><!-- page -->

</body>
<script type="text/javascript">
        $(document).ready(function(){
            var url=window.location.href;
            $('.menu li a').each(function() {
                if(url==$(this).attr('href')){
                    $(this).parent().addClass('active');
                    $(this).parent().siblings().removeClass('active');
                }



            });
        })



</script>
</html>
