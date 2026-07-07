@if($content ?? null)
    @php
        $contentLabel = $label ?? ($content->group_label ?? 'Konten');
    @endphp

    <div class="homepage-edit-controls" aria-label="Aksi {{ $contentLabel }}">
        <span class="homepage-edit-key">{{ $contentLabel }}</span>
        <a
            href="{{ route('admin.homepage-contents.edit', $content) }}"
            class="homepage-edit-btn homepage-edit-btn-edit"
            title="Edit {{ $content->key }}"
        >
            <i class="bi bi-pencil-square" aria-hidden="true"></i>
            <span>Edit</span>
        </a>
        <form
            action="{{ route('admin.homepage-contents.destroy', $content) }}"
            method="POST"
            onsubmit="return confirm('Hapus konten {{ $content->key }}?');"
        >
            @csrf
            @method('DELETE')
            <button
                type="submit"
                class="homepage-edit-btn homepage-edit-btn-delete"
                title="Hapus {{ $content->key }}"
            >
                <i class="bi bi-trash" aria-hidden="true"></i>
                <span>Hapus</span>
            </button>
        </form>
    </div>
@endif
