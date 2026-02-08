<div class="table-responsive">
    <table class="table table-hover">
        @if(isset($headers) && count($headers) > 0)
        <thead>
            <tr>
                @foreach($headers as $header)
                <th>{{ $header }}</th>
                @endforeach
            </tr>
        </thead>
        @endif
        <tbody>
            {{ $slot }}
        </tbody>
    </table>
</div>
