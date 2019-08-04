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
            ->table([
                'resource' => 'users',
                'columns' => [ 'name' => 'name', ]
            ])
            ->assertSee($this->users[0]->name);
    }

    /** @test */
    function resource_limit_defaults_to_10()
    {
        $this->users->take(10)->each(function ($user) {
            $this
                ->table([
                    'resource' => 'users',
                    'columns' => [ 'name' => 'name', ]
                ])
                ->assertSee($user->name);
        });

        $this->users->slice(10)->take(20)->each(function ($user) {
            $this
                ->table([
                    'resource' => 'users',
                    'columns' => [ 'name' => 'name', ]
                ])
                ->assertDontSee($user->name);
        });
    }

    /** @test */
    function it_can_render_specific_fields()
    {
        $this->users->take(10)->each(function ($user) {
            $this
                ->table([
                    'resource' => 'users',
                    'columns' => [ 'id' => 'id', 'name' => 'name', ]
                ])
                ->assertSee($user->id)
                ->assertSee($user->name);
        });
    }

    /** @test */
    function it_can_render_next_set_of_resources_when_next_button_is_clicked()
    {
        $table = $this
            ->table([
                'resource' => 'users',
                'columns' => [ 'name' => 'name', ]
            ]);

        // $table->click('[wire:click="next"]'); Why this doesn't work?
        $table->call('next');

        $this->users->take(10)->each(function ($user) use ($table) {
            $table->assertDontSee($user->name);
        });

        $this->users->slice(10)->take(10)->each(function ($user) use ($table) {
            $table->assertSee($user->name);
        });
    }

    /** @test */
    function doesnt_do_anything_when_next_button_is_clicked_if_last_set_of_results_is_being_displayed()
    {
        $table = $this
            ->table([
                'resource' => 'users',
                'columns' => [ 'name' => 'name', ]
            ])
            ->call('next') // 10 - 20
            ->call('next'); // 20 - 30

        $this->users->slice(20)->take(10)->each(function ($user) use ($table) {
            $table->assertSee($user->name);
        });

        $table->call('next');

        $this->users->slice(20)->take(10)->each(function ($user) use ($table) {
            $table->assertSee($user->name);
        });
    }

    /** @test */
    function it_can_render_previous_set_of_resources_when_previous_button_is_clicked()
    {
        $table = $this
            ->table([
                'resource' => 'users',
                'columns' => [ 'name' => 'name', ]
            ]);

        $table->call('next'); // 10 - 20

        $this->users->slice(10)->take(10)->each(function ($user) use ($table) {
            $table->assertSee($user->name);
        });

        $table->call('previous'); // 0 - 10

        $this->users->slice(10)->take(10)->each(function ($user) use ($table) {
            $table->assertDontSee($user->name);
        });

        $this->users->slice(0)->take(10)->each(function ($user) use ($table) {
            $table->assertSee($user->name);
        });
    }

    /** @test */
    function doesnt_do_anything_when_previous_button_is_clicked_if_first_set_of_results_is_displayed()
    {
        $table = $this
            ->table([
                'resource' => 'users',
                'columns' => [ 'name' => 'name', ]
            ])
            ->call('previous');

        $this->users->take(10)->each(function ($user) use ($table) {
            $table->assertSee($user->name);
        });

        $table->call('next');

        $this->users->slice(10)->take(10)->each(function ($user) use ($table) {
            $table->assertSee($user->name);
        });
    }

    protected function table($options)
    {
        return Livewire::test(ResourceTable::class, $options);
    }
}
