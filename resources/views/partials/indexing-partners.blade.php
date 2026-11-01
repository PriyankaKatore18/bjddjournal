<section class="indexing-partners-footer" aria-labelledby="indexing-partners-title">
    <div class="container py-4">
        <h2 id="indexing-partners-title">Indexing Partners</h2>
        <p class="indexing-partners-footer-intro">
            Our journal is discoverable through the following indexing and research platforms.
        </p>

        @if($indexPartners->isNotEmpty())
            <div class="indexing-partners-footer-grid">
                @foreach($indexPartners as $partner)
                    @php
                        $partnerUrl = trim((string) $partner->url);
                        $partnerName = $partner->name ?: 'Indexing partner';
                        $partnerIcon = trim((string) $partner->icon);
                    @endphp

                    @if($partnerUrl)
                        <a class="indexing-partner-logo-card" href="{{ $partnerUrl }}" target="_blank" rel="noopener" aria-label="{{ $partnerName }}">
                    @else
                        <div class="indexing-partner-logo-card">
                    @endif
                            @if($partnerIcon)
                                <img src="{{ asset('storage/' . ltrim($partnerIcon, '/')) }}" alt="{{ $partnerName }}" loading="lazy">
                            @else
                                <span>{{ $partnerName }}</span>
                            @endif
                    @if($partnerUrl)
                        </a>
                    @else
                        </div>
                    @endif
                @endforeach
            </div>
        @else
            <p class="indexing-partners-footer-empty">Indexing partner logos will appear here.</p>
        @endif
    </div>
</section>
