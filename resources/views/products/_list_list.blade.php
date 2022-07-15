@if ($products->count() > 0)
	<table class="table table-box pml-table mt-2"
		current-page="{{ empty(request()->page) ? 1 : empty(request()->page) }}"
	>
		@foreach ($products as $key => $product)
			<tr>
				<td width="1%">
					<div class="product-image-list mr-3">
						<img src="{{ $product->getImageUrl() }}" />
					</div>
				</td>
				<td width="50%">
					<h5 class="no-margin text-normal">
						<span class="kq_search" href="javascript:;">
							{{ $product->title }}
						</span>
					</h5>
					<span class="text-muted d-block mt-2">
						{{ trans('messages.created_at') }}:
						{{ \Illuminate\Support\Carbon::parse($product->created_at)->toDateTimeString()}}
					</span>
				</td>

			</tr>
		@endforeach
	</table>
	@include('elements/_per_page_select', ["items" => $products])

@elseif (!empty(request()->keyword))
	<div class="empty-list">
		<span class="material-icons-outlined">
			category
			</span>
		<span class="line-1">
			{{ trans('messages.no_search_result') }}
		</span>
	</div>
@else
	<div class="empty-list">
		<span class="material-icons-outlined">
			category
			</span>
		<span class="line-1 text-muted">
			<p>{!! trans('messages.product.no_product') !!}</p>
		</span>
	</div>
@endif
