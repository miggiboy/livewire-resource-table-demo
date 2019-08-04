<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Livewire\Livewire;
use App\Http\Livewire\ResourceTable;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ResourceTableTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public $users;

    public function setUp() :void
    {
        parent::setUp();

        $this->withoutExceptionHandling();

        $this->users = factory(User::class, 30)->create();
    }

    /** @test */
    function can_render_resource_list()
    {
        $this
            ->table([ 'resource' => 'users' ])
            ->assertSee($this->users[0]->name);
    }

    /** @test */
    function resource_limit_defaults_to_10()
    {
        $this->users->take(10)->each(function ($user) {
            $this
                ->table([ 'resource' => 'users' ])
                ->assertSee($user->name);
        });

        $this->users->reverse()->take(20)->each(function ($user) {
            $this
                ->table([ 'resource' => 'users' ])
                ->assertDontSee($user->name);
        });
    }

    protected function table($options)
    {
        return Livewire::test(ResourceTable::class, $options);
    }
}
