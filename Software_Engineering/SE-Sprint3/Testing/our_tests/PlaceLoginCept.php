<?php 

$I = new AcceptanceTester($scenario);
$I->wantTo('verify that the Place Login page works for correct credentials');
$I->amOnPage('/Place/login.html');
$I->fillField('email','test1@gmail.com');
$I->fillField('password','dyuqRN');
$I->click('CHECK CREDENTIALS');

/// After successfully logging in

$I->seeInCurrentUrl('login-success');
$I->see('Successful');
$I->see('LOG OUT');

/// Check that logout button works

$I->click('LOG OUT');
$I->seeInCurrentUrl('index.html');
