<table>
    <thead>
        <tr>
            <th style="text-align: center;font-weight: bold" rowspan="2">Estación de servicio</th>
            <th style="text-align: center;font-weight: bold" rowspan="2">Total de tickets</th>
            <th style="background: #DCE6F1;font-weight: bold" rowspan="1" colspan="{{ count($options->statuses) + 1}}">Estados</th>
            <th style="background: #EBF1DE;text-align: center;font-weight: bold" rowspan="1" colspan="{{ count($options->priorities) + 1}}">Prioridad</th>
            <th style="background: #FCD5B4;text-align: center;font-weight: bold" rowspan="1" colspan="{{ count($options->categories) + 1}}">Categorías</th>
        </tr>
        <tr>
            @foreach ($options->statuses as $status)
                <th style="text-align: center;background: #DCE6F1;font-weight: bold">{{ $status['translate'] }}</th>
            @endforeach
            <th style="text-align: center;background: #DCE6F1;font-weight: bold">Total por Estados</th>

            {{--  --}}
            @foreach ($options->priorities as $priority)
                <th style="text-align: center;background: #EBF1DE;font-weight: bold">{{ $priority['translate'] }}</th>
            @endforeach
            <th style="text-align: center;background: #EBF1DE;font-weight: bold">Total por Prioridad</th>


            {{--  --}}
            @foreach ($options->categories as $category)
                <th style="background: #FCD5B4;font-weight: bold">{{ $category->name }}</th>
            @endforeach
            <th style="background: #FCD5B4;font-weight: bold">Total por Categoría</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($customers as $customer)
            <tr>
                <td>{{ $customer->username }}</td>
                <td>{{ $customer->total_tickets }}</td>
                {{-- sTATUS --}}
                @foreach ($customer->statuses_list as $status_value)
                    <td>{{ $status_value }}</td>
                @endforeach
                <td>{{ $customer->total_status }}</td>

                {{-- CATEGORY --}}
                @foreach ($customer->priorities_list as $priority_value)
                    <td>{{ $priority_value }}</td>
                @endforeach
                <td>{{ $customer->total_priorities }}</td>

                {{-- CATEGORY --}}
                @foreach ($customer->categories_list as $category_value)
                    <td>{{ $category_value }}</td>
                @endforeach
                <td>{{ $customer->total_categories }}</td>
            </tr>
        @empty
            <tr>
                <td>No hay datos</td>
            </tr>
        @endforelse
    </tbody>
</table>