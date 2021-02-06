<?php

test('transactionlist command empty', function () {
    $this->artisan('transactionlist 4')
         ->expectsOutput('No transactions found for the Customer 4')
         ->assertExitCode(0);
});

test('transactionlist command ok', function () {
    $this->artisan('transactionlist 2')
		->expectsOutput('===============================================')
		->expectsOutput('Transaction\'s list for Customer 2')
		->expectsOutput('/---------------------------------------------\\')
		->expectsOutput('| Date - Value                                |')
		->expectsOutput('/---------------------------------------------\\')
		//->expectsOutput(' 02/04/2015 - €13.65') > Variable (rnd)
		->expectsOutput('\\---------------------------------------------/')
        ->assertExitCode(0);
});