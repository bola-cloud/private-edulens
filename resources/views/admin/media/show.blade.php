@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h3>عرض الوسائط</h3>
        </div>
        <div class="card-body">
            <h4>الاسم: {{ $media->name }}</h4>
            <p>المحتوى: {{ $media->content }}</p>
            <p>الترتيب: {{ $media->order }}</p>
            <p>النوع: {{ $media->type }}</p>

            @if ($media->type === 'file')
                <p>الملف: <a href="{{ asset($media->path) }}" target="_blank">عرض الملف</a></p>
            @elseif ($media->type === 'video')
                <p>الفيديو: <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#videoModal">عرض الفيديو</button></p>
            @endif

            <p>تم الإنشاء في: {{ $media->created_at }}</p>

            <a href="{{ route('media.edit', $media->id) }}" class="btn btn-warning">تعديل</a>
            <form action="{{ route('media.destroy', $media->id) }}" method="POST" style="display:inline;" onsubmit="return confirmDelete();">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">حذف</button>
            </form>
        </div>
    </div>
</div>

@if ($media->type === 'video')
<!-- Modal -->
<div class="modal fade" id="videoModal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="videoModalLabel">الفيديو</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="ratio ratio-16x9">
                    <iframe src="{{ $media->path }}" title="video" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<script>
    function confirmDelete() {
        return confirm('هل تود حذف هذه الوسائط؟');
    }
</script>
@endsection
