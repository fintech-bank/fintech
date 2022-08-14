<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models\Cms{
/**
 * App\Models\Cms\CmsCategory
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Cms\CmsSubCategory[] $subcategories
 * @property-read int|null $subcategories_count
 * @method static \Illuminate\Database\Eloquent\Builder|CmsCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsCategory whereSlug($value)
 * @mixin \Eloquent
 */
	class IdeHelperCmsCategory {}
}

namespace App\Models\Cms{
/**
 * App\Models\Cms\CmsPage
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property mixed|null $content
 * @property int $publish
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $subcategory_id
 * @property-read \App\Models\Cms\CmsSubCategory $category
 * @method static \Illuminate\Database\Eloquent\Builder|CmsPage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsPage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsPage query()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsPage whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsPage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsPage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsPage wherePublish($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsPage whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsPage whereSubcategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsPage whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsPage whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperCmsPage {}
}

namespace App\Models\Cms{
/**
 * App\Models\Cms\CmsSubCategory
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property CmsSubCategory|null $parent
 * @property int|null $parent_id
 * @property int $cms_category_id
 * @property-read \App\Models\Cms\CmsCategory $category
 * @property-read \Illuminate\Database\Eloquent\Collection|CmsSubCategory[] $subcategories
 * @property-read int|null $subcategories_count
 * @method static \Illuminate\Database\Eloquent\Builder|CmsSubCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsSubCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsSubCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|CmsSubCategory whereCmsCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsSubCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsSubCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsSubCategory whereParent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsSubCategory whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CmsSubCategory whereSlug($value)
 * @mixin \Eloquent
 */
	class IdeHelperCmsSubCategory {}
}

namespace App\Models\Core{
/**
 * App\Models\Core\Agency
 *
 * @property int $id
 * @property string $name
 * @property string $bic
 * @property string $code_banque
 * @property string $code_agence
 * @property string $address
 * @property string $postal
 * @property string $city
 * @property string $country
 * @property string $phone
 * @property int $online
 * @property-read \Illuminate\Database\Eloquent\Collection|DocumentTransmiss[] $documents
 * @property-read int|null $documents_count
 * @property-read \Illuminate\Database\Eloquent\Collection|User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Agency newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Agency newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Agency query()
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereBic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereCodeAgence($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereCodeBanque($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency whereOnline($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Agency wherePostal($value)
 * @mixin \Eloquent
 */
	class IdeHelperAgency {}
}

namespace App\Models\Core{
/**
 * App\Models\Core\Bank
 *
 * @property int $id
 * @property int|null $bridge_id
 * @property string $name
 * @property string $logo
 * @property string $primary_color
 * @property string $country
 * @property string $bic
 * @property string $process_time
 * @property-read \Illuminate\Database\Eloquent\Collection|CustomerBeneficiaire[] $beneficiaires
 * @property-read int|null $beneficiaires_count
 * @method static \Illuminate\Database\Eloquent\Builder|Bank newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bank newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Bank query()
 * @method static \Illuminate\Database\Eloquent\Builder|Bank whereBic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bank whereBridgeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bank whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bank whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bank whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bank whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bank wherePrimaryColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Bank whereProcessTime($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerMobility[] $mobility
 * @property-read int|null $mobility_count
 */
	class IdeHelperBank {}
}

namespace App\Models\Core{
/**
 * App\Models\Core\DocumentCategory
 *
 * @property int $id
 * @property string $name
 * @property-read \Illuminate\Database\Eloquent\Collection|CustomerDocument[] $documents
 * @property-read int|null $documents_count
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentCategory whereName($value)
 * @mixin \Eloquent
 */
	class IdeHelperDocumentCategory {}
}

namespace App\Models\Core{
/**
 * App\Models\Core\EpargnePlan
 *
 * @property int $id
 * @property string $name
 * @property float $profit_percent
 * @property int $lock_days
 * @property int $profit_days
 * @property float $init
 * @property float $limit
 * @property-read \Illuminate\Database\Eloquent\Collection|CustomerEpargne[] $epargnes
 * @property-read int|null $epargnes_count
 * @method static \Illuminate\Database\Eloquent\Builder|EpargnePlan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EpargnePlan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EpargnePlan query()
 * @method static \Illuminate\Database\Eloquent\Builder|EpargnePlan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EpargnePlan whereInit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EpargnePlan whereLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EpargnePlan whereLockDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EpargnePlan whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EpargnePlan whereProfitDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EpargnePlan whereProfitPercent($value)
 * @mixin \Eloquent
 */
	class IdeHelperEpargnePlan {}
}

