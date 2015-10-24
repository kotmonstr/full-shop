<?php
use yii\helpers\Url;
use common\models\Cart;
use yii\helpers\StringHelper;
use common\models\Exchange;
use frontend\helpers\SetupSite;

$USD  = substr(SetupSite::getCurs("USD"),0);
$EUR  = substr(SetupSite::getCurs("EUR"),0);
$UKR = substr(SetupSite::getCurs("UAH"),0);
$Module = Yii::$app->getModule('shop');
$i = 1;

echo $this->render('/menu/_header', [
    'data' => $data,
    'USD' => $USD,
    'UKR' => $UKR,
    'EUR' => $EUR,
]);
//vd($data['currCurency']);
switch ($data['currCurency']) {
    case 'RUB':
        $PRICE_1 = '';
        $PRICE_2 = ' Руб';
        $VALUTE = 1;
        break;
    case 'DOLLAR':
        $PRICE_1 = '$ ';
        $PRICE_2 = '';
        $VALUTE = $USD;
        break;
    case 'UAN':
        $PRICE_1 = '';
        $PRICE_2 = ' Грв';
        $VALUTE = $UKR;
        break;
    default:
        $PRICE_1 = '';
        $PRICE_2 = ' Руб';
        $VALUTE = 1;


}


?>




<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li class="active"><a href="/shop/index" >Home</a></li>
                <li >Мои заказы</li>
            </ol>
        </div><!--/breadcrums-->


<?php if(!$model){ ?>
        <div class="register-req" style="text-align: center">
            <p>Ваша история заказов отсутствует</p>
        </div>
        <?php }else{ ?>

    <?php foreach($model as $order){ ?>
        <div class="step-one">
            <a title="Детальный просмотр" href="<?= Url::to(['/shop/order-detail','id'=> $order->id]); ?>"><h2 class="heading"><?= 'Заказ #: ' . $order->id . ' от ' .date("d-m-Y H:i",$order->created_at) . ' (' . $order->status0->name; ?>)</h2></a>
        </div>

    <?php }?>

<?php } ?>

    </div>
</section>
<style>
    .step-one a h2:hover{
        color: #FE980F;
    }
</style>