<section class="py-16 px-6 md:px-16" x-data="{ editing: false }">
    <h2 class="text-2xl md:text-3xl font-semibold text-center mb-8">Visi & Misi</h2>

    @if ($visimisi)
        <div class="grid md:grid-cols-2 gap-8" x-show="!editing">
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-xl font-bold mb-4 text-green-600">Visi</h3>
                <p class="text-gray-700">{{ $visimisi->visi }}</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-xl font-bold mb-4 text-green-600">Misi</h3>
                <ul class="list-disc list-inside text-gray-700 space-y-2">
                    @foreach (explode("\n", $visimisi->misi) as $misiItem)
                        <li>{{ $misiItem }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @else
        <div class="flex justify-center mb-6">
            <button @click="editing = true" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                Tambah Visi & Misi
            </button>
        </div>
    @endif

    @if (!$visimisi)
        <form action="{{ route('visimisi.store') }}" method="POST"
            class="max-w-3xl mx-auto bg-white rounded-lg shadow p-6 space-y-4" x-show="editing">
            @csrf
            <div>
                <label class="block font-semibold text-gray-700 mb-1">Visi</label>
                <textarea name="visi" rows="3" class="w-full border rounded p-2" required></textarea>
            </div>
            <div>
                <label class="block font-semibold text-gray-700 mb-1">Misi (Pisahkan dengan Enter)</label>
                <textarea name="misi" rows="5" class="w-full border rounded p-2" required></textarea>
            </div>
            <div class="flex justify-end gap-4">
                <button type="button" @click="editing = false"
                    class="px-4 py-2 rounded border text-gray-600 hover:bg-gray-100">
                    Batal
                </button>
                <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    Simpan
                </button>
            </div>
        </form>
    @endif
</section>
