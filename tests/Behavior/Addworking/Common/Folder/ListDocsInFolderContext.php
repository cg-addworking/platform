<?php

namespace Tests\Behavior\Addworking\Common\Folder;

use App\Models\Addworking\Common\Folder;
use App\Models\Addworking\Enterprise\DocumentType;
use App\Models\Addworking\Enterprise\Enterprise;
use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Tests\Behavior\HasGivenAndThenStep;
use Tests\Behavior\RefreshDatabase;
use Tests\TestCase;

class ListDocsInFolderContext extends TestCase implements Context
{
    use RefreshDatabase, HasGivenAndThenStep;

    public function __construct()
    {
        parent::setUp();
    }

    /**
     * @Given les doc-info suivants existent
     */
    public function lesDocInfoSuivantsExistent()
    {
        $docInfo = factory(DocumentType::class)->state('informative')->create(['name' => "doc-info-1"]);
        $this->context['document'] = $docInfo;
    }

    /**
     * @Given je suis authentifié en tant que vendor
     */
    public function jeSuisAuthentifieEnTantQueVendor()
    {
        $customer = factory(Enterprise::class)->state('customer')->create();
        $vendor = factory(Enterprise::class)->state('vendor')->create();
        $customer->vendors()->attach($vendor);

        $this->context['customer'] = $customer;
        $this->context['vendor'] = $vendor;
    }

    /**
     * @Given j'ai un ou plusieurs customers
     */
    public function jaiUnOuPlusieursCustomers()
    {
        $this->assertDatabaseHas(
            'addworking_enterprise_enterprises_has_partners',
            ['vendor_id' => $this->context['vendor']->id,
            'customer_id' => $this->context['customer']->id]
        );
    }

    /**
     * @Given un dossier d'un customer existe
     */
    public function unDossierDunCustomerExiste()
    {
        $folder = factory(Folder::class)->create(
            ['name' => "covid_19",
            'display_name' => "COVID-19",
            'shared_with_vendors' => true]
        );

        $folder->enterprise()->associate($this->context['customer'])->save();

        $folder->link($this->context['document']);

        $this->context['folder'] = $folder;
    }

    /**
     * @When j'essaye de consulter le dossier de mon customer
     */
    public function jessayeDeConsulterLeDossierDeMonCustomer()
    {
        $this->actingAs($this->context['vendor']->users()->first())->get(
            "addworking/enterprise/{$this->context['vendor']->id}/folder/{$this->context['folder']->id}"
        );
    }

    /**
     * @Then je vois la liste des doc-info dans le dossier de mon customer
     */
    public function jeVoisLaListeDesDocInfoDansLeDossierDeMonCustomer()
    {
        $this->assertDatabaseHas(
            'addworking_common_folders_has_items',
            ["folder_id" => $this->context['folder']->id, "item_id" => $this->context['document']->id]
        );
    }
}
