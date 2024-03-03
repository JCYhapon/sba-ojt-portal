<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Company;

class RenewCompanies extends Command
{
    protected $signature = 'renew:companies';

    protected $description = 'Renew companies that have been created for more than 2 years';

    public function handle()
    {
        $companies = Company::all();

        foreach ($companies as $company) {
            $createdAt = $company->created_at;
            $diffInYears = $createdAt->diffInYears(now());

            if ($diffInYears >= 2) {
                $company->status = 2;
                $company->save();
            }
        }

        $this->info('Companies renewed successfully.');
    }
}
