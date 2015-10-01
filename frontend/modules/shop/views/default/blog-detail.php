<?php
use yii\helpers\Url;
use common\models\Cart;
use yii\helpers\StringHelper;
use common\models\Exchange;
use yii\helpers\Html;
use yii\widgets\LinkPager;
use kartik\rating\StarRating;
use yii\helpers\HtmlPurifier;
use common\models\BlogComments;
use frontend\helpers\SetupSite;
use frontend\components\UrlManagerImages;
use yii\widgets\ActiveForm;

$Module = Yii::$app->getModule('shop');
$i = 1;
$model = new \common\models\BlogComments();

$USD  = substr(SetupSite::getCurs("USD"),0);
$EUR  = substr(SetupSite::getCurs("EUR"),0);
$UKR = substr(SetupSite::getCurs("UAH"),0);

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

$this->registerJsFile('/eshop/js/comment.js');

?>
<section>
    <div class="container ">
        <div class="row">
            <div class="col-sm-3">
                <div class="left-sidebar">
                    <h2>Категории товаров</h2>
                    <?= $this->render('/menu/_category-products', ['modelGoodsCategories' => $modelGoodsCategories]); ?>
                    <!--/category-products-->

                    <div class="brands_products"><!--brands_products-->
                        <h2>Бренды</h2>
                        <?= $this->render('/menu/_brands-name', ['modelBrends' => $modelBrends]); ?>
                    </div>
                    <!--/brands_products-->

                    <div class="price-range"><!--price-range-->
                        <h2>Цена</h2>

                        <div class="well text-center">
                            <input type="text" class="span2" value="" data-slider-min="0" data-slider-max="600"
                                   data-slider-step="5" data-slider-value="[250,450]" id="sl2"><br/>
                            <b class="pull-left">$ 0</b> <b class="pull-right">$ 600</b>
                        </div>
                    </div>
                    <!--/price-range-->
                    <!--shipping-->
                    <div class="shipping text-center">
                        <?= $this->render('/menu/_banner', ['modelBanner' => $modelBanner]); ?>

                    </div>
                    <!--/shipping-->

                </div>
            </div>


            <div class="col-sm-9">
                <div class="blog-post-area">
                    <h2 class="title text-center">Новости</h2>




                        <div class="single-blog-post">
                            <h3><?= Html::encode($modelBlog->title) ?></h3>
                            <?php
                            echo StarRating::widget([
                                'name' => $modelBlog->id,
                                'id'=>$modelBlog->id,
                                'value' => isset($modelBlog->rating) ? $modelBlog->rating : 0,
                                'pluginOptions' => [
                                    'readonly' => true,
                                    'showClear' => false,
                                    'showCaption' => false,
                                ],
                            ]); ?>

                            <div class="post-meta">
                                <ul>
                                    <li><i class="fa fa-user"></i><?= $modelBlog->user->username; ?></li>
                                    <li><i class="fa fa-clock-o"></i><?= date("H:i", $modelBlog->created_at); ?></li>
                                    <li><i class="fa fa-calendar"></i><?= date("d m Y", $modelBlog->created_at); ?></li>
                                </ul>

                            </div>
                            <a href="">
                                <?php if ($modelBlog->image): ?>
                                    <img src="<?= $Module::getBlogImage($modelBlog->image) ?>" alt=""/>
                                <?php endif; ?>
                            </a>

                            <p><?= HtmlPurifier::process($modelBlog->content); ?></p>


                        </div>
                    <div class="rating-area">
                        <ul class="ratings">
                            <li class="rate-this">Оцените эту статью:</li>
                            <li>
                                <i class="fa fa-star color"></i>
                                <i class="fa fa-star color"></i>
                                <i class="fa fa-star color"></i>
                                <i class="fa fa-star"></i>
                                <i class="fa fa-star"></i>
                            </li>
                            <li class="color">(6 votes)</li>
                        </ul>
                        <ul class="tag">
                            <li>TAG:</li>
                            <li><a class="color" href="">Pink <span>/</span></a></li>
                            <li><a class="color" href="">T-Shirt <span>/</span></a></li>
                            <li><a class="color" href="">Girls</a></li>
                        </ul>
                    </div><!--/rating-area-->

                    <div class="socials-share">
