<?php 

$I = new AcceptanceTester($scenario);
$I->wantTo('verify that the Hospital Login page works for correct credentials');
$I->amOnPage('/Hospital/login.html');
$I->fillField('email','alpha@hotmail.com');
$I->fillField('password','tSVvYTDc');
$I->click('Login');

/// After successfully logging in

$I->seeInCurrentUrl('login-success');
$I->see('Visitor Details');


// /// Check that logout button works

// $I->click('LOG OUT');
// $I->seeInCurrentUrl('index.html');
