<?php

namespace Tests\Unit\App\Http\Controllers\Sogetrel\User;

use App\Models\Addworking\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class PassworkSavedSearchControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        $user = factory(User::class)->state('support')->create();
        $response = $this->actingAs($user)->get('/sogetrel/saved_search');

        $response->assertViewIs('sogetrel.user.passwork_saved_search.index');
    }

    /**
     * @dataProvider passworkSavedSearchFormData
     */
    public function testStore($data)
    {
        $user = factory(User::class)->states('support')->create();

        $this->assertDatabaseMissing(
            'sogetrel_user_passwork_saved_searches',
            ['search' => json_encode($data["search"])]
        );

        $this->actingAs($user)->post(
            'sogetrel/saved_search',
            $data
        );

        $this->assertDatabaseHas(
            'sogetrel_user_passwork_saved_searches',
            ['search' => json_encode($data["search"])]
        );
    }

    /**
     * @dataProvider passworkSavedSearchFormData
     */
    public function testDestroy($data)
    {
        $user = factory(User::class)->states('support')->create();

        $this->actingAs($user)->post(
            'sogetrel/saved_search',
            $data
        );

        $this->assertDatabaseHas('sogetrel_user_passwork_saved_searches', ['search' => json_encode($data["search"])]);

        $saved_search = DB::table('sogetrel_user_passwork_saved_searches')->first();
        $this->actingAs($user)->delete('sogetrel/saved_search/' . $saved_search->id);

        $this->assertDatabaseMissing(
            'sogetrel_user_passwork_saved_searches',
            ['search' => json_encode($data["search"])]
        );
    }

    /**
     * @dataProvider passworkSavedSearchFormData
     */
    public function testSchedule($data)
    {
        $user = factory(User::class)->states('support')->create();

        $this->actingAs($user)->post(
            'sogetrel/saved_search',
            $data
        );

        $saved_search = DB::table('sogetrel_user_passwork_saved_searches')->first();

        $data = [
            "email" => "email@@test.com",
            "frequency" => "7"
        ];

        $this->assertDatabaseMissing('sogetrel_user_passwork_saved_scheduled_searches', $data);

        $response = $this->actingAs($user)->post(
            'sogetrel/saved_search/' . $saved_search->id . '/schedule',
            $data
        );

        $this->assertDatabaseHas('sogetrel_user_passwork_saved_scheduled_searches', $data);
        $response->assertRedirect('sogetrel/saved_search');
    }

    public function passworkSavedSearchFormData()
    {
        return [
            "passwork_saved_search" => [
                "data" => [
                    "search" => [
                        "electrician" => "1",
                        "multi_activities" => null,
                        "civil_engineering" => null,
                        "engineering_office" => null,
                        "flag_contacted" => null,
                        "flag_parking" => null,
                        "name" => null,
                        "enterprise" => null,
                    ],
                    "name" => "test de recherche",
                ]
            ]
        ];
    }
}
