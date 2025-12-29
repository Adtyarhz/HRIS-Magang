<?php

namespace Database\Seeders;

use App\Models\Position;
use App\Models\Division;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Position::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $divisions = Division::pluck('id', 'name');

        $positions = [
            // ====================
            // TOP MANAGEMENT
            // ====================
            ['title' => 'RUPS'],
            ['title' => 'President Director', 'division' => 'Board of Directors'],
            ['title' => 'President Commissioner', 'division' => 'Board of Commissioners'],
            ['title' => 'Commissioner', 'division' => 'Board of Commissioners'],

            // ====================
            // DIRECTORS & MANAGERS
            // ====================
            ['title' => 'Business Director', 'division' => 'Board of Directors'],
            ['title' => 'Operation Manager', 'division' => 'Operation'],
            ['title' => 'HC & GA Manager', 'division' => 'HC & GA'],
            ['title' => 'IT Manager', 'division' => 'IT'],
            ['title' => 'Internal Audit Manager', 'division' => 'Internal Audit'],
            ['title' => 'Brand & Promotion Manager', 'division' => 'Brand & Promotion'],
            ['title' => 'Funding Manager', 'division' => 'Funding'],
            ['title' => 'Loan Manager 1', 'division' => 'Lending'],
            ['title' => 'Loan Manager 2', 'division' => 'Lending'],
            ['title' => 'Branch Manager', 'division' => 'Branch Office'],
            ['title' => 'Credit Analyst Sc. Head', 'division' => 'Credit Analyst'],

            // ====================
            // STAFF & OFFICER
            // ====================
            ['title' => 'Credit Analyst Officer', 'division' => 'Credit Analyst'],
            ['title' => 'Internal Audit Officer', 'division' => 'Internal Audit'],
            ['title' => 'Research & Development Officer', 'division' => 'Research & Development'],

            // IT
            ['title' => 'IT Support Officer', 'division' => 'IT'],
            ['title' => 'IT Developer', 'division' => 'IT'],
            ['title' => 'IT DevSecOps', 'division' => 'IT'],
            ['title' => 'Data Analyst', 'division' => 'IT'],

            // BRANDING
            ['title' => 'Brand & Promotion Officer', 'division' => 'Brand & Promotion'],

            // KMA
            ['title' => 'PE KMA, SAF, IP', 'division' => 'KMA, SAF, IP'],
            ['title' => 'KMA, SAF, IP Officer', 'division' => 'KMA, SAF, IP'],

            // OPERATION
            ['title' => 'Accounting Officer', 'division' => 'Operation'],
            ['title' => 'Loan Admin Officer', 'division' => 'Operation'],
            ['title' => 'Teller', 'division' => 'Operation'],
            ['title' => 'Customer Service', 'division' => 'Operation'],
            ['title' => 'Frontliner MKK', 'division' => 'Operation'],
            ['title' => 'Legal & Appraiser Officer', 'division' => 'Operation'],
            ['title' => 'Cash Office Head', 'division' => 'Operation'],

            // FUNDING
            ['title' => 'Relationship Manager Funding (Commercial)', 'division' => 'Funding'],
            ['title' => 'Relationship Manager Funding (Retail)', 'division' => 'Funding'],

            // HC & GA
            ['title' => 'Talent Acquisition & Development Officer', 'division' => 'HC & GA'],
            ['title' => 'HC Administration & Compliance Officer', 'division' => 'HC & GA'],
            ['title' => 'General Affair Officer', 'division' => 'HC & GA'],
            ['title' => 'Office Boy', 'division' => 'HC & GA'],
            ['title' => 'Security', 'division' => 'HC & GA'],
            ['title' => 'Driver', 'division' => 'HC & GA'],

            // BRANCH
            ['title' => 'Teller (Branch)', 'division' => 'Branch Office'],
            ['title' => 'Customer Service (Branch)', 'division' => 'Branch Office'],
            ['title' => 'Loan Admin Officer (Branch)', 'division' => 'Branch Office'],
            ['title' => 'Accounting Officer (Branch)', 'division' => 'Branch Office'],
            ['title' => 'Collection Officer (Branch)', 'division' => 'Branch Office'],
            ['title' => 'Relationship Manager Lending (Branch)', 'division' => 'Branch Office'],
            ['title' => 'Relationship Manager Funding (Branch)', 'division' => 'Branch Office'],

            // LENDING
            ['title' => 'Credit Review & Monitoring Officer', 'division' => 'Lending'],
            ['title' => 'Relationship Manager Lending (Loan 1)', 'division' => 'Lending'],
            ['title' => 'Collection Officer (Loan 1)', 'division' => 'Lending'],
            ['title' => 'Relationship Manager Lending (Loan 2)', 'division' => 'Lending'],
            ['title' => 'Collection Officer (Loan 2)', 'division' => 'Lending'],
        ];

        foreach ($positions as $position) {
            Position::create([
                'title' => $position['title'],
                'division_id' => isset($position['division'])
                    ? ($divisions[$position['division']] ?? null)
                    : null,
            ]);
        }

    }
}
