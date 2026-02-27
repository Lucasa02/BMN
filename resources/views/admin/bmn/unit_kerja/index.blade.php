@extends('layouts.admin.main')

@section('content')
  <div class="flex p-3 ml-3 mr-3">
    @if (Route::currentRouteName() == 'bmn.unit_kerja.search')
        <a href="{{ route('bmn.unit_kerja.index') }}" class="mr-3 text-white bg-gray-700 hover:bg-gray-800 font-medium rounded-lg text-sm px-4 py-2">Kembali</a>
    @endif

    <button data-modal-target="create-modal" data-modal-toggle="create-modal"
      class="mr-3 text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5">
      Tambah Unit Kerja
    </button>
  </div>

  {{-- Search Form --}}
  <form class="flex items-center max-w-sm mx-auto p-3 ml-3" action="{{ route('bmn.unit_kerja.search') }}" method="GET">
    <div class="w-full relative">
      <input type="text" id="search" name="search" autocomplete="off" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full pl-10" placeholder="Cari unit kerja...">
      <svg class="w-4 h-4 absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500" fill="none" viewBox="0 0 20 20">
        <path stroke="currentColor" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
      </svg>
    </div>
  </form>

  @if ($unit_kerja->isEmpty())
    <x-empty-data></x-empty-data>
  @else
    <div class="flex flex-col p-3 ml-3">
      <div class="relative overflow-x-auto sm:rounded-lg border">
        <table class="w-full text-sm text-left text-gray-500">
          <thead class="text-xs text-gray-700 uppercase bg-gray-50 font-bold">
            <tr>
              <th class="px-6 py-3">No</th>
              <th class="px-6 py-3">Nama Unit Kerja</th>
              <th class="px-6 py-3">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($unit_kerja as $row)
              <tr class="bg-white border-b hover:bg-gray-50">
                <td class="px-6 py-4">{{ $unit_kerja->firstItem() + $loop->index }}</td>
                <td class="px-6 py-4 font-medium text-gray-900">{{ $row->nama_unit_kerja }}</td>
                <td class="px-6 py-4">
                  <button type="button" data-uuid="{{ $row->uuid }}" class="edit-item text-blue-600 hover:underline">Edit</button>
                  <button onclick="confirmDelete('{{ route('bmn.unit_kerja.destroy', $row->uuid) }}')" data-modal-target="delete-modal" data-modal-toggle="delete-modal" class="text-red-600 hover:underline ml-2">Hapus</button>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    <div class="p-3 ml-6">{{ $unit_kerja->links() }}</div>
  @endif

  {{-- Modal Create --}}
  <div id="create-modal" tabindex="-1" aria-hidden="true" class="{{ session('showModal') || $errors->any() ? 'flex' : 'hidden' }} overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full backdrop-blur-sm">
    <div class="relative p-4 w-full max-w-md max-h-full">
      <div class="relative bg-white rounded-lg shadow border">
        <div class="flex items-center justify-between p-4 border-b">
          <h3 class="text-lg font-semibold">Tambah Unit Kerja</h3>
          <button type="button" data-modal-hide="create-modal" class="text-gray-400 hover:bg-gray-200 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center">✕</button>
        </div>
        <form action="{{ route('bmn.unit_kerja.store') }}" method="POST" class="p-4">
          @csrf
          <div class="mb-4">
            <label for="nama_unit_kerja" class="block mb-2 text-sm font-medium">Nama Unit Kerja</label>
            <input type="text" name="nama_unit_kerja" id="nama_unit_kerja" class="bg-gray-50 border border-gray-300 rounded-lg block w-full p-2.5" required>
            @error('nama_unit_kerja') <small class="text-red-500">{{ $message }}</small> @enderror
          </div>
          <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Simpan Data</button>
        </form>
      </div>
    </div>
  </div>

  {{-- Modal Edit --}}
  <div id="edit-modal" class="fixed inset-0 z-50 hidden overflow-auto bg-black bg-opacity-50 backdrop-blur-sm">
    <div class="flex items-center justify-center min-h-screen">
      <div class="bg-white rounded-lg shadow-xl w-full max-w-md">
        <div class="flex items-center justify-between p-4 border-b">
          <h3 class="text-lg font-semibold">Edit Unit Kerja</h3>
          <button type="button" class="close-modal text-gray-400">✕</button>
        </div>
        <form id="updateForm" class="p-4">
          @csrf @method('PUT')
          <input type="hidden" id="unit_kerja_uuid" name="uuid">
          <div class="mb-4">
            <label for="edit_nama_unit_kerja" class="block mb-2 text-sm font-medium">Nama Unit Kerja</label>
            <input type="text" name="nama_unit_kerja" id="edit_nama_unit_kerja" class="bg-gray-50 border border-gray-300 rounded-lg block w-full p-2.5">
            <div class="text-red-500 text-sm mt-1" id="error-unit_kerja"></div>
          </div>
          <div class="flex justify-end gap-2">
            <button type="button" class="close-modal px-4 py-2 bg-gray-200 rounded-lg">Kembali</button>
            <button type="submit" class="px-4 py-2 bg-blue-700 text-white rounded-lg">Simpan Perubahan</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  @include('components.modal-delete')
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editModal = document.getElementById('edit-modal');
        const updateForm = document.getElementById('updateForm');

        document.querySelectorAll('.edit-item').forEach(button => {
            button.addEventListener('click', function() {
                const uuid = this.getAttribute('data-uuid');
                fetch(`/admin/bmn/unit-kerja/edit/${uuid}`)
                    .then(res => res.json())
                    .then(data => {
                        document.getElementById('unit_kerja_uuid').value = uuid;
                        document.getElementById('edit_nama_unit_kerja').value = data.nama_unit_kerja;
                        editModal.classList.remove('hidden');
                    });
            });
        });

        document.querySelectorAll('.close-modal, [data-modal-hide="create-modal"]').forEach(btn => {
            btn.addEventListener('click', () => {
                editModal.classList.add('hidden');
                document.getElementById('create-modal').classList.add('hidden');
            });
        });

        updateForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const uuid = document.getElementById('unit_kerja_uuid').value;
            fetch(`/admin/bmn/unit-kerja/update/${uuid}`, {
                method: 'POST',
                body: new FormData(updateForm),
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) location.reload();
                else { /* Tampilkan error */ }
            });
        });
    });

    function confirmDelete(url) {
        const form = document.getElementById('deleteForm');
        if(form) form.action = url;
    }
</script>
@endsection
