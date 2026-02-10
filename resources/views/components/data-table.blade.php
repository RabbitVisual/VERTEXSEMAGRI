<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Listagem</h5>
        @if($exportRoute)
            <div class="btn-group">
                <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                    <x-icon name="download" /> Exportar
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ $exportRoute }}?format=csv"><x-icon name="file-csv" /> CSV</a></li>
                    <li><a class="dropdown-item" href="{{ $exportRoute }}?format=excel"><x-icon name="file-excel" /> Excel</a></li>
                    <li><a class="dropdown-item" href="{{ $exportRoute }}?format=pdf"><x-icon name="file-pdf" /> PDF</a></li>
                </ul>
            </div>
        @endif
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-striped align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        @foreach($headers as $header)
                            <th scope="col">{{ $header }}</th>
                        @endforeach
                        @if($showActions)
                            <th scope="col" class="text-end" style="width: 120px;">Ações</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    {{ $slot }}
                </tbody>
            </table>
        </div>
    </div>
    @if(isset($data) && $data instanceof \Illuminate\Pagination\LengthAwarePaginator && $data->hasPages())
        <div class="card-footer">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    Mostrando {{ $data->firstItem() }} a {{ $data->lastItem() }} de {{ $data->total() }} resultados
                </div>
                <div>
                    {{ $data->links() }}
                </div>
            </div>
        </div>
    @endif
</div>