namespace App\Models\Core{
/**
 * App\Models\Core\LoanPlan
 *
 * @property int $id
 * @property string $name
 * @property float $minimum
 * @property float $maximum
 * @property int $duration En Mois
 * @property string|null $instruction
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Core\LoanPlanInterest[] $interests
 * @property-read int|null $interests_count
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPlan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPlan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPlan query()
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPlan whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPlan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPlan whereInstruction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPlan whereMaximum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPlan whereMinimum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPlan whereName($value)
 * @mixin \Eloquent
 */
	class IdeHelperLoanPlan {}
}

namespace App\Models\Core{
/**
 * App\Models\Core\LoanPlanInterest
 *
 * @property int $id
 * @property float $interest
 * @property int $duration En Mois
 * @property int $loan_plan_id
 * @property-read \App\Models\Core\LoanPlan $plan
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPlanInterest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPlanInterest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPlanInterest query()
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPlanInterest whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPlanInterest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPlanInterest whereInterest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoanPlanInterest whereLoanPlanId($value)
 * @mixin \Eloquent
 */
	class IdeHelperLoanPlanInterest {}
}

namespace App\Models\Core{
/**
 * App\Models\Core\Package
 *
 * @property int $id
 * @property string $name
 * @property float $price
 * @property string $type_prlv
 * @property int $visa_classic
 * @property int $check_deposit
 * @property int $payment_withdraw
 * @property int $overdraft
 * @property int $cash_deposit
 * @property int $withdraw_international
 * @property int $payment_international
 * @property int $payment_insurance
 * @property int $check
 * @property int $nb_carte_physique
 * @property int $nb_carte_virtuel
 * @method static \Illuminate\Database\Eloquent\Builder|Package newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Package newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Package query()
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereCashDeposit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereCheck($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereCheckDeposit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereNbCartePhysique($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereNbCarteVirtuel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereOverdraft($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package wherePaymentInsurance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package wherePaymentInternational($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package wherePaymentWithdraw($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereTypePrlv($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereVisaClassic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereWithdrawInternational($value)
 * @mixin \Eloquent
 * @property string $type_cpt
 * @property int $subaccount
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereSubaccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Package whereTypeCpt($value)
 */
	class IdeHelperPackage {}
}

namespace App\Models\Core{
/**
 * App\Models\Core\Service
 *
 * @property int $id
 * @property string $name
 * @property float $price
 * @property string $type_prlv
 * @property int|null $package_id
 * @property-read \App\Models\Core\Package|null $package
 * @method static \Illuminate\Database\Eloquent\Builder|Service newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Service newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Service query()
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service wherePackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereTypePrlv($value)
 * @mixin \Eloquent
 */
	class IdeHelperService {}
}

namespace App\Models\Core{
/**
 * App\Models\Core\Ticket
 *
 * @property int $id
 * @property string $subject
 * @property string $status
 * @property string $priority
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket query()
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperTicket {}
}

namespace App\Models\Core{
/**
 * App\Models\Core\TicketCategory
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|TicketCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TicketCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TicketCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|TicketCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketCategory whereUpdatedAt($value)
 */
	class IdeHelperTicketCategory {}
}

namespace App\Models\Core{
/**
 * App\Models\Core\TicketConversation
 *
 * @property int $id
 * @property string $message
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $agent_id
 * @property int $customer_id
 * @property int $ticket_id
 * @property-read User $agent
 * @property-read User $customer
 * @property-read \App\Models\Core\Ticket $ticket
 * @method static \Illuminate\Database\Eloquent\Builder|TicketConversation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TicketConversation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TicketConversation query()
 * @method static \Illuminate\Database\Eloquent\Builder|TicketConversation whereAgentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketConversation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketConversation whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketConversation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketConversation whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketConversation whereTicketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketConversation whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperTicketConversation {}
}

namespace App\Models\Core{
/**
 * App\Models\Core\TicketSubCategory
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|TicketSubCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TicketSubCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TicketSubCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|TicketSubCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketSubCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketSubCategory whereUpdatedAt($value)
 */
	class IdeHelperTicketSubCategory {}
}

