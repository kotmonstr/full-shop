<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;
$Module = Yii::$app->getModule('shop');
?>




                <div class="features_items"><!--features_items-->
                    <h2 class="title text-center">Товары в ценовой категории</h2>
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
