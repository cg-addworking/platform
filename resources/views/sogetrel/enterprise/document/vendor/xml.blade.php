{!! '<'.'?'.'xml version="1.0" encoding="UTF-8" ?>' !!}
<Fournisseurs LotId="{{ $date }}">
@foreach($vendors as $vendor)
    <Fournisseur>
        <reference>{{ $vendor['navibat_id'] }}</reference>
        <statut>{{ $vendor['status'] }}</statut>
        <Siren>{{ $vendor['siren'] }}</Siren>
        <KB>{{ $vendor['KB'] }}</KB>
        <AC>{{ $vendor['AC'] }}</AC>
        <AA>{{ $vendor['AA'] }}</AA>
        <AH>{{ $vendor['AH'] }}</AH>
    </Fournisseur>
@endforeach
</Fournisseurs>