namespace App\Models\Customer{
/**
 * App\Models\Customer\Customer
 *
 * @property int $id
 * @property string $status_open_account
 * @property int $cotation Cotation bancaire du client
 * @property string $auth_code
 * @property int $ficp
 * @property int $fcc
 * @property int|null $agent_id
 * @property int $user_id
 * @property int $package_id
 * @property int $agency_id
 * @property-read Agency|null $agency
 * @property-read User|null $agent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerBeneficiaire[] $beneficiaires
 * @property-read int|null $beneficiaires_count
 * @property-read \App\Models\Customer\CustomerSituationCharge|null $charge
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerDocument[] $documents
 * @property-read int|null $documents_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerEpargne[] $epargnes
 * @property-read int|null $epargnes_count
 * @property-read \App\Models\Customer\CustomerSituationIncome|null $income
 * @property-read \App\Models\Customer\CustomerInfo|null $info
 * @property-read Package $package
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerPret[] $prets
 * @property-read int|null $prets_count
 * @property-read \App\Models\Customer\CustomerSetting|null $setting
 * @property-read \App\Models\Customer\CustomerSituation|null $situation
 * @property-read \Illuminate\Database\Eloquent\Collection|DocumentTransmiss[] $transmisses
 * @property-read int|null $transmisses_count
 * @property-read User $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerWallet[] $wallets
 * @property-read int|null $wallets_count
 * @method static \Database\Factories\Customer\CustomerFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer query()
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereAgencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereAgentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereAuthCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereCotation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereFcc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereFicp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer wherePackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereStatusOpenAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Customer whereUserId($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerMobility[] $mobilities
 * @property-read int|null $mobilities_count
 */
	class IdeHelperCustomer {}
}

namespace App\Models\Customer{
/**
 * App\Models\Customer\CustomerBeneficiaire
 *
 * @property int $id
 * @property string $uuid
 * @property string $type
 * @property string|null $company
 * @property string|null $civility
 * @property string|null $firstname
 * @property string|null $lastname
 * @property string $currency
 * @property string $bankname
 * @property string $iban
 * @property string|null $bic
 * @property int $titulaire
 * @property int $customer_id
 * @property int $bank_id
 * @property-read Bank $bank
 * @property-read \App\Models\Customer\Customer $customer
 * @property-read mixed $full_name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerTransfer[] $transfers
 * @property-read int|null $transfers_count
 * @method static \Database\Factories\Customer\CustomerBeneficiaireFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerBeneficiaire newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerBeneficiaire newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerBeneficiaire query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerBeneficiaire whereBankId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerBeneficiaire whereBankname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerBeneficiaire whereBic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerBeneficiaire whereCivility($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerBeneficiaire whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerBeneficiaire whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerBeneficiaire whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerBeneficiaire whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerBeneficiaire whereIban($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerBeneficiaire whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerBeneficiaire whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerBeneficiaire whereTitulaire($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerBeneficiaire whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerBeneficiaire whereUuid($value)
 * @mixin \Eloquent
 */
	class IdeHelperCustomerBeneficiaire {}
}

