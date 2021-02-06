<?php

namespace App\Commands;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;
use App\Controllers\TransactionListCtr;
use App\Controllers\CurrencyConverterCtr;
use App\Exceptions\EntityNotFoundException;
use App\Exceptions\UnexpectedValueException;

class TransactionList extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'transactionlist {customerId : Customer id (integer)}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Create a simple report showing transactions for a customer id';

    /**
     * Function called from the relative console command.
	 * Can be logically equivalent to the View, in MVC pattern
     */
    public function handle()
    {
		$lastErrorMsg = null;
		$reportWidth = 45;
		$defaultCurrency = "€";
		
		try
		{	
			//Based on "signature", the "name" argument is mandatory. Otherwise framework don't start the command
			$customerId = $this->argument('customerId');

			$controller = new TransactionListCtr();
			$converter = new CurrencyConverterCtr($defaultCurrency);	//implements iCurrencyConverter
			$transactionsList = $controller->getCustomerTransactions($customerId);

			if ($transactionsList != null && count($transactionsList) > 0)
			{
				//Display results
				
				$this->line("=".str_repeat("=", $reportWidth)."=");
				$this->info(str_replace('{customer}', strval($customerId), _SR('transactions_list')));
				$this->line("/".str_repeat("-", $reportWidth)."\\");
				
				
				$line = "| Date - Value";
				$this->info($line.str_repeat(" ", $reportWidth-strlen($line)+1)."|");
				
				
				$this->line("/".str_repeat("-", $reportWidth)."\\");
				
				foreach($transactionsList as $transaction)
				{
					$line = " ".toDateFormat($transaction->getDate());
					$line .= " - ";

					//NOTE: multiple call to the webservice can delay screen update (bad user experience)
					//It's possible to insert a local caching system, assuming that exchange rate don't change during the display of transactions
					try
					{
						$line .= $defaultCurrency.strval($converter->convert($transaction->getAmount(), $transaction->getCurrency()));
					}
					catch(\UnexpectedValueException $uve)
					{
						$line .= $transaction->getValue()." ["._SR('unsupported_currency')."]";
					}
	
					$this->line($line);
				}
				
				$this->line("\\".str_repeat("-", $reportWidth)."/");
			}
			else
				$this->info(str_replace('{customer}', strval($customerId), _SR('no_transactions_for_customer')));
		}
		catch (\InvalidArgumentException $iae)
		{
			\Log::info($iae->getMessage());
			$this->comment(_SR('invalid_missing_parameters').explode(' ', $this->signature)[0]);
			$lastErrorMsg = $iae->getMessage();
		}
		catch (EntityNotFoundException $enf)
		{
			\Log::info($enf->getMessage());
			$this->comment(_SR('entity_not_found'));
			$lastErrorMsg = $enf->getMessage();
		}		
		catch (\Exception $e) {
			if (!localEnv())
			{
				\Log::error($e->getMessage());
				$this->error(_SR('something_wrong'));
				$lastErrorMsg = $e->getMessage();
			}
			else
				throw $e;	//Only for debug purpose
        }
		finally 
		{
			if (localEnv() && $lastErrorMsg != null)
				$this->line($lastErrorMsg);
		}
    }

    /**
     * Define the command's schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     */
    public function schedule(Schedule $schedule)
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
