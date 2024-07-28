<!-- Modal -->
<div class="modal fade" id="resultModal" tabindex="-1" aria-labelledby="resultModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 40px;">
            <div class="modal-header">
                <h5 class="modal-title" id="resultModalLabel">درجتك</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <div class="stars">
                    @for($i = 0; $i < 3; $i++)
                        @if($i < floor($score / ($totalQuestions / 3)))
                            <i class="fas fa-star"></i>
                        @else
                            <i class="far fa-star"></i>
                        @endif
                    @endfor
                </div>
                <h3 id="exam-score">{{ $score }} / {{ $totalQuestions }}</h3>
                <div class="d-flex justify-content-center mt-4">
                    <a href="#" class="btn btn-secondary me-2">إجاباتي</a>
                    <a href="{{ route('home') }}" class="btn btn-primary">خروج</a>
                </div>
            </div>
        </div>
    </div>
</div>
