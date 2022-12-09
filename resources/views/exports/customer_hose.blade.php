<table>
    <thead>
        <tr>
            <th style="text-align: center;font-weight: bold">Estación de servicio</th>
            <th style="text-align: center;font-weight: bold">Manguera</th>
            <th style="text-align: center;font-weight: bold">Total de tickets</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($customers as $customer)
            @if ($customer->list_hoses && count($customer->list_hoses) > 0)
                <tr>
                    <td rowspan="{{ count($customer->list_hoses)}}">{{ $customer->username }}</td>
                    <td>{{ $customer->list_hoses->first()->name }}</td>
                    <td>{{ $customer->list_hoses->first()->count_tickets }}</td>
                </tr>
                @foreach ($customer->list_hoses as $key => $hose)
                    @if ($key != 0)
                        <tr>
                            <td>{{ $hose->name }}</td>
                            <td>{{ $hose->count_tickets }}</td>
                        </tr>
                    @endif
                @endforeach

            @endif
        @empty
            <tr>
                <td>No hay datos</td>
            </tr>
        @endforelse
    </tbody>
</table>