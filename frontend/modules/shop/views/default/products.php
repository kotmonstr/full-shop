<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;
use common\models\Exchange;

$Module = Yii::$app->getModule('shop');
$i = 1;
?>
<?php
// Валюта
$rates = new Exchange(time());

$USD = $rates->GetRate("USD");
$UKR = $rates->GetRate("UAH");
$EUR = $rates->GetRate("EUR");

//$USD = 1;
//$UKR = 2;
//$EUR = 3;
echo $this->render('/menu/_header', [
    'quantityInCart' => $quantityInCart,
    'data' => $data,
])

?>

<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <div class="left-sidebar">
                    <h2>Категории товаров</h2>
                    <?= $this->render('/menu/_category-products', ['modelGoodsCategories' => $modelGoodsCategories]); ?>

                    <div class="brands_products"><!--brands_products-->

                        <h2>Бренды</h2>
                        <?= $this->render('/menu/_brands-name', ['modelBrends' => $modelBrends]); ?>
                    </div>
                    <!--/brands_products-->

                    <div class="price-range"><!--price-range-->
                        <h2>Price Range</h2>

                        <div class="well">
                            <input type="text" class="span2" value="" data-slider-min="0" data-slider-max="600"
                                   data-slider-step="5" data-slider-value="[250,450]" id="sl2"><br/>
                            <b>$ 0</b> <b class="pull-right">$ 600</b>
                        </div>
                    </div>
                    <!--/price-range-->

                    <div class="shipping text-center"><!--shipping-->
                        <img src="/images/home/shipping.jpg" alt=""/>
                    </div>
                    <!--/shipping-->

                </div>
            </div>

            <div class="col-sm-9 padding-right">
                <div class="features_items"><!--features_items-->
                    <h2 class="title text-center">Товары</h2>
                    <?php if ($modelsGoods): ?>
                        <?php foreach ($modelsGoods as $good): ?>


                            <div class="col-sm-4">
                                <div class="product-image-wrapper">
                                    <div class="single-products img-<?= $good->id ?>">
                                        <div class="productinfo text-center">
                                            <a href="/shop/detail?item=<?= $good->id ?>" title="Просмотреть детали"><img
                                                    src="<?= $Module::getGoodImage($good->image) ?>" alt=""/>

                                                <h2>$<?= $good->price ?></h2>

                                                <p><?= $good->item ?></p></a>
                                            <a href="javascript:void(0);" onclick="addToCart($(this) , <?= $good->id ?>)"
                                               class="btn btn-default add-to-cart"><i
                                                    class="fa fa-shopping-cart"></i>В корзину</a>
                                        </div>

                                    </div>
                                    <div class="choose">
                                        <ul class="nav nav-pills nav-justified">
                                            <li><a href="javascript:void(0);" onclick="AddToWishList(<?= $good->id ?>)"><i class="fa fa-plus-square"></i>В список желаний</a></li>
                                            <li><a href="javascript:void(0);"
                                                   onclick="AddToCompareList(<?= $good->id ?>)"><i class="fa fa-plus-square"></i>В список сравнений</a></li>
                                        </ul>
                                    </div>
                                </div>

                            </div>


                        <?php endforeach; ?>
                    <?php else: ?>
                        Нет товаров
                    <?php endif; ?>
                    <?php
                    // display pagination
                    echo LinkPager::widget([
                        'pagination' => $pages,
                        'registerLinkTags' => true,
                        'hideOnSinglePage' => true
                    ]);
                    ?>
                    <!--                    <ul class="pagination">-->
                    <!--                        <li class="active"><a href="">1</a></li>-->
                    <!--                        <li><a href="">2</a></li>-->
                    <!--                        <li><a href="">3</a></li>-->
                    <!--                        <li><a href="">&raquo;</a></li>-->
                    <!--                    </ul>-->
                </div>
                <!--features_items-->
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
</style>