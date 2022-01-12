<?php

namespace Tests\Behavior\Addworking\Enterprise\Document;

use App\Models\Addworking\Enterprise\DocumentType;
use App\Models\Addworking\Enterprise\Enterprise;
use App\Models\Addworking\User\User;
use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Tests\Behavior\HasGivenAndThenStep;
use Tests\Behavior\RefreshDatabase;
use Tests\TestCase;

class AddDocTypeContext extends TestCase implements Context
{
    use RefreshDatabase, HasGivenAndThenStep;

    public function __construct()
    {
        parent::setUp();
    }

    /**
     * @Given les doc-types suivants existent
     */
    public function lesDocTypesSuivantsExistent()
    {
        $docInfo = factory(DocumentType::class)->state('informative')->create(['id' => "abc", 'name' => "doc-info"]);
    }

    /**
     * @Given je suis authentifié en tant que support
     */
    public function jeSuisAuthentifieEnTantQueSupport()
    {
        $user = factory(User::class)->state('support')->create();
        $this->context['user'] = $user;
    }

    /**
     * @Given une entreprise existe
     */
    public function uneEntrepriseExiste()
    {
        $enterprise = factory(Enterprise::class)->state('customer')->create();
        $this->context['enterprise'] = $enterprise;
    }

    /**
     * @When j'essaye de créer un nouveau doc-type de type informatif
     */
    public function jessayeDeCreerUnNouveauDocTypeDeTypeInformatif()
    {
        $this->actingAs($this->context['user'])
            ->post(
                "addworking/enterprise/{$this->context['enterprise']->id}/document-type",
                ['type' =>
                    [
                        'name' => "mask_paper",
                        'display_name' => "Fiche Masque",
                        'type' => "informative",
                        'is_mandatory' => false
                    ]
                ]
            );
    }

    /**
     * @Then je vois le doc-type dans la liste des doc-type de l'entreprise
     */
    public function jeVoisLeDocTypeDansLaListeDesDocTypeDeLentreprise()
    {
        $this->assertDatabaseHas(
            'addworking_enterprise_document_types',
            ['name' => "mask_paper"]
        );
    }
}