namespace App\Models\Customer{
/**
 * App\Models\Customer\CustomerCheck
 *
 * @property int $id
 * @property string $reference
 * @property int $tranche_start
 * @property int $tranche_end
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $customer_wallet_id
 * @property-read \App\Models\Customer\CustomerWallet $wallet
 * @method static \Database\Factories\Customer\CustomerCheckFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheck newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheck newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheck query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheck whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheck whereCustomerWalletId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheck whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheck whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheck whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheck whereTrancheEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheck whereTrancheStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCheck whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperCustomerCheck {}
}

namespace App\Models\Customer{
/**
 * App\Models\Customer\CustomerCreditCard
 *
 * @property int $id
 * @property string $currency
 * @property string $exp_month
 * @property string $exp_year
 * @property string $number
 * @property string $status
 * @property string $type
 * @property string $support
 * @property string $debit
 * @property string $cvc
 * @property int $payment_internet
 * @property int $payment_abroad
 * @property int $payment_contact
 * @property string $code
 * @property float $limit_retrait
 * @property float $limit_payment
 * @property float $differed_limit
 * @property int $facelia
 * @property int $visa_spec
 * @property int $warranty
 * @property int $customer_wallet_id
 * @property int|null $customer_pret_id
 * @property-read \App\Models\Customer\CustomerFacelia|null $facelias
 * @property-read \App\Models\Customer\CustomerPret|null $pret
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerTransaction[] $transactions
 * @property-read int|null $transactions_count
 * @property-read \App\Models\Customer\CustomerWallet $wallet
 * @method static \Database\Factories\Customer\CustomerCreditCardFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereCustomerPretId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereCustomerWalletId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereCvc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereDebit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereDifferedLimit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereExpMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereExpYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereFacelia($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereLimitPayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereLimitRetrait($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard wherePaymentAbroad($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard wherePaymentContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard wherePaymentInternet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereSupport($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereVisaSpec($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditCard whereWarranty($value)
 * @mixin \Eloquent
 */
	class IdeHelperCustomerCreditCard {}
}

namespace App\Models\Customer{
/**
 * App\Models\Customer\CustomerCreditor
 *
 * @property int $id
 * @property string $name
 * @property int $opposit
 * @property int $customer_wallet_id
 * @property int $customer_sepa_id
 * @property-read \App\Models\Customer\CustomerSepa $sepa
 * @property-read \App\Models\Customer\CustomerWallet $wallet
 * @method static \Database\Factories\Customer\CustomerCreditorFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditor query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditor whereCustomerSepaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditor whereCustomerWalletId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditor whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerCreditor whereOpposit($value)
 * @mixin \Eloquent
 */
	class IdeHelperCustomerCreditor {}
}

namespace App\Models\Customer{
/**
 * App\Models\Customer\CustomerDocument
 *
 * @property int $id
 * @property string $name
 * @property string $reference
 * @property int $signable Le document est-il signable ?
 * @property int $signed_by_client Le document est signé par le client
 * @property int $signed_by_bank Le document est signé par la bank
 * @property string|null $code_sign
 * @property \Illuminate\Support\Carbon|null $signed_at Date de signature du document
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $customer_id
 * @property int $document_category_id
 * @property-read DocumentCategory $category
 * @property-read \App\Models\Customer\Customer $customer
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerDocument newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerDocument newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerDocument query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerDocument whereCodeSign($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerDocument whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerDocument whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerDocument whereDocumentCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerDocument whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerDocument whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerDocument whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerDocument whereSignable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerDocument whereSignedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerDocument whereSignedByBank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerDocument whereSignedByClient($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerDocument whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerDocument signedByClient()
 */
	class IdeHelperCustomerDocument {}
}

namespace App\Models\Customer{
/**
 * App\Models\Customer\CustomerEpargne
 *
 * @property int $id
 * @property string $uuid
 * @property string $reference
 * @property float $initial_payment
 * @property float $monthly_payment
 * @property int $monthly_days
 * @property int $wallet_id
 * @property int $wallet_payment_id
 * @property int $epargne_plan_id
 * @property-read \App\Models\Customer\CustomerWallet $payment
 * @property-read EpargnePlan $plan
 * @property-read \App\Models\Customer\CustomerWallet $wallet
 * @method static \Database\Factories\Customer\CustomerEpargneFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerEpargne newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerEpargne newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerEpargne query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerEpargne whereEpargnePlanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerEpargne whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerEpargne whereInitialPayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerEpargne whereMonthlyDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerEpargne whereMonthlyPayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerEpargne whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerEpargne whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerEpargne whereWalletId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerEpargne whereWalletPaymentId($value)
 * @mixin \Eloquent
 */
	class IdeHelperCustomerEpargne {}
}

