{{--
  Kartu dashboard: judul 16/SemiBold + deskripsi abu-abu, lalu isi (chart).

  <x-ui.card title="Buku Terpopuler" description="5 judul yang paling sering dipinjam">
      <x-ui.bar-list :items="$bukuPopuler" />
  </x-ui.card>
--}}
@props(['title', 'description' => null])

<section {{ $attributes->merge(['class' => 'ui-card']) }}>
    <div class="ui-card__text">
        <h3 class="t-16-semibold">{{ $title }}</h3>
        @if ($description)
            <p class="t-12-regular text-gray">{{ $description }}</p>
        @endif
    </div>
    {{ $slot }}
</section>
