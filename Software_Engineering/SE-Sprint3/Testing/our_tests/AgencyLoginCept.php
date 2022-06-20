<?php 

$I = new AcceptanceTester($scenario);
$I->wantTo('verify that the Agency Login page works for correct credentials');
$I->amOnPage('/Agency/login.html');
$I->fillField('email','b.howells@hotmail.com');
$I->fillField('password','VJjcSkKe');
$I->click('Login');

/// After successfully logging in

$I->seeInCurrentUrl('login-success');
$I->see('Dashboard');
$I->see('Search');

// /// Check that logout button works

// $I->click('LOG OUT');
// $I->seeInCurrentUrl('index.html');