namespace App\Models\Customer{
/**
 * App\Models\Customer\CustomerFacelia
 *
 * @property int $id
 * @property string $reference
 * @property float $amount_available
 * @property float $amount_interest
 * @property float $amount_du
 * @property float $mensuality
 * @property \Illuminate\Support\Carbon|null $next_expiration
 * @property int $wallet_payment_id
 * @property int $customer_pret_id
 * @property int|null $customer_credit_card_id
 * @property int $customer_wallet_id
 * @property-read \App\Models\Customer\CustomerCreditCard|null $card
 * @property-read \App\Models\Customer\CustomerWallet $payment
 * @property-read \App\Models\Customer\CustomerPret $pret
 * @property-read \App\Models\Customer\CustomerWallet $wallet
 * @method static \Database\Factories\Customer\CustomerFaceliaFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerFacelia newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerFacelia newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerFacelia query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerFacelia whereAmountAvailable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerFacelia whereAmountDu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerFacelia whereAmountInterest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerFacelia whereCustomerCreditCardId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerFacelia whereCustomerPretId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerFacelia whereCustomerWalletId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerFacelia whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerFacelia whereMensuality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerFacelia whereNextExpiration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerFacelia whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerFacelia whereWalletPaymentId($value)
 * @mixin \Eloquent
 */
	class IdeHelperCustomerFacelia {}
}

namespace App\Models\Customer{
/**
 * App\Models\Customer\CustomerInfo
 *
 * @property int $id
 * @property string $type
 * @property string|null $civility
 * @property string|null $firstname
 * @property string|null $middlename
 * @property string|null $lastname
 * @property \Illuminate\Support\Carbon|null $datebirth
 * @property string|null $citybirth
 * @property string|null $countrybirth
 * @property string|null $company
 * @property string|null $siret
 * @property string $address
 * @property string|null $addressbis
 * @property string $postal
 * @property string $city
 * @property string $country
 * @property string|null $phone
 * @property string $mobile
 * @property string|null $country_code
 * @property string|null $authy_id
 * @property int $isVerified
 * @property int $customer_id
 * @property-read \App\Models\Customer\Customer $customer
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\Customer\CustomerInfoFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereAddressbis($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereAuthyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereCitybirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereCivility($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereCountryCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereCountrybirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereDatebirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereIsVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereMiddlename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo wherePostal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereSiret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerInfo whereType($value)
 * @mixin \Eloquent
 */
	class IdeHelperCustomerInfo {}
}

namespace App\Models\Customer{
/**
 * App\Models\Customer\CustomerMobility
 *
 * @property int $id
 * @property string $status
 * @property string $old_iban
 * @property string|null $old_bic
 * @property string $mandate
 * @property \Illuminate\Support\Carbon $start
 * @property \Illuminate\Support\Carbon $end_prov
 * @property string|null $env_real
 * @property \Illuminate\Support\Carbon|null $end_prlv
 * @property int $close_account
 * @property string|null $comment
 * @property string|null $code
 * @property int $customer_id
 * @property int $bank_id
 * @property int $customer_wallet_id
 * @property-read \App\Models\Core\Bank $bank
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerMobilityCheque[] $cheques
 * @property-read int|null $cheques_count
 * @property-read \App\Models\Customer\Customer $customer
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerMobilityVirIncoming[] $incomings
 * @property-read int|null $incomings_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerMobilityVirOutgoing[] $outgoings
 * @property-read int|null $outgoings_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerMobilityPrlv[] $prlvs
 * @property-read int|null $prlvs_count
 * @property-read \App\Models\Customer\CustomerWallet $wallet
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobility newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobility newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobility query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobility whereBankId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobility whereCloseAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobility whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobility whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobility whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobility whereCustomerWalletId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobility whereEndPrlv($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobility whereEndProv($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobility whereEnvReal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobility whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobility whereMandate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobility whereOldBic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobility whereOldIban($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobility whereStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobility whereStatus($value)
 */
	class IdeHelperCustomerMobility {}
}

namespace App\Models\Customer{
/**
 * App\Models\Customer\CustomerMobilityCheque
 *
 * @property-read \App\Models\Customer\CustomerMobility|null $mobility
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityCheque newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityCheque newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityCheque query()
 * @mixin \Eloquent
 */
	class IdeHelperCustomerMobilityCheque {}
}

namespace App\Models\Customer{
/**
 * App\Models\Customer\CustomerMobilityPrlv
 *
 * @property-read \App\Models\Customer\CustomerMobility|null $mobility
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityPrlv newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityPrlv newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityPrlv query()
 * @mixin \Eloquent
 */
	class IdeHelperCustomerMobilityPrlv {}
}

