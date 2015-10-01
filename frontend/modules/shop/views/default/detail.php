<?php
use yii\helpers\Url;
use common\models\Exchange;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\widgets\StarRating;
use frontend\helpers\SetupSite;

$USD  = substr(SetupSite::getCurs("USD"),0);
$EUR  = substr(SetupSite::getCurs("EUR"),0);
$UKR = substr(SetupSite::getCurs("UAH"),0);
$Module = Yii::$app->getModule('shop');
$this->registerJsFile('/eshop/js/zoom-init.js', ['depends' => \frontend\assets\ShopAsset::className()]);
$this->registerJsFile('/eshop/js/detail.js',['depends'=> \frontend\assets\ShopAsset::className()]);
?>
<?php

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
<style>
    /* styles unrelated to zoom */

    /* these styles are for the demo, but are not required for the plugin */
    .zoom {
        display: inline-block;
        position: relative;

    }

    /* magnifying glass icon */
    .zoom:after {
        content: '';
        display: block;
        width: 33px;
        height: 33px;
        position: absolute;
        top: 0;
        right: 0;
        background: url(/eshop/images/shop/icon.png);
    }

    .zoom img {
        display: block;
    }

    .zoom img::selection {
        background-color: transparent;
    }

    /
    /
    #zoom img:hover {
        cursor: url(/eshop/images/shop/grab.cur), default;
    }

    #zoom img:active {
        cursor: url(/eshop/images/shop/grabbed.cur), default;
    }
</style>

<section>
    <div class="container">
        <div class="row">


            <div class="col-sm-12">
                <div class="product-details"><!--product-details-->
                    <div class="col-sm-5">
                        <div class="view-product">
                            <span class='zoom' id='zoom'>
                            <img src="<?= $Module::getGoodImage($model->image) ?>" alt=""/>
                                </span>

                            <h3>ZOOM</h3>
                        </div>
                        <div id="similar-product" class="carousel slide" data-ride="carousel">

                            <!-- Wrapper for slides -->
                            <div class="carousel-inner">
                                <div class="item active">
                                    <?php if ($modelPhotos): ?>
                                        <?php foreach ($modelPhotos as $photo): ?>

                                            <a href="javascript:void(0);" onclick="changePlace($(this),'<?= $photo->name ?>')" >
                                                <img src="<?= $Module::getGoodImageExtra($photo->name) ?>" alt="" width="85" height="84">
                                            </a>
<!--                                            <a href=""><img src="--><?//= '/upload/goods-extra/'.$photo->name ?><!--" alt=""></a>-->

                                        <?php endforeach; ?>
                                    <?php endif; ?>

                                </div>
<!--                                <div class="item">-->
<!--                                    <a href=""><img src="/eshop/images/product-details/similar1.jpg" alt=""></a>-->
<!--                                    <a href=""><img src="/eshop/images/product-details/similar2.jpg" alt=""></a>-->
<!--                                    <a href=""><img src="/eshop/images/product-details/similar3.jpg" alt=""></a>-->
<!--                                </div>-->
<!--                                <div class="item">-->
<!--                                    --><?php //if ($modelPhotos): ?>
<!--                                        --><?php //foreach ($modelPhotos as $photo): ?>
<!---->
<!--                                            <a href=""><img src="/eshop/images/product-details/similar1.jpg" alt=""></a>-->
<!--                                            <a href=""><img src="/eshop/images/product-details/similar2.jpg" alt=""></a>-->
<!--                                            <a href=""><img src="/eshop/images/product-details/similar3.jpg" alt=""></a>-->
<!---->
<!--                                        --><?php //endforeach; ?>
<!--                                    --><?php //endif; ?>
<!--                                </div>-->

                            </div>

                            <!-- Controls -->
                            <a class="left item-control" href="#similar-product" data-slide="prev">
                                <i class="fa fa-angle-left"></i>
                            </a>
                            <a class="right item-control" href="#similar-product" data-slide="next">
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </div>

                    </div>
                    <div class="col-sm-7">
                        <div class="product-information"><!--/product-information-->
                            <img src="/eshop/images/product-details/new.jpg" class="newarrival" alt=""/>

                            <h2><?= $model->item ?></h2>

                            <p>Web ID: <?= $model->id ?></p>
