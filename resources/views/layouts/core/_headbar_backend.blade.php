
<div class="headbar d-flex">
    <div class="me-auto"></div>
    <div class="top-search-container"></div>
</div>

<script>
    $(function() {
        TopSearchBar.init({
            container: $('.top-search-container'),
            sections: [
                new SearchSection({
                    url: '#',
                }),
                new SearchSection({
                    url: '#',
                }),
                new SearchSection({
                    url: '#',
                }),
                new SearchSection({
                    url: '#',
                }),
                new SearchSection({
                    url: '#',
                }),
            ],
            lang: {
                no_keyword: `{!! trans('messages.search.type_to_search.wording') !!}`,
                empty_result: `{!! trans('messages.search.empty_result') !!}`,
                tooltip: `{!! trans('messages.click_open_app_search') !!}`,
            }
        });
    });
</script>