namespace App\Models\Customer{
/**
 * App\Models\Customer\CustomerMobilityVirIncoming
 *
 * @property-read \App\Models\Customer\CustomerMobility|null $mobility
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityVirIncoming newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityVirIncoming newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityVirIncoming query()
 * @mixin \Eloquent
 */
	class IdeHelperCustomerMobilityVirIncoming {}
}

namespace App\Models\Customer{
/**
 * App\Models\Customer\CustomerMobilityVirOutgoing
 *
 * @property-read \App\Models\Customer\CustomerMobility|null $mobility
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityVirOutgoing newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityVirOutgoing newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerMobilityVirOutgoing query()
 * @mixin \Eloquent
 */
	class IdeHelperCustomerMobilityVirOutgoing {}
}

namespace App\Models\Customer{
/**
 * App\Models\Customer\CustomerPret
 *
 * @property int $id
 * @property string $uuid
 * @property string $reference
 * @property float $amount_loan Montant du crédit demander
 * @property float $amount_interest Montant des interet du par le client
 * @property float $amount_du Total des sommes du par le client (Credit + Interet - mensualités payé)
 * @property float $mensuality Mensualité du par le client par mois
 * @property int $prlv_day Jours du prélèvement de la mensualité
 * @property int $duration Durée total du contrat en année
 * @property string $status
 * @property int $signed_customer
 * @property int $signed_bank
 * @property int $alert
 * @property string $assurance_type
 * @property int $customer_wallet_id
 * @property int $wallet_payment_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $first_payment_at
 * @property int $loan_plan_id
 * @property int $customer_id
 * @property-read \App\Models\Customer\CustomerCreditCard|null $card
 * @property-read \App\Models\Customer\Customer $customer
 * @property-read \App\Models\Customer\CustomerFacelia|null $facelia
 * @property-read \App\Models\Customer\CustomerWallet $payment
 * @property-read LoanPlan $plan
 * @property-read \App\Models\Customer\CustomerWallet $wallet
 * @method static \Database\Factories\Customer\CustomerPretFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereAlert($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereAmountDu($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereAmountInterest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereAmountLoan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereAssuranceType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereCustomerWalletId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereFirstPaymentAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereLoanPlanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereMensuality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret wherePrlvDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereSignedBank($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereSignedCustomer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereUuid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerPret whereWalletPaymentId($value)
 * @mixin \Eloquent
 */
	class IdeHelperCustomerPret {}
}

namespace App\Models\Customer{
/**
 * App\Models\Customer\CustomerRefundAccount
 *
 * @property int $id
 * @property string $stripe_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $customer_wallet_id
 * @property-read \App\Models\Customer\CustomerWallet $wallet
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerRefundAccount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerRefundAccount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerRefundAccount query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerRefundAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerRefundAccount whereCustomerWalletId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerRefundAccount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerRefundAccount whereStripeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerRefundAccount whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperCustomerRefundAccount {}
}

namespace App\Models\Customer{
/**
 * App\Models\Customer\CustomerSepa
 *
 * @property int $id
 * @property string $uuid
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerCreditor[] $creditor
 * @property string $number_mandate
 * @property float $amount
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $transaction_id
 * @property int $customer_wallet_id
 * @property-read int|null $creditor_count
 * @property-read \App\Models\Customer\CustomerWallet $wallet
 * @method static \Database\Factories\Customer\CustomerSepaFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSepa newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSepa newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSepa query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSepa whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSepa whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSepa whereCreditor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSepa whereCustomerWalletId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSepa whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSepa whereNumberMandate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSepa whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSepa whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSepa whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSepa whereUuid($value)
 * @mixin \Eloquent
 */
	class IdeHelperCustomerSepa {}
}

namespace App\Models\Customer{
/**
 * App\Models\Customer\CustomerSetting
 *
 * @property int $id
 * @property int $notif_sms
 * @property int $notif_app
 * @property int $notif_mail
 * @property int $nb_physical_card
 * @property int $nb_virtual_card
 * @property int $check
 * @property int $customer_id
 * @property-read \App\Models\Customer\Customer $customer
 * @method static \Database\Factories\Customer\CustomerSettingFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSetting whereCheck($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSetting whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSetting whereNbPhysicalCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSetting whereNbVirtualCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSetting whereNotifApp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSetting whereNotifMail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSetting whereNotifSms($value)
 * @mixin \Eloquent
 */
	class IdeHelperCustomerSetting {}
}