<!--                            <img src="/eshop/images/product-details/rating.png" alt=""/>-->
								<span>
									<span><?= $PRICE_1; ?><?= number_format($model->price / $VALUTE, 2, '.', ''); ?><?= $PRICE_2; ?></span>
									<label>Quantity:</label>
									<input id="total" type="text" value="1"/>
									<button type="button" class="btn btn-fefault cart"
                                            onclick="addToCartTotal(<?= $model->id ?>,$('#total').val())">
                                        <i class="fa fa-shopping-cart"></i>
                                        В корзину
                                    </button>
								</span>

                            <?php
                            echo StarRating::widget([
                                'name' => 'rating_21',
                                'value' => isset($model->rating) ? $model->rating : 0,
                                'pluginOptions' => [
                                    'readonly' => true,
                                    'showClear' => false,
                                    'showCaption' => false,
                                ],
                            ]); ?>

                            <p><b>Доступность:</b> <?= $model->status ? 'В наличии' : 'Нет на складе'; ?></p>

                            <p><b>Aкция:</b> Новинка!</p>

                            <p><b>Бренд: </b><?= isset($model->brend->name) ? $model->brend->name : '' ?></p>

                            <p><b>Категория: </b><?= isset($model->category->name) ? $model->category->name : '' ?></p>

                            <script type="text/javascript" src="//yastatic.net/share/share.js" charset="utf-8"></script>
                            <div class="yashare-auto-init" data-yashareL10n="ru" data-yashareType="none" data-yashareQuickServices="vkontakte,facebook,twitter,odnoklassniki,moimir,gplus"></div>


                            <a href=""><img src="/eshop/images/product-details/share.png" class="share img-responsive"
                                            alt=""/></a>
                        </div>
                        <!--/product-information-->
                    </div>
                </div>
                <!--/product-details-->

                <div class="category-tab shop-details-tab"><!--category-tab-->
                    <div class="col-sm-12">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#details" data-toggle="tab">Детали</a></li>
                            <li><a href="#companyprofile" data-toggle="tab">Company Profile</a></li>
                            <li><a href="#tag" data-toggle="tab">Tag</a></li>
                            <li><a href="#reviews" data-toggle="tab">Отзывы (<?= count($modelReview) ?>)</a></li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade active in" id="details">
                            <div class="col-sm-12">
                                <div class="product-image-wrapper">

                                    <h2>$<?= $model->price ?></h2>

                                    <p><?= $model->item ?></p>

                                    <p><?= $model->descr ?></p>
                                    <button onclick="addToCart(<?= $model->id ?>)" type="button"
                                            class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>В
                                        корзину
                                    </button>

                                </div>
                            </div>


                        </div>

                        <div class="tab-pane fade" id="companyprofile">
                            <div class="col-sm-3">
                                <div class="product-image-wrapper">
                                    <div class="single-products">
                                        <div class="productinfo text-center">
                                            <img src="/eshop/images/home/gallery1.jpg" alt=""/>

                                            <h2>$56</h2>

                                            <p>Easy Polo Black Edition</p>
                                            <button type="button" class="btn btn-default add-to-cart"><i
                                                    class="fa fa-shopping-cart"></i>Add to cart
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="product-image-wrapper">
                                    <div class="single-products">
                                        <div class="productinfo text-center">
                                            <img src="/eshop/images/home/gallery3.jpg" alt=""/>

                                            <h2>$56</h2>

                                            <p>Easy Polo Black Edition</p>
                                            <button type="button" class="btn btn-default add-to-cart"><i
                                                    class="fa fa-shopping-cart"></i>Add to cart
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="product-image-wrapper">
                                    <div class="single-products">
                                        <div class="productinfo text-center">
                                            <img src="/eshop/images/home/gallery2.jpg" alt=""/>

                                            <h2>$56</h2>

                                            <p>Easy Polo Black Edition</p>
                                            <button type="button" class="btn btn-default add-to-cart"><i
                                                    class="fa fa-shopping-cart"></i>Add to cart
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="product-image-wrapper">
                                    <div class="single-products">
                                        <div class="productinfo text-center">
                                            <img src="/eshop/images/home/gallery4.jpg" alt=""/>

                                            <h2>$56</h2>

                                            <p>Easy Polo Black Edition</p>
                                            <button type="button" class="btn btn-default add-to-cart"><i
                                                    class="fa fa-shopping-cart"></i>Add to cart
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="tag">
                            <div class="col-sm-3">
                                <div class="product-image-wrapper">
                                    <div class="single-products">
                                        <div class="productinfo text-center">
                                            <img src="/eshop/images/home/gallery1.jpg" alt=""/>

                                            <h2>$56</h2>

                                            <p>Easy Polo Black Edition</p>
                                            <button type="button" class="btn btn-default add-to-cart"><i
                                                    class="fa fa-shopping-cart"></i>Add to cart
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="product-image-wrapper">
                                    <div class="single-products">
                                        <div class="productinfo text-center">
                                            <img src="/eshop/images/home/gallery2.jpg" alt=""/>

                                            <h2>$56</h2>

                                            <p>Easy Polo Black Edition</p>
                                            <button type="button" class="btn btn-default add-to-cart"><i
                                                    class="fa fa-shopping-cart"></i>Add to cart
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="product-image-wrapper">
                                    <div class="single-products">
                                        <div class="productinfo text-center">
                                            <img src="/eshop/images/home/gallery3.jpg" alt=""/>

                                            <h2>$56</h2>

                                            <p>Easy Polo Black Edition</p>
                                            <button type="button" class="btn btn-default add-to-cart"><i
                                                    class="fa fa-shopping-cart"></i>Add to cart
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="product-image-wrapper">
                                    <div class="single-products">
                                        <div class="productinfo text-center">
                                            <img src="/eshop/images/home/gallery4.jpg" alt=""/>

                                            <h2>$56</h2>

                                            <p>Easy Polo Black Edition</p>
                                            <button type="button" class="btn btn-default add-to-cart"><i
                                                    class="fa fa-shopping-cart"></i>Add to cart
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade  in" id="reviews">

                            <div class="col-sm-12">
                                <? if ($modelReview): ?>
                                    <?php foreach ($modelReview as $review): ?>
                                        <ul>
                                            <li><a href=""><i class="fa fa-user"></i><?= $review->name ?></a></li>
                                            <li><a href=""><i
                                                        class="fa fa-clock-o"></i><?= date("H:i", $review->created_at) ?>
                                                </a></li>
                                            <li><a href=""><i
                                                        class="fa fa-calendar-o"></i><?= date("d-m-Y", $review->created_at) ?>
                                                </a></li>
                                        </ul>
                                        <p><?= $review->content ?></p>
                                    <?php endforeach; ?>
                                <?php endif ?>
                                <p><b>Напишите свой отзыв</b></p>

                                <?php
                                $form = ActiveForm::begin([
                                'id' => 'review-form',
                                'options' => ['class'=>'form-inline'],
                                ]) ?>
                                <span>
                                <?= $form->field($_modelReview, 'name')->textInput(['placeholder'=>'Имя','class'=>'form-reviev-input'])->label('') ?>
                                <?= $form->field($_modelReview, 'email')->textInput(['placeholder'=>'Email','class'=>'form-reviev-input'])->label('') ?>
