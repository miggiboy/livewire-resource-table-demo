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

    public function setUp() :void
    {
        $this->withoutExceptionHandling();
    }

    /** @test */
    function can_render_resource_list()
    {
        $users = factory(User::class, 30)->create();

        Livewire::test(ResourceTable::class, [
                'resource' => 'users'
            ])
            ->assertSee($users[0]->name);
    }
}
