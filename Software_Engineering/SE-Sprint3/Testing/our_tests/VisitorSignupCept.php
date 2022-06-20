<?php 

$I = new AcceptanceTester($scenario);
$I->wantTo('verify that the Visitor Sign Up page works for correct credentials');
$I->amOnPage('/Visitor/signup.html');
$I->fillField('citizen_id','12236456789');
$I->fillField('first_name','TestCase');
$I->fillField('last_name','Doe');
$I->fillField('email','abcdef@hotmail.com');
$I->fillField('address','Bremen');
$I->fillField('phone_number','012999999');
$I->fillField('password','testtest');
$I->click('Sign Up');

/// After successfully signing up

$I->seeInCurrentUrl('login-success');
$I->see('Successful');
$I->see('LEAVE ARCHIVE');

/// Check that logout button works

$I->click('LEAVE ARCHIVE');
$I->seeInCurrentUrl('index.html');