<!--                        <a href="">     <img class="media-object" src="--><?//= Yii::$app->UrlManagerImages->createUrl('defaultUser') ?><!--" alt="" height="30"></a>-->

                    </div><!--/socials-share-->





                    <div class="response-area">
                        <h2> Коментарии <?= $modelBlogComents ? '('.count($modelBlogComents).')' : '';?></h2>
                        <ul class="media-list">

                            <?php if($modelBlogComents): ?>
                            <?php foreach($modelBlogComents as $comment):?>

                            <li class="media">
                                <a class="pull-left" href="#">

                                    <img class="media-object" src="<?= Yii::$app->UrlManagerImages->createUrl('defaultUser') ?>" alt="" height="30" >
                                </a>
                                <div class="media-body">
                                    <ul class="sinlge-post-meta">
                                        <li><i class="fa fa-user"></i><?= $comment->author_name; ?></li>
                                        <li><i class="fa fa-clock-o"></i><?= date("H:i",$comment->created_at); ?></li>
                                        <li><i class="fa fa-calendar"></i> <?= date("d m Y",$comment->created_at); ?></li>
                                    </ul>
                                    <p><?= $comment->text; ?></p>

                                </div>
                            </li>

                            <?php endforeach;?>
                            <?php endif; ?>



<!--                            <li class="media">-->
<!--                                <a class="pull-left" href="#">-->
<!--                                    <img class="media-object" src="/images/blog/man-four.jpg" alt="" height="30" >-->
<!--                                </a>-->
<!--                                <div class="media-body">-->
<!--                                    <ul class="sinlge-post-meta">-->
<!--                                        <li><i class="fa fa-user"></i>Janis Gallagher</li>-->
<!--                                        <li><i class="fa fa-clock-o"></i> 1:33 pm</li>-->
<!--                                        <li><i class="fa fa-calendar"></i> DEC 5, 2013</li>-->
<!--                                    </ul>-->
<!--                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.  Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>-->
<!--                                    <a class="btn btn-primary" href=""><i class="fa fa-reply"></i>Replay</a>-->
<!--                                </div>-->
<!--                            </li>-->

                        </ul>
                    </div>

                    <div class="replay-box">
                        <div class="row">
                            <div class="col-sm-4">
                                <h2>Оставить коментарий</h2>

                                <?php
                                $form = ActiveForm::begin([
                                    'action'=>'/shop/accept-blog-comment',
                                    //'id' => 'login-form',
                                    //'options' => ['class' => ''],
                                ]) ?>
                                <?= $form->field($model, 'blog_id')->hiddenInput(['value'=>$modelBlog->id,'class'=>'hidden'])->label('') ?>
                                    <span>*</span>
                                <?= $form->field($model, 'author_name')->textInput(['class'=> 'input-gray','placeholder'=>'Ваше имя...']) ?>
                                <?= $form->field($model, 'email')->textInput(['class'=> 'input-gray'])->hint('Ваш email...') ?>
                                <?= $form->field($model, 'city')->textInput(['class'=> 'input-gray','placeholder'=>'Ваше город...']) ?>

                            </div>
                            <div class="col-sm-8">
                                <div class="text-area">
                                    <span>*</span>
                                    <?= $form->field($model, 'text')->textarea(['class'=> 'input-gray','rows'=> 11])?>
                                    <?= Html::submitButton('Оставить комментарий', ['class' => 'btn btn-primary button-submit-message']) ?>
                                </div>
                            </div>
                            <?php ActiveForm::end() ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<style>
    .star-rating{
        float: right;
        /* top: -14px; */
        margin-top: -30px;
    }

    .single-blog-post img{
        max-width: 840px;
    }
    .input-gray{
        background-color: #eeeeee!important;
    }
    .button-submit-message:hover{
        background-color: #eab700;
    }
    .field-blogcomments-blog_id{
        display: none;
    }
</style>
