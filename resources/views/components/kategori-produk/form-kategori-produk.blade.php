<div>
    <!-- Button trigger modal -->
<button type="button" class="btn btn-round {{ $id ? 'btn-primary btn-icon' : 'btn-dark' }}" data-bs-toggle="modal" data-bs-target="#formKategori{{ $id ?? '' }}">
  @if ($id)
  <i class="fas fa-edit"></i>
  @else
  <span>Kategori Baru</span>
  @endif
</button>

<!-- Modal -->
<div class="modal fade" id="formKategori{{ $id ?? '' }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="formKategoriLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ $action }}" method="POST">
        @csrf
        @if ($id)
        @method('PUT')
        @endif
        <div class="modal-header">
        <h1 class="modal-title fs-5" id="formKategoriLabel">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ... 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Understood</button>
      </div>
      </form>
    </div>
  </div>
</div>
</div>