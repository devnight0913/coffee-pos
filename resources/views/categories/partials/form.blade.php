<form action="{{ isset($category) ? route('categories.update', $category) : route('categories.store') }}" method="POST"
    enctype="multipart/form-data" role="form">
    @csrf
    @isset($category)
        @method('PUT')
    @endisset

    <div class="mb-3">
        <label for="name" class="form-label">@lang('Category Name')</label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name"
            value="{{ old('name', isset($category) ? $category->name : '') }}">
        @error('name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>


    <x-number-input label="Sort Order" name="sort_order"
        value="{{ old('sort_order', isset($category) ? $category->sort_order : '') }}" />




    <div class="mb-3">
        <label for="status" class="form-label">@lang('status.text')</label>
        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
            @isset($category)
                <option value="available" @if ($category->is_active) selected @endif>@lang('Visible')</option>
                <option value="unavailable" @if (!$category->is_active) selected @endif>@lang('Hidden')</option>
            @else
                <option value="available">@lang('Visible')</option>
                <option value="unavailable">@lang('Hidden')</option>
            @endisset
        </select>
        @error('status')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @else
            <div id="categoryStatusHelp" class="form-text">
                @lang('If set to hidden, all items of this category, will not appear in the POS.')
            </div>
        @enderror
    </div>

    <div class="mb-5">
        <label for="image" class="form-label">@lang('Image')</label>
        <input class="form-control @error('image') is-invalid @enderror" name="image" type="file" id="image-input"
            accept="image/png, image/jpeg">
        @error('image')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="mb-5 text-center">
        <div class="mb-3">
            @isset($category)
                <img src="{{ $category->image_url }}" height="250"
                    class="object-fit-cover border rounded  @if (!$category->image_path) d-none @endif"
                    alt="{{ $category->name }}" id="image-preview">
            @else
                <img src="#" height="250" class="object-fit-cover border rounded  d-none" alt="image"
                    id="image-preview">
            @endisset
        </div>
        @isset($category)
            @if ($category->image_path)
                <div class="mb-3">
                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                        data-bs-target="#removeCategoryImageModal">
                        @lang('Remove Image')
                    </button>
                </div>
            @endif
        @endisset

    </div>

    <div class="mb-3">
        <x-save-btn>
            @lang(isset($category) ? 'Update Category' : 'Save Category')
        </x-save-btn>
    </div>
</form>

@isset($category)
    <div class="modal" id="removeCategoryImageModal" tabindex="-1" aria-labelledby="removeCategoryImageModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="removeCategoryImageModalLabel">@lang('Are you sure?')</h5>
                    <button type="button" class="btn-close m-0" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('categories.image.destroy', $category) }}" method="POST" role="form">
                    <div class="modal-body">
                        @csrf
                        @method('DELETE')
                        @lang('You cannot undo this action!')
                    </div>
                    <div class="row p-0 m-0 border-top">
                        <div class="col-6 p-0">
                            <button type="button"
                                class="btn btn-link w-100 m-0 text-danger btn-lg text-decoration-none rounded-0 border-end"
                                data-bs-dismiss="modal">@lang('Cancel')</button>
                        </div>
                        <div class="col-6 p-0">
                            <button type="submit"
                                class="btn btn-link w-100 m-0 text-black btn-lg text-decoration-none rounded-0 border-start">
                                @lang('Remove Image')
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endisset
@push('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("image-input").onchange = function() {
                previewImage(this, document.getElementById("image-preview"))
            };
        });
    </script>
@endpush