namespace App\Models\Customer{
/**
 * App\Models\Customer\CustomerSituation
 *
 * @property int $id
 * @property string|null $legal_capacity
 * @property string|null $family_situation
 * @property string|null $logement
 * @property \Illuminate\Support\Carbon $logement_at
 * @property int $child
 * @property int $person_charged
 * @property string|null $pro_category
 * @property string|null $pro_category_detail
 * @property string|null $pro_profession
 * @property int $customer_id
 * @property-read \App\Models\Customer\Customer $customer
 * @method static \Database\Factories\Customer\CustomerSituationFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituation query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituation whereChild($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituation whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituation whereFamilySituation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituation whereLegalCapacity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituation whereLogement($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituation whereLogementAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituation wherePersonCharged($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituation whereProCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituation whereProCategoryDetail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituation whereProProfession($value)
 * @mixin \Eloquent
 */
	class IdeHelperCustomerSituation {}
}

namespace App\Models\Customer{
/**
 * App\Models\Customer\CustomerSituationCharge
 *
 * @property int $id
 * @property float $rent Loyer, Pret Immobilier, etc...
 * @property int $nb_credit Nombre de crédit actuel
 * @property float $credit Valeur total des mensualité de crédit
 * @property float $divers Autres charges (pension, etc...)
 * @property int $customer_id
 * @property-read \App\Models\Customer\Customer $customer
 * @method static \Database\Factories\Customer\CustomerSituationChargeFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituationCharge newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituationCharge newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituationCharge query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituationCharge whereCredit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituationCharge whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituationCharge whereDivers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituationCharge whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituationCharge whereNbCredit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituationCharge whereRent($value)
 * @mixin \Eloquent
 */
	class IdeHelperCustomerSituationCharge {}
}

namespace App\Models\Customer{
/**
 * App\Models\Customer\CustomerSituationIncome
 *
 * @property int $id
 * @property float $pro_incoming Revenue Salarial, Aide état RSA, etc...
 * @property float $patrimoine Revenue Mensuel du patrimoine
 * @property int $customer_id
 * @property-read \App\Models\Customer\Customer $customer
 * @method static \Database\Factories\Customer\CustomerSituationIncomeFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituationIncome newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituationIncome newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituationIncome query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituationIncome whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituationIncome whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituationIncome wherePatrimoine($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerSituationIncome whereProIncoming($value)
 * @mixin \Eloquent
 */
	class IdeHelperCustomerSituationIncome {}
}

namespace App\Models\Customer{
/**
 * App\Models\Customer\CustomerTransaction
 *
 * @property int $id
 * @property string $uuid
 * @property string $type
 * @property string $designation
 * @property string|null $description
 * @property float $amount
 * @property int $confirmed
 * @property int $differed
 * @property \Illuminate\Support\Carbon|null $confirmed_at
 * @property \Illuminate\Support\Carbon|null $differed_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $customer_wallet_id
 * @property int|null $customer_credit_card_id
 * @property-read \App\Models\Customer\CustomerCreditCard|null $card
 * @property-read \App\Models\Customer\CustomerWallet $wallet
 * @method static \Database\Factories\Customer\CustomerTransactionFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransaction query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransaction whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransaction whereConfirmed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransaction whereConfirmedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransaction whereCustomerCreditCardId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransaction whereCustomerWalletId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransaction whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransaction whereDesignation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransaction whereDiffered($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransaction whereDifferedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransaction whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransaction whereUuid($value)
 * @mixin \Eloquent
 */
	class IdeHelperCustomerTransaction {}
}

