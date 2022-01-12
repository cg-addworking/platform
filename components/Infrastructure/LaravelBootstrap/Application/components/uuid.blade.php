<abbr @attr('id_attr')>
  @icon('key|mr:2') {{ substr($text ?? $slot ?? 'n/a', 0, 8) }}
</abbr>
