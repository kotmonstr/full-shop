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
<input type="hidden" id="valute" value="<?= $data['currCurency'] ?>">
<section id="slider"><!--slider-->
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div id="slider-carousel" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
                        <?php foreach ($modelSlider as $slide): ?>
                            <?php $i++; ?>
                            <li data-target="#slider-carousel" data-slide-to="<? +$i ?>"></li>

                        <?php endforeach ?>
                    </ol>
                    <?php $i = 0; ?>
                    <div class="carousel-inner">
                        <?php foreach ($modelSlider as $slide): ?>
                            <?php $i++; ?>
                            <div class="item <?php if ($i == 1) echo "active"; ?>">
                                <div class="col-sm-6">
                                    <h1><span>K</span>OTMONSTR-SHOPPER</h1>

                                    <h2>KOTMONSTR Shop</h2>

                                    <p>Интернет магазин для любого вида комерции. </p>
                                    <button type="button" class="btn btn-default get">Купить сейчас</button>
                                </div>
                                <div class="col-sm-6">
                                    <img src="<?= '/upload/goods/' . $slide->image ?>"
                                         class="girl img-responsive" alt=""/>
                                    <img src="/eshop/images/home/pricing.png" class="pricing" alt=""/>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>
                    <a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
                        <i class="fa fa-angle-left"></i>
                    </a>
                    <a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
                        <i class="fa fa-angle-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section><!--/slider-->

<section>
    <div class="container ">
        <div class="row">
            <?= $this->render('/menu/_sidebar', ['modelGoodsCategories' => $modelGoodsCategories,
                'modelBrends' => $modelBrends,
                'modelBanner' => $modelBanner,
                'PRICE_1' => $PRICE_1,
                'PRICE_2' => $PRICE_2,
            ]);?>

            <div class="col-sm-9 padding-right target-goods">
                <div class="features_items" id="start_animation"><!--features_items-->
                    <h2 class="title text-center">Товары</h2>
                    <?php if($modelNewGoods):?>
                    <?php foreach ($modelNewGoods as $good): ?>
                        <?php $inCart = Cart::_isItemAlreadyInCart($good->id); ?>

                        <div class="col-sm-4">
                            <div class="product-image-wrapper">
                                <div class="single-products img-<?= $good->id ?>">
                                    <div class="productinfo text-center">
                                        <a href="/shop/detail?item=<?= $good->id ?>"><img
                                                src="<?= $Module::getGoodImage($good->image) ?>" alt=""/>

                                            <h2><?= $PRICE_1 ?><?= number_format($good->price / $VALUTE ,2,'.','');?><?= $PRICE_2 ?></h2>

                                            <p title="<?= $good->item ?>"><?= StringHelper::truncate($good->item, 25) ?></p>
                                        </a>
                                        <a href="javascript:void(0);" onclick="addToCart($(this) , <?= $good->id ?>)"
                                           class="btn btn-default add-to-cart"><i
                                                class="fa fa-shopping-cart"></i> В корзину</a>
                                    </div>

                                </div>
                                <div class="choose">
                                    <ul class="nav nav-pills nav-justified">
                                        <li><a href="javascript:void(0);" onclick="AddToWishList(<?= $good->id ?>)"><i
                                                    class="fa fa-plus-square"></i>В список желаний</a></li>
                                        <li><a href="javascript:void(0);"
                                               onclick="AddToCompareList(<?= $good->id ?>)"><i
                                                    class="fa fa-plus-square"></i>В список сравнений</a></li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <!--features_items-->
                <?= $this->render('/menu/_tabs', ['modelGoodsCategories' => $modelGoodsCategories]); ?>
                <!--/category-tab-->

                <!--recommended_items-->
                <div class="recommended_items">
                    <?= $this->render('/menu/_best', ['modelBest' => $modelBest]); ?>
                </div>
                <!--/recommended_items-->
            </div>
        </div>
    </div>
</section>
<style>
    .product-image-wrapper:hover {
    / / border : 1 px solid #7b7a7c;
        box-shadow: 3px 3px 10px #7b7a7c;
        cursor: pointer;
    }
    .girl{
        max-height: 300px;
    }
    #slider-carousel{
        max-height: 355px!important;
        min-height: 354px!important;
        height: 354px!important;
    }
</style>
<script>

</script>

