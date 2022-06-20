<?php 

$I = new AcceptanceTester($scenario);
$I->wantTo('verify that the Place Sign Up page works for correct credentials');
$I->amOnPage('/Place/signup.html');
$I->fillField('name','CampusGreen5');
$I->fillField('email','CampusGreen4@hotmail.com');
$I->fillField('address','Bremen');
$I->fillField('password','testtest');
$I->click('Sign Up');

/// After successfully signing up

$I->seeInCurrentUrl('login-success');
$I->see('Successful');
$I->see('LOG OUT');

/// Check that logout button works

$I->click('LOG OUT');
$I->seeInCurrentUrl('index.html');
