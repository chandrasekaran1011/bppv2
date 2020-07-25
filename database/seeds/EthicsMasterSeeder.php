<?php

use App\Models\Ethics\Mitigation;
use App\Models\Ethics\RedFlag;
use Illuminate\Database\Seeder;

class EthicsMasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RedFlag::create(['flag'=>'Business Partner has no ethics policy.']);
        RedFlag::create(['flag'=>'Business Partner is directly, or indirectly, owned or controlled by a government or governmental institution..']);
        RedFlag::create(['flag'=>'Business Partner has been sanctioned for corruption.']);
        RedFlag::create(['flag'=>'In case the Business Partner Questionnaire is not returned by the Business Partner.']);
        RedFlag::create(['flag'=>'Reputational risk (e.g., allegations related to integrity, such as a reputation for illegal, improper, or unethical conduct or the third party does not have in place an adequate compliance program or code of conduct or refuses to adopt one, etc.).']);
        RedFlag::create(['flag'=>'Government relationship (e.g., the third party has a family relationship with a foreign official, or government agency or a government official insists that a particular party, company, or individual be selected or engaged, particularly if the official has discretionary authority over the business at issue, etc.).']);
        RedFlag::create(['flag'=>'Insufficient capabilities (e.g., the third party is in a different line of business than that for which it has been engaged, the address of the third party’s business is a mail drop location, etc.).']);
        RedFlag::create(['flag'=>'Type and method of remuneration (e.g., remuneration unusually high compared to the market rate, etc.). This is very important as Systra must ensure that the compensation required/planned for a given business partner is arm’s length.']);
        RedFlag::create(['flag'=>'Other red flags (e.g., the third-party refuses to divulge the identity of its beneficial owners, directors, officers, or other principals, etc.)']);
    
        Mitigation::create(['mitigation'=>'We must be very careful to strictly abide by Ethics regulations and SYSTRA’s Ethics & Compliance Rules.']);
        Mitigation::create(['mitigation'=>'Ethics & right to audit clauses should be included in the contract agreement.']);
        Mitigation::create(['mitigation'=>'The business partner should be briefed in SYSTRA “Code of Ethics” (Ref : MO-292-01-EN) & “Code of Conduct – Anti Corruption”  (reference : DM-01706 EN). The same needs to be signed by the business partner.']);
        Mitigation::create(['mitigation'=>'Inform us immediately if they are the subject of future investigations or if any of their staff become sanctioned.']);
        Mitigation::create(['mitigation'=>'Implement the whistle blower policy under the JV.']);
        Mitigation::create(['mitigation'=>'The business partner should be briefed in SYSTRA “Code of Ethics” (Ref : MO-292-01-EN) & “Code of Conduct – Anti Corruption”  (reference : DM-01706 EN). Sign an undertaking that they will comply fully with the KYP forms and adhere to the SYSTRA “Code of Ethics ” & “Code of Conduct – Anti Corruption”.']);
        Mitigation::create(['mitigation'=>'Ethics & compliance and anti-corruption training should be given at the start of the project and in particular we have to make it clear that SYSTRA has a strong culture of Ethics and aspects such as bribery and gifts are not tolerated.']);
    }
}
