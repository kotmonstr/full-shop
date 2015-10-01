<?php
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\GeoCountry;
use yii\helpers\Html;
use common\models\Order;
use common\models\GeoCity;
use yii\helpers\Url;

$this->registerJsFile('/eshop/js/cart.js', ['depends' => \frontend\assets\ShopAsset::className()]);
echo $this->render('/menu/_header', [
    'data' => $data,

]);
?>


<section id="cart_items">
    <div class="container">

        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="<?= Url::to('/shop/index') ?>">Home</a></li>
                <li class="active">Корзина</li>
            </ol>
        </div>

        <div class="table-responsive cart_info">
            <?php if ($model): ?>
            <table class="table table-condensed">
                <thead>
                <tr class="cart_menu">
                    <td class="image">Товар</td>
                    <td class="description"></td>
                    <td class="price">Цена</td>
                    <td class="quantity">Количество</td>
                    <td class="total">Итого</td>
                    <td></td>
                </tr>
                </thead>
                <tbody>

                <?php foreach ($model as $good): ?>

                    <tr id="row-<?= $good->goods->id ?>">
                        <td class="cart_product">
                            <a href="/shop/detail?item=<?= $good->goods->id ?>"><img
                                    src="<?= '/upload/goods/' . $good->goods->image ?>" alt=""
                                    width="200px"></a>
                        </td>
                        <td class="cart_description">
                            <h4><a href=""><?= $good->goods->item ?></a></h4>

                            <p>Web ID: <?= $good->goods->id ?></p>
                        </td>
                        <td class="cart_price">
                            <p>$<?= $good->goods->price ?></p>
                        </td>
                        <td class="cart_quantity">
                            <div class="cart_quantity_button">
                                <a class="cart_quantity_up" href="javascript:void(0);"
                                   onclick="AddMoreQuantity(<?= $good->goods->id ?>)"><span
                                        class="glyphicon glyphicon-plus"></span></a>
                                <input id="quantity-<?= $good->goods->id ?>" class="cart_quantity_input" type="text"
                                       name="quantity" value="<?= $good->quantity ?>" autocomplete="off" size="2">
                                <a id="minus-<?= $good->goods->id ?>" class="cart_quantity_down"
                                   href="javascript:void(0);"
                                   onclick="RemoveMoreQuantity(<?= $good->goods->id ?>)"><span
                                        class="glyphicon glyphicon-minus"></span></a>
                            </div>
                        </td>
                        <td class="cart_total">
                            <p id="price-<?= $good->goods->id ?>" class="cart_total_price">$<?= $good->price ?></p>
                        </td>
                        <td class="cart_delete" style="margin-right: 10px">
                            <a class="cart_quantity_delete" href="javascript:void(0);"
                               onclick="DeleteFromCart(<?= $good->goods->id ?>)"><i class="fa fa-times"></i></a>
                        </td>
                    </tr>
                <?php endforeach ?>


                </tbody>
            </table>


            <table class="table table-condensed total-table">
                <thead>
                <tr class="cart_menu">
                    <td class="image">Итого</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>

                </tr>
                <?php
                $i = 1;
                $Total = 0;
                ?>
                <?php if ($model): ?>
                    <?php foreach ($model as $good): ?>
                        <tr>
                            <td>
                                <?= $i++ ?>
                            </td>
                            <td>
                                <a href="/shop/detail?item=<?= $good->goods->id ?>"><img
                                        src="<?= '/upload/goods/' . $good->goods->image ?>" alt=""
                                        width="50px"></a>
                            </td>
                            <td>
                                <?= $good->goods->item ?>
                            </td>
                            <td>
                                <?= $good->quantity . ' ед.'; ?>
                            </td>
                            <td>
                                <?= '$' . $good->price ?>
                            </td>
                            <td>
                                <?= '$' . $good->quantity * $good->price ?>
                            </td>
                        </tr>
                        <?php $Total = $Total + ($good->quantity * $good->price); ?>

                    <?php endforeach ?>
                <?php endif ?>
                <tr>
                    <hr>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Итого:</td>
                    <td><?= '$' . $Total ?></td>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</section>

<div class="container" style="margin-bottom: 30px">
    <div class="row">
        <div class="col-sm-12 col-md-offset-5">
            <button type="button" class="btn btn-default get startorder" onclick="startOrderWindow()">Офoрмить заявку
            </button>
        </div>
    </div>
</div>


