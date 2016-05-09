<?php

$I = new FunctionalTester($scenario);
$I->wantTo('ensure that home page works');
$I->amOnPage(Yii::$app->homeUrl);
$I->see('TaZrum 4.0');
$I->seeLink('Ledenlijst');
$I->click('Ledenlijst');
$I->see('Woonplaats');
