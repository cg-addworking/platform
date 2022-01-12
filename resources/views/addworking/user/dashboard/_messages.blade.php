<div class="messages">
	<span class="icon-message"></span>
	<div class="info">
		<span class="number">{{ $count = getUnreadMessagesCount(Auth::user()) }}</span> {{ trans_choice('messages.dashboard.messages', $count) }}
	</div>
	@component('components.button',
	['link' => route('chat.rooms'),
	 'icon' => 'icon-see',
	 'icon_text' => "Voir"
	 ])
	@endcomponent
</div>
