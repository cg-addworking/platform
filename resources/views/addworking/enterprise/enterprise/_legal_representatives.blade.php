@forelse ($enterprise->legalRepresentatives as $legal_representative)
    {{ $legal_representative->views->link }}
    @unless($loop->last)
        <br>
    @endunless
@empty
    n/a
@endforelse