<section id="do_action" style="display: none">
    <div class="container">
        <div class="heading">
            <h3>Оформление заявки</h3>

        </div>
        <div class="row">
            <?php $form = ActiveForm::begin([
                'action' => '/shop/cart-form-submit'
            ]); ?>
            <?= $form->field($model_form, 'ip')->hiddenInput(['value' => yii::$app->session->id, 'class' => 'hidden'])->label(''); ?>
            <?= $form->field($model_form, 'created_at')->hiddenInput(['value' => time(), 'class' => 'hidden'])->label(''); ?>
            <div class="col-sm-6">
                <div class="chose_area">
                    <h5 class="header_title">Обьязательные поля </h5>
                    <ul class="user_info">
                        <label>Индекс:</label>
                        <?= $form->field($model_form, 'post_index')->textInput(['width' => '20px!important'])->label(''); ?>
                        <label>Страна:</label>
                        <?= $form->field($model_form, 'country_id')->dropDownList(ArrayHelper::map(GeoCountry::find()->where(['id' => ['20', '112', '113']])->all(), 'id', 'name_ru'), ['onchange' => 'getArrCities()', 'id' => 'country'])->label('') ?>
                        <label>Город:</label>
                        <?= $form->field($model_form, 'city_id')->dropDownList(ArrayHelper::map(GeoCity::find()->where(['country_id' => 20])->all(), 'id', 'name_ru'), ['id' => 'city'])->label('') ?>
                        <label>Улица:</label>
                        <?= $form->field($model_form, 'street')->textInput(['width' => '20px!important'])->label(''); ?>
                        <label>Имя:</label>
                        <?= $form->field($model_form, 'first_name')->label('') ?>
                        <label>Фамилия:</label>
                        <?= $form->field($model_form, 'second_name')->label('') ?>
                        <label>Отчество:</label>
                        <?= $form->field($model_form, 'ser_name')->label('') ?>
                        <label>Телефон:</label>
                        <?= $form->field($model_form, 'telephone')->label('') ?>
                    </ul>
                </div>
            </div>
            <?php if ($model): ?>

                <div class="col-sm-6 ">
                    <div class="total_area" style="padding-bottom: 43px !important;">
                        <h5 class="header_title">Дополнительные поля </h5>
                        <ul class="user_info">
                        <!--                        <ul>-->
                        <!--                            <li>Сумма покупки <span>-->
                        <? //= '$' . $Total ?><!--</span></li>-->
                        <!--                            <li>Почта <span>$100</span></li>-->
                        <!--                            <li>Доставка до дома <span>$50</span></li>-->
                        <!--                            <li>К оплате <span>$ -->
                        <? //= $Total + 150 ?><!-- </span></li>-->
                        <!--                        </ul>-->

                        <label>Ваши пожелания/коментарии:</label>
                        <?= $form->field($model_form, 'comment')->textarea(['row'=>6])->label('') ?>

<!--                        <label>Перезвонить мне:</label>-->
                        <?= $form->field($model_form, 'recall')->checkbox()->label('') ?>

                        <label>Зарегистрировать меня под логином :</label>
                        <?= $form->field($model_form, 'login')->textInput()->label('') ?>

                        <label>Зарегистрировать меня c паролем :</label>
                        <?= $form->field($model_form, 'password')->passwordInput()->label('') ?>
                        </ul>

                        <table width="90%" class="table-payment">
                            <th colspan="3">
                                <h5 class="header_title" style="margin-bottom: 20px;">Оплата</h5>
                            </th>
                            <tr>
                                <td>
                                    <input id="payment-post" class="radio-payment" type="radio" value="1"
                                           name="payment">
                                    <label class="to-right">На почте</label>
                                </td>
                                <td>
                                    <input id="payment-bank" class="radio-payment" type="radio" value="2"
                                           name="payment">
                                    <label class="to-right">Банковский перевод</label>
                                </td>
                                <td>
                                    <input id="payment-webmoney" class="radio-payment" type="radio" value="3"
                                           name="payment">
                                    <label class="to-right">Webmoney</label>
                                </td>
                            </tr>

                        </table>
                    </div>
                </div>
            <div class="col-sm-6 ">

                    <div class="chose_area">

                    <h5 style="margin-left: 37px;">На ваш электронный адрес будет выслана копия заказа, регистрационные данные, для входа в личный кабинет. Вы сможете отслеживания статус заказа.<h5>

              <?= Html::submitButton('Отправить заявку',['class'=>'btn btn-primary order-submit']); ?>


            </div>
            </div>
            <?php endif; ?>
            <?php ActiveForm::end(); ?>

        </div>
    </div>


    <?php else: ?>
        <div class="col-sm-6 col-md-offset-3">
            <div class="total_area">
                <ul>
                    <li style="text-align: center">Корзина пуста</li>

                </ul>
            </div>
        </div>


    <?php endif; ?>


    </div>
    </div>

    <?= Html::endForm(); ?>
</section>

<style>
    .glyphicon {
        margin-top: 5px;
    }

    .glyphicon:hover {
        color: #FE980F;
    }

    td, th {
        text-align: center;
    }

    .to-right {
        margin-left: 4px;
    }

    .table-payment {
        margin-left: 20px;
    }

    .radio-payment {
        margin-left: 42px !important;
    }

    .check_out {
        width: 100%;
    }

    .form-group {

        width: 477px;
        height: 30px;
    }

    .has-error input {
        border: 1px solid red;
        border-color: red;
        border-radius: 5px;
    }

    .header_title {
        margin-top: -10px;
        margin: 0px auto;
        width: 164px;
    }
    .total_area_right{
        border: 1px solid #E6E4DF;
        color: #696763;
        padding: 30px 25px 30px 40px;
        //margin-bottom: 80px;

    }
    #order-recall{
    //margin-top: 20px;
    position: absolute;
    left: -85px;
    }
    .field-order-comment{
        margin-bottom: 35px;
    }
    .help-block{
        margin: 0px!important;
        font-size: 10px!important;
    }
    .order-submit{
        background: #FE980F;
        border: 0 none;
        border-radius: 0;
        margin-top: 16px;
        vertical-align: middle;
        width: 91%!important;
        padding: 20px!important;
        margin-left: 36px!important;
    }
    .order-submit:hover{
    background-color: #A1D408;
    }
</style>