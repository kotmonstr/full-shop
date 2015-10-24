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
 $summ=0;

?>




<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li class="active"><a href="/shop/index" >Home</a></li>
                <li >Мои заказ # <?= $modelOrder->id ?> </li>
            </ol>
        </div><!--/breadcrums-->







                <div class="review-payment" style="text-align: center">
                    <h2>Заказ #: <?= $modelOrder->id ?></h2>
                </div>

                <div class="table-responsive cart_info">
                    <table class="table table-condensed">
                        <thead>
                        <tr class="cart_menu">
                            <td >Товар</td>
                            <td >Описание</td>
                            <td >Цена</td>
                            <td >Количество</td>
                            <td >Итого</td>

                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach($modelOrderDetail as $item){ ?>

                        <tr>
                            <td class="cart_product">
                                <a href="/shop/detail?item=<?= $item->goods->id ?>"><img
                                        src="<?= '/upload/goods/' . $item->goods->image ?>" alt=""
                                        width="200px"></a>
                            </td>
                            <td class="cart_description">
                                <h4><a href=""><?= $item->goods->item ?></a></h4>
                                <p>Web ID: <?= $item->goods_id ?></p>
                            </td>
                            <td class="cart_price">
                                <p>$<?= $item->price ?></p>
                            </td>
                            <td class="cart_quantity">
                                <div class="cart_quantity_button">
                                    <p><?= $item->quantity ?></p>
                                </div>
                            </td>
                            <td class="cart_total">
                                <p class="cart_total_price">$<?= $item->price * $item->quantity ?></p>
                            </td>

                        </tr>
<?php $summ = $summ + ($item->price * $item->quantity) ; ?>

                        <?php } ?>
                        <tr>
                            <td>
                            </td>
                            <td>
                            </td>
                            <td>
                            </td>
                            <td>
                                <p class="cart_total_price">Итого:</p>
                            </td>
                            <td>
                                <p class="cart_total_price"> $<?= $summ ?></p>
                            </td>


                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="payment-options">
					<span>
						<label><input type="checkbox"> Direct Bank Transfer</label>
					</span>
					<span>
						<label><input type="checkbox"> Check Payment</label>
					</span>
					<span>
						<label><input type="checkbox"> Paypal</label>
					</span>
                </div>







    </div>
</section>