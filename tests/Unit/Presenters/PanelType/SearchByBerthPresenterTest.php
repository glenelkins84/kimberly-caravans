<?php

namespace Tests\Unit\Presenters\PanelType;

use App\Facades\CaravanSearchPage;
use App\Facades\MotorhomeSearchPage;
use App\Models\Page;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Presenters\PanelType\SearchByBerthPresenter as PanelPresenter;
use App\Models\Panel;
use App\Models\Site;

class SearchByBerthPresenterTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_caravan_search_page_when_page_does_not_exist(): void
    {
        $site = factory(Site::class)->state('default')->create();
        $this->app->instance('currentSite', $site);
        $panel = factory(Panel::class)->make();
        $presenter = (new PanelPresenter())->setWrappedObject($panel);

        $pagePresenter = $presenter->getCaravanSearchPage();

        $this->assertNull($pagePresenter);
    }

    public function test_get_caravan_search_page_when_page_exists(): void
    {
        $site = factory(Site::class)->state('default')->create();
        $this->app->instance('currentSite', $site);
        $page = factory(Page::class)->create([
            'site_id' => $site->id,
            'template' => Page::TEMPLATE_CARAVAN_SEARCH,
        ]);
        $panel = factory(Panel::class)->make();
        $presenter = (new PanelPresenter())->setWrappedObject($panel);

        $pagePresenter = $presenter->getCaravanSearchPage();

        $this->assertEquals(Page::TEMPLATE_CARAVAN_SEARCH, $pagePresenter->template);
    }

    public function test_get_motorhome_search_page_when_page_does_not_exist(): void
    {
        $site = factory(Site::class)->state('default')->create();
        $this->app->instance('currentSite', $site);
        $panel = factory(Panel::class)->make();
        $presenter = (new PanelPresenter())->setWrappedObject($panel);

        $pagePresenter = $presenter->getMotorhomeSearchPage();

        $this->assertNull($pagePresenter);
    }

    public function test_get_motorhome_search_page_when_page_exists(): void
    {
        $site = factory(Site::class)->state('default')->create();
        $this->app->instance('currentSite', $site);
        $page = factory(Page::class)->create([
            'site_id' => $site->id,
            'template' => Page::TEMPLATE_MOTORHOME_SEARCH,
        ]);
        $panel = factory(Panel::class)->make();
        $presenter = (new PanelPresenter())->setWrappedObject($panel);

        $pagePresenter = $presenter->getMotorhomeSearchPage();

        $this->assertEquals(Page::TEMPLATE_MOTORHOME_SEARCH, $pagePresenter->template);
    }

    public function test_get_caravan_berth_options(): void
    {
        $panel = factory(Panel::class)->make();
        $presenter = (new PanelPresenter())->setWrappedObject($panel);

        $result = $presenter->getCaravanBerthOptions();

        $this->assertEquals(CaravanSearchPage::BERTH_OPTIONS, $result);
    }

    public function test_get_motorhome_berth_options(): void
    {
        $panel = factory(Panel::class)->make();
        $presenter = (new PanelPresenter())->setWrappedObject($panel);

        $result = $presenter->getMotorhomeBerthOptions();

        $this->assertEquals(MotorhomeSearchPage::BERTH_OPTIONS, $result);
    }

    /**
     * @dataProvider titleContentProvider
     */
    public function test_get_title_content(string $vehicleType, string $expected)
    {
        $panel = factory(Panel::class)->make([
            'vehicle_type' => $vehicleType,
        ]);
        $presenter = (new PanelPresenter())->setWrappedObject($panel);

        $this->assertEquals($expected, $presenter->getTitleContent());
    }

    public function titleContentProvider(): array
    {
        return [
            [Panel::VEHICLE_TYPE_BOTH, 'Motorhome or Caravan'],
            [Panel::VEHICLE_TYPE_CARAVAN, 'Caravan'],
            [Panel::VEHICLE_TYPE_MOTORHOME, 'Motorhome'],
        ];
    }
}
