@props(['name', 'value' => null])

@push('scripts')
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
@endpush

<div x-data="{
    value: '{{ $value }}',
    init() {
        let quill = new Quill(this.$refs.quill, { theme: 'snow' })
        quill.root.innerHTML = this.value
        quill.on('text-change', () => this.value = quill.root.innerHTML)
    }
}">
    <input type="hidden" name="{{ $name }}" x-model="value" />
    <div x-ref="quill"></div>
</div>