namespace App\Models\Customer{
/**
 * App\Models\Customer\CustomerTransfer
 *
 * @property int $id
 * @property string $uuid
 * @property float $amount
 * @property string $reference
 * @property string $reason
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $transfer_date
 * @property \Illuminate\Support\Carbon|null $recurring_start
 * @property \Illuminate\Support\Carbon|null $recurring_end
 * @property string $status
 * @property int|null $transaction_id
 * @property int $customer_wallet_id
 * @property int $customer_beneficiaire_id
 * @property-read \App\Models\Customer\CustomerBeneficiaire $beneficiaire
 * @property-read \App\Models\Customer\CustomerWallet $wallet
 * @method static \Database\Factories\Customer\CustomerTransferFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransfer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransfer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransfer query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransfer whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransfer whereCustomerBeneficiaireId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransfer whereCustomerWalletId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransfer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransfer whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransfer whereRecurringEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransfer whereRecurringStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransfer whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransfer whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransfer whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransfer whereTransferDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransfer whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerTransfer whereUuid($value)
 * @mixin \Eloquent
 */
	class IdeHelperCustomerTransfer {}
}

namespace App\Models\Customer{
/**
 * App\Models\Customer\CustomerWallet
 *
 * @property int $id
 * @property string $uuid
 * @property string $number_account
 * @property string $iban
 * @property string $rib_key
 * @property string $type
 * @property string $status
 * @property float $balance_actual
 * @property float $balance_coming
 * @property int $decouvert
 * @property float $balance_decouvert
 * @property int $alert_debit
 * @property int $alert_fee
 * @property \Illuminate\Support\Carbon|null $alert_date
 * @property int $customer_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerCreditCard[] $cards
 * @property-read int|null $cards_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerCheck[] $checks
 * @property-read int|null $checks_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerCreditor[] $creditors
 * @property-read int|null $creditors_count
 * @property-read \App\Models\Customer\Customer $customer
 * @property-read \App\Models\Customer\CustomerEpargne|null $epargne
 * @property-read \App\Models\Customer\CustomerEpargne|null $epargne_payment
 * @property-read \App\Models\Customer\CustomerFacelia|null $facelia
 * @property-read \App\Models\Customer\CustomerPret|null $loan
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerRefundAccount[] $refunds
 * @property-read int|null $refunds_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerSepa[] $sepas
 * @property-read int|null $sepas_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerTransaction[] $transactions
 * @property-read int|null $transactions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Customer\CustomerTransfer[] $transfers
 * @property-read int|null $transfers_count
 * @method static \Database\Factories\Customer\CustomerWalletFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWallet newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWallet newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWallet query()
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWallet whereAlertDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWallet whereAlertDebit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWallet whereAlertFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWallet whereBalanceActual($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWallet whereBalanceComing($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWallet whereBalanceDecouvert($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWallet whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWallet whereDecouvert($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWallet whereIban($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWallet whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWallet whereNumberAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWallet whereRibKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWallet whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWallet whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CustomerWallet whereUuid($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Customer\CustomerMobility|null $mobility
 */
	class IdeHelperCustomerWallet {}
}

namespace App\Models\Document{
/**
 * App\Models\Document\DocumentTransmiss
 *
 * @property int $id
 * @property string $type_document
 * @property string|null $commentaire
 * @property int $file_transfered
 * @property \Illuminate\Support\Carbon|null $date_transmiss
 * @property string|null $file_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $agency_id
 * @property int $customer_id
 * @property-read Agency $agency
 * @property-read Customer $customer
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentTransmiss newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentTransmiss newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentTransmiss query()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentTransmiss whereAgencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentTransmiss whereCommentaire($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentTransmiss whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentTransmiss whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentTransmiss whereDateTransmiss($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentTransmiss whereFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentTransmiss whereFileTransfered($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentTransmiss whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentTransmiss whereTypeDocument($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentTransmiss whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperDocumentTransmiss {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property string|null $two_factor_confirmed_at
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $admin
 * @property int $agent
 * @property int $customer
 * @property string|null $identifiant
 * @property string|null $last_seen
 * @property int|null $agency_id
 * @property-read Agency|null $agency
 * @property-read Customer|null $customers
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read Package|null $package
 * @property-read \Illuminate\Database\Eloquent\Collection|\NotificationChannels\WebPush\PushSubscription[] $pushSubscriptions
 * @property-read int|null $push_subscriptions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|TicketConversation[] $ticket
 * @property-read int|null $ticket_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAgencyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAgent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCustomer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIdentifiant($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastSeen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorConfirmedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorRecoveryCodes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTwoFactorSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class IdeHelperUser {}
}

