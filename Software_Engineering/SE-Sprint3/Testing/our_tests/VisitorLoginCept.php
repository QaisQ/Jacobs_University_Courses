<?php 

$I = new AcceptanceTester($scenario);
$I->wantTo('verify that the Visitor Login page works for correct credentials');
$I->amOnPage('/Visitor/login.html');
$I->fillField('citizen_id','CC3UDS1R7IB');
$I->fillField('password','q7zhg9');
$I->click('CHECK CREDENTIALS');

/// After successfully logging in

// $I->seeInCurrentUrlEquals('/~jbako/Visitor/login-success.html');
// $I->see('Successfully Entered Archive');
$I->seeInCurrentUrl('login-success');
$I->see('Successful');
$I->see('LEAVE ARCHIVE');

/// Check that logout button works

$I->click('LEAVE ARCHIVE');
$I->seeInCurrentUrl('index.html');
