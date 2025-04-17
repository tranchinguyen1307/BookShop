<div>
    @foreach ($reviews as $review)
        <div class="media mb-4">
            <img src="{{ url('storage/' . $review->user->image) }}" alt="{{ $review->user->name }}"
                class="img-fluid mr-3 mt-1" style="width: 45px;">
            <div class="media-body">
                <h6>{{ $review->user->name }} <small> - <i>{{ $review->created_at->format('d/m/Y') }}</i></small></h6>
                <div class="text-primary mb-2">
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($review->rating >= $i)
                            <i class="fas fa-star"></i>
                        @else
                            <i class="far fa-star"></i>
                        @endif
                    @endfor
                </div>
                <p>{{ $review->message }}</p>
            </div>
        </div>
    @endforeach

    <div class="d-flex justify-content-center">
        {{ $reviews->links() }}
    </div>
    <style>
        .d-none.flex-sm-fill > div:first-child {
            display: none !important;
        }
    </style>
    
    
</div>