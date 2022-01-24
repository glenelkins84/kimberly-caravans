<main>
  <div class="container mx-auto bg-white py-4 px-standard">
    @if ($logo = $pageFacade->getManufacturer()->logo)
    <h1>
      <img src="{{ $logo->getUrl('show') }}" alt="{{ $pageFacade->getManufacturer()->name }}" class="mx-auto">
    </h1>
    @endif

    @if ($introText = $pageFacade->getManufacturer()->caravan_intro_text)
    <div class="text-center font-heading font-semibold text-xl text-tundora leading-snug my-2">
      {{ $introText }}
    </div>
    @endif

    @include('site.shared.areas-for-holder', [
      'page' => $pageFacade->getPage(),
      'holder' => 'Primary',
      'areas' => $pageFacade->getAreas('Primary'),
    ])
  </div>

  @foreach ($pageFacade->getCaravanRanges() as $caravanRange)
    @include('site.pages.manufacturer-caravans._caravan-range', [
      'caravanRange' => $caravanRange,
      'site' => $pageFacade->getSite(),
    ])
  @endforeach
</main>
