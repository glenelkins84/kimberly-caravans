<?php

namespace Tests\Feature\Admin\CaravanRange\RangeSpecificationSmallPrint;

use App\Models\CaravanRange;
use App\Models\RangeSpecificationSmallPrint;
use App\Models\Site;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider requiredValidationProvider
     */
    public function test_required_validation(string $inputName): void
    {
        $data = $this->validData([
            $inputName => null,
        ]);

        $response = $this->submit($data);

        $response->assertSessionHasErrors($inputName);
    }

    public function requiredValidationProvider(): array
    {
        return [
            ['name'],
            ['content'],
        ];
    }

    /**
     * @dataProvider existsValidationProvider
     */
    public function test_exists_validation(string $inputName): void
    {
        $data = $this->validData([
            $inputName => 0,
        ]);

        $response = $this->submit($data);

        $response->assertSessionHasErrors($inputName);
    }

    public function existsValidationProvider(): array
    {
        return [
            ['site_id'],
        ];
    }

    public function test_name_is_unique_validation(): void
    {
        $otherSmallPrint = factory(RangeSpecificationSmallPrint::class)
            ->state('caravan-range')->create();
        $data = $this->validData([
            'site_id' => $otherSmallPrint->site_id,
            'name' => $otherSmallPrint->name,
        ]);

        $response = $this->submit($data, $otherSmallPrint->vehicleRange);

        $response->assertSessionHasErrors('name');
    }

    public function test_successful()
    {
        $range = $this->createRange();
        $data = $this->validData();

        $response = $this->submit($data, $range);

        $response->assertRedirect($this->redirectUrl($range));
        $this->assertDatabaseHas('range_specification_small_prints', $data);
    }

    private function submit(array $data, CaravanRange $range = null): TestResponse
    {
        $user = $this->createSuperUser();
        if (is_null($range)) {
            $range = $this->createRange();
        }
        $url = $this->url($range);

        return $this->actingAs($user)->post($url, $data);
    }

    private function createRange(): CaravanRange
    {
        return factory(CaravanRange::class)->create();
    }

    private function validData(array $overrides = []): array
    {
        $defaults = [
            'name' => 'some name',
            'content' => 'some content',
        ];

        if (!array_key_exists('site_id', $overrides)) {
            $defaults['site_id'] = factory(Site::class)->create()->id;
        }

        return array_merge($defaults, $overrides);
    }

    private function url(CaravanRange $range): string
    {
        return route('admin.caravan-ranges.range-specification-small-prints.store', $range);
    }

    private function redirectUrl(CaravanRange $range): string
    {
        return route('admin.caravan-ranges.range-specification-small-prints.index', $range);
    }
}
