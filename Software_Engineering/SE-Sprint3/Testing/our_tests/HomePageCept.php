<?php 

$I = new AcceptanceTester($scenario);
$I->wantTo('verify that the homepage welcomes me');
$I->amOnPage('/'); // index.php
// $I->see('Welcome to Corona Archive');
$I->see('Welcome');