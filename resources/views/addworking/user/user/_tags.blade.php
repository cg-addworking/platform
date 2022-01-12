@forelse ($user->tagSlugs() as $tag)
    <span class="badge badge-secondary">{{ $tag }}</span>
@empty
    {{ __('addworking.user.user._tags.na') }}
@endforelse
