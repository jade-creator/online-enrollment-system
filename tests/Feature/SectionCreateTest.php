<?php

namespace Tests\Feature;

use App\Http\Livewire\Admin\SectionComponent\SectionViewComponent;
use App\Models;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;
use Livewire\Livewire;
use Tests\TestCase;

class SectionCreateTest extends TestCase
{
    protected  static $db_inited = false;

    protected  static function initDB()
    {
        echo "\n--initDB--\n";
        Artisan::call('migrate');
        Artisan::call('db:seed', ['--class' => 'SchoolTypeSeeder']);
        Artisan::call('db:seed', ['--class' => 'LevelSeeder']);
        Artisan::call('db:seed', ['--class' => 'ProgramSeeder']);
        Artisan::call('db:seed', ['--class' => 'TermSeeder']);
        Artisan::call('db:seed', ['--class' => 'CountrySeeder']);
        Artisan::call('db:seed', ['--class' => 'RoleSeeder']);
        Artisan::call('db:seed', ['--class' => 'AdminSeeder']);
    }

    public function setUp(): void
    {
        parent::setUp();
        Schema::disableForeignKeyConstraints();

        if (!static::$db_inited) {
            static::$db_inited = true;
            static::initDB();
        }
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    /** @test  */
    public function admin_can_create_section()
    {
        $this->actingAs(Models\User::with('role:id,name')
                ->whereHas('role', function ($query){
                    return $query->whereName('admin');
                })
                ->whereNotNull('person_id')
                ->first());

        Livewire::test(SectionViewComponent::class)
            ->set([
                'section.name' => 'TEST-1A',
                'section.room_id' => Models\Room::take(1)->first(),
                'section.seat' => 30,
            ])
//            ->assertSuccessful()
            ->call('save');

        $this->assertTrue(Models\Section::whereName('TEST-1A')->exists());
    }
}
