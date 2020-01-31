<script>
        @section('js')
    const windowLoad = function () {
            const createBadge = function (linkUrl, linkTarget, imgSrc, imgAlt, appendElem) {
                const link = document.createElement('a');
                link.href = linkUrl;
                link.target = linkTarget;
                const img = document.createElement('img');
                img.src = imgSrc;
                img.alt = imgAlt;
                link.append(img);
                appendElem.append(link);
            };

            const badge = document.getElementById('{{ config('badge.prefix') }}-badge');

            if (badge) {
                createBadge(
                    '{{ $badge_options['badge_link_url'] }}',
                    '{{ $badge_options['badge_link_target'] }}',
                    '{{ $badge_img_url }}',
                    '{{ $badge_options['badge_img_alt'] }}',
                    badge
                );
            }
        };

    window.addEventListener('load', windowLoad);
    @endsection
</script>