</span>
                                <?= $form->field($_modelReview, 'content')->textarea(['rows'=>6])->label(''); ?>
                                <b>Rating: </b> <img src="/eshop/images/product-details/rating.png" alt=""/>
                                <div class="form-group">
                                    <div class="col-lg-offset-1 col-lg-11">
                                        <?= Html::submitButton('Вход', ['class' => 'btn btn-default pull-right']) ?>
                                    </div>
                                </div>
                                <?php ActiveForm::end() ?>



<!--                                <form action="#">-->
<!--										<span>-->
<!--											<input type="text" placeholder="Your Name"/>-->
<!--											<input type="email" placeholder="Email Address"/>-->
<!--										</span>-->
<!--                                    <textarea name=""></textarea>-->
<!--                                    <b>Rating: </b> <img src="/eshop/images/product-details/rating.png" alt=""/>-->
<!--                                    <button type="button" class="btn btn-default pull-right">-->
<!--                                        Submit-->
<!--                                    </button>-->
<!--                                </form>-->
                            </div>

                        </div>

                    </div>
                </div>
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

    .productinfo img {
        width: auto;
        max-height: 190px;
    }
    .form-reviev-input{
        width:50%;
    }
    .form-group{
        //width:47%!important;
    }
    .form-reviev-input{
        width:100%!important;
    }
</style>